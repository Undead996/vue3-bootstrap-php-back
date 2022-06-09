import { createRouter, createWebHistory } from 'vue-router'
import Home from '../views/Home.vue'
import Unexpected from '../views/Unexpected.vue'
import Test from '../views/Test.vue'

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/va',
    name: 'VA',
    component: () => import('../views/VA/VA.vue'),
    children: [
      {
        path: '/va/new',
        component: () => import('../views/VA/NewVa.vue'),
      },
      {
        path: '/va/list',
        component: () => import('../views/VA/ListVa.vue'),
      },
      {
        path: '/va/code/:code?',
        name : 'CodeVA',
        component: () => import('../views/VA/CodeVa.vue'),
      },
    ],
  },
  {
    path: '/safety',
    name: 'Safety',
    component: () => import('../views/Safety/Safety.vue'),
    children: [
      {
        path: '/safety/pass',
        component: () => import('../views/Safety/Password.vue'),
      },
      {
        path: '/safety/pay_pass',
        component: () => import('../views/Safety/PayPassword.vue'),
      },
      {
        path: '/safety/antiphishing',
        component: () => import('../views/Safety/Antiphishing.vue'),
      },
      {
        path: '/safety/magic',
        component: () => import('../views/Safety/Magic.vue'),
      },
      {
        path: '/safety/secret_question',
        component: () => import('../views/Safety/SecretQuestion.vue'),
      },
      {
        path: '/safety/ip',
        component: () => import('../views/Safety/IP.vue'),
      },
      {
        path: '/safety/onekey',
        component: () => import('../views/Safety/Onekey.vue'),
      },
    ],
  },
  {
    path: '/history',
    name: 'History',
    component: () => import('../views/History.vue'),
  },
  {
    path: '/pay',
    name: 'Pay',
    component: () => import('../views/Pay.vue'),
  },
  {
    path: '/keyts',
    name: 'Keyts',
    component: () => import('../views/Keyts.vue'),
  },
  {
    path: '/test',
    name: 'Test',
    component: Test,
  },
  
  { path: '/:pathMatch(.*)*',
    component: Unexpected 
  },
]

const router = createRouter({
  mode: 'history',
  history: createWebHistory(),
  routes
})

// router.beforeEach((to, from, next) => {
//   if (to.name != 'Login') {
//     if (store.getters.get_isLogged == false) next({ name: 'Login' })
//     else next()
//   } else {
//     next();
//   }
// })

export default router
