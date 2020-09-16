import $axios from '../api.js'

const state = () => ({
    authenticated: [],
    engineer: {}
})

const mutations = {
    ASSIGN_USER_AUTH(state, payload) {
        state.authenticated = payload
    },
    GET_ENGINEER(state, payload){
        state.engineer = payload
    }
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
    }
}

export default {
    namespaced: true,
    state,
    actions,
    mutations
}