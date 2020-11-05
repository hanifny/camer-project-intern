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
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-3 col-6"  @click="activate('invalid')"> 
                        <!-- small box -->
                        <router-link to="invalid" class="small-box bg-danger">
                            <div class="inner">
                                <h3> {{count.camer_invalid}} </h3>

                                <p>Invalid</p>
                            </div>
                            <div class="icon">  
                                <i class="nav-icon far fa-times-circle"></i>
                            </div>
                            <a href="#" class="small-box-footer">Lebih lanjut <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </router-link>
                    </div>

                    <div class="col-lg-3 col-6" @click="activate('camer')">
                        <!-- small box -->
                        <router-link to="camer" class="small-box bg-warning">
                            <div class="inner">
                                <h3> {{count.camer_must_validation}} </h3>

                                <p>Belum Tervalidasi</p>
                            </div>
                            <div class="icon">
                                <i class="nav-icon fas fa-exclamation-circle"></i>
                            </div>
                            <a href="#" class="small-box-footer">Lebih lanjut <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </router-link>
                    </div>
                    <div class="col-lg-3 col-6" @click="activate('camer')">
                        <!-- small box -->
                        <router-link to="camer" class="small-box bg-success">
                            <div class="inner">
                                <h3> {{count.camer_validated}} </h3>

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
                        <!-- small box -->
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
                    <!-- ./col -->
                    <div class="col-lg-3 col-6" @click="activate('unit')">
                        <!-- small box -->
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
                </div>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
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
            })
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