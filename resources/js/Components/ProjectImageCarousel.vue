<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { Button } from '@/components'

const props = defineProps({
  project: {
    type: Object,
    required: true
  }
})

const currentIndex = ref(0)

// Computed properties
const images = computed(() => {
  return props.project.images || []
})

const hasImages = computed(() => {
  return images.value.length > 0
})

const currentImage = computed(() => {
  if (!hasImages.value) return null
  return images.value[currentIndex.value]
})

// Navigation methods
const nextImage = () => {
  if (images.value.length > 1) {
    currentIndex.value = (currentIndex.value + 1) % images.value.length
  }
}

const previousImage = () => {
  if (images.value.length > 1) {
    currentIndex.value = currentIndex.value === 0 ? images.value.length - 1 : currentIndex.value - 1
  }
}

const goToImage = (index) => {
  if (index >= 0 && index < images.value.length) {
    currentIndex.value = index
  }
}

// Error handling
const handleImageError = (event) => {
  console.error('Failed to load image:', event.target.src)
  // You could set a fallback image here if needed
}

// Keyboard navigation
const handleKeydown = (event) => {
  if (!hasImages.value || images.value.length <= 1) return
  
  switch (event.key) {
    case 'ArrowLeft':
      event.preventDefault()
      previousImage()
      break
    case 'ArrowRight':
      event.preventDefault()
      nextImage()
      break
  }
}

// Lifecycle
onMounted(() => {
  document.addEventListener('keydown', handleKeydown)
})

onUnmounted(() => {
  document.removeEventListener('keydown', handleKeydown)
})
</script>

<template>
  <div class="relative w-full h-64 bg-gray-100 rounded-lg overflow-hidden group">
    <!-- Main Image Display -->
    <div v-if="hasImages" class="relative w-full h-full">
      <img
        :src="currentImage.url"
        :alt="`${project.title} - Image ${currentIndex + 1}`"
        class="w-full h-full object-cover transition-opacity duration-300"
        @error="handleImageError"
      />
      
      <!-- Navigation Arrows (show only if multiple images) -->
      <template v-if="images.length > 1">
        <button
          @click="previousImage"
          class="absolute left-2 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-200 hover:bg-opacity-70"
          aria-label="Previous image"
        >
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
          </svg>
        </button>
        
        <button
          @click="nextImage"
          class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-200 hover:bg-opacity-70"
          aria-label="Next image"
        >
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
          </svg>
        </button>
      </template>
      
      <!-- Image Counter -->
      <div v-if="images.length > 1" class="absolute top-2 right-2 bg-black bg-opacity-50 text-white px-2 py-1 rounded text-sm">
        {{ currentIndex + 1 }} / {{ images.length }}
      </div>
      
      <!-- Dot Indicators (show only if multiple images) -->
      <div v-if="images.length > 1" class="absolute bottom-2 left-1/2 transform -translate-x-1/2 flex space-x-2">
        <button
          v-for="(image, index) in images"
          :key="image.id"
          @click="goToImage(index)"
          :class="[
            'w-2 h-2 rounded-full transition-all duration-200',
            index === currentIndex ? 'bg-white' : 'bg-white bg-opacity-50 hover:bg-opacity-75'
          ]"
          :aria-label="`Go to image ${index + 1}`"
        ></button>
      </div>
    </div>
    
    <!-- Placeholder when no images -->
    <div v-else class="flex items-center justify-center w-full h-full bg-gray-200">
      <div class="text-center text-gray-500">
        <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
        </svg>
        <p class="text-sm">No images available</p>
      </div>
    </div>
  </div>
</template> 