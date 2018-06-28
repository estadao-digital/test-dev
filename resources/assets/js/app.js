require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router';

window.Vue.use(VueRouter);

import Carro from './components/CarroComponent.vue';
import CriaCarro from './components/CriaCarroComponent.vue';
import EditaCarro from './components/EditaCarroComponent.vue';

const routes = [
    {
        path: '/',
        components: {
            carro: Carro
        }
    },
    {path: '/create', component: CriaCarro, name: 'criaCarro'},
    {path: '/edit/:id', component: EditaCarro, name: 'editaCarro'},
]

const router = new VueRouter({ routes })

const app = new Vue({ router }).$mount('#app')