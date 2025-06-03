<script setup>
import { cn } from '@/lib/utils';

const props = defineProps({
    className: {
        type: String,
        default: ''
    }
});
</script>

<template>
    <tbody :class="cn('[&_tr:last-child]:border-0', className)">
        <slot />
    </tbody>
</template> 