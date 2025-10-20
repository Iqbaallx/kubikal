import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  {
    path: '/',
    name: 'home',
    component: () => import('../Pages/Home.vue') // sesuaikan dengan component kamu
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router