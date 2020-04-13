require('./bootstrap');
import Vue from 'vue';
import VueRouter from 'vue-router';
import Vuex from 'vuex';
import VeeValidate from 'vee-validate'
import {routes} from './routes.js';
import storeData from './store.js';
import MainApp from './components/MainApp.vue';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import { Form, HasError, AlertError } from 'vform';
import VueProgressBar from 'vue-progressbar';
import Swal from 'sweetalert2';
import moment from 'moment';
//import 'bootstrap/dist/css/bootstrap.css'
//import 'bootstrap-vue/dist/bootstrap-vue.css'

// Install BootstrapVue
Vue.use(BootstrapVue)
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin)
Vue.use(VeeValidate);
Vue.use(VueRouter);
Vue.use(Vuex);

window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
Vue.component('pagination', require('laravel-vue-pagination'));
import { Datetime } from 'vue-datetime';
 
Vue.component('datetime', Datetime);
import 'vue-datetime/dist/vue-datetime.css'
Vue.use(Datetime)

import FileUpload from 'v-file-upload'
Vue.use(FileUpload)

import Embed from 'v-video-embed'
Vue.use(Embed);


Vue.use(VueProgressBar, {
  color: 'rgb(143, 255, 199)',
  failedColor: 'red',
  height: '4px'
})

window.Swal = Swal;

const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 7000,
  timerProgressBar: true,
  onOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
})

window.Toast = Toast;

let Fuse = new Vue();
window.Fuse = Fuse;

Vue.filter('myDate', function (created) { 
	if (!created) return ''  
	return moment(created).format('MMMM Do YYYY');
})

Vue.filter('myDateTime', function (created) { 
	if (!created) return ''  
	return moment(created).format("dddd, MMMM Do YYYY, h:mm:ss a");
})

const router = new VueRouter({
    routes,
    mode: 'history'
});

const store = new Vuex.Store(storeData);
const app = new Vue({
    el: '#app',
    router,
    store,
    components: {
        MainApp
    },

    data:{
      search:'',
    },
    methods:{
      searchit(){
        Fuse.$emit('searching');
      }
    }
});
