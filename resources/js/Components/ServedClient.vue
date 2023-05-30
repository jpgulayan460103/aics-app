<template>
  <div>
    <v-card flat>
      <v-card-title>
        Served Client from {{ dateFrom }} to {{ dateTo }}
        <v-spacer></v-spacer>
        <v-text-field @keyup="searchClient" v-model="search" append-icon="mdi-magnify" label="Search" single-line hide-details></v-text-field>
      </v-card-title>
      <v-card-text>
        <v-data-table
          :headers="headers"
          :items="servedClients"
          :loading="loading"
          dense
          loading-text="Loading... Please wait"
          :hide-default-footer="true"
        >
          <template v-slot:item.status="{ item }">

            <v-chip v-if="item.payroll_client">
              In Payroll {{ item.payroll_client.payroll.amount }}
              | Client No: {{ item.payroll_client.sequence }}
              <span v-if="item.payroll_client.status"> | {{ item.payroll_client.status }}</span>
            </v-chip>
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

        </v-data-table>

        <v-col cols="12" sm="12" md="8" lg="4">
          <v-pagination
            v-model="currentPage"
            :length="lastPage"
            @input="getList"
          ></v-pagination>
        </v-col>

        <div>
          <v-btn :loading="isExporting" @click="downloadClient()" >Download to EXCEL</v-btn>
          <v-btn :loading="isExporting" @click="downloadClient()" >Download from Database</v-btn>
        </div>

      </v-card-text>
    </v-card>
  </div>
</template>
 
<script>
import userMixin from './../Mixin/userMixin.js'
import { debounce, cloneDeep } from "lodash";

export default {
  mixins: [userMixin],
  props: ["user"],
  data() {
    return {
        search: "",
        servedClients: [],
        loading: true,
        perPage: 20,
        currentPage: 1,
        lastPage: 1,
        dialog_create: false,
        dialogData_edit: {},
        isExporting: false,
        headers: [
            { value: "first_name", text: "First Name", sortable: true },
            { value: "middle_name", text: "Middle Name", sortable: true },
            { value: "last_name", text: "Last Name", sortable: true },
            { value: "ext_name", text: "Ext", sortable: true },
            { value: "birth_date", text: "DOB", sortable: true },
            { value: "barangay", text: "Barangay", sortable: true },
            { value: "city_muni", text: "City/Muni", sortable: true },
            { value: "province", text: "Province", sortable: true },
            { value: "date_claimed", text: "Date Served", sortable: true },
            { value: "amount", text: "Amount", sortable: true },
        ],
    };
  },

  methods: {
    searchClient: debounce(function() {
      this.currentPage = 1;
      this.getList();
    }, 500),
    getList() {
      this.loading = true;
      axios
        .get(route("api.served-clients.index"), {
          params: {
            search: this.search,
            page: this.currentPage,
          }
        })
        .then((response) => {
          this.loading = false;
          this.servedClients = response.data.clients.data;
          this.perPage = response.data.clients.per_page;
          this.currentPage = response.data.clients.current_page;
          this.lastPage = response.data.clients.last_page;
          this.dateFrom = response.data.date_from;
          this.dateTo = response.data.date_to;
        })
        .catch((error) => {
            console.log(error);
            this.loading = false;
        });
    },
  },
  watch: {

  },
  mounted() {
    this.getList();
  },
};
</script>