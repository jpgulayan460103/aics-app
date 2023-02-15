<template>
  <v-card flat>
    <v-card-title>Home</v-card-title>
    <v-card-text>
    
      <v-data-table
          :headers="headers"
          :items="data"
          :items-per-page="50"
          :loading="isBusy"
          loading-text="Loading... Please wait"
         
        >
        <template v-slot:item.title="{ item }">
         {{ item.title  }} <br>
         <small>{{ item.psgc.brgy_name }},{{ item.psgc.city_name }},{{ item.psgc.province_name }}</small>
</template>
      
<template v-slot:item.total="{ item }">
         {{ item.clients_paid * item.amount }}
</template>

        </v-data-table>

    </v-card-text>
  </v-card>
</template>

<script>
export default {
  data() {
    return {
      data: [],
      isBusy: false,
      headers: [
       
        { value: "title", text: "Title", sortable: true },
        { value: "sdo", text: "SDO", sortable: true },
        { value: "clients_count", text: "No. of Clients in Payroll", sortable: true },
        { value: "clients_paid", text: "Clients Paid", sortable: true },
        { value: "amount", text: "Amount per Client", sortable: true },
        { value: "total", text: "Total", sortable: true },
       
      ],
    };
  },

  methods: {
    getReports() {
      this.isBusy = true;
      axios.get( route("api.report")).then((response) => {
        console.log(response.data);
        this.data = response.data;
        this.isBusy = false;
      });
    },
  },
  mounted() {
    this.getReports();
  },
};
</script>

<style>
</style>