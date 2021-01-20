import Vue from 'vue'
import Router from 'vue-router'
import Home from '@/pages/home/Home'
import Cadastra from '@/pages/home/cadastraVeiculo'
import Listar from '@/pages/home/listarVeiculos'
import Atualiza from '@/pages/home/atualizaVeiculo'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'Home',
      component: Home 
    },
    {
      path: '/cadastraVeiculo',
      name: 'Cadastra',
      component: Cadastra 
    },

    {
      path: '/listarVeiculos',
      name: 'Listar',
      component: Listar
    },
    {
      path: '/atualizaVeiculo/:id',
      name: 'atualiza',
      component: Atualiza
    }  
  ]
})
