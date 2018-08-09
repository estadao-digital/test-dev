const routes=[
    { path:'/', component: Vue.component('home-page') },
    { path:'/novo', component: Vue.component('novo') },
    { path:'/editar/:id','name':'editar',props: true, component: Vue.component('detalhe') },
    { path:'/deletar/:id','name':'deletar',props: true, component: Vue.component('delete') },
]

const myRouter = new VueRouter({routes})