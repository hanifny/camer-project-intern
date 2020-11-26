<template>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Dasbor</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Dasbor</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Hai, <b>{{name.split(' ')[0]}}</b>! Selamat datang di Web Camer
                                    <span style="color: #ffa500;">
                                        <i class="nav-icon fas fa-laugh-beam"></i>
                                    </span></h5>
                                <p class="card-text">
                                    Web Camer (Catatan Meter) adalah web yang mengelola catatan meter yang telah
                                    di<i>upload</i> oleh teknisi melalui Aplikasi Camer berbasis Android. 
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6" @click="activate('invalid')">
                        <router-link to="invalid" class="small-box bg-danger">
                            <div class="inner">
                                <h3> {{count.invalid}} </h3>

                                <p>Invalid</p>
                            </div>
                            <div class="icon">
                                <i class="nav-icon far fa-times-circle"></i>
                            </div>
                            <a href="#" class="small-box-footer">Lebih lanjut <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </router-link>
                    </div>

                    <div class="col-lg-3 col-6" @click="activate('camer.listrik')">
                        <router-link to="camer/listrik" class="small-box bg-warning">
                            <div class="inner">
                                <h3> {{count.el_validation + count.wt_validation}} </h3>

                                <p>Belum Tervalidasi</p>
                            </div>
                            <div class="icon">
                                <i class="nav-icon fas fa-exclamation-circle"></i>
                            </div>
                            <a href="#" class="small-box-footer">Lebih lanjut <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </router-link>
                    </div>
                    <div class="col-lg-3 col-6" @click="activate('camer.listrik')">
                        <router-link to="camer/listrik" class="small-box bg-success">
                            <div class="inner">
                                <h3> {{count.validated}} </h3>

                                <p>Tervalidasi</p>
                            </div>
                            <div class="icon">
                                <i class="nav-icon fas fa-check-circle"></i>
                            </div>
                            <a href="#" class="small-box-footer">Lebih lanjut <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </router-link>
                    </div>

                    <div class="col-lg-3 col-6" @click="activate('user')">
                        <router-link to="user" class="small-box bg-info">
                            <div class="inner">
                                <h3> {{count.engineer}} </h3>

                                <p>Teknisi</p>
                            </div>
                            <div class="icon">
                                <i class="nav-icon fas fa-user-ninja"></i>
                            </div>
                            <a href="#" class="small-box-footer">Lebih lanjut <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </router-link>
                    </div>

                    <div class="col-lg-3 col-6" @click="activate('unit')">
                        <router-link to="unit" class="small-box bg-info">
                            <div class="inner">
                                <h3> {{count.unit}} </h3>

                                <p>Unit</p>
                            </div>
                            <div class="icon">
                                <i class="nav-icon fas fa-home"></i>
                            </div>
                            <a href="#" class="small-box-footer">Lebih lanjut <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </router-link>
                    </div>

                    <div class="col-lg-3 col-6">
                        <router-link to="#" class="small-box bg-info">
                            <div class="inner">
                                <h3>
                                    <i class="fas fa-database"></i>
                                </h3>

                                <p>Pencatatan IoT</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-robot"></i>
                            </div>
                            <a href="#" class="small-box-footer font-weight-bold bg-danger rounded-bottom">Dalam tahap
                                pengembangan
                                <!-- <i class="fas fa-arrow-circle-right"></i> -->
                            </a>
                        </router-link>
                    </div>

                    <div class="col-lg-3 col-6">
                        <router-link to="#" class="small-box bg-info">
                            <div class="inner">
                                <h3>
                                    <i class="fas fa-money-bill-wave"></i>
                                </h3>

                                <p>Tagihan</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-file-invoice"></i>
                            </div>
                            <a href="#" class="small-box-footer font-weight-bold bg-danger rounded-bottom">Dalam tahap
                                pengembangan
                                <!-- <i class="fas fa-arrow-circle-right"></i> -->
                            </a>
                        </router-link>
                    </div>

                    <div class="col-lg-3 col-6">
                        <router-link to="#" class="small-box bg-info">
                            <div class="inner">
                                <h3>
                                    <i class="fas fa-envelope-open-text"></i>
                                </h3>

                                <p>Aduan</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-inbox"></i>
                            </div>
                            <a href="#" class="small-box-footer font-weight-bold bg-danger rounded-bottom">Dalam tahap
                                pengembangan
                                <!-- <i class="fas fa-arrow-circle-right"></i> -->
                            </a>
                        </router-link>
                    </div>

                </div>
            </div>
        </section>
    </div>
</template>

<script>
    import {
        mapActions,
        mapState,
        mapMutations
    } from 'vuex'
    export default {
        computed: {
            ...mapState('camer', {
                count: state => state.count
            }),
            ...mapState('user', {
                name: state => state.authenticated.name
            }),
        },
        methods: {
            ...mapActions('camer', ['getCount']),
            ...mapMutations(['SET_ACTIVEEL']),

            activate: function (el) {
                this.SET_ACTIVEEL(el)
            }
        },
        created() {
            this.getCount()
        }
    }
</script>