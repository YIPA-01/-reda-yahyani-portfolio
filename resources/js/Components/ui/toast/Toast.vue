<script setup>
import { computed } from 'vue'
import { ToastRoot, ToastClose } from 'radix-vue'
import { cn } from '@/lib/utils'
import { XIcon } from 'lucide-vue-next'

const props = defineProps({
  class: {
    type: String,
    default: ''
  },
  variant: {
    type: String,
    default: 'default',
    validator: (value) => ['default', 'destructive', 'success'].includes(value)
  }
})

const variantStyles = computed(() => {
  switch (props.variant) {
    case 'destructive':
      return 'destructive group border-destructive bg-destructive text-destructive-foreground'
    case 'success':
      return 'success group border-success bg-success text-success-foreground'
    default:
      return 'group border-border bg-background text-foreground'
  }
})
</script>

<template>
  <ToastRoot
    :class="cn(
      'fixed bottom-4 right-4 z-50 flex w-full max-w-md items-center gap-x-4 rounded-md border p-4 shadow-lg transition-all data-[state=open]:animate-in data-[state=closed]:animate-out data-[state=closed]:fade-out-0 data-[state=open]:fade-in-0 data-[state=closed]:slide-out-to-right-full data-[state=open]:slide-in-from-right-full',
      variantStyles,
      props.class
    )"
  >
    <div class="flex-1 space-y-1">
      <slot />
    </div>
    <ToastClose
      class="text-foreground/50 hover:text-foreground transition-colors"
    >
      <XIcon class="h-4 w-4" />
    </ToastClose>
  </ToastRoot>
</template> 