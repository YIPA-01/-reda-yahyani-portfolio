<script setup>
import { ref, onMounted, onUnmounted, nextTick } from 'vue'
import { cn } from '@/lib/utils'

const props = defineProps({
  align: {
    type: String,
    default: 'right',
    validator: (value) => ['left', 'right'].includes(value),
  },
  width: {
    type: String,
    default: '48',
  },
  contentClass: {
    type: String,
    default: '',
  },
})

const emit = defineEmits(['close'])

const open = ref(false)
const trigger = ref(null)
const content = ref(null)

const closeOnEscape = (e) => {
  if (open.value && e.key === 'Escape') {
    open.value = false
    emit('close')
  }
}

const closeOnClickOutside = (e) => {
  if (!trigger.value || !content.value) return

  if (
    !trigger.value.contains(e.target) &&
    !content.value.contains(e.target)
  ) {
    open.value = false
    emit('close')
  }
}

onMounted(() => {
  document.addEventListener('keydown', closeOnEscape)
  document.addEventListener('click', closeOnClickOutside)
})

onUnmounted(() => {
  document.removeEventListener('keydown', closeOnEscape)
  document.removeEventListener('click', closeOnClickOutside)
})

const toggleContent = async () => {
  open.value = !open.value

  if (!open.value) {
    emit('close')
  }

  await nextTick()

  if (content.value && trigger.value) {
    const rect = trigger.value.getBoundingClientRect()
    content.value.style.top = `${rect.bottom + window.scrollY}px`
    content.value.style.left = props.align === 'left'
      ? `${rect.left}px`
      : `${rect.right - content.value.offsetWidth}px`
  }
}
</script>

<template>
  <div class="relative">
    <div ref="trigger" @click="toggleContent">
      <slot name="trigger" />
    </div>

    <Teleport to="body">
      <div
        v-show="open"
        ref="content"
        :class="[
          'fixed z-50',
          `w-${props.width}`,
          'rounded-md border bg-popover p-1 text-popover-foreground shadow-md outline-none',
          contentClass,
        ]"
        style="position: absolute;"
      >
        <slot />
      </div>
    </Teleport>
  </div>
</template> 