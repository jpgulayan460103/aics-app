<template>
  <v-card flat>
    <v-card-title>Import</v-card-title>
    <v-card-text>
      <form @submit.prevent="submit" enctype="multipart/form-data">
        <input type="file" name="" id="" @input="onFileChange($event)" />

        <v-btn
          class="ma-2"
          :loading="isBusy"
          :disabled="isBusy"
          color="secondary"
          type="submit"
        >
          SUBMIT
        </v-btn>

        <!--<button type="submit" class="btn btn-primary" :loading="loading">
          SUBMIT
        </button>-->
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
          this.isBusy = false;
          console.log(response.data);
          alert(response.data);
        })
        .catch((error) => console.log(error));
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