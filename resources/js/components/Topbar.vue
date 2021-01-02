<template>
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light d-flex justify-content-between">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a class="nav-link d-flex align-items-center" href="#" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <span style="font-size: 31px; color: #343a40;">
                        <i class="nav-icon fas fa-caret-down"></i>
                    </span>
                </a>
                <div class="dropdown-menu  dropdown-menu-right ">
                    <a href="#!" @click="editPassword(authenticated)" class="dropdown-item">
                        <i class="nav-icon fas fa-unlock"></i>&nbsp;
                        <span>Edit Password</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" @click="logout" class="dropdown-item">
                        <i class="nav-icon fas fa-running"></i>&nbsp;
                        <span>Logout</span>
                    </a>
                </div>
            </li>
        </ul>

        <!-- Modal -->
        <b-modal id="edit-password" size="sm" centered hide-footer hide-header>
            <div class="card mb-0">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h5 class="mb-0">Edit Password</h5>
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
                            v-if="errors">
                            {{ errors }}
                        </div>
                        <div class="mt-3 text-right mb-0">
                            <a href="#!" @click.prevent="submitPassword" class="btn btn-sm btn-success">Submit</a>
                        </div>
                    </form>
                </div>
            </div>
        </b-modal>
        <!-- END MODAL -->
    </nav>
    <!-- /.navbar -->
</template>

<script>
    import $axios from '../api.js'
    import {
        mapActions,
        mapMutations,
        mapGetters,
        mapState
    } from 'vuex';
    export default {
        data() {
            return {
                user: {},
                errors: []
            }
        },
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
                this.errors = ''
                this.$bvModal.show('edit-password')
            },
            closeModal() {
                this.$bvModal.hide('edit-password')
            },
            submitPassword() {
                $axios.patch('/user', this.user)
                    .then((response) => {
                        if (response.data.message ==
                            'Your current password does not matches with the password you provided. Please try again.'
                        ) {
                            this.errors = response.data.message
                        } else if (response.data.status == 'success') {
                            this.errors = response.data.message
                            swal.fire(
                                'Berhasil!',
                                'Kamu telah merubah password.',
                                'success'
                            )
                            this.user.password_confirmation = undefined
                            this.user.password = undefined
                            this.user.old_password = undefined
                            this.closeModal()
                        }
                    })
                    .catch((error) => {
                        if (error.response.status == 422) {
                            console.log(error.response.data.errors.password[0]);
                            this.errors = error.response.data.errors.password[0]
                        }
                    })
            }
        }
    }
</script>