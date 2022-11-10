<template>
  <div>
    <table class="table text-center table-bordered">
      <thead>
        <tr>
          <td>Date</td>
          <td>Client</td>
          <td>Beneficiary</td>
          <td>Assistance Requested</td>
          <td>Status</td>
          <td>Actions</td>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(e, i) in data" :key="i" @click="ViewDetails(e)">
          <!--<td><pre>{{e}}</pre></td>-->
          <td>{{ e.created_at }}</td>
          <td>
            {{ e.aics_client.last_name }}, {{ e.aics_client.first_name }}
            {{ e.aics_client.middle_name }}
          </td>
          <td>
            {{ e.aics_beneficiary.last_name }},
            {{ e.aics_beneficiary.first_name }}
            {{ e.aics_beneficiary.middle_name }}
          </td>
          <td>{{ e.aics_type.name }}</td>
          <td>{{ e.status }}</td>
          <td>
            <button class="btn btn-primary" @click="ViewDetails(e)">
              Info
            </button>
            <button class="btn btn-success" @click="Approve(e)">Serve</button>
            <button class="btn btn-danger" @click="Reject(e)">Reject</button>
            <!--<button class="btn btn-info" @click="Print(e)">d</button>-->
          </td>
        </tr>
      </tbody>
    </table>

    <div class="card" v-if="details">
      <div class="row">
        <div class="col-md-6">
          <iframe :src="gis_pdf" frameborder="0" style="height: auto"></iframe>
        </div>
        <div class="col-md-6">
          <div v-for="(docs, i) in details.aics_documents" :key="i">
            <img :src="docs.file_directory" alt="" class="img-fluid"/>
          </div>
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
    };
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