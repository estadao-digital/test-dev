require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';
import Vuex from 'vuex';
import {routes} from "./routes";
import StoreData from "./store";
import MainApp  from './components/MainApp';
import VueSweetalert2 from 'vue-sweetalert2';

Vue.use(VueRouter);
Vue.use(Vuex);
Vue.use(VueSweetalert2);

const store = new Vuex.Store(StoreData);

const router = new VueRouter({
    routes,
    mode: 'history'
});

const app = new Vue({
    el: '#app',
    router,
    store,
    components: {
        MainApp
    }
});
