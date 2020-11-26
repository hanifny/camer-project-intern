<template>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6 d-flex">
                        <h1 class="m-0 text-dark">Data User</h1>
                        <i class="far fa-question-circle ml-1" id="popover-target-1"></i>
                        <b-popover target="popover-target-1" triggers="hover" placement="top">
                            Menu ini termuat daftar identitas semua <i>user</i>. <b>Hanya</b> <i>user</i> dengan <i>role</i> SuperAdmin yang dapat menambah,
                            memperbarui dan menghapus <i>user</i>. 
                        </b-popover>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item" @click="activate('home')">
                                <router-link to="/">Dasbor</router-link>
                            </li>
                            <li class="breadcrumb-item active">Data User</li>
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
                            <div v-if="authenticated.role == 'SuperAdmin'"
                                class="card-header border-0 d-flex align-items-center justify-content-center">
                                <a href="" class="btn btn-sm btn-success" @click.prevent="formAdd">
                                    <i class="nav-icon fas fa-plus-circle"></i>
                                    Tambah
                                </a>
                            </div>
                            <div class="table-responsive">
                                <table class="table align-items-center text-center table-flush">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Role</th>
                                            <th>Username</th>
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
                                                {{user.username}}
                                            </td>
                                            <td>
                                                {{user.name}}
                                            </td>
                                            <td v-if="authenticated.role == 'SuperAdmin'">
                                                <button href="" class="btn btn-sm btn-warning"
                                                    @click.stop="formEdit(user)">Edit</button>
                                                <button v-if="user.role != 'SuperAdmin'" href=""
                                                    class="btn btn-sm btn-danger"
                                                    @click.stop="deleteUser(user)">Hapus</button>
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
                                <h5 v-if="user.id" class="mb-0">Edit Data User</h5>
                                <h5 v-else class="mb-0">Tambah Data User</h5>
                            </div>
                            <div class="col-4 text-right">
                                <a href="#!" @click.prevent="closeModal" class="btn btn-sm btn-danger">x</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="form-group">
                                <label class="form-control-label" for="name">Nama</label>
                                <input id="name" type="text" v-model="user.name" class="form-control">
                            </div>
                            <div class="form-group mt-2">
                                <label class="form-control-label" for="username">Username</label>
                                <input id="username" type="username" class="form-control" v-model="user.username">
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
                                <a v-if="user.id" href="#!" class="btn btn-sm btn-success"
                                    @click.prevent="updateUser">Edit</a>
                                <a v-else href="#!" class="btn btn-sm btn-success" @click.prevent="storeUser">Submit</a>
                            </div>
                        </form>
                    </div>
                </div>
            </b-modal>
        </section>
    </div>
</template>

<script>
    import $axios from '../api.js'
    import {
        mapActions,
        mapState,
        mapMutations
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
            ...mapMutations(['SET_ACTIVEEL']),

            activate: function (el) {
                this.SET_ACTIVEEL(el)
            },

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
                    text: "Kamu akan menghapus user " + user.name,
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