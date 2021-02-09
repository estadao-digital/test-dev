export default [
  {
    path: '',
    name: 'Home',
    component: () => import('@/views/public/Home.vue')
  },
  {
    path: 'termos-uso',
    name: 'Termos',
    component: () => import('@/views/public/Termos.vue')
  },
  {
    path: 'politica-privacidade',
    name: 'Politica',
    component: () => import('@/views/public/Politica.vue')
  }
]
