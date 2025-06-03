<script setup>
import { DialogTrigger as DialogTriggerPrimitive } from 'radix-vue'

defineProps({
  ...DialogTriggerPrimitive.props
})
</script>

<template>
  <DialogTriggerPrimitive v-bind="$props">
    <slot />
  </DialogTriggerPrimitive>
</template> 