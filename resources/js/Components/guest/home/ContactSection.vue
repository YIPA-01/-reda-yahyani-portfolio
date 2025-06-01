<script setup>
import { Link } from '@inertiajs/vue3'
import { Button } from '@/components'
import Card from '@/Components/ui/card/Card.vue'
import MessageDialog from '@/Components/guest/contact/MessageDialog.vue'
</script>

<template>
  <!-- Contact CTA -->
  <section class="container py-24 relative overflow-hidden">
    <!-- Floating Background Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
      <div 
        v-for="i in 15" 
        :key="i"
        class="absolute w-3 h-3 bg-primary/10 rounded-full animate-float-gentle"
        :style="{
          top: Math.random() * 100 + '%',
          left: Math.random() * 100 + '%',
          animationDelay: Math.random() * 6 + 's',
          animationDuration: (4 + Math.random() * 3) + 's'
        }"
      />
    </div>
    
    <!-- Gradient Orbs -->
    <div class="absolute top-1/4 left-1/4 w-64 h-64 bg-gradient-to-br from-primary/20 to-purple-500/20 rounded-full blur-3xl animate-pulse-slow opacity-40"></div>
    <div class="absolute bottom-1/4 right-1/4 w-48 h-48 bg-gradient-to-br from-blue-500/20 to-primary/20 rounded-full blur-3xl animate-pulse-slow opacity-40" style="animation-delay: 2s;"></div>
    
    <Card class="mx-auto max-w-7xl bg-primary/10 p-12 relative overflow-hidden group scale-105 shadow-2xl shadow-primary/20">
      <!-- Background Effects - Always Active -->
      <div class="absolute inset-0 bg-gradient-to-br from-primary/10 via-transparent to-purple-500/10 opacity-100 transition-opacity duration-500"></div>
      
      <!-- Animated Border - Always Active -->
      <div class="absolute inset-0 rounded-lg border border-primary/30 transition-colors duration-300 animate-pulse-glow"></div>
      
      <!-- Floating particles - Always Active -->
      <div class="absolute inset-0 pointer-events-none">
        <div 
          v-for="n in 12" 
          :key="n"
          class="absolute w-1 h-1 bg-primary rounded-full opacity-100 transition-opacity duration-300 animate-float"
          :style="{
            top: Math.random() * 100 + '%',
            left: Math.random() * 100 + '%',
            animationDelay: (n * 0.1) + 's'
          }"
        />
      </div>
      
      <div class="text-center relative z-10">
        <!-- Status Badge - Always Active -->
        <div class="inline-flex items-center px-4 py-2 rounded-full bg-primary/10 border border-primary/20 mb-6 scale-105 transition-transform duration-300">
          <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse mr-2"></div>
          <span class="text-sm font-medium text-primary">Ready to Collaborate</span>
        </div>
        
        <!-- Main Title - Always Active -->
        <h2 class="text-3xl font-bold tracking-tight sm:text-4xl gradient-text scale-105 transition-transform duration-300">
          Ready to Build Something Amazing?
        </h2>
        
        <!-- Description - Always Active -->
        <p class="mx-auto mt-6 max-w-2xl text-lg text-foreground transition-colors duration-300" style="animation-delay: 0.2s;">
          Let's collaborate to create exceptional digital experiences that drive results.
          <br>
          <span class="text-primary font-semibold">Whether you have a specific project in mind or need guidance, I'm here to help.</span>
        </p>
        
        <!-- Action Buttons -->
        <div class="mt-10 flex items-center justify-center gap-6" style="animation-delay: 0.4s;">
          <!-- Primary CTA with enhanced effects -->
          <div class="group/cta relative">
            <MessageDialog size="lg" class="relative h-12 px-8 hover:scale-105 transition-transform duration-300" />
          </div>
          
          <!-- Secondary CTA -->

        </div>
        
        <!-- Additional Info - Always Active -->
        <div class="mt-8 flex items-center justify-center gap-8 text-sm text-foreground" style="animation-delay: 0.6s;">
          <div class="flex items-center gap-2 group/info text-primary transition-colors duration-300">
            <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></div>
            <span class="translate-x-1 transition-transform duration-300">Quick Response</span>
          </div>
          <div class="flex items-center gap-2 group/info text-primary transition-colors duration-300">
            <div class="w-2 h-2 bg-blue-500 rounded-full animate-pulse" style="animation-delay: 0.5s;"></div>
            <span class="translate-x-1 transition-transform duration-300">Free Consultation</span>
          </div>
          <div class="flex items-center gap-2 group/info text-primary transition-colors duration-300">
            <div class="w-2 h-2 bg-purple-500 rounded-full animate-pulse" style="animation-delay: 1s;"></div>
            <span class="translate-x-1 transition-transform duration-300">Custom Solutions</span>
          </div>
        </div>
      </div>
    </Card>
  </section>
</template> 