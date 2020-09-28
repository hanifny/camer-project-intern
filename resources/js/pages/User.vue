<template>
    <div class="main-content    ">
        <div class="header bg-gradient-success pb-6">
            <div class="container-fluid">
                <div class="header-body">
                    <div class="row align-items-center py-4">
                        <div class="col-lg-6 col-7">
                            <h6 class="h2 text-white d-inline-block mb-0">Data User</h6>
                        </div>
                        <div v-if="authenticated.role == 'SuperAdmin'" class="col-lg-6 col-5 text-right">
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
                            <h3 class="mb-0">Data User</h3>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-items-center text-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Role</th>
                                        <th>Email</th>
                                        <th>Nama</th>
                                        <th v-if="authenticated.role == 'SuperAdmin'">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="list">
                                    <tr v-for="user, index in users">
                                        <th scope="row">
                                            <div class="media align-items-center">
                                                <div class="media-body">
                                                    <span class="number mb-0 text-sm"> {{index+1}} </span>
                                                </div>
                                            </div>
                                        </th>
                                        <td> {{user.role}} </td>
                                        <td>
                                            {{user.email}}
                                        </td>
                                        <td>
                                            {{user.nama}}
                                        </td>
                                        <td v-if="authenticated.role == 'SuperAdmin'">
                                            <button href="" class="btn btn-sm btn-warning"
                                                @click.stop="formEdit(user)">Edit</button>
                                            <button v-if="user.role != 'SuperAdmin'" href="" class="btn btn-sm btn-danger"
                                                @click.stop="deleteUser(user)">Delete</button>
                                        </td>
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
        <b-modal id="form" hide-footer hide-header size="sm" centered>
            <div class="card mb-0">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 v-if="user.id" class="mb-0">Edit Data User</h3>
                            <h3 v-else class="mb-0">Tambah Data User</h3>
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
                            <input id="nama" type="text" v-model="user.nama" class="form-control"> 
                        </div>
                        <div class="form-group mt-2">
                            <label class="form-control-label" for="email">Email</label>
                            <input id="email" type="email" class="form-control" v-model="user.email">
                        </div>
                        <div class="form-group mt-2">
                            <label class="form-control-label" for="tipe">Password</label>
                            <input id="password" type="password" class="form-control" v-model="user.password">
                        </div>
                        <div class="form-group mt-2">
                            <label class="form-control-label" for="role"> Role </label>
                            <select id="role" class="form-control" v-model="user.role">
                                <option value="admin"> Admin </option>
                                <option value="engineer"> Teknisi </option>
                            </select>
                        </div>
                        <div class="mt-3 text-right mb-0">
                            <a v-if="user.id" href="#!" class="btn btn-sm btn-success" @click.prevent="updateUser">Edit</a>
                            <a v-else href="#!" class="btn btn-sm btn-success" @click.prevent="storeUser">Submit</a>
                        </div>
                    </form>
                </div>
            </div>
        </b-modal>
    </div>
</template>

<script>
    import $axios from '../api.js'
    import {
        mapActions,
        mapState
    } from 'vuex';
    export default {
        data() {
            return {
                user: {}
            }
        },
        computed: {
            ...mapState('user', {
                users: state => state.user
            }),
            ...mapState('user', {
                authenticated: state => state.authenticated   
            })
        },
        methods: {
            ...mapActions('user', ['getUser']),
            ...mapActions('user', ['addUser']),
            ...mapActions('user', ['editUser']),
            ...mapActions('user', ['removeUser']),

            formAdd() {
                this.user = {}
                this.$bvModal.show('form')
            },
            closeModal() {
                this.$bvModal.hide('form')
            },
            storeUser() {
                this.addUser(this.user)
                this.closeModal()
            },
            formEdit(user) {
                this.$bvModal.show('form')
                this.user = user
            },
            updateUser() {
                this.editUser(this.user)
                this.closeModal()
            },
            deleteUser(user) {
                swal.fire({
                    title: 'Apakah kamu yakin?',
                    text: "Kamu akan menghapus user " + user.nama,
                    icon: 'error',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, saya sangat yakin!',
                    cancelButtonText: 'Tidak, jangan!',
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.removeUser(user)
                        this.getUser()
                    }
                })
            }
        },
        created() {
            this.getUser()
        }
    }
</script>

<style>

</style>