<script setup>
import { computed, inject } from 'vue'
import { cn } from '@/lib/utils'

const isOpen = inject('isOpen')

const props = defineProps({
  align: {
    type: String,
    default: 'start',
    validator: (value) => ['start', 'end', 'center'].includes(value),
  },
  class: {
    type: String,
    default: '',
  },
})

const alignmentClasses = computed(() => {
  return {
    'right-0': props.align === 'end',
    'left-0': props.align === 'start',
    'left-1/2 -translate-x-1/2': props.align === 'center',
  }
})
</script>

<template>
  <div v-if="isOpen" :class="[cn('dropdown-content', alignmentClasses, props.class)]">
    <slot />
  </div>
</template> 