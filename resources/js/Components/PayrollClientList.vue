<template>
  <v-card flat outlined>
    <v-system-bar color="primary">
      <v-icon @click="print()"> mdi-printer</v-icon>
      <v-icon>mdi-download</v-icon>
    </v-system-bar>
    <v-card-text>
      <div class="row">
        <div class="col-md-12 text-center">
          <h2>{{ data.title }}</h2>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          CITY/MUNICIPALITY : {{ data.muni_city }}<br />
          BARANGAY : {{ data.barangay }} <br />
        </div>
        <div class="col-md-6 text-end">
          {{ data.schedule }}
        </div>
      </div>
      <v-data-table
        v-if="data.clients"
        :headers="headers"
        :items="data.clients"
        :items-per-page="10"
        :loading="isBusy"
        loading-text="Loading... Please wait"
        :search="search"
      >
        <template v-slot:item.actions="{ item }">
          <v-icon small class="mr-2" @click="EditItem(item)">
            mdi-pencil
          </v-icon>
        </template>
      </v-data-table>

      

    </v-card-text>
  </v-card>
</template>

<script>
export default {
  props: ["id"],
  data() {
    return {
      data: [],
      isBusy: false,
      headers: [
        { value: "id", text: "ID", sortable: false },
        { value: "last_name", text: "Last Name", sortable: false },
        { value: "first_name", text: "First Name", sortable: false },
        { value: "middle_name", text: "Middle Name", sortable: false },
        { value: "ext_name", text: "Ext", sortable: false },
        { value: "amount", text: "Amount", sortable: false },
        { value: "signature", text: "signature", sortable: false },
       
      ],
    };
  },
  methods:
  {
    print()
    {
      window.open(route("api.payroll.print",this.id), "_blank")
    }
  },
  mounted() {
    console.log("list");
    console.log(this.id);
    this.isBusy = true;
    axios
      .get(route("api.payroll.show", this.id))
      .then((res) => {
        this.data = res.data[0];
        this.isBusy = false;
      })
      .catch((error) => console.log(error));
  },
};
</script>

<style>
</style>