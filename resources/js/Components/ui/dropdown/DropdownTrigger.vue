<script setup>
import { inject } from 'vue'
import { cn } from '@/lib/utils'

const isOpen = inject('isOpen')

defineProps({
  class: {
    type: String,
    default: '',
  },
})
</script>

<template>
  <div @click="isOpen.value = !isOpen.value" :class="cn('flex cursor-pointer items-center gap-1', $props.class)">
    <slot />
  </div>
</template> 