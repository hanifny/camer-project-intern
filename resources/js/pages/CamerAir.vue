<template>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6 d-flex">
                        <h1 class="m-0 text-dark">Camer Air {{reverseYearMonth}}</h1>
                        <i class="far fa-question-circle ml-1" id="popover-target-1"></i>
                        <b-popover target="popover-target-1" triggers="hover" placement="top">
                            Menu ini termuat catatan meter air yang telah di<i>upload</i> oleh teknisi, kemudian
                            di menu ini administrator dapat melakukan validasi data tersebut.
                        </b-popover>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item" @click="activate('home')">
                                <router-link to="/">Dasbor</router-link>
                            </li>
                            <li class="breadcrumb-item active">Camer Air</li>
                        </ol>
                    </div>
                </div>
                <div class="row mb-0 d-flex justify-content-center">
                    <div class="col-lg-3">
                        <div class="card card-stats">
                            <div class="card-body p-3">
                                <div class="row">
                                    <div class="col d-flex align-items-center justify-content-between">
                                        <h6 class="text-muted text-uppercase"><b>Belum tervalidasi</b></h6>
                                        <span class="h2 font-weight-bold">
                                            {{count.el_validation}}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card card-stats">
                            <div class="card-body p-3">
                                <div class="row">
                                    <div class="col d-flex align-items-center justify-content-between">
                                        <h6 class="text-muted text-uppercase"><b>Tervalidasi hari ini</b></h6>
                                        <span class="h2 font-weight-bold">
                                            {{count.el_validated_today}}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-header d-flex align-items-center justify-content-center">
                                    <span class="font-weight-bold">Bulan :</span>
                                    <input type="month" name="currentMonth" value="currentMonth" v-model="currentMonth"
                                        class="btn btn-outline-primary font-weight-bold ml-2 mr-2">
                                    <span v-if="user.role == 'Admin' || user.role == 'SuperAdmin'">|</span>
                                    <b-button v-b-modal="'modal-form'"
                                        v-if="user.role == 'Admin' || user.role == 'SuperAdmin'"
                                        class="btn btn-success ml-2 mr-2">
                                        <i class="fas fa-plus-circle nav-icon"></i>
                                        Tambah Camer
                                    </b-button>
                                </div>
                                <div class="table-responsive">
                                    <table class="table align-items-center table-flush text-center">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>No</th>
                                                <th>
                                                    <div class="dropdown">
                                                        <a class="dropdown-toggle" href="#" role="button"
                                                            id="dropdownMenuLink" data-toggle="dropdown"
                                                            aria-haspopup="true" aria-expanded="false">
                                                            Unit
                                                        </a>

                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                            <a class="dropdown-item" href="#"
                                                                @click="camer('Semua')">Semua</a>
                                                            <a class="dropdown-item" href="#" @click="camer('T')">Tower
                                                                T</a>
                                                            <a class="dropdown-item" href="#" @click="camer('U')">Tower
                                                                U</a>
                                                            <a class="dropdown-item" href="#"
                                                                @click="camer('B')">Basement</a>
                                                        </div>
                                                    </div>
                                                </th>
                                                <th>Meter Awal</th>
                                                <th>Meter Akhir</th>
                                                <th>Teknisi</th>
                                                <th>Administrator</th>
                                                <th>Bulan</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody class="list">
                                            <tr v-for="(camer, index) in all_camer.data"
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
                                                <td v-if="camer.meter_awal != null">
                                                    {{ camer.meter_awal }} kwh
                                                </td>
                                                <td v-else> Tidak ada data </td>

                                                <td v-if="camer.meter_akhir != null"> {{ camer.meter_akhir }} kwh </td>
                                                <td v-else> Tidak ada data </td>
                                                <td> {{camer.engineer}} </td>
                                                <td> {{camer.validator}} </td>
                                                <td> {{camer.bulan_tahun}} </td>
                                                <td v-if="camer.validasi == 1"> <strong> Tervalidasi </strong> </td>
                                                <td v-else-if="camer.validasi == 2"> <strong> Tidak Tervalidasi
                                                    </strong> </td>
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
                                <!-- PAGINATION -->
                                <div class="card-footer">
                                    <nav aria-label="...">
                                        <ul class="pagination justify-content-end">
                                            <pagination v-if="activePagination == 'ac'" :data="all_camer"
                                                @pagination-change-page="getCamer"></pagination>
                                            <pagination v-else-if="activePagination == 'pt'" :data="all_camer"
                                                @pagination-change-page="paginationPerTower"></pagination>
                                            <pagination v-else-if="activePagination == 'pm'" :data="all_camer"
                                                @pagination-change-page="paginationPerMonth"></pagination>
                                        </ul>
                                    </nav>
                                </div>
                                <!-- END PAGINATION -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- MODAL CAMER -->
                <b-modal id="modal-camer" size="lg" centered hide-header hide-footer>
                    <div class="row">
                        <div class="col-md ml-auto mr-auto">
                            <div class="card card-upgrade mb-0">
                                <div class="card-header d-flex">
                                    <div class="col-8">
                                        <h3 class="card-title mb-0 font-weight-bold">Detail Catatan Meter Air</h3>
                                    </div>
                                    <div class="col-4 text-right">
                                        <a href="#!" @click.prevent="closeModalCamer"
                                            class="btn btn-sm btn-danger">x</a>
                                    </div>
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
                                                            {{currentItem.meter_akhir}} kwh
                                                        </strong>
                                                        <strong v-else>
                                                            <input class="col-9" type="number"
                                                                v-model="currentItem.meter_akhir"> &nbsp; kwh
                                                        </strong>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col col-lg-5">Stand Awal Air</div>
                                                    <div class="col-auto text-right">:</div>
                                                    <div class="col col-lg-6">
                                                        <span v-if="currentItem.meter_awal">
                                                            {{currentItem.meter_awal}} kwh
                                                        </span>
                                                        <span v-else> Tidak ada data </span>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col col-lg-5">Pemakaian</div>
                                                    <div class="col-auto text-right">:</div>
                                                    <div class="col col-lg-6">
                                                        <span v-if="currentItem.meter_awal !=null"> <strong>
                                                                {{currentItem.meter_akhir - currentItem.meter_awal}} kwh
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
                                                            <img :src="'/img/camer/' + currentItem.gambar"
                                                                class="rounded" alt="Gambar tidak tersedia"
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
                                <div v-if="currentItem.validasi == 3 && (user.role == 'Admin' || user.role == 'SuperAdmin')"
                                    class="text-center d-flex bd-highlight pr-3 pl-3 pb-3">
                                    <strong @click="invalid(currentItem)"
                                        class="finger-cursor rounded mr-1 p-2 btn-danger flex-fill bd-highlight">D A
                                        T A &nbsp; T I D A K &nbsp; V A L I D</strong>
                                    <strong @click="validasi(currentItem)"
                                        class="finger-cursor rounded ml-1 p-2 btn-success flex-fill bd-highlight">V
                                        A L
                                        I D A S
                                        I</strong>
                                </div>
                                <div v-else-if="currentItem.validasi == 1"
                                    class="text-center p-2 rounded-bottom btn-success">
                                    <strong>T E R V A L I D A S I</strong>
                                </div>
                                <div v-else-if="currentItem.validasi == 2"
                                    class="text-center p-2 rounded-bottom btn-danger">
                                    <strong>T I D A K &nbsp; T E R V A L I D A S I</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </b-modal>
                <!-- END MODAL CAMER -->

                <!-- MODAL ADD CAMER -->
                <b-modal id="modal-form" hide-footer hide-header size="md" centered>
                    <div class="card mb-0">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h5 class="mb-0">Tambah Camer</h5>
                                </div>
                                <div class="col-4 text-right">
                                    <a href="#!" @click.prevent="closeModalForm" class="btn btn-sm btn-danger">x</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="form-group">
                                    <label class="form-control-label" for="tipe">Tipe</label>
                                    <input type="text" class="form-control" disabled placeholder="WT">
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="bulan_tahun">Bulan</label>
                                    <input type="month" class="form-control" id="bulan_tahun" v-model="newCamer.bulan_tahun">
                                </div>
                                <div class="form-group mt-2">
                                    <label class="form-control-label" for="unit">Unit</label>
                                    <input placeholder="Ditulis dengan huruf kapital" id="unit" type="text"
                                        class="form-control" v-model="newCamer.unit">
                                </div>
                                <div class="form-group mt-2">
                                    <label class="form-control-label" for="meter_akhir">Meter Akhir</label>
                                    <input id="meter_akhir" type="text" class="form-control"
                                        v-model="newCamer.meter_akhir">
                                </div>
                                <div class="form-group mt-2">
                                    <label class="form-control-label" for="gambar"> Gambar </label> <br>
                                    <input id="gambar" ref="gambar" type="file" @change="handleFileUpload()">
                                </div>
                                <div class="mt-3 text-right mb-0">
                                    <a class="btn btn-sm btn-success" href="#!" @click.prevent="simpanCamer">Simpan</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </b-modal>
                <!-- END MODAL ADD CAMER -->

            </div>
            <!-- /.content -->
            <!-- /.content-wrapper -->
        </section>

    </div>
</template>

<script>
    import {
        mapState,
        mapActions,
        mapMutations
    } from 'vuex';
    import { bus } from '../app';
    export default {
        data() {
            return {
                currentItem: {},
                currentMonth: '',
                activePagination: 'ac',
                currentTower: '',
                newCamer: {},
            }
        },
        computed: {
            ...mapState('camer', {
                count: state => state.count
            }),
            ...mapState('camer', {
                all_camer: state => state.camer
            }),
            ...mapState('user', {
                user: state => state.authenticated
            }),
            reverseYearMonth: function () {
                let rym = this.currentMonth.split("-").reverse().join(" ")
                this.activePagination = 'pm'
                this.getCamerPerMonth({
                    bulan: rym,
                    page: 1,
                    type: 'wt'
                })
            }
        },
        methods: {
            ...mapActions('camer', ['getCamer']),
            ...mapActions('camer', ['getCamerPerMonth']),
            ...mapActions('camer', ['validation']),
            ...mapActions('camer', ['validation_per_month']),
            ...mapActions('camer', ['exportToExcel']),
            ...mapActions('camer', ['addCamer']),
            ...mapActions('camer', ['getCount']),

            closeModalCamer() {
                this.$bvModal.hide('modal-camer')
            },

            closeModalForm() {
                this.$bvModal.hide('modal-form')
            },

            paginationPerTower(page) {
                this.getCamer({
                    bulan: this.currentMonth.split("-").reverse().join(" "),
                    tower: this.currentTower,
                    page: page,
                    tipe: 'wt'
                });
            },
            
            paginationPerMonth(page) {
                this.getCamerPerMonth({
                    bulan: this.currentMonth.split("-").reverse().join(" "),
                    page: page,
                    tipe: 'wt'
                });
            },

            camer(twr) {
                this.currentTower = twr
                this.activePagination = 'pt'
                this.getCamer({
                    bulan: this.currentMonth.split("-").reverse().join(" "),
                    tower: twr,
                    page: 1,
                    tipe: 'wt'
                });
            },
            
            exportExcel() {
                this.exportToExcel()
            },
            
            cekDetail(camer) {
                this.$bvModal.show('modal-camer')
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
                        this.validation(camer);
                        bus.$emit('refreshDataEl');
                        this.closeModalCamer();
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
                        this.validation(camer);
                        this.closeModalCamer();
                        bus.$emit('refreshDataEl');
                    }
                })
            },
            
            // Handles a change on the file upload
            handleFileUpload() {
                this.newCamer.gambar = this.$refs.gambar.files[0];
            },

            // Simpan Camer
            simpanCamer() {
                // Initialize the form data
                let formData = new FormData();

                // Add the form data we need to submit
                formData.append('gambar', this.newCamer.gambar);
                formData.append('bulan', this.newCamer.bulan_tahun);
                formData.append('tipe', 'wt');
                formData.append('unit', this.newCamer.unit);
                formData.append('meter_akhir', this.newCamer.meter_akhir);

                // Make the request to the POST /single-file URL
                this.addCamer(formData);
                this.closeModalForm();
                this.newCamer = {};
                bus.$emit('refreshDataEl');
            },
        },

        created() {
            this.getCount();
            this.bulan_tahun();

            bus.$on('refreshDataEl', () => {
                this.bulan_tahun();
                this.getCount();
                setTimeout(() => {
                    this.camer('Semua');
                }, 755);
            });
        },
    }
</script>