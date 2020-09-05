import Vue from 'vue'
import store from './store'
import Router from 'vue-router'
import Home from './pages/Home.vue'
import Login from './pages/Login.vue'
import Unit from './pages/Unit.vue'
import Camer from './pages/Camer.vue'

Vue.use(Router)

// Define route
const router = new Router({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home,
            meta: { requiresAuth: true }
        },
        {
            path: '/login',
            name: 'login',
            component: Login
        },
        {
            path: '/unit',
            name: 'unit',
            component: Unit,
            meta: { requiresAuth: true }
        },
        {
            path: '/camer',
            name: 'camer',
            component: Camer,
            meta: { requiresAuth: true }
        }
    ]
})

// Navigation Guards
router.beforeEach((to, from, next) => {
    store.commit('CLEAR_ERRORS')
    if(to.matched.some(record => record.meta.requiresAuth)) {
        let auth = store.getters.isAuth
        if(!auth) {
            next({ name: 'login' })
        } else {
            next()
        }
    } else {
        next()
    }
})

export default router