<template>
  <div>
    <v-dialog v-model="openModal">
      <v-card>
        <v-card-title>New Payroll</v-card-title>
        <v-card-text>
          <form
            @submit.prevent="submit"
            enctype="multipart/form-data"
            action=""
          >
            <label for=""> Title</label>
            <input
              type="text"
              name=""
              v-model="formData.title"
              id=""
              class="form-control"
            />

            <label for="">SDO</label>
            <input
              type="text"
              name=""
              v-model="formData.sdo"
              id=""
              class="form-control"
            />

            <label for="">Region</label>
            <input
              type="text"
              name=""
              v-model="formData.region"
              id=""
              class="form-control"
            />

            <label for="">Province</label>
            <input
              type="text"
              name=""
              v-model="formData.province"
              id=""
              class="form-control"
            />

            <label for="">Municipality/City</label>
            <input
              type="text"
              name=""
              v-model="formData.muni_city"
              id=""
              class="form-control"
            />

            <label for="">Barangay</label>
            <input
              type="text"
              name=""
              v-model="formData.barangay"
              id=""
              class="form-control"
            />

            <label for="">Schedule</label>
            <input
              type="date"
              name=""
              v-model="formData.schedule"
              id=""
              class="form-control"
            />

            <button
              type="submit"
              class="btn btn-primary btn-block"
            >
              SUBMIT
            </button>
          </form>
        </v-card-text>
      </v-card>
    </v-dialog>

    <v-card flat>
     
      <v-card-title>Payroll
        <v-spacer/>  <v-btn @click="openModal = true" dark>New Payroll</v-btn>
      </v-card-title>
      <v-card-text>
        <v-data-table
          :headers="headers"
          :items="payrolls"
          :items-per-page="50"
          :loading="isBusy"
          loading-text="Loading... Please wait"
          :search="search"
        >
          <template v-slot:item.actions="{ item }">
            <v-icon small class="mr-2" @click="EditItem(item)">
              mdi-pencil
            </v-icon>
            <v-icon small class="mr-2" @click="ViewList(item)">
              mdi-eye
            </v-icon>
          </template>
        </v-data-table>
      </v-card-text>
    </v-card>
  </div>
</template>

<script>
export default {
  data() {
    return {
      openModal: false,
      formData: {
        title: "",
      },
      search: "",
      isBusy: true,
      headers: [
        { value: "id", text: "ID", sortable: true },
        { value: "title", text: "Title", sortable: true },
        { value: "sdo", text: "SDO", sortable: true },
        { value: "province", text: "Province", sortable: true },
        { value: "muni_city", text: "City/Municipality", sortable: true },
        { value: "barangay", text: "Barangay", sortable: true },
      ],
      payrolls: [],
    };
  },
  methods: {
    submit() {
      this.isBusy = true;
      axios
        .post(route("api.payroll.create"), this.formData)
        .then((response) => {
          this.isBusy = false;
          this.data = response.data;
          this.getPayrolls();
        })
        .catch((error) => console.log(error));
    },
    getPayrolls() {
      axios.get(route("api.payroll.index")).then((response) => {
        this.payrolls = response.data;
      });
    },
  },
  mounted() {
    this.getPayrolls();
  },
};
</script>

<style>
</style>