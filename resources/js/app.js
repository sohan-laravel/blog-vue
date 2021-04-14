/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('jszip');
require('pdfmake');
require('datatables.net-bs4');
require('datatables.net');

//vue initiate
window.Vue = require('vue');

//vueX

import Vuex from 'vuex'
Vue.use(Vuex)
import storeData from './store/store'

const store = new Vuex.Store(
    storeData
)

//toastr

import toastr from 'toastr'
window.toastr = toastr;

//Sweat Alert

import Swal from 'sweetalert2'

window.Swal = Swal;


const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

window.Toast = Toast;

// v form
import { Form, HasError, AlertError } from 'vform'

window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

// vue router
import VueRouter from 'vue-router'

Vue.use(VueRouter)

// vue routes
import { routes } from './routes/routes';

const router = new VueRouter({
    routes, // short for `routes: routes`
    //mode: 'history',
})

// moment js date time formate and all filter  vue work use

import { filter } from './filter/filter'

// mixin helper function vue js

import './helpers/mixin'



/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('home', require('./components/backend/home').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    router,
    store
}).$mount('#app')
