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

      <template #cell(status)="data">
        <div :class="getColor(data.item.status)">
          {{ data.item.status }}
        </div>
      </template>

      <template #cell(actions)="data">
        <b-button size="sm" @click="ViewDetails(data.item)" v-b-modal.modal-xl>
          Show Details
        </b-button>
      </template>

      <!--<template #row-details="row">
        <b-card>
          <b-row class="mb-2">
            <b-col sm="3" class="text-sm-right"><b>Age:</b></b-col>
          </b-row>

          <b-row class="mb-2">
            <b-col sm="3" class="text-sm-right"><b>Is Active:</b></b-col>
          </b-row>

          <b-button size="sm" @click="row.toggleDetails">Hide Details</b-button>
        </b-card>
      </template>-->
    </b-table>

    <b-modal
      id="modal-xl"
      title="Details"
      size="xl"
      class="modal modal-xl"
      role="document"
      modal-class="modal-fullscreen"
      button-size="sm"
    >
      <div class="container-fluid" v-if="details">
        <div class="row">
          <div class="col-md-8">
            <div class="images" v-viewer v-if="show_img_pv">
              <!--<img v-for="src in images" :key="src" :src="src" />-->
              <img :src="src" style="width: 100%; height: auto" />
            </div>

            <iframe
              v-if="!show_img_pv"
              :src="src"
              style="min-height: 56.25vw; width: 100%"
            ></iframe>
          </div>

          <div class="col-md-4" v-if="details.aics_type">
            Assistance Requested: <b> {{ details.aics_type.name }}</b> <br />
            <hr />

            <b-button size="sm" @click="ViewFile(gis_pdf)"
              >View General Intake Sheet</b-button
            >

            <br />
            <hr />
            Requirements:

            <div
              class="card tex-center"
              v-for="(docs, i) in details.aics_documents"
              :key="i"
              @click="ViewFile(docs.file_directory)"
              style="cursor: pointer; margin-bottom: 10px"
            >
              <div class="card-body">
                <b-icon icon="paperclip" style="color: grey"></b-icon>
                {{ docs.requirement.name }}
              </div>
            </div>
          </div>
        </div>
      </div>

      <template #modal-footer="{ close }">
        <b-button
          class="btn btn-success float-right"
          @click="UpdateStatus(details, 'Served')"
        >
          Serve
        </b-button>
        <b-button
          class="btn btn-danger float-right"
          @click="UpdateStatus(details, 'Rejected')"
        >
          Reject
        </b-button>

        <!--<b-button variant="primary" class="float-right" @click="close()">
            Close
          </b-button>-->
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
      src: "",
      color: "blue",
      show_img_pv: false,
    };
  },
  computed: {
    images() {
      this.details.aics_documents;
    },
  },
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
      this.src = this.gis_pdf;
      this.show_img_pv = false;
    },
    ViewFile(e) {
      let ext = e.split(".").pop();
      let images = ["png", "jpeg", "jpg"];

      if (images.includes(ext)) {
        this.src = e;
        this.show_img_pv = true;
      } else {
        this.show_img_pv = false;
        this.src = e;
      }
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
          if (response.data.message == "saved") {
            alert(response.data.message + " " + s);
            this.getGIS();
          } else {
            alert(response.data.message);
          }
        })
        .catch((error) => console.log(error));
    },
    getColor(e) {
      switch (e) {
        case "Served":
          return "green";
          break;
        case "Rejected":
          return "red";
          break;
        default:
          return "blue";
          break;
      }
    },
  },
  mounted() {
    this.getGIS();
    console.log("here 2" );
  },
};
</script>

<style>
.modal-fullscreen .modal-dialog {
  max-width: 100%;
  margin: 0;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  height: 100vh;
  display: flex;
  position: fixed;
  z-index: 100000;
}
.red {
  color: red;
}
.green {
  color: green;
}
.blue {
  color: blue;
}
</style>