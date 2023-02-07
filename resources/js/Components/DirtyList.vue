<template>
  <div>
    <b-pagination
      v-model="currentPage"
      :total-rows="rows"
      :per-page="perPage"
      aria-controls="my-table"
    ></b-pagination>

    <b-table
      id="my-table"
      class="table text-center"
      striped
      hover
      bordered
      :per-page="perPage"
      :items="data"
      :busy="isBusy"
      :fields="fields"
      label-sort-asc=""
      label-sort-desc=""
      label-sort-clear=""
      small
    >
      <template #table-busy>
        <div class="text-center text-danger my-2">
          <b-spinner class="align-middle"></b-spinner>
          <strong>Loading...</strong>
        </div>
      </template>
    </b-table>
  </div>
</template>
 
 <script>
export default {
  data() {
    return {
      data: [],
      isBusy: false,
      perPage: 100,
      currentPage: 1,
      fields: [
        { key: "id", label: "ID", sortable: true },
        { key: "middle_name", label: "Middle Name", sortable: true },
        { key: "last_name", label: "Last Name", sortable: true },
        { key: "ext_name", label: "Ext", sortable: true },
        { key: "birth_date", label: "DOB", sortable: true },
        { key: "barangay", label: "Barangay", sortable: true },
        { key: "city_muni", label: "City/Muni", sortable: true },
        { key: "province", label: "Province", sortable: true },
        { key: "region", label: "Region", sortable: true },
        { key: "fund_source", label: "Fund Source", sortable: true },
        { key: "status", label: "Status", sortable: true },
        { key: "actions", label: "Actions" },
      ],
    };
  },
  computed: {
    rows() {
      return this.data.length;
    },
  },
  methods: {
    getList() {
      this.isBusy = !this.isBusy;
      axios
        .get(route("api.dirty_list.index"))
        .then((response) => {
          this.isBusy = !this.isBusy;
          this.data = response.data;
        })
        .catch((error) => console.log(error));
    },
    onFiltered(filteredItems) {
        // Trigger pagination to update the number of buttons/pages due to filtering
        this.totalRows = filteredItems.length
        this.currentPage = 1
      }
  },
  mounted() {
    this.getList();
  },
};
</script>