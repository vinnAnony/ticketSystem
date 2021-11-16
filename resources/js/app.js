/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

import Gate from "./Gate"
Vue.prototype.$gate = new Gate(window.user);


import VueProgressbar from "vue-progressbar";
Vue.use(VueProgressbar, {
    color: '#bffaf3',
    failedColor: '#874b4b',
    thickness: '2px',
    transition: {
      speed: '0.2s',
      opacity: '0.6s',
      termination: 300
    },
    autoRevert: true,
    location: 'top',
    position:'fixed',
    inverse: false,
    autoFinish: true
});

import Swal from 'sweetalert2'
window.Swal = Swal;
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    onOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  })
  window.Toast = Toast;

  //Listen using emit
  window.Fire = new Vue();

import { Form } from "vform";
import {
    Button,
    HasError,
    AlertError,
    AlertErrors,
    AlertSuccess
  } from 'vform/src/components/bootstrap5';


window.Form = Form;

Vue.component(Button.name, Button)
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
Vue.component(AlertErrors.name, AlertErrors)
Vue.component(AlertSuccess.name, AlertSuccess)

import VueRouter from "vue-router";
Vue.use(VueRouter)

let routes = [
    {path: "/dashboard", component: require("./components/Dashboard.vue").default},
    {path: "/users", component: require("./components/ManageUsers.vue").default},
    {path: "/events", component: require("./components/ManageEvents.vue").default},
]

const router = new VueRouter({
    mode: "history",
    routes
})

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('dashboard-component', require('./components/Dashboard.vue').default);
Vue.component('m-users-component', require('./components/ManageUsers.vue').default);
Vue.component('m-events-component', require('./components/ManageEvents.vue').default);
Vue.component('not-found', require('./components/NotFound.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router,
});
