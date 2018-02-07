require('./bootstrap');

window.Vue = require('vue');

Vue.component('carros', require('./components/Carros.vue'))

import VueSweetAlert from 'vue-sweetalert'
Vue.use(VueSweetAlert)

const app = new Vue({
    el: '#app'
});
