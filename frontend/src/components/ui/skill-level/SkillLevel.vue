<script setup>
import { computed } from 'vue';
import { cn } from '@/lib/utils';

const props = defineProps({
    level: {
        type: Number,
        required: true,
        validator: (value) => value >= 0 && value <= 100
    },
    className: {
        type: String,
        default: ''
    }
});

const levelColor = computed(() => {
    if (props.level < 30) return 'bg-red-500';
    if (props.level < 60) return 'bg-yellow-500';
    if (props.level < 80) return 'bg-blue-500';
    return 'bg-green-500';
});
</script>

<template>
    <div :class="cn('flex items-center gap-4', className)">
        <div class="flex-1 h-2 bg-muted rounded-full overflow-hidden">
            <div
                class="h-full transition-all duration-300 ease-in-out rounded-full"
                :class="levelColor"
                :style="{ width: `${level}%` }"
            />
        </div>
        <span class="text-sm text-muted-foreground w-12">{{ level }}%</span>
    </div>
</template> 