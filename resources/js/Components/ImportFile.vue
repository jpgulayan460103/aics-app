<template>
  <v-card flat>
    <v-card-title>Import </v-card-title>
    <v-card-text>
      <form @submit.prevent="submit" enctype="multipart/form-data">
        <input type="file" name="" id="" @input="onFileChange($event)" required/>

        

        <v-btn :loading="isBusy"  color="black"
      class="ma-2 white--text" :disabled="isBusy" type="submit" >
          SUBMIT
        </v-btn>

        feedback: {{ feedback }}
      </form>
    </v-card-text>
  </v-card>
</template>

<script>
export default {
  name: "import",
  data() {
    return {
      file: [],
      isBusy: false,
      feedback: "",
    };
  },
  methods: {
    submit() {
      console.log("here");
      this.isBusy = true;
      let formData = new FormData();
      formData.append("file", this.file);

      const headers = {
        "Content-Type": "multipart/form-data;",
      };

      axios
        .post(route("api.client.upload"), formData, headers)
        .then((response) => {
          console.log("ajdlkasd");
          this.isBusy = false;
          console.log(response.data);
         this.feedback = response.data.success;
        })
        .catch((error) => {console.log(error);
          this.feedback = response.data.errors.message;
        });
    },
    onFileChange(e) {
      console.log(e);
      this.file = e.target.files[0];
      console.log(this.formData);
    },
  },
};
</script>

<style>
</style>