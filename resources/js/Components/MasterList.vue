<template>
  <div>
    <v-dialog v-model="dialog_create" width="80%" fullscreen>
      <v-card>
        <v-card-title>
          <v-spacer></v-spacer>
          <v-btn icon @click="dialog_create = false">
            <v-icon>mdi-close</v-icon>
          </v-btn>
        </v-card-title>
        <v-card-text>
          <GISComponent :dialog_data="dialogData_edit" :getList="getList" :user-data="userData"
            :set-dialog-create="setDialogCreate"></GISComponent>
        </v-card-text>
      </v-card>
    </v-dialog>
    <v-card flat>
      <v-card-title>
        Master List
        <v-spacer></v-spacer>
        <v-text-field @keyup="searchClient" v-model="search" append-icon="mdi-magnify" label="Search" single-line
          hide-details></v-text-field>
      </v-card-title>
      <v-card-text>
        <v-data-table :headers="headers" :items="data" :loading="isBusy" dense loading-text="Loading... Please wait"
          :hide-default-footer="true" :items-per-page="perPage" :page.sync="currentPage">
          <template v-slot:item.status="{ item }">

            <v-chip v-if="item.is_verified == 'grievance'" small color="red" outlined>{{
              item.is_verified }}
            </v-chip>

            <div v-if="item.payroll_client && item.is_verified != 'grievance'">
              <div v-if="item.payroll_client.new_payroll_client">
                <v-chip color="primary" outlined small>
                  Client No: {{ item.payroll_client.new_payroll_client.sequence }}
                </v-chip>
                <v-chip small> In Payroll schedule:
                  ({{ item.payroll_client.new_payroll_client.payroll.schedule }}) |
                  amount: {{ item.payroll_client.new_payroll_client.payroll.amount }}
                </v-chip>

                <v-chip small> Date Accomplished: {{
                  item.payroll_client.updated_at | FormatDateAccomplished }}
                </v-chip>

              </div>


              <div v-else>
                <v-chip color="primary" outlined small :hidden="item.payroll_client.status == 'cancelled-revalidate'">
                  Client No: {{ item.payroll_client.sequence }}</v-chip>
                <span v-if="item.payroll_client.status">
                  <v-chip small :color="item.payroll_client.status != 'cancelled-revalidate' ? 'success' : 'error'"
                    outlined>{{ item.payroll_client.status }}</v-chip>
                </span>

                <v-chip small :hidden="item.payroll_client.status == 'cancelled-revalidate'"> In Payroll schedule: ({{
                  item.payroll_client.payroll.schedule }}) | amount: {{
    item.payroll_client.payroll.amount }} </v-chip>


                <div class="my-2" v-if="item.payroll_client">
                  <v-chip small :hidden="item.payroll_client.status == 'cancelled-revalidate'"> Date Accomplished: {{
                    item.payroll_client.updated_at | FormatDateAccomplished }}
                  </v-chip>
                </div>
              </div>
            </div>



            
          </template>

          <template v-slot:item.barangay="{ item }">
            <span v-if="item.psgc"> <small>{{ item.psgc.brgy_name }}, <br> {{ item.psgc.city_name }},<br> {{
              item.psgc.province_name }}</small> </span>
          </template>




          <template v-slot:item.actions="{ item }">

            <div>
              <span
                v-if="!item.payroll_client || (item.payroll_client && item.payroll_client.status == 'cancelled-revalidate') || userData.role == 'Super-Admin'">
                <span v-if="item.is_verified == 'verified'">
                  <v-btn small elevation="0" color="primary" class="white--text" tile @click="EditItem(item)">
                    <v-icon left>
                      mdi-pencil
                    </v-icon>GIS

                  </v-btn>
                </span>
              </span>

              <v-btn-toggle tile group borderless v-if="!item.is_verified">
                <v-btn small value="left" @click="isVerified(item.id, 'verified', item)" :loading="verifying">
                  <v-icon left> mdi-check-circle </v-icon>
                  Verify
                </v-btn>

                <v-btn small value="center" @click="isVerified(item.id, 'grievance', item)" :loading="verifying">
                  <v-icon left> mdi-close-circle </v-icon>
                  Grievance
                </v-btn>
              </v-btn-toggle>


            </div>


          </template>
        </v-data-table>

        <v-col cols="12" sm="12" md="8" lg="4">
          <v-pagination v-model="currentPage" :length="lastPage" @input="getList"></v-pagination>
        </v-col>

        <div v-if="userData.role == 'Super-Admin'">
          <v-btn color="primary" :loading="isExporting" @click="downloadClient()">Download</v-btn>
        </div>

      </v-card-text>
    </v-card>
  </div>
</template>
 
<script>
import GISComponent from "./GISComponent.vue";
import userMixin from './../Mixin/userMixin.js'
import authMixin from "../Mixin/authMixin";
import { debounce, cloneDeep } from "lodash";

export default {
  mixins: [userMixin, authMixin],
  props: ["user"],
  components: { GISComponent },
  data() {
    return {
      search: "",
      data: [],
      isBusy: true,
      perPage: 10,
      currentPage: 1,
      lastPage: 1,
      dialog_create: false,
      dialogData_edit: {},
      headers: [
        { value: "first_name", text: "First Name", sortable: true },
        { value: "middle_name", text: "Middle Name", sortable: true },
        { value: "last_name", text: "Last Name", sortable: true },
        { value: "ext_name", text: "Ext", sortable: true },
        { value: "birth_date", text: "DOB", sortable: true },
        { value: "barangay", text: "Address", sortable: true },
        { value: "user.name", text: "Last Updated By", sortable: true },
        { value: "status", text: "Payroll Status", sortable: true, divider: true, width: '50px', },
        { value: "actions", text: "Actions", width: '100px', },
      ],
      isExporting: false,
      verifying: false

    };
  },

  methods: {
    getList() {
      this.isBusy = true;
      axios
        .get(route("api.clients"), {
          params: {
            search: this.search,
            page: this.currentPage,
          }
        })
        .then((response) => {
          this.isBusy = false;
          this.data = response.data.data;
          this.perPage = response.data.per_page;
          this.currentPage = response.data.current_page;
          this.lastPage = response.data.last_page;
        })
        .catch((error) => console.log(error));
    },
    EditItem(item) {
      this.dialog_create = true;
      this.dialogData_edit = {};
      this.dialogData_edit = cloneDeep(item);
    },
    PrintGIS(item) {
      window.open(
        route("api.pdf.gis2", { id: item.id }),
        "_blank"
      );
    },
    setDialogCreate(value) {
      this.dialog_create = value;
    },
    downloadClient: debounce(function (status = "unclaimed") {
      this.isExporting = true;
      axios.post(route('api.client.export'), { status })
        .then((res) => {
          this.isExporting = false;
          window.location.href = res.data.file;
        })
        .catch(err => {
          console.warn(err);
          this.isExporting = false;
        });
    }, 250),
    searchClient: debounce(function () {
      this.currentPage = 1;
      this.getList();
    }, 500),
    isVerified: debounce(function (id, stat, client) {

      this.verifying = true;
      let message = "TAG " + client.full_name + " AS " + stat.toUpperCase() + "? \n"
      var conf = confirm(message);
      if (conf) {
        axios.post(route("api.client.verify", id), { "is_verified": stat }).then(response => {
          // console.log(response.data);
          this.verifying = false;
          if (response.data.message) {
            alert(response.data.message);
          }

          this.$nextTick(() => {
            this.getList();
          })


        }).catch(err => console.log(err))



      }

    }, 500),
  },
  watch: {
    dialog_create(newVal, oldVal) {
      if (!newVal) {
        this.dialogData_edit = {};
      }
    }
  },
  mounted() {
    this.getList();
  },
};
</script>