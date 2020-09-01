<!-- HTML SECTION -->
<template>
    <!-- Main content -->
    <div class="main-content">
        <!-- Header -->
        <div class="header py-7 py-lg-7 pt-lg-5 bg-gradient-success">
            <div class="container">
                <div class="header-body text-center mb-7">
                    <div class="row justify-content-center">
                        <div class="col-xl-5 col-lg-6 col-md-8 px-5">
                            <img src="img/white.png" alt="CAMER" class="brand-image">
                        </div>
                    </div>
                </div>
            </div>
            <div class="separator separator-bottom separator-skew zindex-100">
                <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
                    <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
                </svg>
            </div>
        </div>
        <!-- Page content -->
        <div class="container mt--8 pb-5">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-7">
                    <div class="card bg-secondary border-0 mb-0">
                        <div class="card-body px-lg-5 py-lg-5">
                            <form autocomplete="off" @submit.prevent="postLogin">
                                <div class="form-group mb-3">
                                    <div class="input-group input-group-merge input-group-alternative" :class="{'has-error': errors.email}">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Email" type="email" v-model="data.email" autofocus required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-merge input-group-alternative" :class="{'has-error': errors.password}">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Password" type="password" v-model="data.password" required>
                                    </div>
                                </div>
                                <div class="custom-control custom-control-alternative text-center alert alert-danger" v-if="errors.invalid">
                                    {{ errors.invalid }}
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary my-4">Sign in</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<!-- JAVASCRIPT SECTION -->
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
                data: {
                    email: '',
                    password: '',
                    remember_me: false
                }
            }
        },
        //SEBELUM COMPONENT DI-RENDER
        created() {
            //KITA MELAKUKAN PENGECEKAN JIKA SUDAH LOGIN DIMANA VALUE isAuth BERNILAI TRUE
            if (this.isAuth) {
                //MAKA DI-DIRECT KE ROUTE DENGAN NAME home
                this.$router.push({
                    name: 'home'
                })
            }
        },
        computed: {
            ...mapGetters(['isAuth']), //MENGAMBIL GETTERS isAuth DARI VUEX
            ...mapState(['errors'])
        },
        methods: {
            ...mapActions('auth', ['submit']), //MENGINISIASI FUNGSI submit() DARI VUEX AGAR DAPAT DIGUNAKAN PADA COMPONENT TERKAIT. submit() BERASAL DARI ACTION PADA FOLDER STORES/auth.js
            // ...mapActions('user', ['getUserLogin']), 
            ...mapMutations(['CLEAR_ERRORS']),

            //KETIKA TOMBOL LOGIN DITEKAN, MAKA AKAN MEMINCU METHODS postLogin()
            postLogin() {
                //DIMANA TOMBOL INI AKAN MENJALANKAN FUNGSI submit() DENGAN MENGIRIMKAN DATA YANG DIBUTUHKAN
                this.submit(this.data).then(() => {
                    //KEMUDIAN DI CEK VALUE DARI isAuth
                    //APABILA BERNILAI TRUE
                    if (this.isAuth) {
                        this.CLEAR_ERRORS()
                        //MAKA AKAN DI-DIRECT KE ROUTE DENGAN NAME home
                        // toast.fire({
                        //     icon: 'success',
                        //     title: 'Signed in successfully'
                        // })
                        this.$router.push({
                            name: 'home'
                        })
                    }
                })
            }
        },
        // destroyed() {
            // this.getUserLogin() 
            // Menyimpan informasi user yang sudah login
        // }
    }
</script>