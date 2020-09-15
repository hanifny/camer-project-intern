import $axios from '../api.js'

const state = () => ({
    authenticated: []
})

const mutations = {
    ASSIGN_USER_AUTH(state, payload) {
        state.authenticated = payload
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
    }
}

export default {
    namespaced: true,
    state,
    actions,
    mutations
}