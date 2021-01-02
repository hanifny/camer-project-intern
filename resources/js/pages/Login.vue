<!-- HTML SECTION -->
<template>
    <div class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo d-flex flex-column align-items-center">
                <img src="img/favicon-removebg-preview.png" alt="CAMER" style="width: 221px">
                <a href="/"><b>CAMER</b></a>
            </div>
            <div class="card">
                <div class="card-body login-card-body">
                    <p class="login-box-msg">Sign in to start your session</p>

                    <form autocomplete="off" @submit.prevent="postLogin">
                        <div class="input-group mb-3">
                            <input type="username" class="form-control" placeholder="Username" v-model="data.username" autofocus required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" placeholder="Password" v-model="data.password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-end">
                            <div class="custom-control custom-control-alternative text-center alert alert-danger"
                                v-if="errors.invalid">
                                {{ errors.invalid }}
                            </div>
                            <div class="col-4">
                                <button type="submit" class="btn btn-success btn-block">Sign in</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.login-box -->
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
            ...mapActions('auth', [
                'submit'
            ]), //MENGINISIASI FUNGSI submit() DARI VUEX AGAR DAPAT DIGUNAKAN PADA COMPONENT TERKAIT. submit() BERASAL DARI ACTION PADA FOLDER STORES/auth.js
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
                        toast.fire({
                            icon: 'success',
                            title: 'Signed in successfully'
                        })
                        this.$router.push({
                            name: 'home'
                        })
                    }
                })
            }
        },
    }
</script>