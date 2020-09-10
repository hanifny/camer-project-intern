<template>
    <div class="main-content">

        <div class="header bg-gradient-success pb-6">
            <div class="container-fluid">
                <div class="header-body">
                    <div class="row align-items-center py-4">
                        <div class="col-lg-6 col-7">
                            <h6 class="h2 text-white d-inline-block mb-0"> Data Apartement Unit {{units.length}} </h6>
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
                                <div class="form-row">
                                    <div class="form-group">
                                        <select id="inputState" class="form-control" v-model="floor">
                                            <option selected @click="getAllUnit">Semua</option>
                                            <option v-for="i in 12" @click="clickUnitPerFloor">Lantai {{i}}</option>
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
                                    <pagination v-if="floor == 'Semua'" :data="units" @pagination-change-page="getAllUnit"></pagination>
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
    } from 'vuex';
    export default {
        data() {
            return {
                floor: 'Semua',
            }
        },
        computed: {
            ...mapState('camer', {
                units: state => state.unit
            })
        },
        methods: {
            ...mapActions('camer', ['getAllUnit']),
            ...mapActions('camer', ['getUnitPerFloor']),

            clickUnitPerFloor() {
                let floor = this.floor.split(" ")
                this.getUnitPerFloor(floor[1])
            }
        },
        created() {
            this.getAllUnit(1)
        }
    }
</script>