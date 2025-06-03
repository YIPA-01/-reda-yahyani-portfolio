<script setup>
import { Github, Linkedin, Twitter, Mail, ExternalLink } from 'lucide-vue-next'

const props = defineProps({
  variant: {
    type: String,
    default: 'default', // 'default', 'large', 'minimal'
  },
  showLabels: {
    type: Boolean,
    default: false
  }
})

const socialLinks = [
  {
    name: 'GitHub',
    url: 'https://github.com/YIPA-01',
    icon: Github,
    color: 'hover:text-gray-900 dark:hover:text-white',
    bgColor: 'hover:bg-gray-100 dark:hover:bg-gray-800'
  },
  {
    name: 'LinkedIn',
    url: 'https://www.linkedin.com/in/reda-yahyani-77905a232/',
    icon: Linkedin,
    color: 'hover:text-blue-600',
    bgColor: 'hover:bg-blue-50 dark:hover:bg-blue-900/20'
  },
  {
    name: 'Twitter',
    url: 'https://x.com/reda_yahyani',
    icon: Twitter,
    color: 'hover:text-sky-500',
    bgColor: 'hover:bg-sky-50 dark:hover:bg-sky-900/20'
  },
  {
    name: 'Email',
    url: 'mailto:yahyanireda@gmail.com',
    icon: Mail,
    color: 'hover:text-red-500',
    bgColor: 'hover:bg-red-50 dark:hover:bg-red-900/20'
  }
]

const getSizeClasses = () => {
  switch (props.variant) {
    case 'large':
      return 'w-12 h-12 text-xl'
    case 'minimal':
      return 'w-8 h-8 text-sm'
    default:
      return 'w-10 h-10 text-base'
  }
}
</script>

<template>
  <div class="flex items-center gap-3">
    <a
      v-for="social in socialLinks"
      :key="social.name"
      :href="social.url"
      target="_blank"
      rel="noopener noreferrer"
      :class="[
        'inline-flex items-center justify-center rounded-full border border-border/50 bg-background/50 backdrop-blur-sm transition-all duration-200',
        getSizeClasses(),
        social.color,
        social.bgColor,
        'hover:border-primary/50 hover:scale-110 hover:shadow-lg hover:shadow-primary/20'
      ]"
      :title="showLabels ? undefined : `Visit my ${social.name}`"
    >
      <component :is="social.icon" :class="variant === 'large' ? 'w-6 h-6' : variant === 'minimal' ? 'w-4 h-4' : 'w-5 h-5'" />
      <span v-if="showLabels" class="ml-2 text-sm font-medium">{{ social.name }}</span>
    </a>
  </div>
</template>

<style scoped>
/* Add subtle glow effect on hover */
a:hover {
  box-shadow: 0 0 20px rgba(var(--primary), 0.3);
}
</style> 