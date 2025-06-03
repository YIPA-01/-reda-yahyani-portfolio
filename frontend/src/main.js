import { createApp } from 'vue'
import { createRouter, createWebHistory } from 'vue-router'
import App from './App.vue'
import './style.css'

// Import pages
import Home from './pages/Home.vue'
import About from './pages/About.vue'
import Projects from './pages/Projects.vue'
import Contact from './pages/Contact.vue'

// Router configuration
const router = createRouter({
  history: createWebHistory('/reda-yahyani-portfolio/'), // Match your GitHub repo name
  routes: [
    { path: '/', component: Home, name: 'home' },
    { path: '/about', component: About, name: 'about' },
    { path: '/projects', component: Projects, name: 'projects' },
    { path: '/contact', component: Contact, name: 'contact' }
  ],
  scrollBehavior(to, from, savedPosition) {
    if (savedPosition) {
      return savedPosition
    } else {
      return { top: 0 }
    }
  }
})

// Create and mount the app
const app = createApp(App)
app.use(router)
app.mount('#app') 