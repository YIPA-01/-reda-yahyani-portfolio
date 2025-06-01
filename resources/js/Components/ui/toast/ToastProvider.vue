<script setup>
import { ToastViewport, ToastProvider as Provider } from 'radix-vue'
</script>

<template>
  <Provider>
    <slot />
    <ToastViewport class="fixed bottom-0 right-0 z-[100] flex flex-col gap-2 w-[390px] max-w-[100vw] p-4" />
  </Provider>
</template> 