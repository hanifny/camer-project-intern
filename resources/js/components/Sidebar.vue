<template>
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="#!" class="brand-link">
            <img src="/img/favicon-removebg-preview.png" alt="CAMER" class="brand-image img-circle elevation-3">
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
                    <a href="#" class="d-block"> {{authenticated.name}} </a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <li class="nav-item" @click="activate('home')">
                        <router-link to="/" class="nav-link"
                            :class="{ active : $route.name == 'home' || $route.name == 'login' }">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Dasbor
                            </p>
                        </router-link>
                    </li>

                    <li class="nav-item" @click="activate('camer.listrik')">
                        <router-link to="/camer/listrik" class="nav-link"
                            :class="{ active : $route.name == 'camer.listrik' }">
                            <i class="fas fa-bolt nav-icon"></i>
                            <p>
                                Camer Listrik
                                <span class="badge badge-warning right"> {{count.el_validation}} </span>
                            </p>
                            
                        </router-link>
                    </li>
                    <li class="nav-item" @click="activate('camer.air')">
                        <router-link to="/camer/air" class="nav-link" :class="{ active : $route.name == 'camer.air' }">
                            <i class="fas fa-tint nav-icon"></i>
                            <p>
                                Camer Air
                                <span class="badge badge-warning right"> {{count.wt_validation}} </span>
                            </p>
                            
                        </router-link>
                    </li>

                    <li class="nav-item" @click="activate('unit')">
                        <router-link to="/unit" class="nav-link" :class="{ active : $route.name == 'unit' }">
                            <i class="nav-icon far fa-building"></i>
                            <p>
                                Data Unit
                            </p>
                        </router-link>
                    </li>

                    <li class="nav-item" @click="activate('user')">
                        <router-link to="/user" class="nav-link" :class="{ active : $route.name == 'user' }">
                            <i class="nav-icon fas fa-user-astronaut"></i>
                            <p>
                                Data User
                            </p>
                        </router-link>
                    </li>

                    <li class="nav-item" @click="activate('invalid')">
                        <router-link to="/invalid" class="nav-link" :class="{ active : $route.name == 'invalid' }">
                            <i class="nav-icon far fa-times-circle"></i>
                            <p>
                                Data Invalid
                                <span class="badge badge-danger right"> {{count.invalid}} </span>
                            </p>
                        </router-link>
                    </li>

                    <li v-if="authenticated.role == 'Admin' || authenticated.role == 'SuperAdmin'"
                        @click.prevent="exportExcel" class="nav-item">
                        <router-link to="#" class="nav-link">
                            <i class="nav-icon far fa-file-excel"></i>
                            <p>
                                Ekspor ke Excel
                            </p>
                        </router-link>
                    </li>

                </ul>
            </nav>
        </div>
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
            ...mapActions('camer', ['getCount']),
            ...mapActions('camer', ['exportToExcel']),

            exportExcel() {
                this.exportToExcel()
            },
            logout() {
                this.signout().then(() => {
                    this.$router.push({
                        name: 'login'
                    })
                })
            },
        },
        created() {
            this.getCount()
        }
    }
</script>