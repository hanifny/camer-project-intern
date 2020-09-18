<template>
<div id="app">
        <app-sidebar v-if="isAuth"></app-sidebar>
        <!-- Main content -->
        <div class="main-content" id="panel">
            <app-topbar v-if="isAuth"></app-topbar>
            <router-view></router-view>
            <app-footer v-if="isAuth"></app-footer>
        </div>
        
</div>
</template>
<script>
    import { mapState, mapGetters } from 'vuex'
    import Sidebar from './components/Sidebar.vue'
    import Topbar from './components/Topbar.vue'
    import Footer from './components/Footer.vue'
    export default {
        computed: {
            ...mapState(['token']),
            ...mapGetters(['isAuth'])
        },
        components: {
            'app-sidebar': Sidebar,
            'app-topbar' : Topbar,
            'app-footer' : Footer
        }
    }
</script>