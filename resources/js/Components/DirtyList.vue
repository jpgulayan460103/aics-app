<template>
   
</template>

<script>
import ImportFile from './ImportFile.vue';

export default {
    
  data() {
    return{
        data: [],
    }
  },
  methods: {
    getList() {
      axios
        .get(route("api.dirty_list.index"))
        .then((response) => {
          this.data = response.data;
        })
        .catch((error) => console.log(error));
    },
  },
};
</script>

<style>
</style>