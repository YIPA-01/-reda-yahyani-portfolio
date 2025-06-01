<script setup>
import { computed } from 'vue'
import { Card, CardContent } from '@/components'

const props = defineProps({
  education: {
    type: Array,
    required: true
  }
})

const visibleEducation = computed(() => {
  return props.education.filter(item => item.is_visible)
})

function formatDate(date) {
  if (!date) return 'Present'
  return new Date(date).toLocaleDateString('en-US', { year: 'numeric', month: 'short' })
}
</script>

<template>
  <div class="space-y-8">
    <div v-for="(item, index) in visibleEducation" :key="item.id" class="relative">
      <!-- Timeline line -->
      <div
        v-if="index !== visibleEducation.length - 1"
        class="absolute left-[7px] top-[24px] h-full w-[2px] bg-border"
      />
      
      <!-- Timeline item -->
      <div class="flex gap-4">
        <!-- Timeline dot -->
        <div
          class="relative z-10 mt-1 h-4 w-4 rounded-full border-2 border-primary bg-background"
        />
        
        <!-- Content -->
        <Card class="flex-1">
          <CardContent class="p-6">
            <div class="flex flex-col gap-1">
              <!-- Header -->
              <div class="flex items-start justify-between">
                <div>
                  <h3 class="font-semibold text-foreground">{{ item.school }}</h3>
                  <p class="text-sm text-muted-foreground">{{ item.degree }} in {{ item.field }}</p>
                </div>
                <div class="text-sm text-muted-foreground">
                  {{ formatDate(item.start_date) }} - {{ formatDate(item.end_date) }}
                </div>
              </div>
              
              <!-- Description -->
              <p 
                v-if="item.description"
                class="mt-2 text-sm text-muted-foreground"
                v-html="item.description"
              />
            </div>
          </CardContent>
        </Card>
      </div>
    </div>
    
    <!-- Empty state -->
    <Card v-if="visibleEducation.length === 0">
      <CardContent class="p-6 text-center text-muted-foreground">
        No education history available.
      </CardContent>
    </Card>
  </div>
</template> 