<template>
  <div>
    <b-table
      class="table text-center"
      striped
      hover
      bordered
      :items="data"
      :fields="fields"
      :busy="isBusy"
      label-sort-asc=""
      label-sort-desc=""
      label-sort-clear=""
    >
      <template #cell(created_at)="data">
        {{ data.item.created_at | formatDate }}
      </template>

      <template #cell(client)="data">
        {{ data.item.aics_client.last_name }}
        {{ data.item.aics_client.ext_name }},
        {{ data.item.aics_client.first_name }}
        {{ data.item.aics_client.middle_name }}
      </template>

      <template #cell(beneficiary)="data">
        {{ data.item.aics_beneficiary.last_name }}
        {{ data.item.aics_beneficiary.first_name }}
        {{ data.item.aics_beneficiary.middle_name }}
      </template>

      <template #cell(assistance)="data">
        {{ data.item.aics_type.name }}
      </template>

      <template #cell(actions)="data">
        <b-button @click="ViewDetails(data.item)" v-b-modal.modal-xl>
          Show Details
        </b-button>
      </template>

      <template #row-details="row">
        <b-card>
          <b-row class="mb-2">
            <b-col sm="3" class="text-sm-right"><b>Age:</b></b-col>
          </b-row>

          <b-row class="mb-2">
            <b-col sm="3" class="text-sm-right"><b>Is Active:</b></b-col>
          </b-row>

          <b-button size="sm" @click="row.toggleDetails">Hide Details</b-button>
        </b-card>
      </template>
    </b-table>

    <b-modal id="modal-xl" title="Details" size="xl">
      <div class="row" v-if="details">
        <span v-if="details.aics_type">
          {{ details.aics_type.name }}
        </span>

        <div class="col-md-12">
          <b-list-group>
            <b-list-group-item
              >GIS

              <iframe
                :src="gis_pdf"
                frameborder="0"
                style="min-height: 500px; width: 100%"
              ></iframe>
            </b-list-group-item>

            <b-list-group-item
              v-for="(docs, i) in details.aics_documents"
              :key="i"
              ><p>{{ docs.requirement.name }}</p>

              <iframe
                :src="docs.file_directory"
                frameborder="0"
                style="min-height: 500px; width: 100%"
              ></iframe>

              <!--<b-img
              thumbnail
              fluid
              :src="docs.file_directory"
              alt=""
              class="img-fluid"
            />-->
            </b-list-group-item>
          </b-list-group>
        </div>
      </div>

      <template #modal-footer="{ close }">
        <div class="w-100">
          <p class="float-left">Modal Footer Content</p>

          <button
            class="btn btn-success"
            @click="UpdateStatus(details, 'Served')"
          >
            Serve
          </button>
          <button
            class="btn btn-danger"
            @click="UpdateStatus(details, 'Rejected')"
          >
            Reject
          </button>

          <b-button variant="primary" class="float-right" @click="close()">
            Close
          </b-button>
        </div>
      </template>
    </b-modal>
  </div>
</template>

<script>
export default {
  data() {
    return {
      data: [],
      details: [],
      gis_pdf: [],
      fields: [
        { key: "created_at", label: "Date", sortable: true },
        { key: "client", label: "Client", sortable: true },
        { key: "beneficiary", label: "Beneficiary", sortable: true },
        { key: "assistance", label: "Assistance Requested", sortable: true },
        { key: "status", label: "Status", sortable: true },
        { key: "actions", label: "Actions" },
      ],
      isBusy: true,
    };
  },
  computed: {},
  methods: {
    getGIS() {
      this.isBusy = true;
      axios
        .get("api/aics/assistances")
        .then((response) => {
          console.log(response.data);
          this.data = response.data;
          this.isBusy = false;
        })
        .catch((error) => console.log(error));
    },

    ViewDetails(e) {
      this.gis_pdf = "api/pdf/" + e.uuid;
      this.details = e;
    },
    Print(e) {
      /*console.log(e.uuid);
      
        axios.get()
        .then((response)=>{
            console.log(response.data);
            this.details = response.data;
        }).error((err)=>console.log(err));*/
    },
    UpdateStatus(e, s) {
      axios
        .put("api/aics/assistances/" + e.uuid, { uuid: e.uuid, status: s })
        .then((response) => {
          alert(response.data.message);

          if (response.data.message == "saved");
          {
            this.getGIS();
          }
        })
        .catch((error) => console.log(error));
    },
  },
  mounted() {
    this.getGIS();
  },
};
</script>

<style>
</style>