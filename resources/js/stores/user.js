import $axios from '../api.js'

const state = () => ({
    authenticated: [],
    engineer: {},
})

const mutations = {
    ASSIGN_USER_AUTH(state, payload) {
        state.authenticated = payload
    },
    GET_ENGINEER(state, payload){
        state.engineer = payload
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
    getEngineer({commit}) {
        return new Promise((resolve, reject) => {
            $axios.get('/engineer')
            .then((response) => {
                commit('GET_ENGINEER', response.data)
                resolve(response.data)
            })
        })
    },
    addEngineer({ commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.post('/engineer', payload)
        })
    },
    changePassword({commit}, payload) {
        return new Promise((resolve, reject) => {
            $axios.put('/user', payload)
            .then((response) => {
                if (response.data.message == 'Your current password does not matches with the password you provided. Please try again.') {
                    commit('SET_ERRORS', { invalid: response.data.message}, { root: true })
                    console.log("err");
                } else if (response.data.status == 'success') {
                    console.log("success");
                    commit('SET_ERRORS', {invalid: "null"}, { root: true })
                }
            })
            .catch((error) => {
                if (error.response.status == 422) {
                    console.log("erq");
                    commit('SET_ERRORS', { invalid: error.response.data.errors.password[0]}, { root: true })
                }
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