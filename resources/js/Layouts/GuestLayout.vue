<script setup>
import { Link } from '@inertiajs/vue3'
import { ThemeSwitcher } from '@/components'
import MobileNav from '@/Components/guest/navigation/MobileNav.vue'
import SocialLinks from '@/Components/guest/SocialLinks.vue'
import { Button } from '@/components'
import { ToastProvider, Toast } from '@/Components/ui/toast'
import { useToast } from '@/Composables/useToast'
import { onMounted } from 'vue'

const props = defineProps({
  flash: {
    type: Object,
    default: () => ({})
  }
})

const { messages, showSuccess, showError } = useToast()

const navigation = [
  { name: 'Home', href: '#hero' },
  { name: 'About', href: '#about' },
  { name: 'Skills', href: '#skills' },
  { name: 'Services', href: '#services' },
  { name: 'Projects', href: '#projects' },
  { name: 'Contact', href: '#contact' }
]

// Smooth scroll function
const scrollToSection = (href) => {
  const element = document.querySelector(href)
  if (element) {
    element.scrollIntoView({
      behavior: 'smooth',
      block: 'start'
    })
  }
}

onMounted(() => {
  if (props.flash?.success) {
    showSuccess(props.flash.success)
  }
  if (props.flash?.error) {
    showError(props.flash.error)
  }
})
</script>

<template>
  <ToastProvider>
    <div class="min-h-screen bg-background font-sans antialiased">
      <!-- Header -->
      <header class="sticky top-0 z-50 w-full border-b bg-background/95 backdrop-blur supports-[backdrop-filter]:bg-background/60">
        <div class="container flex h-14 items-center">
          <!-- Mobile Navigation -->
          <MobileNav :navigation="navigation" />

          <!-- Desktop Navigation -->
          <div class="mr-4 hidden md:flex">
            <nav class="flex items-center space-x-6 text-sm font-medium">
              <a
                v-for="item in navigation"
                :key="item.href"
                :href="item.href"
                @click.prevent="scrollToSection(item.href)"
                class="transition-colors hover:text-foreground/80 text-foreground/60 hover:text-foreground cursor-pointer"
              >
                {{ item.name }}
              </a>
            </nav>
          </div>

          <div class="flex flex-1 items-center justify-between space-x-2 md:justify-end">
            <div class="w-full flex-1 md:w-auto md:flex-none" />
            <ThemeSwitcher />
          </div>
        </div>
      </header>

      <!-- Main content -->
      <main>
        <slot />
      </main>

      <!-- Footer -->
      <footer class="border-t py-8 md:py-12">
        <div class="container">
          <div class="flex flex-col items-center justify-between gap-6 md:flex-row">
            <!-- Left side - Copyright and GitHub link -->
            <div class="flex flex-col items-center gap-4 md:items-start">
              <p class="text-center text-sm leading-loose text-muted-foreground md:text-left">
                Built by 
                <span class="font-medium text-foreground">Reda Yahyani</span>
              </p>

              
              <p class="text-xs text-muted-foreground">
                The source code is available on
                <a
                  href="https://github.com/redayahyani"
                  target="_blank"
                  rel="noreferrer"
                  class="font-medium underline underline-offset-4 hover:text-primary transition-colors"
                >
                  GitHub
                </a>
              </p>
            </div>

            <!-- Right side - Social Links -->
            <div class="flex flex-col items-center gap-4 md:items-end">
              <SocialLinks variant="default" />
            </div>
          </div>
          
          <!-- Bottom section -->
          <div class="mt-8 pt-6 text-center">
            <p class="text-xs text-muted-foreground">
              © {{ new Date().getFullYear() }} Reda Yahyani. All rights reserved.
            </p>
          </div>
        </div>
      </footer>
    </div>

    <!-- Toast Messages -->
    <template v-for="msg in messages" :key="msg.id">
      <Toast :variant="msg.type">
        {{ msg.message }}
      </Toast>
    </template>
  </ToastProvider>
</template>

<style scoped>
/* Smooth scrolling for the entire page */
:global(html) {
  scroll-behavior: smooth;
}

/* Offset scroll position to account for sticky header */
:global(section[id]) {
  scroll-margin-top: 4rem;
}
</style>
