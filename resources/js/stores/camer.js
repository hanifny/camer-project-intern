import $axios from '../api.js'
import { reject } from 'lodash'

const state = () => ({
    unit: {},
    type: {},
    camer: {},
    count: {}
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
    }
}

const actions = {
    destroyUnit({ commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.delete('/unit/' + payload)
        })
    },
    storeNewUnit({commit}, payload) {
        return new Promise((resolve, reject) => {
            $axios.post('/unit', payload)
        })
    },
    editUnit({commit}, payload) {
        return new Promise((resolve, reject) => {
            $axios.put('/unit', payload)
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
            $axios.get('/floor/' + payload)
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
    getCamer({ commit }) {
        return new Promise((resolve, reject) => {
            $axios.get('/camer')
            .then((response) => {
                commit('GET_CAMER', response.data)
                resolve(response.data)
            })
        })
    },
    getCamerPerMonth({ commit }, payload) {
        return new Promise((resolve, reject) => {
            $axios.get('/camer/' + payload) 
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