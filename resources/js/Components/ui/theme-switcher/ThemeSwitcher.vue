<script setup>
import { ref, watch, onMounted, onUnmounted } from 'vue'
import { Button } from '@/components'
import { useTheme } from '../../../Composables/useTheme'

const { theme, setTheme: setAppTheme } = useTheme()

const isOpen = ref(false)
const currentTheme = ref('system')
const currentColor = ref('zinc')
const currentRadius = ref('0.5')
const dialogRef = ref(null)

const colors = {
  zinc: { hue: 240, saturation: 5.9, lightness: 10 },
  slate: { hue: 215.4, saturation: 16.3, lightness: 46.9 },
  stone: { hue: 25, saturation: 5.3, lightness: 44.7 },
  gray: { hue: 220, saturation: 8.9, lightness: 46.1 },
  neutral: { hue: 0, saturation: 0, lightness: 45.1 },
  red: { hue: 0, saturation: 84.2, lightness: 60.2 },
  rose: { hue: 346.8, saturation: 77.2, lightness: 49.8 },
  orange: { hue: 24, saturation: 96, lightness: 53 },
  green: { hue: 142.1, saturation: 76.2, lightness: 36.3 },
  blue: { hue: 221.2, saturation: 83.2, lightness: 53.3 },
  yellow: { hue: 47.9, saturation: 95.8, lightness: 53.1 },
  violet: { hue: 262.1, saturation: 83.3, lightness: 57.8 }
}

const radiuses = [
  { value: '0', label: '0' },
  { value: '0.25', label: '0.25' },
  { value: '0.5', label: '0.5' },
  { value: '0.75', label: '0.75' },
  { value: '1', label: '1' },
]

const selectedColor = ref('orange')

function updateTheme(newTheme) {
  const root = document.documentElement
  const isDark = newTheme === 'dark' || (newTheme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches)

  root.classList.remove('light', 'dark')
  root.classList.add(isDark ? 'dark' : 'light')
  currentTheme.value = newTheme
  localStorage.setItem('theme', newTheme)
  setAppTheme(newTheme)
}

function updateColor(colorName) {
  selectedColor.value = colorName
  const color = colors[colorName]
  
  document.documentElement.style.setProperty(
    '--primary',
    `${color.hue} ${color.saturation}% ${color.lightness}%`
  )
  currentColor.value = colorName
  localStorage.setItem('color', colorName)
}

function updateRadius(radius) {
  const root = document.documentElement
  root.style.setProperty('--radius', `${radius}rem`)
  currentRadius.value = radius
  localStorage.setItem('radius', radius)
}

function handleClickOutside(event) {
  if (dialogRef.value && !dialogRef.value.contains(event.target)) {
    isOpen.value = false
  }
}

// Watch for system theme changes
watch(
  () => window.matchMedia('(prefers-color-scheme: dark)').matches,
  (isDark) => {
    if (currentTheme.value === 'system') {
      updateTheme('system')
    }
  }
)

onMounted(() => {
  // Load saved preferences
  const savedTheme = localStorage.getItem('theme') || 'system'
  const savedColor = localStorage.getItem('color') || 'orange'
  const savedRadius = localStorage.getItem('radius') || '0.5'

  updateTheme(savedTheme)
  updateColor(savedColor)
  updateRadius(savedRadius)

  // Add click outside listener
  document.addEventListener('click', handleClickOutside)
})

onUnmounted(() => {
  // Remove click outside listener
  document.removeEventListener('click', handleClickOutside)
})
</script>

<template>
  <div class="relative">
    <!-- Trigger Button -->
    <Button variant="outline" size="icon" @click.stop="isOpen = !isOpen">
      <span class="sr-only">Toggle theme</span>
      <svg v-if="currentTheme === 'dark'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />
      </svg>
      <svg v-else xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
      </svg>
    </Button>

    <!-- Theme Customizer Dialog -->
    <div v-if="isOpen" ref="dialogRef" class="fixed inset-x-4 top-16 z-50 mx-auto max-w-[320px] rounded-lg border bg-popover p-4 text-popover-foreground shadow-lg sm:right-4 sm:left-auto sm:top-14">
      <div class="grid gap-4">
        <!-- Theme Section -->
        <div class="space-y-2">
          <div class="flex items-center justify-between">
            <span class="text-sm font-medium">Theme</span>
            <div class="flex gap-1">
              <Button
                v-for="mode in ['light', 'dark']"
                :key="mode"
                variant="ghost"
                size="sm"
                class="h-8 w-8"
                :class="{ 'bg-accent': currentTheme === mode }"
                @click="updateTheme(mode)"
              >
                <span class="sr-only">{{ mode }} mode</span>
                <svg v-if="mode === 'light'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-10 w-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                </svg>
                <svg v-else xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />
                </svg>
              </Button>
            </div>
          </div>
        </div>

        <!-- Color Section -->
        <div class="space-y-2">
          <div class="flex items-center justify-between">
            <span class="text-sm font-medium">Color</span>
          </div>
          <div class="grid grid-cols-6 gap-1">
            <button
              v-for="(color, name) in colors"
              :key="name"
              class="group relative h-6 w-6 rounded-md border"
              :class="{ 'ring-2 ring-primary ring-offset-2': currentColor === name }"
              :style="{
                backgroundColor: `hsl(${color.hue} ${color.saturation}% ${color.lightness}%)`
              }"
              @click="updateColor(name)"
            >
              <span class="sr-only">{{ name }} theme</span>
              <svg v-if="currentColor === name" class="absolute inset-0 m-auto h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M20 6L9 17l-5-5" />
              </svg>
            </button>
          </div>
        </div>

        <!-- Radius Section -->
        <div class="space-y-2">
          <div class="flex items-center justify-between">
            <span class="text-sm font-medium">Radius</span>
          </div>
          <div class="flex gap-1">
            <button
              v-for="radius in radiuses"
              :key="radius.value"
              class="flex h-6 w-8 items-center justify-center rounded-md border text-xs transition-colors hover:bg-accent"
              :class="{ 'bg-accent': currentRadius === radius.value }"
              @click="updateRadius(radius.value)"
            >
              {{ radius.label }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template> 