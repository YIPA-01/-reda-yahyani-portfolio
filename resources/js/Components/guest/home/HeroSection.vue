<script setup>
import { Link } from '@inertiajs/vue3'
import { Button } from '@/components'
import MessageDialog from '@/Components/guest/contact/MessageDialog.vue'
import SocialLinks from '@/Components/guest/SocialLinks.vue'
</script>

<template>
  <!-- Hero Section -->
  <section class="relative py-20 md:py-32 bg-gradient-to-b from-background to-background/50 overflow-hidden">
    <!-- Animated Background Grid -->
    <div class="absolute inset-0 -z-10 bg-[linear-gradient(to_right,#4f4f4f2e_1px,transparent_1px),linear-gradient(to_bottom,#4f4f4f2e_1px,transparent_1px)] bg-[size:14px_24px] animate-grid-move"></div>
    
    <!-- Floating Background Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none -z-10">
      <div 
        v-for="i in 20" 
        :key="i"
        class="absolute w-3 h-3 bg-primary/20 rounded-full animate-float-random"
        :style="{
          top: Math.random() * 100 + '%',
          left: Math.random() * 100 + '%',
          animationDelay: Math.random() * 8 + 's',
          animationDuration: (4 + Math.random() * 4) + 's'
        }"
      />
      
      <!-- Larger floating orbs -->
      <div 
        v-for="i in 8" 
        :key="'orb-' + i"
        class="absolute w-8 h-8 bg-gradient-to-br from-primary/10 to-purple-500/10 rounded-full animate-float-slow blur-sm"
        :style="{
          top: Math.random() * 100 + '%',
          left: Math.random() * 100 + '%',
          animationDelay: Math.random() * 6 + 's',
          animationDuration: (6 + Math.random() * 4) + 's'
        }"
      />
    </div>
    
    <!-- Gradient Orbs -->
    <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-gradient-to-br from-primary/20 to-purple-500/20 rounded-full blur-3xl animate-pulse-slow opacity-30"></div>
    <div class="absolute bottom-1/4 right-1/4 w-80 h-80 bg-gradient-to-br from-blue-500/20 to-primary/20 rounded-full blur-3xl animate-pulse-slow opacity-30" style="animation-delay: 2s;"></div>
    
    <div class="container relative z-10">
      <div class="mx-auto max-w-3xl text-center">
        <!-- Status Badge with Animation -->
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
          <div class="group relative">
            <MessageDialog size="lg" class="relative h-12 px-8 hover:scale-105 transition-transform duration-300" />
          </div>
        </div>
        
        <!-- Social Links -->
        <div class="mt-8 flex flex-col items-center gap-4" style="animation-delay: 1.4s;">
          <p class="text-sm text-muted-foreground">Connect with me</p>
          <SocialLinks variant="large" />
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