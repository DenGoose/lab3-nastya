import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  {
    path: '/loans/',
    name: 'Loans',
    component: () => import('@/views/LoansPage')
  },
  {
    path: '/loans/filtered/:filter_field?:filter_id?',
    name: 'LoansFiltered',
    props: (route) => {
      return {
        filter_field: route.params.filter_field,
        filter_id: route.params.filter_id,
      }
    },
    component: () => import('@/views/LoansPage')
  },
  {
    path: '/clients',
    name: 'Clients',
    component: () => import('@/views/ClientsPage'),
  },
  {
    path: '/clients-edit/:id?',
    name: 'ClientsEdit',
    props: (route) => {
      return {
        id: route.params.id,
      }
    },
    component: () => import('@/views/ClientsEdit'),
  },
  {
    path: '/loans-edit/:id?',
    name: 'LoansEdit',
    props: (route) => {
      return {
        id: route.params.id,
      }
    },
    component: () => import('@/views/LoansEdit'),
  },
  {
    path: '/:catchAll(.*)',
    name: 'NotFound',
    component: () => import('@/views/ClientsPage'),
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router
