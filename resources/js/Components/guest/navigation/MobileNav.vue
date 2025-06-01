<script setup>
import { ref } from 'vue'
import { Button } from '@/components'

const props = defineProps({
  navigation: {
    type: Array,
    required: true
  }
})

const isOpen = ref(false)

function toggleMenu() {
  isOpen.value = !isOpen.value
}

// Smooth scroll function
const scrollToSection = (href) => {
  const element = document.querySelector(href)
  if (element) {
    element.scrollIntoView({
      behavior: 'smooth',
      block: 'start'
    })
  }
  isOpen.value = false // Close menu after clicking
}
</script>

<template>
  <div class="md:hidden">
    <Button
      variant="ghost"
      class="mr-2 px-0 text-base hover:bg-transparent focus-visible:bg-transparent focus-visible:ring-0 focus-visible:ring-offset-0 md:hidden"
      @click="toggleMenu"
    >
      <svg
        v-if="!isOpen"
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
        stroke-width="1.5"
        stroke="currentColor"
        class="h-6 w-6"
      >
        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
      </svg>
      <svg
        v-else
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
        stroke-width="1.5"
        stroke="currentColor"
        class="h-6 w-6"
      >
        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
      </svg>
      <span class="sr-only">Toggle menu</span>
    </Button>

    <!-- Mobile navigation menu -->
    <div
      v-if="isOpen"
      class="fixed inset-0 top-16 z-50 grid h-[calc(100vh-4rem)] grid-flow-row auto-rows-max overflow-auto p-6 pb-32 shadow-md animate-in slide-in-from-bottom-80 md:hidden"
    >
      <div class="relative z-20 grid gap-6 rounded-md bg-popover p-4 text-popover-foreground shadow-md">
        <nav class="grid grid-flow-row auto-rows-max text-sm">
          <a
            v-for="item in navigation"
            :key="item.href"
            :href="item.href"
            @click.prevent="scrollToSection(item.href)"
            class="-mx-2 flex items-center rounded-md p-2 text-sm font-medium hover:underline text-foreground/60 hover:text-foreground cursor-pointer"
          >
            {{ item.name }}
          </a>
        </nav>
      </div>
    </div>
  </div>
</template> 