<template>
  <div class="container">
    <div class="row">
      <div class="col-md-2">
        <ul>
          <li v-for="(link, k) in links" :key="k">
            <router-link :to="link.to">{{ link.text }}</router-link>
          </li>
        </ul>
       
      </div>
      <div class="col-md-10">
        <router-view></router-view>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      links: [
        {
          to: "/",
          text: "Dashboard",
        },
        {
          to: "/",
          text: "Client List",
        },
        {
          to: "import",
          text: "Import",
        },
        {
          to: "gis",
          text: "GIS",
        },
        
      ],
    };
  },
  methods: {},
  mounted() {
    console.log("app");
  },
};
</script>

<style>
</style>