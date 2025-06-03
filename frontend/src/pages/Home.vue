<template>
  <div class="home">
    <!-- Hero Section -->
    <HeroSection />
    
    <!-- About Section -->
    <AboutSection />
    
    <!-- Services Section -->
    <ServicesSection />
    
    <!-- Skills Section -->
    <SkillsSection :skills="skills" />
    
    <!-- Projects Section -->
    <ProjectsSection :projects="projects" />
    
    <!-- Contact Section -->
    <ContactSection />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useFirebase } from '../composables/useFirebase'
import HeroSection from '../components/guest/home/HeroSection.vue'
import AboutSection from '../components/guest/home/AboutSection.vue'
import ServicesSection from '../components/guest/home/ServicesSection.vue'
import SkillsSection from '../components/guest/home/SkillsSection.vue'
import ProjectsSection from '../components/guest/home/ProjectsSection.vue'
import ContactSection from '../components/guest/home/ContactSection.vue'

const { getProjects, getSkills } = useFirebase()

// Reactive data
const projects = ref([])
const skills = ref([])

// Load data on component mount
onMounted(async () => {
  document.title = 'Reda Yahyani - Full Stack Developer'
  
  try {
    // Load projects and skills from Firebase
    projects.value = await getProjects()
    skills.value = await getSkills()
  } catch (error) {
    console.error('Error loading data:', error)
  }
})
</script>

<style scoped>
.home {
  min-height: 100vh;
}

/* Enhanced animations */
.home section {
  scroll-margin-top: 80px;
}
</style> 