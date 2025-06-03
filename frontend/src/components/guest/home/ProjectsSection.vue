<script setup>
import { ref, computed } from 'vue'
import Card from '@/components/ui/card/Card.vue'

const props = defineProps({
  projects: {
    type: Array,
    default: () => []
  }
})
</script>

<template>
  <!-- Projects Section -->
  <section class="container py-24 relative overflow-hidden" id="projects">
    <!-- Floating Background Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
      <div 
        v-for="i in 8" 
        :key="i"
        class="absolute w-2 h-2 bg-primary/20 rounded-full animate-float"
        :style="{
          top: Math.random() * 100 + '%',
          left: Math.random() * 100 + '%',
          animationDelay: Math.random() * 4 + 's',
          animationDuration: (3 + Math.random() * 2) + 's'
        }"
      />
    </div>
    
    <div class="mx-auto max-w-7xl relative">
      <!-- Header -->
      <div class="mx-auto max-w-2xl text-center mb-16">
        <div class="inline-flex items-center px-4 py-2 rounded-full bg-primary/10 border border-primary/20 mb-6">
          <div class="w-2 h-2 bg-primary rounded-full animate-pulse mr-2"></div>
          <span class="text-sm font-medium text-primary">Portfolio</span>
        </div>
        
        <h2 class="text-4xl font-bold tracking-tight sm:text-5xl mb-6">
          <span>Recent Projects</span>
        </h2>
        <p class="text-lg text-muted-foreground">
          Showcasing my latest work and technical achievements
        </p>
      </div>
      
      <!-- Projects Grid -->
      <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
        <Card 
          v-for="(project, index) in props.projects.slice(0, 6)" 
          :key="project.id"
          class="group overflow-hidden hover:shadow-2xl transition-all duration-500"
          :style="{ animationDelay: (index * 0.2) + 's' }"
        >
          <!-- Project Image -->
          <div class="relative h-48 overflow-hidden">
            <img 
              :src="project.image_url || '/api/placeholder/400/250'" 
              :alt="project.title"
              class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
              @error="$event.target.src = '/api/placeholder/400/250'"
            />
            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
          </div>
          
          <div class="p-6">
            <h3 class="text-2xl font-semibold mb-2">{{ project.title }}</h3>
            <p class="text-muted-foreground mb-4">{{ project.description }}</p>
            
            <div class="flex flex-wrap gap-2 mb-4">
              <span 
                v-for="tech in project.technologies" 
                :key="tech"
                class="inline-flex items-center rounded-full bg-primary/10 px-3 py-1 text-sm text-primary"
              >
                {{ tech }}
              </span>
            </div>
            
            <div class="flex gap-2">
              <a 
                v-if="project.demo_url" 
                :href="project.demo_url" 
                target="_blank"
                class="flex-1 bg-primary text-primary-foreground hover:bg-primary/90 h-9 rounded-md px-3 inline-flex items-center justify-center text-sm font-medium transition-colors"
              >
                Live Demo
              </a>
              <a 
                v-if="project.github_url" 
                :href="project.github_url" 
                target="_blank"
                class="flex-1 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 rounded-md px-3 inline-flex items-center justify-center text-sm font-medium transition-colors"
              >
                View Code
              </a>
            </div>
          </div>
        </Card>
      </div>
      
      <!-- View All Button -->
      <!-- <div class="mt-12 text-center" style="animation-delay: 0.6s;">
        <Link :href="route('guest.projects.index')">
          <Button variant="outline" size="lg" class="h-12 px-8 group hover:border-primary/50 transition-all duration-300 hover:scale-105">
            <span class="group-hover:translate-x-1 transition-transform duration-300">View All Projects</span>
            <svg class="ml-2 h-4 w-4 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
          </Button>
        </Link>
      </div> -->
    </div>
  </section>
</template> 