<template>
  <v-card flat outlined>
    <v-card-title>

      <!--<v-btn @click="print_options=!print_options" color="black" dark class="m-1">Print</v-btn>-->
      
      <v-btn @click="print()" color="black" dark class="m-1">
        <v-icon > mdi-printer </v-icon>  Print Current Page:{{ page }}</v-btn>
      
        <v-btn @click="print_w_gt()" color="black" dark class="m-1">
          <v-icon > mdi-printer </v-icon> Print last Page w/ Footer & Grand Total
        </v-btn>
     
      <v-icon @click="print_footer()"> mdi mdi-foot-print</v-icon>
      <!--<v-icon>mdi-download</v-icon>-->
   
     </v-card-title>
    <v-card-text>
      <div class="row">
        <div class="col-md-12 text-center d-print-block">
          <h6>{{ data.title }}</h6>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6" v-if="data.psgc">
          CITY/MUNICIPALITY : {{ data.psgc.city_name }}<br />
          BARANGAY : {{ data.psgc.brgy_name }} <br />
          SCHEDULE : {{ data.schedule }}
        </div>
        <div class="col-md-6 text-end">
          <v-spacer></v-spacer>
          <v-text-field
            v-model="search"
            append-icon="mdi-magnify"
            label="Search"
            single-line
            hide-details
            class="d-print-none"
          ></v-text-field>
        </div>
      </div>
      <v-data-table
        v-if="data.clients"
        :headers="headers"
        :items="data.clients.map((i, index) => {
            i.key = index + 1
            return i;
          })"
        :items-per-page="10"
        :loading="isBusy"
        loading-text="Loading... Please wait"
        :search="search"
        @update:page="currentPage"
        :footer-props="{
              'items-per-page-options':[10],
              'disable-items-per-page': true,
            }"
      >
      <template v-slot:item.key="{ item }">
         {{item.key}}
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

  </v-card>
</template>

<script>
import { isEmpty} from 'lodash'
export default {
  props: ["id"],
  data() {
    return {
      data: [],
      isBusy: false,
      headers: [
      { value: "key", text: "No.", sortable: false },
      { value: "last_name", text: "Last Name", sortable: false },
        { value: "ext_name", text: "Ext", sortable: false, width:"20px;" },
        { value: "first_name", text: "First Name", sortable: false },
        { value: "middle_name", text: "Middle Name", sortable: false },

        { value: "amount", text: "Amount", sortable: false },

        { value: "status", text: "Status", sortable: false },
      ],
      search: "",
      page: 1,
      print_options: false,
     
    };
  },
  computed: {
   lastPage() {return Math.ceil(this.data.clients.length/10);}
},
  watch() {
    id();
    {
      this.getClients();
    }
  },
  methods: {
    print() {
      window.open(
        route("api.payroll.printv2", { id: this.id, page: this.page }),
        "_blank"
      );
    },
    print_w_gt()
    {
      window.open(
        route("api.payroll.printv2", { id: this.id, page: this.lastPage, gt: 1}),
        "_blank"
      );
    },
    print_footer() {
      window.open(route("api.payroll.print_footer", this.id), "_blank");
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
      axios
        .post(route("api.client.update", e.id), e)
        .then((response) => {
          console.log(response.data);
        })
        .catch((error) => console.log(error));
    },
    cancel(e) {
      e;
    },
    currentPage(e)
    {
      this.page = e;
    },
    isEmpty(value){
      return isEmpty(value);
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