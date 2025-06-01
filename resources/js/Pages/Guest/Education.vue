<script setup>
import { Head } from '@inertiajs/vue3'
import GuestLayout from '@/Layouts/GuestLayout.vue'
import EducationTimeline from '@/Components/guest/education/EducationTimeline.vue'
import { Card, CardContent, CardHeader, CardTitle } from '@/components'

defineProps({
  education: {
    type: Array,
    required: true
  }
})
</script>

<template>
  <Head title="Education" />

  <GuestLayout>
    <div class="container py-12">
      <Card>
        <CardHeader>
          <CardTitle class="text-2xl font-bold tracking-tight">Education</CardTitle>
        </CardHeader>
        <CardContent class="pt-6">
          <EducationTimeline :education="education" />
        </CardContent>
      </Card>
    </div>
  </GuestLayout>
</template> 