<template>
 
    <div class="container-fluid">
      <v-row  dense>
        <v-col cols="1">


          <v-list dense>

            <v-list-item-group v-model="selectedItem" color="primary" class="d-print-none">
              <v-list-item v-for="(link, i) in links" :key="i" :to="link.to">

                <v-list-item-content>
                  <v-list-item-title v-text="link.text"></v-list-item-title>
                </v-list-item-content>
              </v-list-item>
            </v-list-item-group>
          </v-list>


        </v-col>
        <v-col cols="11">
          {{ this.userData.role }}
          <router-view :user="user" :upload-config="uploadConfig"></router-view>
        </v-col>
      </v-row>
    </div>
  
</template>

<script>
import userMixin from '../Mixin/userMixin';

export default {
  props: ['user', 'uploadConfig'],
  mixins: [userMixin],
  data() {
    return {
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
  methods: {},
  mounted() {

    switch (this.userData.role) {
      case "admin":
      case "Super-Admin":
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