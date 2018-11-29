import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'

import axios from 'axios'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import 'material-design-icons-iconfont/dist/material-design-icons.css'

import ptBR from 'vee-validate/dist/locale/pt_BR';
import VeeValidate, { Validator } from 'vee-validate';

Validator.localize('pt_BR', ptBR);
Vue.use(VeeValidate);

Vue.use(Vuetify, {
    theme: {
        primary: '#d77b1c',
        secondary: '#b45f1c',
        accent: '#ee8e1d',
        error: '#b71c1c'
    }
});

Vue.use(axios)
axios.defaults.baseURL = 'http://127.0.0.1:9000/api'

Vue.config.productionTip = false

new Vue({
    router,
    store,
    render: h => h(App)
}).$mount('#app')
