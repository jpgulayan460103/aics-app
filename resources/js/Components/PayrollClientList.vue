<template>
  <v-card flat outlined>


    <v-card-title v-if="userData.role == 'Admin' || userData.role == 'Super-Admin'">

      <!--<v-btn @click="print_options=!print_options" color="black" dark class="m-1">Print</v-btn>-->
      

      <div style="margin-right: 1em;">
        <v-menu offset-y>
          <template v-slot:activator="{ on, attrs }">
            <v-btn
              color="primary"
              dark
              v-bind="attrs"
              v-on="on"
            >
              <v-icon> mdi-printer </v-icon> Print
            </v-btn>
          </template>
          <v-list>
            <v-list-item @click="PrintGISMany()">
              <v-list-item-title>
                <v-icon> mdi-printer </v-icon> Selected GIS <v-chip label small>CTLR + SPACE</v-chip>
              </v-list-item-title>
            </v-list-item>
            <v-list-item @click="print_gis_page()">
              <v-list-item-title>
                <v-icon> mdi-printer </v-icon> All GIS of page {{ page }} <v-chip label small>CTLR + SHIFT + P</v-chip>
              </v-list-item-title>
            </v-list-item>
            <v-list-item @click="print_payroll()">
              <v-list-item-title>
                <v-icon> mdi-printer </v-icon> Payroll of page {{ page }} <v-chip label small>CTLR + P</v-chip>
              </v-list-item-title>
            </v-list-item>
            <v-list-item @click="print_payroll_w_gt()">
              <v-list-item-title>
                <v-icon> mdi-printer </v-icon> Last Page w/ Footer & Grand Total <v-chip label small>CTLR + ALT + P</v-chip>
              </v-list-item-title>
            </v-list-item>
            <v-list-item @click="print_payroll_footer()">
              <v-list-item-title>
                <v-icon> mdi mdi-foot-print</v-icon> Footer Only
              </v-list-item-title>
            </v-list-item>
          </v-list>
        </v-menu>
      </div>

      <div>
        <v-menu offset-y>
          <template v-slot:activator="{ on, attrs }">
            <v-btn
              color="default"
              dark
              v-bind="attrs"
              v-on="on"
            >
              <v-icon> mdi-cog </v-icon> Actions
            </v-btn>
          </template>
          <v-list>
            <v-list-item @click="getClients()">
              <v-list-item-title>
                <v-icon> mdi-refresh </v-icon> Refresh Payroll <v-chip label small>CTLR + R</v-chip>
              </v-list-item-title>
            </v-list-item>
            <v-list-item @click="MarkAsClaimed()">
              <v-list-item-title @click="MarkAsClaimed()">
                <v-icon> mdi-account-check </v-icon> Tag selected as claimed <v-chip label small>ALT + C</v-chip>
              </v-list-item-title>
            </v-list-item>
            <v-list-item @click="MarkAsUnClaimed()">
              <v-list-item-title @click="MarkAsUnClaimed()">
                <v-icon> mdi-account-remove </v-icon> Tag selected as unclaimed <v-chip label small>ALT + Z</v-chip>
              </v-list-item-title>
            </v-list-item>
            <v-list-item @click="markAllAsClaimed()">
              <v-list-item-title>
                <v-icon> mdi-check-all </v-icon> Tag all as claimed status
              </v-list-item-title>
            </v-list-item>
            <!-- <v-list-item @click="uploadToCrims()">
              <v-list-item-title>
                <v-icon> mdi-cloud-upload </v-icon> Upload to Database
              </v-list-item-title>
            </v-list-item> -->
          </v-list>
        </v-menu>
      </div>

    </v-card-title>
    <v-card-text>
      <div class="row">
        <div class="col-md-12 text-center d-print-block">
          <h6>{{ data.title }}</h6>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6" v-if="data.psgc">
          CITY/MUNICIPALITY : <b>{{ data.psgc.city_name }}</b><br />
          BARANGAY : <b>{{ data.psgc.brgy_name }}</b> <br />
          SCHEDULE : <b>{{ data.schedule }}</b> <br />
          NO. OF BENEFICIARIES: <b>{{ data.clients.length }}</b> <br />
          NO. OF CLAIMED: <b>{{ data.clients.filter(i => i.status == "claimed").length }}</b> <br />
        </div>
        <div class="col-md-6 text-end">
          <v-spacer></v-spacer>
          <v-text-field v-model="search" append-icon="mdi-magnify" label="Search" single-line hide-details
            class="d-print-none"></v-text-field>
        </div>
      </div>
      <v-data-table show-select v-model="selected" v-if="data.clients" :headers="headers" :items="data.clients.map((i, index) => {
        i.key = index + 1
        return i;
      })" :items-per-page="10" :loading="isBusy" loading-text="Loading... Please wait" :search="search"
        @update:page="currentPage" :footer-props="{
          'items-per-page-options': [10],
          'disable-items-per-page': true,
          'showFirstLastPage': true,

        }"
        @toggle-select-all="selectAllToggle"
        :page="page">

        <template v-slot:item.data-table-select="{ item, isSelected, select }">
        <v-simple-checkbox
          :value="isSelected"
          :readonly="item.deleted_at != null"
          :disabled="item.deleted_at != null"
          @input="select($event)"
        ></v-simple-checkbox>
      </template>
        <template v-slot:footer.page-text="{ pageStart, pageStop, itemsLength }">
          <v-row align="center" no-gutters >
            <v-col> 
              <label for="">Page No.</label>
              <input type="text" name="" id="" class="form-control" v-model="page">
            </v-col>
            <v-col>
              {{ pageStart }} of {{ itemsLength }}
            </v-col>
          </v-row>

        </template>

        <template v-slot:item.key="{ item }">
          {{ item.key }}
        </template>


        <template v-slot:item.last_name="{ item }">
          {{ item.aics_client.last_name }}
        </template>
        <template v-slot:item.ext_name="{ item }">
          {{ item.aics_client.ext_name }}
        </template>
        <template v-slot:item.first_name="{ item }">
          {{ item.aics_client.first_name }}
        </template>
        <template v-slot:item.middle_name="{ item }">
          {{ item.aics_client.middle_name }}
        </template>
        <template v-slot:item.amount="{ item }">
          {{ data.amount }}
        </template>

        <!--template v-slot:item.actions="{ item }">
          <v-icon small class="mr-2" @click="EditItem(item)">
            mdi-pencil
          </v-icon>
        </template>-->

        <template v-slot:item.status="{ item }">
          <span v-if="item.deleted_at == null">
            <v-edit-dialog :return-value.sync="item.status" large persistent @save="save(item)" @cancel="cancel(item)"
              v-if="userData.role == 'Admin' || userData.role == 'Super-Admin'">
              <div>{{ item.status }}</div>
              <template v-slot:input>
                <div class="mt-4 text-h6">Claim Status</div>
                <select class="form-control" v-model="item.status">

                  <option value="claimed">Claimed</option>
                  <option value="">Unclaimed</option>
                  <option value="cancelled-revalidate">Cancelled (Revalidate)</option>
                </select>
              </template>
            </v-edit-dialog>
          </span>
          <span v-else>
            <span v-if="item.new_payroll_client">
              Moved to {{ item.new_payroll_client.payroll ? item.new_payroll_client.payroll.title : "" }} Client #: {{ item.new_payroll_client.sequence }}
            </span>
            <span v-else>
              Removed from Payroll List
            </span>
          </span>
        </template>
      </v-data-table>
    </v-card-text>

    <!--<v-dialog v-model="print_options" width="300px" height="300px">
      <v-card>
        <v-card-title></v-card-title>
        <v-card-text>

         Select Page: 
         <input type="text" name="" id="" v-model="page" class="form-control">
          <label>
          With Grand Total &
          Footer? </label> <input type="checkbox" name="" id="" v-model="gt"  >

        </v-card-text>
      </v-card>
    </v-dialog>-->

    <v-dialog
      v-model="uploadDialog"
      persistent
      max-width="290"
    >
      <v-card>
        <v-card-title class="text-h5">
          Uploading to Database
        </v-card-title>
        <v-card-text>
          Database status: <b>{{ crimsUploads.connectionStatus }}</b><br>
          <span v-if="crimsUploads.isConnected">
            Uploading status: <b>{{ Math.round(uploadProgress, 2)  }}%</b>
          </span>
          <span v-else>
            Please check connection to server <a :href="uploadConfig.globalUrl">{{ uploadConfig.globalUrl }}</a>
          </span>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>

          <v-btn
            color="green darken-1"
            text
            @click="uploadDialog = false"
            v-if="crimsUploads.lastBatch == crimsUploads.currentBatch"
          >
            Done
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>





    <span v-shortkey="['ctrl', 'r']" @shortkey="getClients()"></span>
    <span v-shortkey="['ctrl', 'shift', 'p']" @shortkey="print_gis_page()"></span>
    <span v-shortkey="['ctrl', 'p']" @shortkey="print_payroll()"></span>
    <span v-shortkey="['ctrl', 'alt', 'p']" @shortkey="print_payroll_w_gt()"></span>
    <span v-shortkey="['ctrl', 'space']" @shortkey="PrintGISMany()"></span>
    <span v-shortkey="['alt', 'c']" @shortkey="MarkAsClaimed()"></span>
    <span v-shortkey="['alt', 'z']" @shortkey="MarkAsUnClaimed()"></span>
  </v-card>
</template>

<script>
import { isEmpty } from 'lodash';
import { debounce } from "lodash";
import userMixin from './../Mixin/userMixin.js'


export default {
  mixins: [userMixin],
  props: ["id", "user", "uploadConfig"],
  data() {
    return {
      data: [],
      isBusy: false,
      disabledCount: 0,
      uploadDialog: false,
      crimsUploads: {
        perClient: 100,
        currentBatch: 1,
        lastBatch: 1,
        clients: [],
        isConnected: false,
        connectionStatus: "",
      },
      headers: [
        { value: "sequence", text: "No.", sortable: false, width: "20px;" },
        { value: "last_name", text: "Last Name", sortable: false, width: "100px;" },
        { value: "ext_name", text: "Ext", sortable: false, width: "20px;" },
        { value: "first_name", text: "First Name", sortable: false },
        { value: "middle_name", text: "Middle Name", sortable: false },

        { value: "amount", text: "Amount", sortable: false },

        { value: "status", text: "Status", sortable: false, width: "50px;" },
      ],
      search: "",
      page: 1,
      print_options: false,
      selected: [],
      url: "",
      clientListPerPage: 10,
    };
  },
  watch() {
    id();
    {
      this.getClients();
    }
  },
  methods: {
    print_gis_page() {
      window.open(
        route("pdf.payroll_client.printv2", { id: this.id, page: this.page }),
        "_blank"
      );
    },
    print_payroll() {
      window.open(
        route("pdf.payroll.printv2", { id: this.id, page: this.page }),
        "_blank"
      );
    },
    print_payroll_w_gt() {
      window.open(
        route("pdf.payroll.printv2", { id: this.id, _query: {
          page: this.lastPage,
          gt: 1
        } }),
        "_blank"
      );
    },
    print_payroll_footer() {
      window.open(route("api.payroll.print_footer", this.id), "_blank");
    },
    getClients() {
      this.isBusy = true;
      axios
        .get(route("api.payroll.show", this.id))
        .then((res) => {
          this.data = res.data;
          this.isBusy = false;
        })
        .catch((error) => {
          console.log(error);
          this.isBusy = false;
        });
    },
    async save(e) {
      return axios.put(route("api.payroll-clients.update", e.id), e);
    },
    cancel(e) {
      e;
    },
    currentPage(e) {
      this.page = e;
    },
    isEmpty(value) {
      return isEmpty(value);
    },
    uploadToCrims: debounce(async function () {
      this.uploadDialog = true;
      this.crimsUploads.connectionStatus = "Connecting...";
      const { globalUrl, localUrl, serverName } = this.uploadConfig;
      try {
        await axios.get(`${globalUrl}/api/clients`);
        this.crimsUploads.connectionStatus = "Connected";
        this.crimsUploads.isConnected = true;
        const claimedClients = this.data.clients.filter(i => i.status == "claimed");
        this.crimsUploads.lastBatch = ~~(claimedClients.length / this.crimsUploads.perClient);
        if((claimedClients.length % this.crimsUploads.perClient) != 0){
          this.crimsUploads.lastBatch++
        }
        this.crimsUploads.currentBatch = 0;
        
        for (let index = 0; index < this.crimsUploads.lastBatch; index++) {
          this.crimsUploads.clients = claimedClients.slice((this.crimsUploads.perClient * this.crimsUploads.currentBatch), ((this.crimsUploads.currentBatch + 1) * this.crimsUploads.perClient));
          const aics_clients =  this.crimsUploads.clients.map(client => {
              let newClient = {
                entered_datetime: client.created_at,
                entered_by: serverName,
                client_number: client.sequence,
                accomplished_datetime: client.updated_at,
                psgc: client.aics_client.psgc.brgy_psgc,
                last_name: client.aics_client.last_name,
                first_name: client.aics_client.first_name,
                middle_name: client.aics_client.middle_name,
                ext_name: client.aics_client.ext_name,
                sex: client.aics_client.gender,
                civil_status: client.aics_client.civil_status,
                birth_date: client.aics_client.birth_date,
                age: client.aics_client.age,
                mode_of_admission: "Referral",
                type_of_assistance: client.aics_client.aics_type.name,
                amount: this.data.amount,
                source_of_fund: this.data.source_of_fund,
                client_category: client.category ? client.category.category : "",
                charging: this.data.charging,
                mode_of_assistance: "CAV",
                date_claimed: client.date_claimed,
                uuid: client.aics_client.uuid,
              };
              return newClient
            });
          await axios.post(`${globalUrl}/api/clients`, {aics_clients});
          await axios.post(`${localUrl}/api/clients`, {aics_clients});
          this.crimsUploads.currentBatch++;
        }

      } catch (error) {
        console.log(error);
        this.crimsUploads.isConnected = false;
        this.crimsUploads.connectionStatus = "Unable to connect to server.";
      }
    }, 250),
    markAllAsClaimed: debounce(async function () {
      if(confirm("Are you sure you want to tag all clients as claimed?")){
        axios.post(route('api.payroll.set_claimed', this.id))
        .then(res => {
          alert("All clients has been tagged as claimed.");
          this.getClients();
        })
        .catch(res => {
          console.error(res);
        });
      }
    }, 250),
    MarkAsClaimed: debounce(async function () {
      let promises = [];
      for (let index = 0; index < this.selected.length; index++) {
        const item = this.selected[index];
        if(!item.deleted_at){
          item.status = "claimed";
          promises.push(this.save(item));
        }
      }
      await Promise.all(promises);
      this.getClients();
    }, 250),
    MarkAsUnClaimed: debounce(async function () {
      let promises = [];
      for (let index = 0; index < this.selected.length; index++) {
        const item = this.selected[index];
        item.status = "";
        promises.push(this.save(item));
      }
      await Promise.all(promises);
      this.getClients();
    }, 250),
    PrintGISMany() {
      if(!isEmpty(this.selected)){
        let ids = this.selected.map(item => item.aics_client_id);
        window.open(

            route(`pdf.batch-gis`, {
              id: this.id,
              _query: {
                ids
              }
            }),
            "_blank"
        );
      }
    },
    selectAllToggle(props) {
      if(this.selected.length != (props.items.length - this.disabledCount)) {
        this.selected = [];
        this.disabledCount = 0;
        const self = this;
        props.items.forEach(item => {
          if(!item.deleted_at) {
            self.selected.push(item);
          }else{  
            this.disabledCount++;
          }
        });
      }else{
        this.selected = [];
      }
     }


  },
  mounted() {
    this.isBusy = true;
    this.getClients();
  },

  computed: {
    lastPage() {
      return Math.ceil(this.data.clients.length / 10);
    },
    uploadProgress(){
      return (this.crimsUploads.currentBatch / this.crimsUploads.lastBatch) * 100;
    }
  }

};
</script>

<style></style>