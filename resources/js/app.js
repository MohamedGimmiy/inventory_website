

require('./bootstrap');

import Vue from 'vue'
import VueRouter from 'vue-router'
import {routes} from './routes'

// making user used globally
import User from './helpers/user';
window.User = User;

// making user used globally
import Notif from './helpers/Notif';
window.Notif = Notif;

// sweet alert
import Swal from 'sweetalert2';


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
  })

  window.Toast = Toast;


Vue.use(VueRouter)



const router = new VueRouter({
    mode: 'history',
    routes // short for `routes: routes`
  })

const app = new Vue({
    el: '#app',
    router,
});
