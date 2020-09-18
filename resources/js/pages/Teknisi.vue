<template>
    <div class="main-content    ">
        <div class="header bg-gradient-success pb-6">
            <div class="container-fluid">
                <div class="header-body">
                    <div class="row align-items-center py-4">
                        <div class="col-lg-6 col-7">
                            <h6 class="h2 text-white d-inline-block mb-0">Data Teknisi</h6>
                        </div>
                        <div v-if="user.role == 'Admin'" class="col-lg-6 col-5 text-right">
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
                            <h3 class="mb-0">Data Teknisi</h3>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-items-center text-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th>No</th>
                                        <th>ID</th>
                                        <th>Email</th>
                                        <th>Nama</th>
                                    </tr>
                                </thead>
                                <tbody class="list">
                                    <tr v-for="engineer, index in engineers">
                                        <th scope="row">
                                            <div class="media align-items-center">
                                                <div class="media-body">
                                                    <span class="number mb-0 text-sm"> {{index+1}} </span>
                                                </div>
                                            </div>
                                        </th>
                                        <td> {{engineer.id}} </td>
                                        <td>
                                            {{engineer.email}}
                                        </td>
                                        <td>
                                            {{engineer.nama}}
                                        </td>
                                        <!-- <td>
                                            <a href="/editdatateknisi" class="btn btn-sm btn-warning">Edit</a>
                                            <a href="#" class="btn btn-sm btn-danger">Delete</a>
                                        </td> -->
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer py-4">
                            <nav aria-label="...">
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <b-modal id="formAdd" hide-footer hide-header size="sm" centered>
            <div class="card mb-0">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Tambah Data Teknisi</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="#!" @click.prevent="closeModal" class="btn btn-sm btn-danger">x</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form>
                        <div class="form-group">
                            <label class="form-control-label" for="nama">Nama</label>
                            <input id="nama" type="text" v-model="engineer.nama" class="form-control"> 
                        </div>
                        <div class="form-group mt-2">
                            <label class="form-control-label" for="email">Email</label>
                            <input id="email" type="email" class="form-control" v-model="engineer.email">
                        </div>
                        <div class="form-group mt-2">
                            <label class="form-control-label" for="tipe">Password</label>
                            <input id="password" type="password" class="form-control" v-model="engineer.password">
                        </div>
                        <div class="mt-3 text-right mb-0">
                            <a href="#!" class="btn btn-sm btn-success" @click.prevent="storeEngineer">Submit</a>
                        </div>
                    </form>
                </div>
            </div>
        </b-modal>
    </div>
</template>

<script>
    import {
        mapActions,
        mapState
    } from 'vuex';
    export default {
        data() {
            return {
                engineer: {}
            }
        },
        computed: {
            ...mapState('user', {
                engineers: state => state.engineer
            }),
            ...mapState('user', {
                user: state => state.authenticated   
            })
        },
        methods: {
            ...mapActions('user', ['getEngineer']),
            ...mapActions('user', ['addEngineer']),

            formAdd() {
                this.$bvModal.show('formAdd')
            },
            closeModal() {
                this.$bvModal.hide('formAdd')
            },
            storeEngineer() {
                this.addEngineer(this.engineer)
                this.getEngineer()
                this.$bvModal.hide('formAdd')
            }
        },
        created() {
            this.getEngineer()
        }
    }
</script>

<style>

</style>