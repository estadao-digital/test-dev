
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';
import BootstrapVue from 'bootstrap-vue';
import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap-vue/dist/bootstrap-vue.css";
import { library } from '@fortawesome/fontawesome-svg-core';
import { fas } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import App from './components/App';
import Home from './views/Home';
import Cars from './views/Cars';
import NewCar from './views/NewCar';

library.add(fas);

Vue.component('font-awesome-icon', FontAwesomeIcon);

window.Vue = require('vue');

Vue.use(VueRouter);
Vue.use(BootstrapVue);

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/carros',
            name: 'cars',
            component: Cars,
        },
        {
            path: '/novo-carro',
            name: 'new-car',
            component: NewCar,
        },
    ],
});

const app = new Vue({
    el: '#app',
    components: { App },
    router,
});
