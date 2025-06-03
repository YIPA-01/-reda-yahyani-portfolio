<script setup>
import { DialogRoot } from 'radix-vue'

defineProps({
  ...DialogRoot.props
})
</script>

<template>
  <DialogRoot v-bind="$props">
    <slot />
  </DialogRoot>
</template> 