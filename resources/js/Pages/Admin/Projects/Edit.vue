<script setup>
import { Head } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import ProjectForm from './Form.vue';

defineProps({
    project: {
        type: Object,
        required: true
    }
});
</script>

<template>
    <Head title="Edit Project" />

    <AdminLayout>
        <template #header>
            <h2 class="text-xl font-semibold text-foreground">Edit Project</h2>
        </template>

        <div class="container py-6">
            <ProjectForm
                mode="edit"
                :project="project"
            />
        </div>
    </AdminLayout>
</template> 