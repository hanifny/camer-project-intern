<template>
    <div class="main-content">
        <div class="header bg-gradient-success pb-6">
            <div class="container-fluid">
                <div class="header-body">
                    <div class="row align-items-center py-4">
                        <div class="col-lg-6 col-7">
                            <h6 class="h2 text-white d-inline-block mb-0">Catatan Meter</h6>
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
                            <h3 class="mb-0">Rekap Data Catatan Meter</h3>
                            <form>
                                <div class="form-row">
                                    <div class="form-group">
                                        <select id="inputState" class="form-control">
                                            <option selected disabled>Bulan</option>
                                            <option>...</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <select id="inputState" class="form-control">
                                            <option selected disabled>Tahun</option>
                                            <option>...</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-danger" @click.prevent="getCamer">Validasi Semua</button>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-success">Export to Excel <i
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
                                        <th>Validasi</th>
                                    </tr>
                                </thead>
                                <tbody class="list">
                                    <tr v-for="camer, index in all_camer" v-bind:class="{ validated: camer.validasi, fingerCursor: camer }" @click="cekDetail">
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
                                        <td v-if="camer.pemakaian_listrik"> {{ camer.pemakaian_listrik }} watt </td>
                                        <td v-else> Tidak ada data </td>
                                        <td v-if="camer.pemakaian_air"> {{ camer.pemakaian_air }} m<sup>3</sup></td>
                                        <td v-else> Tidak ada data </td>
                                        <td> {{camer.engineer}} </td>
                                        <td> {{camer.validator}} </td>
                                        <td> {{camer.bulan_tahun}} </td>
                                        <td v-if="camer.validasi"> Tervalidasi </td>
                                        <td v-else>
                                            <div class="col-lg-6 col-5 text-right">
                                                <a href="/adddatateknisi" class="btn btn-sm btn-success">Validasi</a>
                                            </div>
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
    </div>
</template>

<script>
    import {
        mapState,
        mapActions
    } from 'vuex'
    export default {
        computed: {
            ...mapState('camer', {
                all_camer: state => state.camer
            })
        },
        methods: {
            ...mapActions('camer', ['getCamer']),
            confirm() {
                swal.fire({
                    title: '<strong>HTML <u>example</u></strong>',
                    icon: 'info',
                    html: 'You can use <b>bold text</b>, ' +
                        '<a href="//sweetalert2.github.io">links</a> ' +
                        'and other HTML tags',
                    showCloseButton: true,
                    showCancelButton: true,
                    focusConfirm: false,
                    confirmButtonText: '<i class="fa fa-thumbs-up"></i> Great!',
                    confirmButtonAriaLabel: 'Thumbs up, great!',
                    cancelButtonText: '<i class="fa fa-thumbs-down"></i>',
                    cancelButtonAriaLabel: 'Thumbs down'
                })
            },
            cekDetail() {
                swal.fire({
                    title: '<strong>HTML <u>example</u></strong>',
                    icon: 'info',
                    html: 'You can use <b>bold text</b>, ' +
                        '<a href="//sweetalert2.github.io">links</a> ' +
                        'and other HTML tags',
                    showCloseButton: true,
                    showCancelButton: true,
                    focusConfirm: false,
                    confirmButtonText: '<i class="fa fa-thumbs-up"></i> Great!',
                    confirmButtonAriaLabel: 'Thumbs up, great!',
                    cancelButtonText: '<i class="fa fa-thumbs-down"></i>',
                    cancelButtonAriaLabel: 'Thumbs down'
                })
            }
        },
        created() {
            this.getCamer()
        }
    }
</script>