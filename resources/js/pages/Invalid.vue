<template>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6 d-flex">
                        <h1 class="m-0 text-dark">Data Invalid</h1>
                        <i class="far fa-question-circle ml-1" id="popover-target-1"></i>
                        <b-popover target="popover-target-1" triggers="hover" placement="top">
                            Data invalid adalah data yang harus dikirim ulang dikarenakan bukti gambar yang buram atau
                            tidak jelas.
                        </b-popover>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item" @click="activate('home')">
                                <router-link to="/">Dasbor</router-link>
                            </li>
                            <li class="breadcrumb-item active">Data Invalid</li>
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
                    <div class="col">
                        <div class="card">
                            <div class="table-responsive">
                                <table class="table align-items-center table-flush text-center">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Unit</th>
                                            <th>Pemakaian Listrik</th>
                                            <th>Pemakaian Air</th>
                                            <th>Engineer</th>
                                            <th>Validator</th>
                                            <th>Bulan</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list">
                                        <tr v-for="(camer, index) in all_camer_invalid"
                                            v-bind:class="{ 'validated': camer.validasi == 1, 'invalid': camer.validasi == 2, 'finger-cursor': camer }"
                                            @click.prevent="cekDetail(camer)" :key="camer.id">
                                            <th scope="row">
                                                <div class="media">
                                                    <div class="media-body">
                                                        <span class="number mb-0 text-sm">{{index+1}}</span>
                                                    </div>
                                                </div>
                                            </th>
                                            <td>
                                                <router-link to="">{{camer.unit}}</router-link>
                                            </td>
                                            <td v-if="camer.pemakaian_listrik != null"> {{ camer.pemakaian_listrik }}
                                                kwh
                                            </td>
                                            <td v-else> Tidak ada data </td>
                                            <td v-if="camer.pemakaian_air != null"> {{ camer.pemakaian_air }}
                                                m<sup>3</sup>
                                            </td>
                                            <td v-else> Tidak ada data </td>
                                            <td> {{camer.engineer}} </td>
                                            <td> {{camer.validator}} </td>
                                            <td> {{camer.bulan_tahun}} </td>
                                            <td v-if="camer.validasi == 1"> <strong> Tervalidasi </strong> </td>
                                            <td v-else-if="camer.validasi == 2"> <strong> Tidak Tervalidasi </strong>
                                            </td>
                                            <td v-else-if="user.role == 'Engineer' && camer.validasi == 0">
                                                <strong>Belum Tervalidasi</strong>
                                            </td>
                                            <td v-else>
                                                <strong> Belum Tervalidasi </strong>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer py-4">
                                <nav aria-label="...">
                                    <ul class="pagination justify-content-end mb-0">

                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <b-modal id="bv-modal" size="lg" centered hide-header hide-footer>
                <div class="row">
                    <div class="col-md ml-auto mr-auto">
                        <div class="card card-upgrade mb-0">
                            <div class="card card-upgrade mb-0">
                                <div class="card-header">
                                    <h3 class="card-title mb-0 font-weight-bold">Detail Catatan Meter Invalid</h3>
                                </div>
                                <div class="card-body">
                                    <div class="container">
                                        <div class="row align-items-center">
                                            <div class="col col-lg-6">
                                                <div class="row">
                                                    <div class="col col-lg-5">Tipe</div>
                                                    <div class="col-auto text-right">:</div>
                                                    <div class="col col-lg-6">{{currentItem.tipe}}</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col col-lg-5">Unit</div>
                                                    <div class="col-auto text-right">:</div>
                                                    <div class="col col-lg-6">{{currentItem.unit}}</div>
                                                </div>
                                                <div class="row d-flex align-items-center">
                                                    <div class="col col-lg-5">Stand Akhir Air</div>
                                                    <div class="col-auto text-right">:</div>
                                                    <div class="col col-lg-6">
                                                        <strong
                                                            v-if="currentItem.validasi == 1 || currentItem.validasi == 2 || user.role == 'Engineer'">
                                                            {{currentItem.meter_akhir}} m <sup>3</sup>
                                                        </strong>
                                                        <strong v-else>
                                                            <input class="col-9" type="number"
                                                                v-model="currentItem.meter_akhir"> &nbsp; m <sup>3</sup>
                                                        </strong>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col col-lg-5">Stand Awal Air</div>
                                                    <div class="col-auto text-right">:</div>
                                                    <div class="col col-lg-6">
                                                        <span v-if="currentItem.meter_awal">
                                                            {{currentItem.meter_awal}} m <sup>3</sup>
                                                        </span>
                                                        <span v-else> Tidak ada data </span>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col col-lg-5">Pemakaian</div>
                                                    <div class="col-auto text-right">:</div>
                                                    <div class="col col-lg-6">
                                                        <span v-if="currentItem.meter_awal !=null"> <strong>
                                                                {{currentItem.meter_akhir - currentItem.meter_awal}} m
                                                                <sup>3</sup>
                                                            </strong>
                                                        </span>
                                                        <span v-else> Tidak ada data </span>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col col-lg-5">Teknisi</div>
                                                    <div class="col-auto text-right">:</div>
                                                    <div class="col col-lg-6"><strong> {{currentItem.engineer}}
                                                        </strong></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col col-lg-5">Tanggal Upload Data</div>
                                                    <div class="col-auto text-right">:</div>
                                                    <div class="col col-lg-6"><strong> {{currentItem.tanggal_upload}}
                                                        </strong></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col col-lg-5">Validator</div>
                                                    <div class="col-auto text-right">:</div>
                                                    <div class="col col-lg-6">
                                                        <span
                                                            v-if="currentItem.validator !=null">{{currentItem.validator}}</span>
                                                        <span v-else> - </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col col-lg-6">
                                                <div class="text-center">
                                                    <div class="zoom-effect">
                                                        <div class="kotak">
                                                            <img :src="'/img/camer/' + currentItem.gambar" class="rounded" alt="Gambar tidak tersedia"
                                                                height="275px" width="375px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- ./row -->
                                    </div>
                                </div>
                                <!-- ./card-body -->
                            </div>
                            <div v-if="currentItem.validasi == 2" class="text-center p-2 rounded-bottom btn-danger">
                                <strong>T I D A K &nbsp; T E R V A L I D A S I</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </b-modal>
        </section>
    </div>
</template>

<script>
    import {
        mapState,
        mapActions
    } from 'vuex'
    export default {
        data() {
            return {
                currentItem: {},
            }
        },
        computed: {
            ...mapState('camer', {
                all_camer_invalid: state => state.camer_invalid
            }),
            ...mapState('user', {
                user: state => state.authenticated
            }),
        },
        methods: {
            ...mapActions('camer', ['getCamerInvalid']),

            cekDetail(camer) {
                this.$bvModal.show('bv-modal')
                this.currentItem = camer
            },
        },
        created() {
            this.getCamerInvalid()
        }
    }
</script>