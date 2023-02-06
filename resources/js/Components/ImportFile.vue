<template>
  <form @submit.prevent="submit" enctype="multipart/form-data">
    <input type="file" name="" id="" @input="onFileChange($event)" />
    
    <button type="submit" class="btn btn-primary btn-lg btn-lg btn-block">
      SUBMIT
    </button>
  </form>
</template>

<script>
export default {
  name: "import",
  data() {
    return {
      file: [],
    };
  },
  methods: {
    submit() {
      console.log("here");
      let formData = new FormData();
      formData.append("file", this.file);

      const headers = {
        "Content-Type": "multipart/form-data;",
      };

      axios
        .post(route("api.client.upload"), formData, headers)
        .then((response) => {
          console.log(response.data);
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