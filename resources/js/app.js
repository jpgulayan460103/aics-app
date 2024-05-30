/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;
import '@mdi/font/css/materialdesignicons.css'
import 'material-design-icons-iconfont/dist/material-design-icons.css';

import Vuetify from 'vuetify';
import VueRouter from "vue-router";
import VueShortkey from 'vue-shortkey';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import App from "./components/App.vue";
import Home from "./components/Home.vue";
import moment from 'moment';
import 'viewerjs/dist/viewer.css'
import VueViewer from 'v-viewer'
import ImportFile from './Components/ImportFile.vue'
import MasterList from "./Components/MasterList"
import ServedClient from "./Components/ServedClient"
import GISComponent from "./Components/GISComponent.vue"
import Payroll from "./Components/Payroll"
import PayrollClientList from "./Components/PayrollClientList"
import Users from "./Components/Users"
import ActivityLog from "./Components/ActivityLog"
import Grievance from "./Components/Grievance"
import AssistanceTypes from "./Components/AssistanceTypes.vue"
import QRScanner from "./Components/QRScanner.vue"
Vue.use(Vuetify);
Vue.use(VueRouter);
Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
Vue.use(VueViewer)
Vue.use(VueShortkey)

const router = new VueRouter({
    mode: "history",
    base: process.env.MIX_BASE_NAME,
    routes: [
        // { path: "/404", component: NotFound },
        {
            path: "/",
            redirect: { name: "home" },
        },
        {
            path: "/home",
            name: "home",
            component: Home,
            props: true,
        },
        {
            path: "/import",
            name: "import",
            component: ImportFile,
            meta: {
                requiresAuth: true,
                requiresRoles: ["Super-Admin", "Admin"]
            }
        },
        {
            path: "/gis",
            name: "gis",
            component: GISComponent,

        },
        {
            path: "/master_list",
            name: "master_list",
            component: MasterList,
            meta: {
                requiresAuth: true,
                requiresRoles: ["Super-Admin", "Admin","encoder","Encoder"]
            }

        },
        {
            path: "/payroll",
            name: "payroll",
            component: Payroll,
            meta: {
                requiresAuth: true,
                requiresRoles: ["Super-Admin", "Admin"]
            }

        },
        {
            path: "/payroll/:id?",
            name: "payroll_list",
            component: PayrollClientList,
            props: true,
            meta: {
                requiresAuth: true,
                requiresRoles: ["Super-Admin", "Admin"]
            }
        },
        {
            path: "/users/:id?",
            name: "users",
            component: Users,
            props: true,
            meta: {
                requiresAuth: true,
                requiresRoles: ["Super-Admin", "Admin"]
            }
        },
        {
            path: "/logs",
            name: "logs",
            component: ActivityLog,
            meta: {
                requiresAuth: true,
                requiresRoles: ["Super-Admin", "Admin","grievance-officer"]
            }

        },
        {
            path: "/grievance",
            name: "grievance",
            component: Grievance,
            meta: {
                requiresAuth: true,
                requiresRoles: ["Super-Admin", "Admin", "grievance-officer"]
            }

        },
        {
            path: "/assistance-types",
            name: "assistance-types",
            component: AssistanceTypes,
            meta: {
                requiresAuth: true,
                requiresRoles: ["Super-Admin", "Admin"]
            }

        },
        {
            path: "/qr",
            name: "qr",
            component: QRScanner,
            meta: {
                requiresAuth: true,
                requiresRoles: ["Super-Admin", "Admin"]
            }

        },
        
        
        
    ],
});

Vue.filter("formatDate", function (value) {
    if (value) {
        return moment(String(value)).format("MM-DD-YYYY HH:mm:ss");
    }
});

Vue.filter("FormatDateAccomplished", function (value) {
    if (value) {
        return moment(String(value)).format("YYYY-MM-DD");
    }
});


export default new Vuetify({
    icons: {
        iconfont: 'mdi', // default - only for display purposes
    },
})

const app = new Vue({
    el: '#app',
    components: { App },
    router,
    vuetify: new Vuetify(),

});

