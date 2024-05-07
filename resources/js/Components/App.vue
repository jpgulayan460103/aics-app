<template>
  <v-sheet>
    <v-toolbar dense dark color="red" >
      <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
      <v-toolbar-title> 
      AICS Onsite Payroll Generation & Encoding App!
      </v-toolbar-title>

      <v-spacer></v-spacer>

      {{this.userData.name }}
      ({{ this.userData.role }})  

      <v-btn icon @click="logout()">
        <v-icon> mdi-logout</v-icon>      
      </v-btn>

      
    </v-toolbar>

    <v-container dense fluid>      
      <router-view :user="user" :upload-config="uploadConfig"></router-view>
    </v-container>

    <v-navigation-drawer v-model="drawer" absolute temporary >      
      <v-list-item>
        <v-list-item-content centered>
          <v-list-item-title>
            <v-img max-height="64" max-width="250px" src="/images/DSWD-DVO-LOGO.png" contain alt="DSWD"></v-img>
          </v-list-item-title>
        </v-list-item-content>
      </v-list-item>

      <v-list dense nav>

        <v-list-item-group v-model="selectedItem" color="primary" class="d-print-none">
          <v-list-item v-for="(link, i) in links" :key="i" :to="link.to">

            <v-list-item-content>
              <v-list-item-title v-text="link.text"></v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list-item-group>
      </v-list>
    </v-navigation-drawer>
  </v-sheet>
  
</template>

<script>
import axios from 'axios';
import userMixin from '../Mixin/userMixin';

export default {
  props: ['user', 'uploadConfig'],
  mixins: [userMixin],
  data() {
    return {
      drawer: null,
      selectedItem: 1,
      links: [],

      admin_menu: [

        {
          to: "/",
          text: "Home",
        },
        {
          to: "/import",
          text: "Import",

        },
        {
          to: "/master_list",
          text: "Master List",
        },
        {
          to: "/payroll",
          text: "Payroll",
        },
        {
          to: "/users",
          text: "Users",
        },
        {
          to: "/logs",
          text: "Logs",
        },
        {
          to: "/grievance",
          text: "Grievance",
        },
        /*{
          to: "/assistance-types",
          text: "Assistance Types",
        },*/
      ],
      default_menu: [

        {
          to: "/",
          text: "Home",
        },

        {
          to: "/master_list",
          text: "Master List",
        },


      ],
      grievance_menu: [

        {
          to: "/",
          text: "Home",
        },

        {
          to: "/logs",
          text: "Logs",
        },
        {
          to: "/grievance",
          text: "Grievance",
        },
       

      ]
    };
  },
  methods: {
    logout() {
      axios.post("/logout").then(response => {
       
        location.reload();
      })
        .catch(error => {
          console.log(error);
        });
    }
  },
  mounted() {

    switch (this.userData.role.toLowerCase()) {
      case "admin":
      case "super-admin":
        this.links = this.admin_menu

        break;
      case "grievance-officer":
        this.links = this.grievance_menu

        break;
      default:
        this.links = this.default_menu
        break;
    }


  },
};
</script>

<style></style>