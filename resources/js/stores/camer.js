import $axios from '../api.js'

const state = () => ({
    camer: {},
    count: {},
    camer_invalid: {} 
})

const mutations = {
    GET_CAMER(state, payload) {
        state.camer = payload
    },
    GET_COUNT(state, payload) {
        state.count = payload
    },
    GET_CAMER_INVALID(state, payload) {
        state.camer_invalid = payload
    },
}

const actions = {
        
    // CAMER
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
    getCamer({ commit }, payload) {
        setTimeout(function() {
            return new Promise((resolve, reject) => {
                $axios.get('/camer/' + payload.tipe + '/' + payload.bulan + '/' + payload.tower + '?page=' + payload.page) 
                .then((response) => {
                    commit('GET_CAMER', response.data)
                    resolve(response.data)
                })
            })
        }, 155)
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
            $axios.get('/camer/' + payload.type + '/' + payload.bulan + '?page=' + payload.page) 
            .then((response) => {
                commit('GET_CAMER', response.data)
                resolve(response.data)
            })
        })
    },
    validation({ commit, dispatch }, payload) {
        return new Promise((resolve, reject) => {
            $axios.patch('/camer', payload)
        })
    },
    getCount({commit}) {
        setTimeout(function() {
            return new Promise((resolve, reject) => {
                $axios.get('/count')
                .then((response) => {
                    commit('GET_COUNT', response.data)
                    resolve(response.data)
                })
            })
        }, 155)
    },
    addCamer({commit, dispatch}, payload) {
        return new Promise((resolve, reject) => {
            $axios.post('/camer', 
                payload,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }
            )
            .then((response) => {
                if(response.data.status == "data already added" || response.data.status == "failed") {
                    swal.fire(
                        'Gagal!',
                        'Mohon diperhatikan data yang diinput',
                        'error'
                    );    
                } else {
                    swal.fire(
                        'Berhasil!',
                        'Camer baru berhasil ditambah!',
                        'success'
                    );
                }
            })
        });
    }
    // ./camer
}

export default {
    namespaced: true,
    state,
    actions,
    mutations
}