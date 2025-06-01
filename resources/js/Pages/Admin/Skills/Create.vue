<script setup>
import { Head } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import SkillForm from './Form.vue';
</script>

<template>
    <Head title="Create Skill" />

    <AdminLayout>
        <template #header>
            <h2 class="text-xl font-semibold text-foreground">Create Skill</h2>
        </template>

        <div class="container py-6">
            <SkillForm mode="create" />
        </div>
    </AdminLayout>
</template> 