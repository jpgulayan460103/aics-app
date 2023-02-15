<template>
  <v-card flat outlined>
    <v-system-bar color="white">
      <v-icon @click="print()"> mdi-printer</v-icon>
      <v-icon>mdi-download</v-icon>
    </v-system-bar>
    <v-card-title>
     
    </v-card-title>
    <v-card-text>
      <div class="row">
        <div class="col-md-12 text-center">
          <h2>{{ data.title }}</h2>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6" v-if="data.psgc">
          CITY/MUNICIPALITY : {{ data.psgc.city_name }}<br />
          BARANGAY : {{ data.psgc.brgy_name }} <br />
          {{ data.schedule }}
        </div>
        <div class="col-md-6 text-end">
          

          <v-spacer></v-spacer>
        <v-text-field
          v-model="search"
          append-icon="mdi-magnify"
          label="Search"
          single-line
          hide-details
        ></v-text-field>

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
        <template v-slot:item.amount="{ item }">
          {{ data.amount }}
        </template>

        <!--template v-slot:item.actions="{ item }">
          <v-icon small class="mr-2" @click="EditItem(item)">
            mdi-pencil
          </v-icon>
        </template>-->

        <template v-slot:item.status="{item}">
          <v-edit-dialog
            :return-value.sync="item.status"
            large
            persistent
            @save="save(item)"
            @cancel="cancel(item)"
          
          >
            <div>{{ item.status }}</div>
            <template v-slot:input>
              <div class="mt-4 text-h6">Claim Status</div>
              <select class="form-control" v-model="item.status">
                <option value=""></option>
                <option value="claimed">Claimed</option>
              </select>
            </template>
          </v-edit-dialog>
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
        
        { value: "last_name", text: "Last Name", sortable: false },
        { value: "first_name", text: "First Name", sortable: false },
        { value: "middle_name", text: "Middle Name", sortable: false },
        { value: "ext_name", text: "Ext", sortable: false },
        { value: "amount", text: "Amount", sortable: false },

        { value: "status", text: "Status", sortable: false },
      ],
      search: "",
    };
  },
  watch() {
    id();
    {
      this.getClients();
    }
  },
  methods: {
    print() {
      window.open(route("api.payroll.print", this.id), "_blank");
    },
    getClients() {
      axios
        .get(route("api.payroll.show", this.id))
        .then((res) => {
          this.data = res.data;
          this.isBusy = false;
        })
        .catch((error) => console.log(error));
    },
    save(e) {
      console.log(e);
      axios.post(route("api.client.update",e.id),e).then(response => {
        console.log(response.data);
      }).catch(error=>console.log(error));
    },
    cancel(e)
    {
      e;
    }
  
    
  },
  mounted() {
    console.log("list");
    console.log(this.id);
    this.isBusy = true;
    this.getClients();
  },
};
</script>

<style>
</style>