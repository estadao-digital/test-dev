const routes=[
    { path:'/', component: Vue.component('home-page') },
    { path:'/editar/:id','name':'editar',props: true, component: Vue.component('detalhe') }
]

const myRouter = new VueRouter({routes})