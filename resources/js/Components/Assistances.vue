<template>
  <div>
    <pre>
    {{ uuid }}
   </pre
    >
  </div>
</template>

<script>
export default {
  data() {
    return {
      data: [],
    };
  },
  props: ["uuid"],
  methods: {
    getClientInfo() {
      axios
        .get("api/aics/assistances/" + this.uuid)
        .then((response) => {
          this.data = response.data;
        })
        .catch((error) => console.log(error));
    },
  },
  mounted() {
    this.getClientInfo();
  },
};
</script>

<style>
</style>