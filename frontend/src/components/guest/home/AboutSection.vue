<script setup>
import Card from '@/components/ui/card/Card.vue'

const props = defineProps({
  education: {
    type: Array,
    required: true,
    default: () => []
  }
})
</script>

<template>
  <!-- About Me Section -->
  <section class="container py-24 bg-background/50 relative overflow-hidden">
    <!-- Floating Background Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
      <div 
        v-for="i in 15" 
        :key="i"
        class="absolute w-2 h-2 bg-primary/15 rounded-full animate-float-gentle"
        :style="{
          top: Math.random() * 100 + '%',
          left: Math.random() * 100 + '%',
          animationDelay: Math.random() * 6 + 's',
          animationDuration: (4 + Math.random() * 3) + 's'
        }"
      />
    </div>
    
    <div class="mx-auto max-w-7xl relative">
      <div class="grid gap-12 lg:grid-cols-2 lg:gap-8">
        <!-- Left Content -->
        <div>
          <div class="inline-flex items-center px-4 py-2 rounded-full bg-primary/10 border border-primary/20 mb-6">
            <div class="w-2 h-2 bg-primary rounded-full animate-pulse mr-2"></div>
            <span class="text-sm font-medium text-primary">About Me</span>
          </div>
          
          <h2 class="text-3xl font-bold tracking-tight sm:text-4xl mb-6">
            Passionate Developer
          </h2>
          
          <div class="space-y-4">
            <p class="text-lg text-muted-foreground" style="animation-delay: 0.2s;">
              Hi, I'm <span class="text-primary font-semibold">Reda Yahyani</span>, a passionate Full Stack Developer with over 
              <span class="inline-flex items-center text-primary font-semibold">5 years</span> 
              of experience in building exceptional digital experiences. I specialize in creating robust and scalable web applications using modern technologies.
            </p>
            <p class="text-lg text-muted-foreground" style="animation-delay: 0.4s;">
              My approach combines technical expertise with creative problem-solving to deliver solutions that not only meet but exceed client expectations. I'm particularly enthusiastic about 
              <span class="text-primary font-semibold">cloud architecture</span>, 
              <span class="text-primary font-semibold">API design</span>, and creating 
              <span>seamless user experiences</span>.
            </p>
          </div>
        </div>
        
        <!-- Right Content -->
        <div class="relative">
          <div class="absolute inset-0 -z-10 bg-gradient-to-tr from-primary/10 via-primary/5 to-transparent rounded-3xl"></div>
          <div class="space-y-6">
            <!-- Education Card -->
            <Card class="bg-background/80 backdrop-blur-sm p-6 group hover:border-primary/50 transition-all duration-300 hover:scale-105 hover:shadow-xl hover:shadow-primary/10" style="animation-delay: 0.8s;">
              <div class="flex items-center gap-3 mb-6">
                <div class="p-2 rounded-lg bg-primary/10 text-primary group-hover:scale-110 transition-transform duration-300">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                    <path d="M6 12v5c3 3 9 3 12 0v-5"/>
                  </svg>
                </div>
                <h3 class="text-xl font-semibold group-hover:text-primary transition-colors duration-300">Education</h3>
              </div>
              
              <div v-if="education?.length" class="relative">
                <div 
                  v-for="(edu, index) in education" 
                  :key="index"
                  class="group/item relative flex gap-6 pb-8 last:pb-0 hover:translate-x-2 transition-transform duration-300"
                >
                  <!-- Timeline -->
                  <div class="flex flex-col items-center">
                    <!-- Dot -->
                    <div class="relative z-10 flex h-4 w-4 items-center justify-center">
                      <div class="h-3 w-3 rounded-full border-2 border-primary bg-background transition-all duration-200 group-hover/item:scale-110 group-hover/item:bg-primary group-hover/item:shadow-lg group-hover/item:shadow-primary/50" />
                    </div>
                    
                    <!-- Line -->
                    <div 
                      v-if="index < education.length - 1"
                      class="mt-2 h-full w-px bg-border transition-colors duration-200 group-hover/item:bg-primary/40"
                    />
                  </div>

                  <!-- Content -->
                  <div class="flex-1 pb-2">
                    <!-- Header -->
                    <div class="mb-3 flex flex-wrap items-center gap-3">
                      <h3 class="text-lg font-semibold leading-tight group-hover/item:text-primary transition-colors duration-300">
                        {{ edu.degree }}
                      </h3>
                      <span class="inline-flex items-center rounded-md bg-primary/10 px-2.5 py-1 text-xs font-medium text-primary ring-1 ring-inset ring-primary/20 group-hover/item:bg-primary/20 transition-colors duration-300">
                        {{ edu.duration }}
                      </span>
                    </div>

                    <!-- Institution -->
                    <p class="mb-2 font-medium text-primary group-hover/item:text-primary/80 transition-colors duration-300">
                      {{ edu.institution }}
                    </p>

                    <!-- Description -->
                    <p 
                      v-if="edu.description" 
                      class="text-sm leading-relaxed text-muted-foreground group-hover/item:text-foreground transition-colors duration-300"
                    >
                      {{ edu.description }}
                    </p>
                  </div>
                </div>
              </div>

              <div v-else class="text-center text-muted-foreground py-4 animate-pulse">
                No education entries found
              </div>
            </Card>
            
            <!-- Experience Card -->
            <Card class="bg-background/80 backdrop-blur-sm p-6 group hover:border-primary/50 transition-all duration-300 hover:scale-105 hover:shadow-xl hover:shadow-primary/10" style="animation-delay: 1s;">
              <div class="flex items-center gap-3 mb-6">
                <div class="p-2 rounded-lg bg-primary/10 text-primary group-hover:scale-110 transition-transform duration-300">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                    <polyline points="7.5 4.21 12 6.81 16.5 4.21"/>
                    <polyline points="7.5 19.79 7.5 14.6 3 12"/>
                    <polyline points="21 12 16.5 14.6 16.5 19.79"/>
                    <polyline points="3.27 6.96 12 12.01 20.73 6.96"/>
                    <line x1="12" y1="22.08" x2="12" y2="12"/>
                  </svg>
                </div>
                <h3 class="text-xl font-semibold group-hover:text-primary transition-colors duration-300">Work Experience</h3>
              </div>
              <div class="space-y-8">
                <div class="relative pl-6 group/item pb-8 hover:translate-x-2 transition-transform duration-300">
                  <div class="absolute left-0 top-[28px] h-full w-[2px] bg-muted group-hover/item:bg-primary/50 transition-colors duration-300"></div>
                  <div class="absolute left-[-4px] top-[22px] h-3 w-3 rounded-full border-2 border-primary bg-background 
                             group-hover/item:bg-primary group-hover/item:scale-110 group-hover/item:shadow-lg group-hover/item:shadow-primary/50 transition-all duration-300">
                  </div>
                  
                  <div>
                    <div class="flex flex-col sm:flex-row sm:items-center gap-2 mb-1">
                      <h4 class="font-semibold text-lg group-hover/item:text-primary transition-colors duration-300">Senior Full Stack Developer</h4>
                      <span class="inline-flex items-center rounded-full bg-primary/10 px-3 py-1 text-xs font-medium text-primary group-hover/item:bg-primary/20 transition-colors duration-300">
                        2020 - Present
                      </span>
                    </div>
                    <p class="text-primary font-medium group-hover/item:text-primary/80 transition-colors duration-300">TechCorp Solutions</p>
                    <p class="mt-2 text-sm text-muted-foreground leading-relaxed group-hover/item:text-foreground transition-colors duration-300">
                      Led development of enterprise web applications, mentored junior developers, and implemented modern development practices.
                    </p>
                  </div>
                </div>
                <div class="relative pl-6 group/item hover:translate-x-2 transition-transform duration-300">
                  <div class="absolute left-[-4px] top-[22px] h-3 w-3 rounded-full border-2 border-primary bg-background 
                             group-hover/item:bg-primary group-hover/item:scale-110 group-hover/item:shadow-lg group-hover/item:shadow-primary/50 transition-all duration-300">
                  </div>
                  
                  <div>
                    <div class="flex flex-col sm:flex-row sm:items-center gap-2 mb-1">
                      <h4 class="font-semibold text-lg group-hover/item:text-primary transition-colors duration-300">Full Stack Developer</h4>
                      <span class="inline-flex items-center rounded-full bg-primary/10 px-3 py-1 text-xs font-medium text-primary group-hover/item:bg-primary/20 transition-colors duration-300">
                        2018 - 2020
                      </span>
                    </div>
                    <p class="text-primary font-medium group-hover/item:text-primary/80 transition-colors duration-300">Digital Innovations Inc.</p>
                    <p class="mt-2 text-sm text-muted-foreground leading-relaxed group-hover/item:text-foreground transition-colors duration-300">
                      Developed and maintained multiple client projects, implemented responsive designs, and optimized application performance.
                    </p>
                  </div>
                </div>
              </div>
            </Card>
          </div>
        </div>
      </div>
    </div>
  </section>
</template> 