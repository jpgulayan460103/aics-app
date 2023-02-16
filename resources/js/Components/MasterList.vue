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
          <GISComponent :dialog_data="dialogData_edit"></GISComponent>
        </v-card-text>
      </v-card>
    </v-dialog>
    <v-card flat>
      <v-card-title>
        Master List
        <v-spacer></v-spacer>
        <v-text-field
          v-model="search"
          append-icon="mdi-magnify"
          label="Search"
          single-line
          hide-details
        ></v-text-field>
      </v-card-title>
      <v-card-text>
        <v-btn
          elevation="2"
          icon
          @click="exportClients"
          :disabled="isExporting"
          :loading="isExporting"
        >
          <v-icon>mdi-download</v-icon>
        </v-btn>
        <v-data-table
          dense
          :headers="headers"
          :items="data"
          :items-per-page="50"
          :loading="isBusy"
          loading-text="Loading... Please wait"
          :search="search"
        >
          <template v-slot:item.status="{ item }">
            
            <v-chip v-if="item.payroll_id"> In Payroll 
              {{item.payroll.amount}}
            <span color="green" v-if="item.status=='claimed'" dark> | {{ item.status }}</span></v-chip>
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
            <v-icon small class="mr-2" @click="EditItem(item)">
              mdi-pencil
            </v-icon>
          </template>
        </v-data-table>
      </v-card-text>
    </v-card>
  </div>
</template>
 
<script>
import GISComponent from "./GISComponent.vue";
import { debounce } from "lodash";

export default {
  components: { GISComponent },
  data() {
    return {
      search: "",
      data: [],
      isBusy: true,
      isExporting: false,
      perPage: 100,
      currentPage: 1,
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
        { value: "region", text: "Region", sortable: true },

        { value: "status", text: "Status", sortable: true },
        { value: "actions", text: "Actions" },
      ],
    };
  },

  methods: {
    getList() {
      axios
        .get(route("api.clients"))
        .then((response) => {
          this.isBusy = !this.isBusy;
          this.data = response.data;
        })
        .catch((error) => console.log(error));
    },
    EditItem(item) {
      this.dialog_create = true;
      this.dialogData_edit = {};
      this.dialogData_edit = item;
    },
    exportClients: debounce(function () {
      this.isExporting = true;
      axios
        .post(route("api.client.export"))
        .then((res) => {
          this.isExporting = false;
          window.location.href = res.data.file;
        })
        .catch((err) => {
          this.isExporting = false;
        });
    }, 500),
  },
  mounted() {
    this.getList();
  },
};
</script>