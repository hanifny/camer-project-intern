<template>
    <div class="main-content">

        <div class="header bg-gradient-success pb-6">
            <div class="container-fluid">
                <div class="header-body">
                    <div class="row align-items-center py-4">
                        <div class="col-lg-6 col-7">
                            <h6 class="h2 text-white d-inline-block mb-0">Rekap Data Camer</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid mt--6">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col" class="sort" data-sort="number">No</th>
                                        <th scope="col" class="sort" data-sort="idpelanggan">Id Pelanggan</th>
                                        <th scope="col" class="sort" data-sort="napel">Nama Pelanggan</th>
                                        <th scope="col" class="sort" data-sort="statpel">Status Pelanggan</th>
                                        <th scope="col" class="sort" data-sort="terakhirtglval">Terakhir Tgl Validasi</th>
                                        <th scope="col" class="sort" data-sort="aksi">Aksi</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody class="list">
                                    <tr>
                                        <th scope="row">
                                            <div class="media align-items-center">
                                                <div class="media-body">
                                                    <span class="number mb-0 text-sm">1</span>
                                                </div>
                                            </div>
                                        </th>
                                        <td class="idpel">222233</td>
                                        <td class="napel">Suparman</td>
                                        <td class="statpel">Aktif</td>
                                        <td class="terakhirtglval">28-10-2020</td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-warning">Detail</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">
                                            <div class="media align-items-center">
                                                <div class="media-body">
                                                    <span class="number mb-0 text-sm">2</span>
                                                </div>
                                            </div>
                                        </th>
                                        <td class="idpel">222244</td>
                                        <td class="napel">Eman</td>
                                        <td class="statpel">Aktif</td>
                                        <td class="terakhirtglval">28-10-2020</td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-warning">Detail</a>
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
    </div>
</template>

<script>
    export default {

    }
</script>

<style>

</style>