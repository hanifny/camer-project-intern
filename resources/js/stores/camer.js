import $axios from '../api.js'
import { reject } from 'lodash'

const state = () => ({
    unit: {},
    camer: {},
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
            $axios.patch('camer_per_month', payload)
            .then((response) => {
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