import Vue from 'vue'
import router from './router.js'
import store from './store.js'
import swal from 'sweetalert2'
import App from './App.vue'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'

window.swal = swal

Vue.use(BootstrapVue)

Vue.component('pagination', require('laravel-vue-pagination'));
const toast = swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 1300,
    timerProgressBar: true,
    onOpen: (toast) => {
      toast.addEventListener('mouseenter', swal.stopTimer)
      toast.addEventListener('mouseleave', swal.resumeTimer)
    }
})
window.toast = toast;

new Vue({
    el: '#app',
    router,
    store,
    components: {
        App
    }
})