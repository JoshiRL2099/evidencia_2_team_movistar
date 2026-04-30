import { createRouter, createWebHistory } from 'vue-router'
import PublicOrderLookupView from '../views/PublicOrderLookupView.vue'

const routes = [
  {
    path: '/',
    name: 'public-order-lookup',
    component: PublicOrderLookupView,
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router