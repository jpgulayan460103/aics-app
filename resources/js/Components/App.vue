<template>
  <div class="container">
    <div class="row">
      <!--<div class="col-md-2"></div>-->
      <div class="col-md-12">
       
          
          
            <router-view></router-view>
          
       
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      
      items: [
        {
          to: "/",
          icon: "mdi-web",
          text: "Dashboard",
        },
      ],
    };
  },
  methods: {
   
  },
  mounted() {
   
  },
};
</script>

<style>
</style>