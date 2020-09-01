import axios from 'axios';

const $axios = axios.create({
    baseURL: '/api',
    headers: {
        // Authorization: localStorage.getItem('token') != 'null' ? 'Bearer ' + localStorage.getItem('token'):'',
        'Content-Type': 'application/json'
    }
});

$axios.interceptors.request.use (
    function (config) {
        const token = localStorage.getItem('token')
        if (token) config.headers.Authorization = `Bearer ${token}`;
        return config;
    },
    function (error) {
        return Promise.reject (error);
    }
);

export default $axios;