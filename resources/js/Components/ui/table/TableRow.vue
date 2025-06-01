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
    <tr :class="cn('border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted', className)">
        <slot />
    </tr>
</template> 