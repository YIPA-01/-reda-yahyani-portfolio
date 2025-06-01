<script setup>
import { Link } from '@inertiajs/vue3'
import { Button } from '@/components'
import Card from '@/Components/ui/card/Card.vue'
import ProjectImageCarousel from '@/Components/ProjectImageCarousel.vue'

const props = defineProps({
  projects: {
    type: Object,
    required: true
  }
})
</script>

<template>
  <!-- Projects Section -->
  <section class="container py-24 relative overflow-hidden">
    <!-- Floating Background Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
      <div 
        v-for="i in 10" 
        :key="i"
        class="absolute w-2 h-2 bg-primary/15 rounded-full animate-float-gentle"
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
      <div class="mx-auto max-w-2xl text-center">
        <div class="inline-flex items-center px-4 py-2 rounded-full bg-primary/10 border border-primary/20 mb-6">
          <div class="w-2 h-2 bg-primary rounded-full animate-pulse mr-2"></div>
          <span class="text-sm font-medium text-primary">Portfolio</span>
        </div>
        
        <h2 class="text-3xl font-bold tracking-tight sm:text-4xl">Featured Projects</h2>
        <p class="mt-4 text-lg text-muted-foreground" style="animation-delay: 0.2s;">
          Showcasing some of my recent work and achievements
        </p>
      </div>
      
      <!-- Projects Grid -->
      <div class="mt-16 grid gap-8 sm:grid-cols-2">
        <Card 
          v-for="(project, index) in projects" 
          :key="project.id"
          class="group overflow-hidden"
          :style="{ animationDelay: (index * 0.2) + 's' }"
        >
          <ProjectImageCarousel :project="project" />
          
          <div class="p-6">
            <h3 class="text-2xl font-semibold">{{ project.title }}</h3>
            <p class="mt-2 text-muted-foreground">{{ project.description }}</p>
            
            <div class="mt-4 flex flex-wrap gap-2">
              <span 
                v-for="tech in project.technologies" 
                :key="tech"
                class="inline-flex items-center rounded-full bg-primary/10 px-3 py-1 text-sm text-primary"
              >
                {{ tech }}
              </span>
            </div>
            
            <!-- <div class="mt-6">
              <Link :href="route('guest.projects.show', project.id)">
                <Button variant="outline" class="w-full">View Project</Button>
              </Link>
            </div> -->
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