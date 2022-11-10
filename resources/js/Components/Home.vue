<template>
  <div>
    <b-table
      class="table text-center"
      striped
      hover
      bordered
      :items="req_assistance_list"
      :fields="fields"
    >
      <template #cell(created_at)="data">
        {{ data.item.created_at | formatDate }}
      </template>

      <template #cell(client)="data">
        {{ data.item.aics_client.last_name }},
        {{ data.item.aics_client.first_name }}
        {{ data.item.aics_client.middle_name }}
      </template>

      <template #cell(beneficiary)="data">
        {{ data.item.aics_beneficiary.last_name }},
        {{ data.item.aics_beneficiary.first_name }}
        {{ data.item.aics_beneficiary.middle_name }}
      </template>

      <template #cell(assistance)="data">
        {{ data.item.aics_type.name }}
      </template>

      <template #cell(show_details)="data">
        <b-button @click="ViewDetails(data.item)" class="btn btn-primary">
          {{ data.item.detailsShowing ? "Hide" : "Show" }} Details
        </b-button>

        <!--
            
            
            <b-button  @click="data.toggleDetails" class="btn btn-primary">
          {{ data.detailsShowing ? 'Hide' : 'Show'}} Details
        </b-button>
        
        <button class="btn btn-primary" @click="ViewDetails(data.item)">
          Info
        </button>-->

        <button class="btn btn-success" @click="Approve(data.item)">
          Serve
        </button>
        <button class="btn btn-danger" @click="Reject(data.item)">
          Reject
        </button>
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

    <div class="card" v-if="details">
      <div class="row">
        <pre>
            {{details}}
        </pre>
        <div class="col-md-9">
          <iframe
            :src="gis_pdf"
            frameborder="0"
            style="min-height: 500px; width: 100%"
          ></iframe>
        </div>
        <div class="col-md-3">
          <span v-for="(docs, i) in details.aics_documents" :key="i">
            <b-img
              thumbnail
              fluid
              :src="docs.file_directory"
              alt=""
              class="img-fluid"
            />
          </span>
        </div>
      </div>
    </div>
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
        { key: "created_at", label: "Date" },
        { key: "client", label: "Client" },
        { key: "beneficiary", label: "Beneficiary" },
        { key: "assistance", label: "Assistance Requested" },
        { key: "status", label: "Status" },
        { key: "show_details", label: "Actions" },
      ],
    };
  },
  computed: {
    req_assistance_list() {
      return this.data.filter((e, i) => {
        e._showDetails  = false;
        return e;
      });
    },
  },
  methods: {
    getGIS() {
      axios
        .get("api/aics/assistances")
        .then((response) => {
          console.log(response.data);
          this.data = response.data;
        })
        .catch((error) => console.log(error));
    },
    ViewDetails(e) {
      e._showDetails = !e._showDetails;
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
  },
  mounted() {
    this.getGIS();
  },
};
</script>

<style>
</style>