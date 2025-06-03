<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

const navigateToContact = () => {
  router.push('/contact')
}

const navigateToProjects = () => {
  router.push('/projects')
}
</script>

<template>
  <!-- Hero Section -->
  <section class="relative min-h-screen flex items-center justify-center overflow-hidden">
    <!-- Enhanced Background Effects -->
    <div class="absolute inset-0 bg-gradient-to-br from-background via-background/95 to-primary/5"></div>
    
    <!-- Multiple Floating Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
      <div 
        v-for="i in 15" 
        :key="i"
        class="absolute w-2 h-2 bg-primary/10 rounded-full animate-float-gentle"
        :style="{
          top: Math.random() * 100 + '%',
          left: Math.random() * 100 + '%',
          animationDelay: Math.random() * 4 + 's',
          animationDuration: (4 + Math.random() * 3) + 's'
        }"
      />
      
      <!-- Larger floating shapes -->
      <div 
        v-for="j in 5" 
        :key="`large-${j}`"
        class="absolute w-8 h-8 bg-primary/5 rounded-full animate-float-slow"
        :style="{
          top: Math.random() * 100 + '%',
          left: Math.random() * 100 + '%',
          animationDelay: Math.random() * 6 + 's',
          animationDuration: (8 + Math.random() * 4) + 's'
        }"
      />
    </div>

    <!-- Hero Content -->
    <div class="container relative z-10">
      <div class="mx-auto max-w-4xl text-center">
        <!-- Status Badge with Enhanced Animation -->
        <div class="inline-flex items-center rounded-full border px-4 py-1.5 group hover:scale-105 transition-transform duration-300 cursor-pointer">
          <span class="flex h-2 w-2 rounded-full bg-emerald-500 animate-pulse-glow"></span>
          <span class="ml-2 text-sm font-medium group-hover:text-primary transition-colors duration-300">Available for new projects</span>
        </div>
        <h1 class="mt-6 text-4xl font-bold tracking-tight sm:text-5xl md:text-6xl">
          Transforming Ideas into
          <span class="text-primary">Digital Reality</span>
        </h1>
        
        <!-- Animated Description -->
        <p class="mt-6 text-lg leading-8 text-muted-foreground" style="animation-delay: 1s;">
          Full Stack Developer specializing in building exceptional digital experiences.
          From concept to deployment, I bring your vision to life with modern technologies.
        </p>
        
        <!-- Animated Buttons -->
        <div class="mt-10 flex items-center justify-center gap-6" style="animation-delay: 1.2s;">
          <button 
            @click="navigateToContact"
            class="bg-primary text-primary-foreground hover:bg-primary/90 h-12 px-8 rounded-md font-medium transition-all duration-300 hover:scale-105"
          >
            Get In Touch
          </button>
          <button 
            @click="navigateToProjects"
            class="border border-input bg-background hover:bg-accent hover:text-accent-foreground h-12 px-8 rounded-md font-medium transition-all duration-300 hover:scale-105"
          >
            View Projects
          </button>
        </div>
        
        <!-- Social Links -->
        <div class="mt-8 flex flex-col items-center gap-4" style="animation-delay: 1.4s;">
          <p class="text-sm text-muted-foreground">Connect with me</p>
          <div class="flex gap-4">
            <a href="#" class="w-10 h-10 rounded-full bg-primary/10 hover:bg-primary/20 flex items-center justify-center transition-colors">
              <i class="fab fa-github"></i>
            </a>
            <a href="#" class="w-10 h-10 rounded-full bg-primary/10 hover:bg-primary/20 flex items-center justify-center transition-colors">
              <i class="fab fa-linkedin"></i>
            </a>
            <a href="#" class="w-10 h-10 rounded-full bg-primary/10 hover:bg-primary/20 flex items-center justify-center transition-colors">
              <i class="fab fa-twitter"></i>
            </a>
          </div>
        </div>
        
        <!-- Scroll Indicator -->
        <div class="mt-16 animate-bounce-slow">
          <div class="mx-auto w-6 h-10 border-2 border-primary/30 rounded-full flex justify-center">
            <div class="w-1 h-3 bg-primary rounded-full mt-2 animate-scroll-indicator"></div>
          </div>
          <p class="mt-2 text-xs text-muted-foreground">Scroll to explore</p>
        </div>
      </div>
    </div>
  </section>
</template> 