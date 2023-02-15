<template>
  <v-card flat>
    <v-card-title>Import </v-card-title>
    <v-card-text>
      <form @submit.prevent="submit" enctype="multipart/form-data">
        <input type="file" name="" id="" @input="onFileChange($event)" required/>

        

        <v-btn
          :loading="isBusy"
          color="black"
          class="ma-2 white--text"
          :disabled="isBusy"
          type="submit"
        >
          SUBMIT
        </v-btn>

        feedback: {{ feedback }}
        <span v-if="errorFile">
          Please download the file to view the errors. 
          <a :href="errorFile">{{ errorFile  }}</a>
        </span>
        
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
      errorFile: "",
    };
  },
  methods: {
    submit() {
      this.errorFile = "";
      // console.log("here");
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
        .catch((error) => {
          this.isBusy = false;
          this.feedback = error.response.data.errors.file[0];
          this.errorFile = error.response.data.errors.errors_file_path;
          // window.location.href = error.response.data.errors.errors_file_path;
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