<template>
    <div class="container mt-5 mb-5">
        <div class="row d-flex pt-4 justify-content-center">
            <div class="col-md-4 rounded p-4 col-md-offset-2 bg-white d-flex justify-content-center">
                <button class="btn btn-lg btn-success" @click="bayar">
                    <h1>
                        <i class="fas fa-7x fa-credit-card"></i>
                        BAYAR TAGIHAN BULAN INI
                    </h1>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    import $axios from '../api'
    export default {
        methods: {
            bayar() {
                swal.fire({
                    title: 'Apakah kamu yakin?',
                    text: "Kamu akan melakukan pembayaran di bulan ini.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#f5365c',
                    cancelButtonText: 'Tidak',
                    confirmButtonText: 'Ya'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $axios.post('/payment/store')
                            .then(function (response) {
                                // handle success
                                console.log(response);
                                swal.fire(
                                    'Berhasil!',
                                    'Bayar melalui BCA dengan virtual account : ' + response.data.data.va_numbers[0].va_number,
                                    'success'
                                )
                            })
                            .catch(function (error) {
                                // handle error
                                console.log(error);
                                swal.fire(
                                    'Gagal!',
                                    'Maaf, coba hubungi web developer.',
                                    'failed'
                                )
                            })
                    }
                })
            }
        }
    }
</script>