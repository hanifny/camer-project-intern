-<template>
    <div class="main-content">

        <div class="header bg-gradient-success pb-6">
            <div class="container-fluid">
                <div class="header-body">
                    <div class="row align-items-center py-4">
                        <div class="col-lg-6 col-7">
                            <h6 class="h2 text-white d-inline-block mb-0"> Data Apartement Unit </h6>
                        </div>
                        <div class="col-lg-6 col-5 text-right">
                            <a href="" v-if="user.role == 'Admin' || user.role == 'SuperAdmin'"
                                class="btn btn-sm btn-success" @click.prevent="formAdd">Add</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid mt--6">
            <div class="row">
                <div class="col">
                    <div class="card" v-bind="getUnit">
                        <div class="card-header border-0 d-flex align-items-center justify-content-between">
                            <h3 class="mb-0">Daftar Unit Apartement Capitol Park</h3>
                            <form class="form-inline d-flex justify-content-end">
                                <label class="form-control-label" for="lantai">Lantai &nbsp; </label>
                                <input id="lantai" type="text" class="form-control col-4" v-model="floor">
                            </form>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush text-center">
                                <thead class="thead-light">
                                    <tr>
                                        <th>No</th>

                                        <th>
                                            <div class="dropdown">
                                                <a class="btn btn-secondary dropdown-toggle" href="#" role="button"
                                                    id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    Unit
                                                </a>

                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                    <a class="dropdown-item" href="#" @click="getTower('Semua')">Semua</a>
                                                    <a class="dropdown-item" href="#" @click="getTower('T')">Tower T</a>
                                                    <a class="dropdown-item" href="#" @click="getTower('U')">Tower U</a>
                                                </div>
                                            </div>
                                        </th>


                                        <th>Tipe</th>
                                        <th>Lantai</th>
                                        <th v-if="user.role == 'Admin' || user.role == 'SuperAdmin'">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="list">
                                    <tr v-for="(unit, index) in units.data" :key="unit.id">
                                        <th scope="row">
                                            <div class="media">
                                                <div class="media-body">
                                                    <span class="number mb-0 text-sm">{{index+1}}</span>
                                                </div>
                                            </div>
                                        </th>
                                        <td> {{unit.unit}} </td>
                                        <td> {{unit.tipe}} </td>
                                        <td> {{unit.lantai}} </td>
                                        <td v-if="user.role == 'Admin' || user.role == 'SuperAdmin'">
                                            <button href="" class="btn btn-sm btn-warning"
                                                @click.stop="formEdit(unit)">Edit</button>
                                            <button href="" class="btn btn-sm btn-danger"
                                                @click.stop="deleteUnit(unit.id)">Delete</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer py-4">
                            <nav aria-label="...">
                                <ul class="pagination justify-content-center mb-0">
                                    <pagination v-if="activePagination == 'au'" :data=units @pagination-change-page="getAllUnit"></pagination>
                                    <pagination v-else-if="activePagination == 'pt'" :data=units @pagination-change-page="pcpUnitPerTower"></pagination>
                                    <pagination v-else-if="activePagination == 'pf'" :data=units @pagination-change-page="pcpUnitPerFloor"></pagination>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <b-modal id="bv-modal" size="sm" centered hide-header hide-footer>
            <div class="card mb-0">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 v-if="newUnit.id" class="mb-0">Edit Data Unit</h3>
                            <h3 v-else class="mb-0">Tambah Data Unit</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="#!" @click.prevent="closeModal" class="btn btn-sm btn-danger">x</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form>
                        <div class="form-group">
                            <label class="form-control-label" for="unit">Unit</label>
                            <input id="unit" type="text" v-model="newUnit.unit" class="form-control">
                        </div>
                        <div class="form-group mt-2">
                            <label class="form-control-label" for="lantai">Lantai</label>
                            <input id="lantai" type="number" class="form-control" v-model="newUnit.lantai">
                        </div>
                        <div class="form-group mt-2">
                            <label class="form-control-label" for="tipe">Tipe</label>
                            <select id="tipe" class="form-control" v-model="newUnit.tipe_id">
                                <option v-if="newUnit.tipe != unit.tipe" v-for="unit in types" :value=unit.id>
                                    {{unit.tipe}} </option>
                                <option :value=newUnit.tipe_id> {{newUnit.tipe}} </option>
                            </select>
                        </div>
                        <div class="mt-3 text-right mb-0">
                            <a v-if="newUnit.id" href="#!" class="btn btn-sm btn-warning"
                                @click.prevent="updateUnit">Edit</a>
                            <a v-else href="#!" class="btn btn-sm btn-success" @click.prevent="storeUnit">Submit</a>
                        </div>
                    </form>
                </div>
            </div>
        </b-modal>
        <!-- END MODAL -->
    </div>
</template>

<script>
    import {
        mapState,
        mapActions
    } from 'vuex';
    export default {
        data() {
            return {
                floor: 'Semua',
                newUnit: {},
                tower: 'Semua',
                activePagination: ''
            }
        },
        computed: {
            ...mapState('camer', {
                units: state => state.unit
            }),
            ...mapState('camer', {
                types: state => state.type
            }),
            ...mapState('user', {
                user: state => state.authenticated
            }),
            getUnit: function () {
                if ((this.floor == "Semua" || this.floor == "") && this.tower == "Semua") {
                    this.getAllUnit(1)
                    this.activePagination = 'au'
                } else if (this.floor != "") {
                    this.activePagination = 'pf'
                    this.getUnitPerFloor({floor: this.floor, page: 1})
                }
            },
        },
        methods: {
            ...mapActions('camer', ['getAllUnit']),
            ...mapActions('camer', ['getUnitPerFloor']),
            ...mapActions('camer', ['getType']),
            ...mapActions('camer', ['storeNewUnit']),
            ...mapActions('camer', ['editUnit']),
            ...mapActions('camer', ['destroyUnit']),
            ...mapActions('camer', ['getUnitPerTower']),

            pcpUnitPerFloor(x) {
                this.getUnitPerFloor({floor: this.floor, page: x})
                
            },
            pcpUnitPerTower(x) {
                this.getUnitPerTower({tower: this.tower, page: x})
                
            },
            formAdd() {
                this.newUnit = {}
                this.$bvModal.show('bv-modal')
                this.getType()
            },
            closeModal() {
                this.$bvModal.hide('bv-modal')
            },
            storeUnit() {
                this.storeNewUnit(this.newUnit)
                this.closeModal()
            },
            formEdit(unit) {
                this.newUnit = unit
                this.getType()
                this.$bvModal.show('bv-modal')
            },
            updateUnit() {
                this.editUnit(this.newUnit)
                this.closeModal()
            },
            deleteUnit(id) {
                swal.fire({
                    title: 'Apakah kamu yakin?',
                    text: "Kamu akan menghapus unit ini.",
                    icon: 'error',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#f5365c',
                    cancelButtonText: 'Tidak, jangan',
                    confirmButtonText: 'Ya, hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.destroyUnit(id)
                        this.getAllUnit(1)
                        this.activePagination = 'au'
                    }
                })
            },
            getTower(id) {
                this.floor = ''
                this.tower = id;
                if (id == "Semua") {
                    this.getAllUnit(1)
                    this.activePagination = 'au'
                } else if (id == "T" || id == "U") {
                    this.getUnitPerTower({tower: id, page: 1})
                    this.activePagination = 'pt'
                }
            }
        },
        created() {
            this.activePagination = 'au'
            this.getAllUnit(1)
        }
    }
</script>