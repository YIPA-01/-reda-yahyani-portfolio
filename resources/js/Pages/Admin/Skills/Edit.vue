<script setup>
import { Head } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import SkillForm from './Form.vue';

defineProps({
    skill: {
        type: Object,
        required: true
    }
});
</script>

<template>
    <Head title="Edit Skill" />

    <AdminLayout>
        <template #header>
            <h2 class="text-xl font-semibold text-foreground">Edit Skill</h2>
        </template>

        <div class="container py-6">
            <SkillForm
                mode="edit"
                :skill="skill"
            />
        </div>
    </AdminLayout>
</template> 