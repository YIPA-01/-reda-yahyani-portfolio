<template>
  <div id="app" class="min-h-screen bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
      <div class="container-custom">
        <div class="flex justify-between items-center py-4">
          <!-- Logo -->
          <router-link to="/" class="text-xl font-bold text-gray-900">
            Reda Yahyani
          </router-link>

          <!-- Desktop Navigation -->
          <div class="hidden md:flex space-x-8">
            <router-link 
              to="/" 
              class="text-gray-600 hover:text-gray-900 transition-colors"
              :class="{ 'text-blue-600 font-medium': $route.name === 'home' }"
            >
              Home
            </router-link>
            <router-link 
              to="/about" 
              class="text-gray-600 hover:text-gray-900 transition-colors"
              :class="{ 'text-blue-600 font-medium': $route.name === 'about' }"
            >
              About
            </router-link>
            <router-link 
              to="/projects" 
              class="text-gray-600 hover:text-gray-900 transition-colors"
              :class="{ 'text-blue-600 font-medium': $route.name === 'projects' }"
            >
              Projects
            </router-link>
            <router-link 
              to="/contact" 
              class="text-gray-600 hover:text-gray-900 transition-colors"
              :class="{ 'text-blue-600 font-medium': $route.name === 'contact' }"
            >
              Contact
            </router-link>
          </div>

          <!-- Mobile menu button -->
          <button 
            @click="mobileMenuOpen = !mobileMenuOpen"
            class="md:hidden p-2 rounded-md text-gray-600 hover:text-gray-900"
          >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
          </button>
        </div>

        <!-- Mobile Navigation -->
        <div v-show="mobileMenuOpen" class="md:hidden pb-4">
          <div class="flex flex-col space-y-2">
            <router-link 
              to="/" 
              @click="mobileMenuOpen = false"
              class="block px-3 py-2 text-gray-600 hover:text-gray-900 transition-colors"
              :class="{ 'text-blue-600 font-medium': $route.name === 'home' }"
            >
              Home
            </router-link>
            <router-link 
              to="/about" 
              @click="mobileMenuOpen = false"
              class="block px-3 py-2 text-gray-600 hover:text-gray-900 transition-colors"
              :class="{ 'text-blue-600 font-medium': $route.name === 'about' }"
            >
              About
            </router-link>
            <router-link 
              to="/projects" 
              @click="mobileMenuOpen = false"
              class="block px-3 py-2 text-gray-600 hover:text-gray-900 transition-colors"
              :class="{ 'text-blue-600 font-medium': $route.name === 'projects' }"
            >
              Projects
            </router-link>
            <router-link 
              to="/contact" 
              @click="mobileMenuOpen = false"
              class="block px-3 py-2 text-gray-600 hover:text-gray-900 transition-colors"
              :class="{ 'text-blue-600 font-medium': $route.name === 'contact' }"
            >
              Contact
            </router-link>
          </div>
        </div>
      </div>
    </nav>

    <!-- Main content -->
    <main>
      <router-view />
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12 mt-20">
      <div class="container-custom">
        <div class="text-center">
          <p class="text-gray-400">
            © 2024 Reda Yahyani. All rights reserved.
          </p>
          <div class="mt-4 flex justify-center space-x-6">
            <a href="#" class="text-gray-400 hover:text-white transition-colors">
              GitHub
            </a>
            <a href="#" class="text-gray-400 hover:text-white transition-colors">
              LinkedIn
            </a>
            <a href="#" class="text-gray-400 hover:text-white transition-colors">
              Twitter
            </a>
          </div>
        </div>
      </div>
    </footer>
  </div>
</template>

<script>
import { ref } from 'vue'

export default {
  name: 'App',
  setup() {
    const mobileMenuOpen = ref(false)

    return {
      mobileMenuOpen
    }
  }
}
</script> 