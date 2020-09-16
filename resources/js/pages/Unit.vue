<template>
    <div class="main-content">

        <div class="header bg-gradient-success pb-6">
            <div class="container-fluid">
                <div class="header-body">
                    <div class="row align-items-center py-4">
                        <div class="col-lg-6 col-7">
                            <h6 class="h2 text-white d-inline-block mb-0"> Data Apartement Unit </h6>
                        </div>
                        <div class="col-lg-6 col-5 text-right">
                            <a href="" class="btn btn-sm btn-success" @click.prevent="formAdd">Add</a>
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
                            <h3 class="mb-0">Daftar Unit Apartement Capitol Park</h3>
                            <form>
                                <div class="form-row" v-bind="getUnit">
                                    <div class="form-group">
                                        <select id="inputState" class="form-control" v-model="floor">
                                            <option selected>Semua</option>
                                            <option v-for="i in 12">Lantai {{i}}</option>
                                        </select>
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
                                        <th>Tipe</th>
                                        <th>Lantai</th>
                                    </tr>
                                </thead>
                                <tbody class="list">
                                    <tr v-for="(unit, index) in units" :key="unit.id">
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
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer py-4">
                            <nav aria-label="...">
                                <ul class="pagination justify-content-center mb-0">
                                    <pagination v-if="floor == 'Semua'" :data="units"
                                        @pagination-change-page="getAllUnit"></pagination>
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
                            <h3 class="mb-0">Tambah Data Unit</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="#!" @click.prevent="closeModal" class="btn btn-sm btn-danger">x</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form>
                        <div class="form-group">
                            <label class="form-control-label" for="input-username">Unit</label>
                            <input type="text" v-model="newUnit.unit" class="form-control">
                        </div>
                        <div class="form-group mt-2">
                            <label class="form-control-label" for="lantai">Lantai</label>

                            <select class="form-control" v-model="newUnit.lantai">
                                <option v-for="i in 12"> {{i}} </option>
                            </select>
                        </div>
                        <div class="form-group mt-2">
                            <label class="form-control-label" for="tipe">Tipe</label>

                            <select class="form-control" v-model="newUnit.type_id">
                                <option v-for="unit in types" :value=unit.id> {{unit.type}} </option>
                            </select>
                        </div>
                        <div class="mt-3 text-right mb-0">
                            <a href="#!" class="btn btn-sm btn-success" @click.prevent="storeUnit">Submit</a>
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
                newUnit: {}
            }
        },
        computed: {
            ...mapState('camer', {
                units: state => state.unit
            }),
            ...mapState('camer', {
                types: state => state.type
            }),
            getUnit: function () {
                if (this.floor == "Semua") {
                    this.getAllUnit('1')
                    // this.getAllUnit(1)
                } else {
                    let floor = this.floor.split(" ")
                    this.getUnitPerFloor(floor[1])
                }
            },
        },
        methods: {
            ...mapActions('camer', ['getAllUnit']),
            ...mapActions('camer', ['getUnitPerFloor']),
            ...mapActions('camer', ['getType']),
            ...mapActions('camer', ['storeNewUnit']),

            formAdd() {
                this.$bvModal.show('bv-modal')
                this.getType()
            },
            closeModal() {
                this.$bvModal.hide('bv-modal')
            },
            storeUnit() {
                console.log(this.newUnit);
                this.storeNewUnit(this.newUnit)
                this.getAllUnit(1)
                this.closeModal()
                this.newUnit = {}
            }
        },
        created() {
            this.getAllUnit(1)
        }
    }
</script>