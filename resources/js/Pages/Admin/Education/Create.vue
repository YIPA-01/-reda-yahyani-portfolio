<script setup>
import { Head } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import EducationForm from './Form.vue'
</script>

<template>
  <Head title="Create Education" />

  <AdminLayout>
    <template #header>
      <h2 class="text-xl font-semibold text-foreground">Create Education</h2>
    </template>

    <div class="container py-6">
      <EducationForm mode="create" />
    </div>
  </AdminLayout>
</template> 