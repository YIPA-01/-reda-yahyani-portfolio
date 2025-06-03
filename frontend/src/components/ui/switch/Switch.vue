<script setup>
import { computed } from 'vue'
import { cn } from '@/lib/utils'

const props = defineProps({
    modelValue: {
        type: Boolean,
        required: true
    },
    className: {
        type: String,
        default: ''
    }
})

const emit = defineEmits(['update:modelValue'])

const checked = computed({
    get: () => props.modelValue,
    set: (value) => emit('update:modelValue', value)
})
</script>

<template>
    <button
        type="button"
        role="switch"
        :aria-checked="checked"
        @click="checked = !checked"
        :class="cn(
            'peer inline-flex h-6 w-11 shrink-0 cursor-pointer items-center rounded-full border-2 border-transparent transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:ring-offset-background disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-primary data-[state=unchecked]:bg-input',
            className
        )"
        :data-state="checked ? 'checked' : 'unchecked'"
        v-bind="$attrs"
    >
        <span
            :class="cn(
                'pointer-events-none block h-5 w-5 rounded-full bg-background shadow-lg ring-0 transition-transform data-[state=checked]:translate-x-5 data-[state=unchecked]:translate-x-0'
            )"
            :data-state="checked ? 'checked' : 'unchecked'"
        />
    </button>
</template> 