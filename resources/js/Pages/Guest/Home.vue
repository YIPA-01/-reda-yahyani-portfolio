<script setup>
import { Head } from '@inertiajs/vue3'
import GuestLayout from '@/Layouts/GuestLayout.vue'

// Import section components
import HeroSection from '@/Components/guest/home/HeroSection.vue'
import AboutSection from '@/Components/guest/home/AboutSection.vue'
import ServicesSection from '@/Components/guest/home/ServicesSection.vue'
import SkillsSection from '@/Components/guest/home/SkillsSection.vue'
import ProjectsSection from '@/Components/guest/home/ProjectsSection.vue'
import ContactSection from '@/Components/guest/home/ContactSection.vue'
import HomeAnimations from '@/Components/guest/home/HomeAnimations.vue'

const props = defineProps({
  projects: {
    type: Object,
    required: true
  },
  skills: {
    type: Object,
    required: true
  },
  education: {
    type: Array,
    required: true,
    default: () => []
  }
})

// Skills data for the skills section

</script>

<template>
  <Head title="Reda Yahyani - Full Stack Developer" />

  <GuestLayout>
    
    <!-- Hero Section -->
    <HeroSection id="hero" />

    <!-- About Me Section -->
    <AboutSection id="about" :education="education" />

    <!-- Services Section -->
    <ServicesSection id="services" />

    <!-- Skills Section -->
    <SkillsSection id="skills" />

    <!-- Projects Section -->
    <ProjectsSection id="projects" :projects="projects" />

    <!-- Contact CTA -->
    <ContactSection id="contact" />
  </GuestLayout>
</template>

<style scoped>
/* Enhanced Keyframe Animations */
@import './resources/css/app.css';
</style>