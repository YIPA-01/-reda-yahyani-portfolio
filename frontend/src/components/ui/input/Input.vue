<script setup>
import { computed } from 'vue'
import { cn } from '@/lib/utils'

const props = defineProps({
    type: {
        type: String,
        default: 'text'
    },
    modelValue: {
        type: [String, Number],
        default: ''
    },
    className: {
        type: String,
        default: ''
    }
})

const emit = defineEmits(['update:modelValue'])

const baseStyles = computed(() => {
    if (props.type === 'range') {
        return 'h-2 w-full cursor-pointer appearance-none rounded-lg bg-input accent-primary focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2'
    }
    
    return 'flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50'
})

const value = computed({
    get: () => props.modelValue,
    set: (val) => {
        if (props.type === 'number' || props.type === 'range') {
            emit('update:modelValue', Number(val))
        } else {
            emit('update:modelValue', val)
        }
    }
})
</script>

<template>
    <input
        :type="type"
        :value="value"
        @input="value = $event.target.value"
        :class="cn(baseStyles, className)"
        v-bind="$attrs"
    />
</template> 