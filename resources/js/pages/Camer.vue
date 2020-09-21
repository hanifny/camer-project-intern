<template>
    <div class="main-content">
        <div class="header bg-gradient-success pb-6">
            <div class="container-fluid">
                <div class="header-body">
                    <div class="row align-items-center py-4">
                        <div class="col-lg-6 col-7">
                            <h6 class="h2 text-white d-inline-block mb-0">Catatan Meter {{reverseYearMonth}} </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid mt--6">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-header border-0 d-flex align-items-center justify-content-between">
                            <h3 class="mb-0">Rekap Data Catatan Meter {{currentMonth}}</h3>
                            <form>
                                <div class="form-row">
                                    <div class="form-group">
                                        <input type="month" name="currentMonth" value="currentMonth"
                                            v-model="currentMonth">
                                    </div>
                                    <div class="form-group" v-if="user.role == 'Admin'">
                                        <button class="btn btn-danger"
                                            @click.prevent="validasiSemua(all_camer)">Validasi Semua</button>
                                    </div>
                                    <div class="form-group" v-if="user.role == 'Admin'">
                                        <button @click.prevent="exportExcel" class="btn btn-success">Export to Excel <i
                                                class="fas fa-file-excel"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
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
                                    <tr v-for="(camer, index) in all_camer"
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
                                        <td v-if="camer.pemakaian_listrik != null"> {{ camer.pemakaian_listrik }} watt
                                        </td>
                                        <td v-else> Tidak ada data </td>
                                        <td v-if="camer.pemakaian_air != null"> {{ camer.pemakaian_air }} m<sup>3</sup>
                                        </td>
                                        <td v-else> Tidak ada data </td>
                                        <td> {{camer.engineer}} </td>
                                        <td> {{camer.validator}} </td>
                                        <td> {{camer.bulan_tahun}} </td>
                                        <td v-if="camer.validasi == 1"> <strong> Tervalidasi </strong> </td>
                                        <td v-else-if="camer.validasi == 2"> <strong> Tidak Tervalidasi </strong> </td>
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
                                                {{currentItem.pencatatan_listrik}} watt
                                            <td v-else class="d-flex justify-content-start col-sm">: &nbsp;
                                                <input v-model="currentItem.pencatatan_listrik" type="number"> &nbsp;
                                                watt
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Stand Awal Listrik</td>
                                            <td v-if="currentItem.pencatatan_listrik_bulan_lalu">:
                                                {{currentItem.pencatatan_listrik_bulan_lalu}} watt </td>
                                            <td v-else>: Tidak ada data </td>
                                        </tr>
                                        <tr>
                                            <td>Pemakaian Listrik</td>
                                            <td v-if="currentItem.pemakaian_listrik !=null">: <strong>
                                                    {{currentItem.pemakaian_listrik}} watt </strong></td>
                                            <td v-else>: Tidak ada data </td>
                                        </tr>
                                        <tr>
                                            <td>Stand Akhir Air</td>
                                            <td
                                                v-if="currentItem.validasi == 1 || currentItem.validasi == 2 || user.role == 'Engineer'">
                                                :
                                                {{currentItem.pencatatan_air}} m<sup style="margin-top:10px;">3</sup>
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
                                                        <img :src="'/img/camer/' + currentItem.gambar1" height="150px"
                                                            width="250px;">
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="pl-1 pt-3 pb-3">
                                                <div class="zoom-effect">
                                                    <div class="kotak">
                                                        <img :src="'/img/camer/' + currentItem.gambar2" height="150px"
                                                            width="250px;">
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div v-if="currentItem.validasi == 0 && user.role == 'Admin'"
                            class="text-center d-flex bd-highlight pr-5 pl-5 pb-3">
                            <strong @click="invalid(currentItem)"
                                class="finger-cursor rounded p-2 btn-danger flex-fill bd-highlight">D A
                                T A &nbsp; T I D A K &nbsp; V A L I D</strong>
                            <strong @click="validasi(currentItem)"
                                class="finger-cursor rounded ml-2 p-2 btn-success flex-fill bd-highlight">V A L I D A S
                                I</strong>
                        </div>
                        <div v-else-if="currentItem.validasi == 1" class="text-center p-2 rounded-bottom btn-info">
                            <strong>T E R V A L I D A S I</strong>
                        </div>
                        <div v-else-if="currentItem.validasi == 2" class="text-center p-2 rounded-bottom btn-danger">
                            <strong>T I D A K &nbsp; T E R V A L I D A S I</strong>
                        </div>
                    </div>
                </div>
            </div>
        </b-modal>
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
                currentMonth: ''
            }
        },
        computed: {
            ...mapState('camer', {
                all_camer: state => state.camer
            }),
            ...mapState('user', {
                user: state => state.authenticated
            }),
            reverseYearMonth: function () {
                let rym = this.currentMonth.split("-").reverse().join(" ")
                this.getCamerPerMonth(rym)
            }
        },
        methods: {
            ...mapActions('camer', ['getCamer']),
            ...mapActions('camer', ['getCamerPerMonth']),
            ...mapActions('camer', ['validation']),
            ...mapActions('camer', ['validation_per_month']),
            ...mapActions('camer', ['exportToExcel']),

            exportExcel() {
                this.exportToExcel()
            },
            cekDetail(camer) {
                this.$bvModal.show('bv-modal')
                this.currentItem = camer
            },
            validasi(camer) {
                swal.fire({
                    title: 'Apakah kamu yakin?',
                    text: "Kamu akan melakukan validasi.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#f5365c',
                    cancelButtonText: 'Tidak, jangan',
                    confirmButtonText: 'Ya, lakukan validasi!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        swal.fire(
                            'Berhasil!',
                            'Kamu telah melakukan validasi.',
                            'success'
                        )
                        this.validation(camer)
                        this.getCamer()
                        this.bulan_tahun()
                        this.$bvModal.hide('bv-modal')
                    }
                })
            },
            validasiSemua(camer) {
                swal.fire({
                    title: 'Apakah kamu yakin?',
                    text: "Kamu akan melakukan validasi untuk semua data di bulan ini",
                    icon: 'error',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, saya sangat yakin!',
                    cancelButtonText: 'Tidak, jangan!',
                }).then((result) => {
                    if (result.isConfirmed) {
                        swal.fire(
                            'Berhasil!',
                            'Kamu telah melakukan validasi.',
                            'success'
                        )
                        this.validation_per_month(camer)
                        this.getCamer()
                        this.bulan_tahun()
                    }
                })
            },
            bulan_tahun() {
                let month_year = new Date().toISOString().split('-')
                month_year = month_year[0] + "-" + month_year[1]
                this.currentMonth = month_year
            },
            invalid(camer) {
                swal.fire({
                    title: 'Apakah kamu yakin?',
                    text: "Data ini kamu anggap tidak valid",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, saya sangat yakin!',
                    cancelButtonText: 'Tidak, jangan!',
                }).then((result) => {
                    if (result.isConfirmed) {
                        swal.fire(
                            'Berhasil!',
                            'Kamu menyatakan data ini tidak valid.',
                            'success'
                        )
                        camer.status = "invalid"
                        this.validation(camer)
                        this.$bvModal.hide('bv-modal')
                        this.getCamer()
                        this.bulan_tahun()
                    }
                })
            }
        },
        created() {
            this.getCamer()
            this.bulan_tahun()
        }
    }
</script>