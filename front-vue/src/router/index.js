import Vue from 'vue'
import VueRouter from 'vue-router'

import Public from '@/views/public/router/'
import Dashboard from '@/views/dashboard/router/'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    component: () => import('@/views/public/Index.vue'),
    children: [
      ...Public
    ]
  },
  {
    path: '/app',
    name: 'App',
    meta: { requiresAuth: true },
    component: () => import('@/views/dashboard/Index.vue'),
    children: [
      ...Dashboard
    ]
  },
  {
    path: '*',
    name: 'PageNotFound',
    component: () => import('@/views/public/PageNotFound.vue')
  }
]

const router = new VueRouter({
  // mode: 'history',
  base: process.env.BASE_URL,
  // base: process.env.NODE_ENV === 'development' ? process.env.BASE_URL : '//',
  routes
})

export default router
