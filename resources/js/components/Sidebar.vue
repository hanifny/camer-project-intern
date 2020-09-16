<template>
    <nav class="sidenav navbar navbar-vertical fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
        <div class="scrollbar-inner">
            <div class="sidenav-header align-items-center">
                <a class="navbar-brand" href="javascript:void(0)">
                    <img src="img/blue.png" class="navbar-brand-img" alt="...">
                </a>
            </div>
            <div class="navbar-inner">
                <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                    <ul class="navbar-nav">
                        <li class="nav-item" @click="activate('home')">
                            <router-link class="nav-link" to="/" :class="{ active : active_el == 'home' || active_el == 'login' }">
                                <i class="ni ni-tv-2 text-primary"></i>
                                <span class="nav-link-text">Dashboard</span>
                            </router-link>
                        </li>
                        <li class="nav-item" @click="activate('camer')">
                            <router-link class="nav-link" to="/camer" :class="{ active : active_el == 'camer' }">
                                <i class="ni ni-box-2 text-primary"></i>
                                <span class="nav-link-text">Catatan Meter</span>
                            </router-link>
                        </li>
                        <li class="nav-item" @click="activate('unit')">
                            <router-link class="nav-link" to="/unit" :class="{ active : active_el == 'unit' }">
                                <i class="ni ni-archive-2 text-orange"></i>
                                <span class="nav-link-text">Data Apartement Unit</span>
                            </router-link>
                        </li>
                        <li class="nav-item" @click="activate('teknisi')">
                            <router-link class="nav-link" to="/teknisi" :class="{ active : active_el == 'teknisi' }">
                                <i class="ni ni-single-02 text-yellow"></i>
                                <span class="nav-link-text">Data Teknisi</span>
                            </router-link>
                        </li>
                        <!-- <li class="nav-item" @click="activate('invalid')">
                            <a class="nav-link" href="" :class="{ active : active_el == 5 }">
                                <i class="ni ni-bullet-list-67 text-default"></i>
                                <span class="nav-link-text">Data Invalid</span>
                            </a>
                        </li> -->
                    </ul>
                </div>
            </div>
        </div>
    </nav>
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
            return {
                active_el: 'home'
            }
        },
        methods: {
            ...mapActions('auth', ['signout']),

            logout() {
                this.signout().then(() => {
                    this.$router.push({
                        name: 'login'
                    })
                })
            },
            activate: function (el) {
                this.active_el = el
            }
        },
        mounted() {
            this.active_el = this.$route.name
            // console.log(this.active_el)  
        },
        methods: {
            activate: function (e) {
                this.active_el = e
            }
        }
    }
</script>