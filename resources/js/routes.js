import AllCar from './components/AllCar.vue';
import CreateCar from './components/CreateCar.vue';
import EditCar from './components/EditCar.vue';

export const routes = [
    {
        name: 'home',
        path: '/',
        component: AllCar
    },
    {
        name: 'create',
        path: '/create',
        component: CreateCar
    },
    {
        name: 'edit',
        path: '/edit/:id',
        component: EditCar
    }
];