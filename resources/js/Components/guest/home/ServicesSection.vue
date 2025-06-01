<script setup>
import Card from '@/Components/ui/card/Card.vue'

const services = [
  {
    id: 1,
    title: "Web Development",
    description: "Building modern, responsive web applications with Vue.js and Laravel",
    icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75 22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3-4.5 16.5" />
          </svg>`
  },
  {
    id: 2,
    title: "UI/UX Design",
    description: "Creating intuitive and beautiful user interfaces with modern design principles",
    icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 0 0-5.78 1.128 2.25 2.25 0 0 1-2.4 2.245 4.5 4.5 0 0 0 8.4-2.245c0-.399-.078-.78-.22-1.128Zm0 0a15.998 15.998 0 0 0 3.388-1.62m-5.043-.025a15.994 15.994 0 0 1 1.622-3.395m3.42 3.42a15.995 15.995 0 0 0 4.764-4.648l3.876-5.814a1.151 1.151 0 0 0-1.597-1.597L14.146 6.32a15.996 15.996 0 0 0-4.649 4.763m3.42 3.42a6.776 6.776 0 0 0-3.42-3.42" />
          </svg>`
  },
  {
    id: 3,
    title: "API Development",
    description: "Developing robust and scalable RESTful APIs with Laravel",
    icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6.429 9.75 2.25 12l4.179 2.25m0-4.5 5.571 3 5.571-3m-11.142 0L2.25 7.5 12 2.25l9.75 5.25-4.179 2.25m0 0L21.75 12l-4.179 2.25m0 0 4.179 2.25L12 21.75 2.25 16.5l4.179-2.25m11.142 0-5.571 3-5.571-3" />
          </svg>`
  },
  {
    id: 4,
    title: "Cloud Solutions",
    description: "Deploying and managing applications on cloud platforms",
    icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15a4.5 4.5 0 0 0 4.5 4.5H18a3.75 3.75 0 0 0 1.332-7.257 3 3 0 0 0-3.758-3.848 5.25 5.25 0 0 0-10.233 2.33A4.502 4.502 0 0 0 2.25 15Z" />
          </svg>`
  }
]
</script>

<template>
  <!-- Services Section -->
  <section class="container py-24 relative overflow-hidden">
    <!-- Floating Background Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
      <div 
        v-for="i in 12" 
        :key="i"
        class="absolute w-3 h-3 bg-primary/10 rounded-full"
        :style="{
          top: Math.random() * 100 + '%',
          left: Math.random() * 100 + '%',
          animationDelay: Math.random() * 5 + 's',
          animationDuration: (3 + Math.random() * 3) + 's'
        }"
      />
    </div>
    
    <!-- Gradient Background -->
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-gradient-to-br from-primary/10 to-purple-500/10 rounded-full blur-3xl animate-pulse-slow opacity-50"></div>
    
    <div class="mx-auto max-w-7xl relative">
      <!-- Header -->
      <div class="mx-auto max-w-2xl text-center">
        <div class="inline-flex items-center px-4 py-2 rounded-full bg-primary/10 border border-primary/20 mb-6">
          <div class="w-2 h-2 bg-primary rounded-full animate-pulse mr-2"></div>
          <span class="text-sm font-medium text-primary">What I Offer</span>
        </div>
        
        <h2 class="text-3xl font-bold tracking-tight sm:text-4xl">Services</h2>
        <p class="mt-4 text-lg text-muted-foreground" style="animation-delay: 0.2s;">
          Comprehensive solutions tailored to your needs
        </p>
      </div>
      
      <!-- Services Grid -->
      <div class="mt-16 grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
        <Card 
          v-for="(service, index) in services" 
          :key="service.id"
          class="group relative overflow-hidden hover:border-primary/50 p-8 transition-all duration-500 hover:scale-105 hover:shadow-2xl hover:shadow-primary/20"
          :style="{ animationDelay: (index * 0.1) + 's' }"
        >
          <!-- Background Effects -->
          <div class="absolute inset-0 bg-gradient-to-br from-primary/5 via-transparent to-purple-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
          <div class="absolute -right-12 bottom-0 h-48 w-48 translate-y-1/3 transform rounded-full bg-primary/5 transition-all duration-500 group-hover:translate-y-0 group-hover:bg-primary/10"></div>
          
          <!-- Floating particles on hover -->
          <div class="absolute inset-0 pointer-events-none">
            <div 
              v-for="n in 8" 
              :key="n"
              class="absolute w-1 h-1 bg-primary rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300 animate-float"
              :style="{
                top: Math.random() * 100 + '%',
                left: Math.random() * 100 + '%',
                animationDelay: (n * 0.1) + 's'
              }"
            />
          </div>
          
          <div class="relative z-10">
            <!-- Icon with enhanced animations -->
            <div class="mb-6 inline-block rounded-2xl bg-primary/10 p-4 group-hover:bg-primary/20 transition-all duration-300 group-hover:scale-110 group-hover:rotate-3">
              <div class="h-6 w-6 text-primary transition-transform duration-300 group-hover:scale-110" v-html="service.icon"></div>
              <!-- Glow effect -->
              <div class="absolute inset-0 rounded-2xl bg-primary/20 opacity-0 group-hover:opacity-100 animate-pulse-glow transition-opacity duration-300"></div>
            </div>
            
            <!-- Title with gradient effect -->
            <h3 class="mb-2 text-xl font-semibold group-hover:text-primary transition-colors duration-300">
              {{ service.title }}
            </h3>
            
            <!-- Description -->
            <p class="text-muted-foreground group-hover:text-foreground transition-colors duration-300">
              {{ service.description }}
            </p>
            
            <!-- Hover indicator -->
            <div class="mt-4 flex items-center text-primary opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-y-2 group-hover:translate-y-0">
              <span class="text-sm font-medium">Learn more</span>
              <svg class="ml-2 h-4 w-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
              </svg>
            </div>
          </div>
          
          <!-- Border glow effect -->
          <div class="absolute inset-0 rounded-lg border border-transparent group-hover:border-primary/30 transition-colors duration-300"></div>
        </Card>
      </div>
    </div>
  </section>
</template> 