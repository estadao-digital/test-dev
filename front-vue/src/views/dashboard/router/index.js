export default [

  {
    path: '',
    name: 'Home',
    component: () => import('@/views/dashboard/Home.vue')
  },
  {
    path: 'car',
    name: 'Car',
    component: () => import('@/views/dashboard/Car.vue')
  },
  {
    path: 'car/new',
    name: 'CarForm',
    component: () => import('@/views/dashboard/CarForm.vue')
  },
  {
    path: 'car/form/:id',
    name: 'CarFormEdit',
    component: () => import('@/views/dashboard/CarForm.vue')
  }

]
