<template>
    <div class="main-content    ">
        <div class="header bg-gradient-success pb-6">
            <div class="container-fluid">
                <div class="header-body">
                    <div class="row align-items-center py-4">
                        <div class="col-lg-6 col-7">
                            <h6 class="h2 text-white d-inline-block mb-0">Data Teknisi</h6>
                        </div>
                        <!-- <div class="col-lg-6 col-5 text-right">
                            <a href="" class="btn btn-sm btn-success" @click.prevent="formAdd">Add</a>
                        </div> -->
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
    </div>
</template>

<script>
    import { mapActions, mapState } from 'vuex';
    export default {
        computed: {
            ...mapState('user', {
                engineers: state => state.engineer
            })
        },
        methods: {
            ...mapActions('user', ['getEngineer']),

            formAdd() {
                console.log('Ok');
            }
        },
        created() {
            this.getEngineer()
        }
    }
</script>

<style>

</style>