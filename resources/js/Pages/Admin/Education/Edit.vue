<script setup>
import { Head } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import EducationForm from './Form.vue'

defineProps({
  education: {
    type: Object,
    required: true
  }
})
</script>

<template>
  <Head title="Edit Education" />

  <AdminLayout>
    <template #header>
      <h2 class="text-xl font-semibold text-foreground">Edit Education</h2>
    </template>

    <div class="container py-6">
      <EducationForm mode="edit" :education="education" />
    </div>
  </AdminLayout>
</template> 