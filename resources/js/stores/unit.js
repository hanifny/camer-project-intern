import $axios from '../api.js'

const state = () => ({
    unit: {},
})

const mutations = {
    GET_ALL_UNIT(state, payload) {
        state.unit = payload
    },
    GET_UNIT_PER_FLOOR(state, payload) {
        state.unit = payload
    },
}

const actions = {
    // UNIT
    getUnitPerTower({commit}, payload) {
        return new Promise((resolve, reject) => {
            $axios.get('/unit/tower/' + payload.tower + '?page=' + payload.page)
            .then((response) => {
                commit('GET_ALL_UNIT', response.data)
                resolve(response.data)
            })
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
                swal.fire(
                    'Gagal!',
                    'Maaf, unit ini tidak dapat dihapus.',
                    'error'
                )
            })
        })
    },
    storeNewUnit({commit, dispatch}, payload) {
        return new Promise((resolve, reject) => {
            $axios.post('/unit', payload)
            .then((response) => {
                dispatch('getAllUnit', 1).then(() => {
                    resolve(response.data)
                })
                swal.fire(
                    'Berhasil!',
                    'Kamu telah menambah unit.',
                    'success'
                )
            })
            .catch((error) => {
                swal.fire(
                    'Gagal!',
                    'Maaf, tidak dapat menambahkan unit ini.',
                    'error'
                )
            })
        })
    },
    editUnit({commit, dispatch}, payload) {
        return new Promise((resolve, reject) => {
            $axios.put('/unit', payload)
            .then((response) => {
                dispatch('getAllUnit', 1).then(() => {
                    resolve(response.data)
                })
                swal.fire(
                    'Berhasil!',
                    'Kamu telah mengedit unit ini.',
                    'success'
                )
            })
            .catch((error) => {
                swal.fire(
                    'Gagal!',
                    'Maaf, unit ini tidak dapat diedit.',
                    'error'
                )
            })
        })
    },
    getAllUnit({ commit }, payload) {
        setTimeout(function() {
            return new Promise((resolve, reject) => {
                $axios.get('/unit?page='+payload)
                .then((response) => {
                    commit('GET_ALL_UNIT', response.data)
                    resolve(response.data)
                })
            })
        }, 155)
    },
    getUnitPerFloor({ commit }, payload ) {
        return new Promise((resolve, reject) => {
            $axios.get('/unit/' + payload.floor + '?page=' + payload.page)
            .then((response) => {
                commit('GET_UNIT_PER_FLOOR', response.data)
                resolve(response.data)
            })
        })
    },
    // ./unit
}

export default {
    namespaced: true,
    state,
    actions,
    mutations
}