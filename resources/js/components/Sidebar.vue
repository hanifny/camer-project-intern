<template>
    <nav class="sidenav navbar navbar-vertical fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
        <div class="scrollbar-inner">
            <div class="sidenav-header align-items-center" @click="activate('home')">
                <router-link class="navbar-brand pt-5" to="/">
                    <img src="img/logo.png" class="navbar-brand-img" alt="...">
                </router-link>
            </div>
            <div class="navbar-inner">
                <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                    <ul class="navbar-nav">
                        <li class="nav-item" @click="activate('home')">
                            <router-link class="nav-link" to="/" :class="{ active : activeEl == 'home' || activeEl == 'login' }">
                                <i class="ni ni-tv-2 text-primary"></i>
                                <span class="nav-link-text">Dashboard</span>
                            </router-link>
                        </li>
                        <li class="nav-item" @click="activate('camer')">
                            <router-link class="nav-link" to="/camer" :class="{ active : activeEl == 'camer' }">
                                <i class="ni ni-box-2 text-primary"></i>
                                <span class="nav-link-text">Catatan Meter</span>
                            </router-link>
                        </li>
                        <li class="nav-item" @click="activate('unit')">
                            <router-link class="nav-link" to="/unit" :class="{ active : activeEl == 'unit' }">
                                <i class="ni ni-archive-2 text-orange"></i>
                                <span class="nav-link-text">Data Apartement Unit</span>
                            </router-link>
                        </li>
                        <li class="nav-item" @click="activate('teknisi')">
                            <router-link class="nav-link" to="/teknisi" :class="{ active : activeEl == 'teknisi' }">
                                <i class="ni ni-single-02 text-yellow"></i>
                                <span class="nav-link-text">Data User</span>
                            </router-link>
                        </li>
                        <li class="nav-item" @click="activate('invalid')">
                            <router-link class="nav-link" to="/invalid" :class="{ active : activeEl == 'invalid' }">
                                <i class="ni ni-bullet-list-67 text-default"></i>
                                <span class="nav-link-text">Data Invalid</span>
                            </router-link>
                        </li>

                        <li class="nav-item" @click="activate('chat')">
                            <router-link class="nav-link" to="/chat" :class="{ active : activeEl == 'chat' }">
                                <i class="fas fa-comments"></i>
                                <span class="nav-link-text">Chat</span>
                            </router-link>
                        </li>

                        <li class="nav-item" @click="activate('pembayaran')">
                            <router-link class="nav-link" to="/pembayaran" :class="{ active : activeEl == 'pembayaran' }">
                                <i class="fas fa-credit-card"></i>
                                <span class="nav-link-text">Pembayaran</span>
                            </router-link>
                        </li>
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
            }
        },
        computed: {
            ...mapState(['activeEl'])
        },
        methods: {
            ...mapActions('auth', ['signout']),
            ...mapMutations(['SET_ACTIVEEL']),


            logout() {
                this.signout().then(() => {
                    this.$router.push({
                        name: 'login'
                    })
                })
            },
            activate: function (el) {
                this.SET_ACTIVEEL(el)
            }
        },
        mounted() {
            this.SET_ACTIVEEL(this.$route.name)
            // console.log(this.activeEl)  
        }
    }
</script>