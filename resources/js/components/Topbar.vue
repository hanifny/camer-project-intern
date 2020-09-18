<template>
    <nav class="navbar navbar-top navbar-expand navbar-dark bg-gradient-success">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Search form -->
                <form class="navbar-search navbar-search-light form-inline mr-sm-3" id="navbar-search-main">
                    <button type="button" class="close" data-action="search-close" data-target="#navbar-search-main"
                        aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </form>
                <!-- Navbar links -->
                <ul class="navbar-nav align-items-center  ml-auto ">
                    <li class="nav-item d-xl-none">
                        <!-- Sidenav toggler -->
                        <div class="pr-3 sidenav-toggler sidenav-toggler-dark" data-action="sidenav-pin"
                            data-target="#sidenav-main">
                            <div class="sidenav-toggler-inner">
                                <i class="sidenav-toggler-line"></i>
                                <i class="sidenav-toggler-line"></i>
                                <i class="sidenav-toggler-line"></i>
                            </div>
                        </div>
                    </li>
                </ul>
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item dropdown">
                        <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <div class="media align-items-center">
                                <span class="avatar avatar-sm rounded-circle">
                                    <span style="font-size: 1.5em; color: Black;">
                                        <i class="fas fa-user-secret"></i>
                                    </span>
                                    <!-- <img alt="Image placeholder" src="img/favicon.png"> -->
                                </span>
                                <div class="media-body  ml-2  d-none d-lg-block">
                                    <span v-if="authenticated" class="mb-0 text-sm  font-weight-bold">
                                        {{authenticated.nama}} </span>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-menu  dropdown-menu-right ">
                            <div class="dropdown-header noti-title">
                                <h6 class="text-overflow m-0">Welcome!</h6>
                            </div>
                            <div class="dropdown-divider"></div>
                            <a href="#" @click="logout" class="dropdown-item">
                                <i class="ni ni-user-run"></i>
                                <span>Logout</span>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
    import {
        mapState,
        mapActions
    } from 'vuex';
    export default {
        computed: {
            ...mapState('user', {
                authenticated: state => state.authenticated
            }),
        },
        created() {
            this.getUserLogin()
        },
        methods: {
            ...mapActions('user', ['getUserLogin']),

            logout() {
                console.log('ok');
                return new Promise((resolve, reject) => {
                    localStorage.removeItem('token')
                    resolve()
                }).then(() => {
                    this.$store.state.token = localStorage.getItem('token')
                    toast.fire({
                        icon: 'success',
                        title: 'Thank you! ;)'
                    })
                    this.$router.push('/login')
                })
            }
        }
    }
</script>