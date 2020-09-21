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
                            <!-- <a href="#!" @click="editPassword(authenticated)" class="dropdown-item">
                                <i class="ni ni-single-02"></i>
                                <span>Edit Password</span>
                            </a> -->
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
        <!-- Modal -->
        <!-- <b-modal id="edit-password" size="sm" centered hide-footer hide-header>
            <div class="card mb-0">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Edit Password</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="#!" @click.prevent="closeModal(authenticated)" class="btn btn-sm btn-danger">x</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form>
                        <div class="form-group">
                            <label class="form-control-label" for="password">Password Lama</label>
                            <input id="password" type="password" v-model=user.old_password class="form-control">
                            <input type="hidden" v-model=user.email>
                        </div>
                        <div class="form-group mt-2">
                            <label class="form-control-label" for="pwd">Password Baru</label>
                            <input id="pwd" type="password" v-model=user.password class="form-control">
                        </div>
                        <div class="form-group mt-2">
                            <label class="form-control-label" for="pwdkonfir">Konfirmasi Password Baru</label>
                            <input id="pwdkonfir" type="password" v-model=user.password_confirmation
                                class="form-control">
                        </div>
                        <div class="custom-control custom-control-alternative text-center alert alert-danger"
                            v-if="errors.invalid">
                            {{ errors.invalid }}
                        </div>
                        <div class="mt-3 text-right mb-0">
                            {{errors}}
                            <a href="#!" @click.prevent="submitPassword(errors)"
                                class="btn btn-sm btn-success">Submit</a>
                        </div>
                    </form>
                </div>
            </div>
        </b-modal> -->
        <!-- END MODAL -->
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
                user: {}
            }
        },
        computed: {
            ...mapState('user', {
                authenticated: state => state.authenticated
            }),
            ...mapState(['errors']),
            ...mapGetters(['changedPassword']), //MENGAMBIL GETTERS changedPassword DARI VUEX
        },
        created() {
            this.getUserLogin()
        },
        methods: {
            ...mapActions('user', ['getUserLogin']),
            ...mapActions('user', ['changePassword']),
            ...mapMutations(['CLEAR_ERRORS']),

            logout() {
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
            },
            editPassword(authenticated) {
                this.user = authenticated
                this.CLEAR_ERRORS()
                this.$bvModal.show('edit-password')
            },
            closeModal() {
                this.$bvModal.hide('edit-password')
            },
            // submitPassword(errors) {
            //     console.log(errors.invalid);
            //     this.CLEAR_ERRORS()
            //     console.log(errors.invalid);
            //     console.log(this.changedPassword);
            //     this.changePassword(this.user)

            //     if (this.changedPassword) {
            //         swal.fire(
            //             'Berhasil!',
            //             'Password telah diubah.',
            //             'success'
            //         )
            //         // this.$bvModal.hide('edit-password')
            //     }
            //     console.log(this.changedPassword);
            // }
        }
    }
</script>