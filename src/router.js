import Vue from 'vue'
import Router from 'vue-router'
import Listagem from './components/carros/listagem.vue'
import Editar from './components/carros/editar.vue'
import Adicionar from './components/carros/adicionar.vue'
import Deletar from './components/carros/deletar.vue'

Vue.use(Router)

export default new Router({
  routes:[
    {
      path: '/',
      name: 'listagem',
      component: Listagem
    },
    {
      path: '/adicionar',
      name: 'adicionar',
      component: Adicionar
    },
    {
      path: '/editar/:id',
      name: 'editar',
      component: Editar
    },
    {
      path: '/deletar/:id',
      name: 'deletar',
      component: Deletar
    }
  ]
})