<template>
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="index3.html" class="brand-link">
            <img src="img/favicon-removebg-preview.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3">
            <span class="brand-text"><b>CAMER</b></span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="https://images.unsplash.com/photo-1580724780391-e4772f8c9401?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=500&q=60"
                        class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block"> {{authenticated.nama}} </a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <li class="nav-item" @click="activate('home')">
                        <router-link to="/" class="nav-link"
                            :class="{ active : activeEl == 'home' || activeEl == 'login' }">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Dasbor
                            </p>
                        </router-link>
                    </li>

                    <li class="nav-item" @click="activate('camer')">
                        <router-link to="/camer" class="nav-link" :class="{ active : activeEl == 'camer' }">
                            <i class="nav-icon far fa-folder"></i>
                            <p>
                                Catatan Meter
                                <span class="badge badge-warning right"> {{count.camer_must_validation}} </span>
                            </p>
                        </router-link>
                    </li>

                    <li class="nav-item" @click="activate('unit')">
                        <router-link to="/unit" class="nav-link" :class="{ active : activeEl == 'unit' }">
                            <i class="nav-icon far fa-building"></i>
                            <p>
                                Data Unit
                            </p>
                        </router-link>
                    </li>

                    <li class="nav-item" @click="activate('user')">
                        <router-link to="/user" class="nav-link" :class="{ active : activeEl == 'user' }">
                            <i class="nav-icon fas fa-user-astronaut"></i>
                            <p>
                                Data User
                            </p>
                        </router-link>
                    </li>

                    <li class="nav-item" @click="activate('invalid')">
                        <router-link to="/invalid" class="nav-link" :class="{ active : activeEl == 'invalid' }">
                            <i class="nav-icon far fa-times-circle"></i>
                            <p>
                                Data Invalid
                                <span class="badge badge-danger right"> {{count.camer_invalid}} </span>
                            </p>
                        </router-link>
                    </li>

                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
</template>

<script>
    import {
        mapActions,
        mapMutations,
        mapGetters,
        mapState
    } from 'vuex';
    export default {
        data() {
            return {}
        },
        computed: {
            ...mapState(['activeEl']),
            ...mapState('camer', {
                count: state => state.count
            }),
            ...mapState('user', {
                authenticated: state => state.authenticated
            }),
        },
        created() {
            this.getUserLogin()
        },
        methods: {
            ...mapActions('user', ['getUserLogin']),
            ...mapActions('auth', ['signout']),
            ...mapMutations(['SET_ACTIVEEL']),
            ...mapActions('camer', ['getCount']),

            logout() {
                this.signout().then(() => {
                    this.$router.push({
                        name: 'login'
                    })
                })
            },
            activate: function (el) {
                this.SET_ACTIVEEL(el)
            },
        },
        mounted() {
            this.SET_ACTIVEEL(this.$route.name)
        },
        created() {
            this.getCount()
        }
    }
</script>