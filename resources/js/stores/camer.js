import $axios from '../api.js'
import { reject } from 'lodash'

const state = () => ({
    unit: {},
    type: {},
    camer: {},
    count: {},
    camer_invalid: {} 
})

const mutations = {
    GET_ALL_UNIT(state, payload) {
        state.unit = payload
    },
    GET_UNIT_PER_FLOOR(state, payload) {
        state.unit = payload
    },
    GET_CAMER(state, payload) {
        state.camer = payload
    },
    GET_TYPE(state, payload) {
        state.type = payload
    },
    GET_COUNT(state, payload) {
        state.count = payload
    },
    GET_CAMER_INVALID(state, payload) {
        state.camer_invalid = payload
    },
}

const actions = {
    getUnitPerTower({commit}, payload) {
        return new Promise((resolve, reject) => {
            $axios.get('/unit/tower/' + payload.tower + '?page=' + payload.page)
            .then((response) => {
                commit('GET_ALL_UNIT', response.data)
                resolve(response.data)
            })
        })
    },
    exportToExcel({ commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios({
                url: 'camer/export', //your url
                method: 'GET',
                responseType: 'blob', // important
              }).then((response) => {
                 const url = window.URL.createObjectURL(new Blob([response.data]));
                 const link = document.createElement('a');
                 link.href = url;
                 link.setAttribute('download', 'Camer.xlsx'); //or any other extension
                 document.body.appendChild(link);
                 link.click();
              });
        })
    },
    destroyUnit({ commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.delete('/unit/' + payload)
            .then((response) => {
                swal.fire(
                    'Berhasil!',
                    'Kamu telah menghapus unit ini.',
                    'success'
                )
            })
            .catch((error) => {
                console.log(error.response);
                swal.fire(
                    'Gagal!',
                    'Maaf, unit ini tidak dapat dihapus.',
                    'error'
                )
            })
        })
    },
    storeNewUnit({commit}, payload) {
        return new Promise((resolve, reject) => {
            $axios.post('/unit', payload)
            .then((response) => {
                console.log(response.data);
                    swal.fire(
                        'Berhasil!',
                        'Kamu telah menambah unit.',
                        'success'
                    )
            })
            .catch((error) => {
                console.log(error.response);
                swal.fire(
                    'Gagal!',
                    'Maaf, tidak dapat menambahkan unit ini.',
                    'error'
                )
            })
        })
    },
    editUnit({commit}, payload) {
        return new Promise((resolve, reject) => {
            $axios.put('/unit', payload)
            .then((response) => {
                swal.fire(
                    'Berhasil!',
                    'Kamu telah mengedit unit ini.',
                    'success'
                )
            })
        })
    },
    getAllUnit({ commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.get('/unit?page='+payload)
            .then((response) => {
                commit('GET_ALL_UNIT', response.data)
                resolve(response.data)
            })
        })
    },
    getUnitPerFloor({ commit }, payload ) {
        return new Promise((resolve, reject) => {
            $axios.get('/floor/' + payload.floor + '?page=' + payload.page)
            .then((response) => {
                commit('GET_UNIT_PER_FLOOR', response.data)
                resolve(response.data)
            })
        })
    },
    getType({commit}) {
        return new Promise((resolve, reject) => {
            $axios.get('/type/')
            .then((response) => {
                commit('GET_TYPE', response.data)
                resolve(response.data)
            })
        })
    },
    getCamer({ commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.get('/camer?page=' + payload)
            .then((response) => {
                commit('GET_CAMER', response.data)
                resolve(response.data)
            })
        })
    },
    getCamerInvalid({ commit }) {
        return new Promise((resolve, reject) => {
            $axios.get('/invalid')
            .then((response) => {
                commit('GET_CAMER_INVALID', response.data)
                resolve(response.data)
            })
        })
    },
    getCamerPerMonth({ commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.get('/camer/' + payload.bulan + '?page=' + payload.page) 
            .then((response) => {
                commit('GET_CAMER', response.data)
                resolve(response.data)
            })
        })
    },
    getCamerPerTower({ commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.get('/camer/' + payload.bulan + '/' + payload.tower + '?page=' + payload.page) 
            .then((response) => {
                commit('GET_CAMER', response.data)
                resolve(response.data)
            })
        })
    },
    validation({ commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.patch('/camer', payload)
            .then((response) => {
                resolve(response.data)
            })
        })
    },
    validation_per_month({commit}, payload) {
        return new Promise((resolve, reject) => {
            $axios.patch('/camer_per_month', payload)
            .then((response) => {
                resolve(response.data)
                swal.fire(
                    'Berhasil!',
                    'Kamu telah melakukan validasi.',
                    'success'
                )
            })
            .catch((error) => {
                swal.fire(
                    'Gagal!',
                    'Maaf, data sudah tervalidasi.',
                    'error'
                )
            })
        })
    },
    getCount({commit}) {
        return new Promise((resolve, reject) => {
            $axios.get('/count')
            .then((response) => {
                commit('GET_COUNT', response.data)
                resolve(response.data)
            })
        })
    }
}

export default {
    namespaced: true,
    state,
    actions,
    mutations
}