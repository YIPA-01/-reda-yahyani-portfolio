<script setup>
import { onMounted, reactive } from 'vue'
import Card from '@/Components/ui/card/Card.vue'


const skills = [
  {
    category: "Frontend",
    icon: "devicon-html5-plain colored",
    items: [
      { name: "Vue.js", level: 90, icon: "devicon-vuejs-plain colored" },
      { name: "React", level: 85, icon: "devicon-react-original colored" },
      { name: "TypeScript", level: 80, icon: "devicon-typescript-plain colored" },
      { name: "TailwindCSS", level: 95, icon: "devicon-tailwindcss-plain colored" }
    ]
  },
  {
    category: "Backend",
    icon: "devicon-devicon-plain colored",
    items: [
      { name: "Laravel", level: 90, icon: "devicon-laravel-plain colored" },
      { name: "Node.js", level: 85, icon: "devicon-nodejs-plain colored" },
      { name: "PostgreSQL", level: 80, icon: "devicon-postgresql-plain colored" },
      { name: "Redis", level: 75, icon: "devicon-redis-plain colored" }
    ]
  },
  {
    category: "DevOps",
    icon: "devicon-azuredevops-plain colored",
    items: [
      { name: "Docker", level: 85, icon: "devicon-docker-plain colored" },
      { name: "AWS", level: 80, icon: "devicon-amazonwebservices-plain colored" },
      { name: "Git", level: 90, icon: "devicon-git-plain colored" },
      { name: "Linux", level: 85, icon: "devicon-linux-plain colored" }
    ]
  }
]

// Reactive states for animations
const skillAnimated = reactive({})

// Initialize all skills as not animated
onMounted(() => {
  // Initialize skill animations
  skills.forEach(category => {
    category.items.forEach(skill => {
      skillAnimated[skill.name] = false
    })
  })
  
  // Start animations with delay
  setTimeout(() => {
    animateSkillsOnLoad()
  }, 500)
})

const animateSkill = (skill) => {
  skillAnimated[skill.name] = true
}

const animateSkillsOnLoad = () => {
  skills.forEach((category, categoryIndex) => {
    category.items.forEach((skill, skillIndex) => {
      setTimeout(() => {
        skillAnimated[skill.name] = true
      }, (categoryIndex * 200) + (skillIndex * 100))
    })
  })
}

const getSkillLevel = (level) => {
  if (level >= 90) return 'Expert'
  if (level >= 75) return 'Advanced'
  if (level >= 60) return 'Intermediate'
  return 'Beginner'
}
</script>

<template>
  <!-- Skills Section -->
  <section class="container py-24 relative overflow-hidden">
    <!-- Floating Background Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
      <div 
        v-for="i in 12" 
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
      <!-- Header with animated entrance -->
      <div class="mx-auto max-w-2xl text-center mb-16">
        <div class="inline-flex items-center px-4 py-2 rounded-full bg-primary/10 border border-primary/20 mb-6">
          <div class="w-2 h-2 bg-primary rounded-full animate-pulse mr-2"></div>
          <span class="text-sm font-medium text-primary">Skills & Expertise</span>
        </div>
        
        <h2 class="text-4xl font-bold tracking-tight sm:text-5xl mb-6">
          <span>Technical Arsenal</span>
        </h2>
        <p class="text-lg text-muted-foreground">
          Crafting digital experiences with cutting-edge technologies
        </p>
      </div>
      
      <!-- Skills Grid with staggered animations -->
      <div class="space-y-16">
        <div 
          v-for="(category, categoryIndex) in skills" 
          :key="category.category"
          class="skill-category"
          :style="{ animationDelay: categoryIndex * 0.2 + 's' }"
        >
          <!-- Category Header -->
          <div class="flex items-center gap-4 mb-8">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-primary/20 to-primary/5 flex items-center justify-center">
              <i :class="[category.icon, 'text-2xl','animate-float']"></i>
            </div>
            <h3 class="text-3xl font-bold">{{ category.category }}</h3>
          </div>
          
          <!-- Skills Cards -->
          <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            <Card 
              v-for="(skill, skillIndex) in category.items" 
              :key="skill.name"
              class="group relative overflow-hidden p-6 glass-effect border border-white/10 hover:border-primary/50 transition-all duration-0"
              :style="{ animationDelay: (categoryIndex * 0.2 + skillIndex * 0.1) + 's' }"
              @mouseenter="animateSkill(skill)"
            >
              <!-- Hover Background Effect -->
              <div class="absolute inset-0 bg-gradient-to-br from-primary/5 via-transparent to-purple-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-100"></div>
              
              <!-- Skill Icon with Animation -->
              <div class="relative z-10 flex items-center gap-4 mb-4">
                <div class="relative">
                  <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-primary/20 to-primary/5 flex items-center justify-center group-hover:scale-110 transition-transform duration-100">
                    <i :class="[skill.icon, 'text-3xl transition-transform duration-100 group-hover:rotate-12']"></i>
                  </div>
                  <!-- Floating Glow Effect -->
                  <div class="absolute inset-0 rounded-2xl bg-primary/20 opacity-0 group-hover:opacity-100 animate-pulse-glow transition-opacity duration-100"></div>
                </div>
                
                <div class="flex-1">
                  <h4 class="font-semibold text-lg text-white group-hover:text-primary transition-colors duration-100">
                    {{ skill.name }}
                  </h4>
                </div>
              </div>
              
              <!-- Animated Progress Bar -->
              <div class="relative z-10">
                <Card class="h-3 bg-gray-800 overflow-hidden mb-2">
                  <div  class="h-full bg-gradient-to-r from-primary to-purple-500 transition-all duration-1000 skill-progress relative overflow-hidden"
                       :style="{ width: skillAnimated[skill.name] ? skill.level + '%' : '0%' }">
                    <!-- Shimmer Effect -->
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-100"></div>
                  </div>
                </Card>
                
                <!-- Skill Level Indicator -->
                <div class="flex justify-between items-center text-xs text-muted-foreground">
                  <span>Beginner</span>
                  <span class="font-medium text-primary">{{ skill.level }}%</span>
                  <span>Expert</span>
                </div>
              </div>
              
              <!-- Floating Skill Badge -->
              <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-all duration-100 transform translate-y-2 group-hover:translate-y-0">
                <div class="px-3 py-1 rounded-full bg-primary/20 border border-primary/30 text-xs font-medium text-primary">
                  {{ getSkillLevel(skill.level) }}
                </div>
              </div>
              
              <!-- Particle Effect on Hover -->
              <div class="absolute inset-0 pointer-events-none">
                <div 
                  v-for="n in 6" 
                  :key="n"
                  class="absolute w-1 h-1 bg-primary rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-100"
                  :style="{
                    top: Math.random() * 100 + '%',
                    left: Math.random() * 100 + '%',
                    animationDelay: (n * 0.1) + 's'
                  }"
                  :class="'animate-float'"
                />
              </div>
            </Card>
          </div>
        </div>
      </div>
    </div>
  </section>
</template> 