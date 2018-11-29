import Vue from 'vue'
import Router from 'vue-router'
import Carros from './views/Carros.vue'

Vue.use(Router)

export default new Router({
    mode: 'history',
    base: process.env.BASE_URL,
    routes: [
        {
            path: '/',
            name: 'carros',
            component: Carros
        }
    ]
})
