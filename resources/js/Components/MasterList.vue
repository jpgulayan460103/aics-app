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
          :hide-default-footer="true">
          <template v-slot:item.status="{ item }">


            <v-chip v-if="item.payroll_client">
              In Payroll <span v-if="item.payroll_client.amount">{{ item.payroll_client.payroll.amount }}</span>
              | Client No: {{ item.payroll_client.sequence }}
              <span v-if="item.payroll_client.status"> | {{ item.payroll_client.status }}</span>
            </v-chip>

          </template>

          <template v-slot:item.verified="{ item }">
            <span dark v-if="item.is_verified == 'grievance'">{{
              item.is_verified }}
            </span>

            <span v-if="!item.is_verified">
              <v-btn dark small @click="isVerified(item.id, 'verified')">
                <v-icon small> mdi-check-circle </v-icon>
                VERIFY
              </v-btn>
              <br>


            </span>
          </template>

          <template v-slot:item.grievance="{ item }">


            <span v-if="!item.is_verified">
              <v-btn dark small @click="isVerified(item.id, 'grievance')">
                <v-icon small>mdi-close-circle </v-icon>
                GRIEVANCE </v-btn>
            </span>
          </template>



          <template v-slot:item.barangay="{ item }">
            <span v-if="item.psgc"> {{ item.psgc.brgy_name }}</span>
          </template>

          <template v-slot:item.city_muni="{ item }">
            <span v-if="item.psgc"> {{ item.psgc.city_name }}</span>
          </template>

          <template v-slot:item.province="{ item }">
            <span v-if="item.psgc"> {{ item.psgc.province_name }}</span>
          </template>

          <template v-slot:item.region="{ item }">
            <span v-if="item.psgc"> {{ item.psgc.region_name }}</span>
          </template>

          <template v-slot:item.actions="{ item }">

            <span
              v-if="!item.payroll_client || (item.payroll_client && item.payroll_client.status == 'cancelled-revalidate')">
              <span v-if="item.is_verified == 'verified'">
                <v-icon small class="mr-2" @click="EditItem(item)">
                  mdi-pencil
                </v-icon>
              </span>
            </span>

            <!--<span v-if="item.payroll_client || item.is_verified == 'grievance' || !item.is_verified  ">
              <small> No Action Available </small>
            </span>-->





            <!--<v-icon small class="mr-2" @click="PrintGIS(item)"
              v-if="item.payroll_client && item.payroll_client.payroll_id">
              mdi-printer
            </v-icon>-->

          </template>
        </v-data-table>

        <v-col cols="12" sm="12" md="8" lg="4">
          <v-pagination v-model="currentPage" :length="lastPage" @input="getList"></v-pagination>
        </v-col>

        <div v-if="userData.role == 'Super-Admin'">
          <v-btn :loading="isExporting" @click="downloadClient()">Download</v-btn>
        </div>

      </v-card-text>
    </v-card>
  </div>
</template>
 
<script>
import GISComponent from "./GISComponent.vue";
import userMixin from './../Mixin/userMixin.js'
import { debounce, cloneDeep } from "lodash";

export default {
  mixins: [userMixin],
  props: ["user"],
  components: { GISComponent },
  data() {
    return {
      search: "",
      data: [],
      isBusy: true,

      perPage: 20,
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
        { value: "barangay", text: "Barangay", sortable: true },
        { value: "city_muni", text: "City/Muni", sortable: true },
        { value: "province", text: "Province", sortable: true },

        { value: "status", text: "Payroll Status", sortable: true },
        { value: "verified", text: "Verification Status" },
        { value: "grievance", text: "" },

        { value: "actions", text: "Actions" },
      ],
      isExporting: false,

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
    isVerified: debounce(function (id, stat) {
      axios.post(route("api.client.verify", id), { "is_verified": stat }).then(response => {
        console.log(response.data);
      }).catch(err => console.log(err))
      this.getList();

    }, 200),
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