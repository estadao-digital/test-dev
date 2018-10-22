import List from '@/components/List'
import Create from '@/components/Create'
import Edit from '@/components/Edit'

const routes = [
    {
        path: '/',
        name: 'ListarCarros',
        component: List
    },
    { 
        path: '/carro/novo',
        name: 'NovoCarro', 
        component: Create 
    },
    { 
        path: '/carro/:id/editar',
        name: 'EditarCarro', 
        component: Edit 
    }
]

export default routes
