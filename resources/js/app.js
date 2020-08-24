import Vue from 'vue'
import router from './router.js'
import store from './store.js'
import swal from 'sweetalert2'
import App from './App.vue'

window.swal = swal

const toast = swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    onOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
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