import $axios from '../api.js'

const state = () => ({
    authenticated: [],
    user: {},
})

const mutations = {
    ASSIGN_USER_AUTH(state, payload) {
        state.authenticated = payload
    },
    GET_USER(state, payload){
        state.user = payload
    }, 
}

const actions = {
    getUserLogin({ commit }) {
        return new Promise((resolve, reject) => {
            $axios.post('/me')
            .then((response) => {
                commit('ASSIGN_USER_AUTH', response.data)
                resolve(response.data)
            })
        })
    },
    getUser({commit}) {
        return new Promise((resolve, reject) => {
            $axios.get('/user')
            .then((response) => {
                commit('GET_USER', response.data)
                resolve(response.data)
            })
        })
    },
    addUser({ commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.post('/user', payload)
            .then((response) => {
                console.log(response.data);
                    swal.fire(
                        'Berhasil!',
                        'Kamu telah menambah user ' + response.data.nama,
                        'success'
                    )
            })
            .catch((error) => {
                console.log(error.response);
                swal.fire(
                    'Failed!',
                    error.response.data.message,
                    'error'
                )
            })
        })
    },
    editUser({commit}, payload) {
        return new Promise((resolve, reject) => {
            $axios.put('/user', payload)
            .then((response) => {
                console.log(response.data);
                    swal.fire(
                        'Berhasil!',
                        'Kamu telah mengedit user.',
                        'success'
                    )
            })
            .catch((error) => {
                console.log(error.response);
                swal.fire(
                    'Failed!',
                    error.response.data.message,
                    'error'
                )
            })
        })
    },
    removeUser({commit}, payload) {
        return new Promise((resolve, reject) => {
            $axios.delete('/user/' + payload.id)
            .then((response) => {
                swal.fire(
                    'Berhasil!',
                    'Kamu telah menghapus user ' + response.data.nama,
                    'success'
                )
            })
            .catch((error) => {
                console.log(error.response);
                swal.fire(
                    'Failed!',
                    error.response.data.message,
                    'error'
                )
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