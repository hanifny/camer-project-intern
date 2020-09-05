import $axios from '../api.js'
import { reject } from 'lodash'

const state = () => ({
    unit: {}
})

const mutations = {
    GET_ALL_UNIT(state, payload) {
        state.unit = payload
    },
    GET_UNIT_PER_FLOOR(state, payload) {
        state.unit = payload
    }
}

const actions = {
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
            $axios.get('/floor/'+payload)
            .then((response) => {
                commit('GET_UNIT_PER_FLOOR', response.data)
                resolve(response.data)
            })
        })
    },
    getCamer({ commit }) {
        return new Promise((resolve, reject) => {
            $axios.get('/camer')
            .then((response) => {
                resolve(response)
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