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
            <b-modal id="bv-modal" size="lg" hide-header hide-footer>
                <div class="row">
                    <div class="col-md ml-auto mr-auto">
                        <div class="card card-upgrade mb-0">
                            <div class="card-header text-center pt-4 pb-1 border-bottom-0">
                                <h3 class="card-title">Detail Lengkap Catatan Meter</h3>
                            </div>
                            <div class="card-body pt-0 pb-0">
                                <div class="table-responsive table-upgrade">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td>Unit</td>
                                                <td>: {{currentItem.unit}} </td>
                                            </tr>
                                            <tr>
                                                <td>Stand Akhir Listrik</td>
                                                <td
                                                    v-if="currentItem.validasi == 1 || currentItem.validasi == 2 || user.role == 'Engineer'">
                                                    :
                                                    {{currentItem.pencatatan_listrik}} kwh
                                                <td v-else class="d-flex justify-content-start col-sm">: &nbsp;
                                                    <input v-model="currentItem.pencatatan_listrik" type="number">
                                                    &nbsp;
                                                    kwh
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Stand Awal Listrik</td>
                                                <td v-if="currentItem.pencatatan_listrik_bulan_lalu">:
                                                    {{currentItem.pencatatan_listrik_bulan_lalu}} kwh </td>
                                                <td v-else>: Tidak ada data </td>
                                            </tr>
                                            <tr>
                                                <td>Pemakaian Listrik</td>
                                                <td v-if="currentItem.pemakaian_listrik !=null">: <strong>
                                                        {{currentItem.pemakaian_listrik}} kwh </strong></td>
                                                <td v-else>: Tidak ada data </td>
                                            </tr>
                                            <tr>
                                                <td>Stand Akhir Air</td>
                                                <td
                                                    v-if="currentItem.validasi == 1 || currentItem.validasi == 2 || user.role == 'Engineer'">
                                                    :
                                                    {{currentItem.pencatatan_air}} m<sup
                                                        style="margin-top:10px;">3</sup>
                                                <td v-else class="d-flex justify-content-start col-sm">: &nbsp;
                                                    <input type="number" v-model="currentItem.pencatatan_air">
                                                    &nbsp;
                                                    m<sup style="margin-top:10px;">3</sup>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Stand Awal Air</td>
                                                <td v-if="currentItem.pencatatan_air_bulan_lalu">:
                                                    {{currentItem.pencatatan_air_bulan_lalu}} m<sup>3</sup> </td>
                                                <td v-else>: Tidak ada data </td>
                                            </tr>
                                            <tr>
                                                <td>Pemakaian Air</td>
                                                <td v-if="currentItem.pemakaian_air !=null">: <strong>
                                                        {{currentItem.pemakaian_air}} m<sup>3</sup> </strong></td>
                                                <td v-else>: Tidak ada data </td>
                                            </tr>
                                            <tr>
                                                <td>Nama Teknisi</td>
                                                <td>: <strong> {{currentItem.engineer}} </strong></td>
                                            </tr>
                                            <tr>
                                                <td>Tgl Upload Data</td>
                                                <td>: <strong> {{currentItem.tanggal_upload}} </strong></td>
                                            </tr>
                                            <tr>
                                                <td>Lampiran Foto</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td class="text-right pt-3 pb-3 pr-1">
                                                    <div class="zoom-effect">
                                                        <div class="kotak">
                                                            <img :src="'/img/camer/' + currentItem.gambar1"
                                                                height="150px" width="250px;">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="pl-1 pt-3 pb-3">
                                                    <div class="zoom-effect">
                                                        <div class="kotak">
                                                            <img :src="'/img/camer/' + currentItem.gambar2"
                                                                height="150px" width="250px;">
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
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