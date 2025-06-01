<script setup>
import { computed } from 'vue'

const props = defineProps({
  modelValue: {
    type: [String, Number],
    default: ''
  },
  disabled: {
    type: Boolean,
    default: false
  },
  placeholder: {
    type: String,
    default: ''
  },
  rows: {
    type: [String, Number],
    default: 4
  }
})

const emit = defineEmits(['update:modelValue'])

const classes = computed(() => {
  return [
    'flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50',
  ]
})

const updateValue = (event) => {
  emit('update:modelValue', event.target.value)
}
</script>

<template>
  <textarea
    :value="modelValue"
    :disabled="disabled"
    :placeholder="placeholder"
    :rows="rows"
    :class="classes"
    @input="updateValue"
  />
</template>