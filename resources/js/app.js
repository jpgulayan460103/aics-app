/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

import VueRouter from "vue-router";
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import App from "./components/App.vue";
import Home from "./components/Home.vue";
import moment from 'moment';
import 'viewerjs/dist/viewer.css'
import VueViewer from 'v-viewer'

Vue.use(VueRouter);
Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
Vue.use(VueViewer)


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('gis-component', require('./components/GISComponent.vue').default);
//Vue.component('app', require('./components/App.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const router = new VueRouter({
    mode: "history",
    //base: process.env.MIX_BASE_NAME,
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
       
    ],
});



const app = new Vue({
    el: '#app',
    components: { App },
    router,
});

Vue.filter("formatDate", function (value) {
    if (value) {
        return moment(String(value)).format("MM-DD-YYYY");
    }
});
