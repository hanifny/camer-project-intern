import Vue from 'vue'
import store from './store'
import Router from 'vue-router'
import Home from './pages/Home.vue'
import Login from './pages/Login.vue'
import Unit from './pages/Unit.vue'
import CamerListrik from './pages/CamerListrik.vue'
import CamerAir from './pages/CamerAir.vue'
import User from './pages/User.vue'
import Invalid from './pages/Invalid.vue'
import Chat from './pages/Chat.vue'
import Pembayaran from './pages/Pembayaran.vue'

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
            path: '/camer/air',
            name: 'camer.air',
            component: CamerAir,
            meta: { requiresAuth: true }
        },
        {
            path: '/camer/listrik',
            name: 'camer.listrik',
            component: CamerListrik,
            meta: { requiresAuth: true }
        },
        {
            path: '/user',
            name: 'user',
            component: User,
            meta: { requiresAuth: true }
        },
        {
            path: '/invalid',
            name: 'invalid',
            component: Invalid,
            meta: { requiresAuth: true }
        },
        {
            path: '/chat',
            name: 'chat',
            component: Chat,
            meta: { requiresAuth: true }
        },
        {
            path: '/pembayaran',
            name: 'pembayaran',
            component: Pembayaran,
            meta: { requiresAuth: true }
        },
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