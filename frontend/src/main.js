// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import { sync } from 'vuex-router-sync'

import Vue from 'vue'
import Vuex from 'vuex'
import VueResource from 'vue-resource'
import VueRouter from 'vue-router'
import BootstrapVue from 'bootstrap-vue'
import VeeValidate, { Validator } from 'vee-validate'
import messagesBr from './language/pt_br.js';

import App from './App'
import routes from './router'
import VuexStore from './vuex/store'

Vue.use(Vuex)
Vue.use(VueResource)
Vue.use(VueRouter)
Vue.use(BootstrapVue)
Vue.use(VeeValidate)

const dictionary = {
    pt_br: {
        messages: messagesBr
    }
}
  
// Override and merge the dictionaries
Validator.localize('pt_br', dictionary.pt_br);

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

Vue.http.options.root = process.env.SERVER

const store = new Vuex.Store(VuexStore)
const router = new VueRouter({
  routes
})

sync(store, router)

Vue.config.productionTip = false

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  store,
  components: { App },
  template: '<App/>'
})
