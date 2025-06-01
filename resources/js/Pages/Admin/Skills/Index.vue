<script setup>
import { Head, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref } from 'vue';
import { useToast } from '@/Composables/useToast';
import { Button, SkillLevel } from '@/components';
import { Card, CardContent, CardHeader, CardTitle } from '@/components';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components';

const props = defineProps({
    skills: {
        type: Array,
        required: true
    },
    flash: {
        type: Object,
        default: () => ({})
    }
});

const { showToast } = useToast();

// Show toast message if exists
if (props.flash?.message) {
    showToast(props.flash.message);
}

const deleteSkill = (skillId) => {
    if (confirm('Are you sure you want to delete this skill?')) {
        router.delete(route('admin.skills.destroy', skillId));
    }
};

const toggleVisibility = (skill) => {
    router.put(route('admin.skills.update', skill.id), {
        ...skill,
        is_visible: !skill.is_visible
    });
};
</script>

<template>
    <Head title="Skills Management" />

    <AdminLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold text-foreground">Skills Management</h2>
                <Button :href="route('admin.skills.create')">
                    Add New Skill
                </Button>
            </div>
        </template>

        <div class="container py-6">
            <Card>
                <CardHeader>
                    <CardTitle>Skills</CardTitle>
                </CardHeader>
                <CardContent>
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>Name</TableHead>
                                <TableHead>Level</TableHead>
                                <TableHead>Visibility</TableHead>
                                <TableHead class="text-right">Actions</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <TableRow v-for="skill in skills" :key="skill.id">
                                <TableCell>{{ skill.name }}</TableCell>
                                <TableCell>
                                    <SkillLevel :level="skill.level" />
                                </TableCell>
                                <TableCell>
                                    <Button
                                        size="sm"
                                        :variant="skill.is_visible ? 'outline' : 'ghost'"
                                        @click="toggleVisibility(skill)"
                                    >
                                        {{ skill.is_visible ? 'Visible' : 'Hidden' }}
                                    </Button>
                                </TableCell>
                                <TableCell class="text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <Button
                                            variant="ghost"
                                            size="sm"
                                            :href="route('admin.skills.edit', skill.id)"
                                        >
                                            Edit
                                        </Button>
                                        <Button
                                            variant="destructive"
                                            size="sm"
                                            @click="deleteSkill(skill.id)"
                                        >
                                            Delete
                                        </Button>
                                    </div>
                                </TableCell>
                            </TableRow>
                            <TableRow v-if="skills.length === 0">
                                <TableCell
                                    colspan="4"
                                    class="h-24 text-center text-muted-foreground"
                                >
                                    No skills found. Start by adding a new skill.
                                </TableCell>
                            </TableRow>
                        </TableBody>
                    </Table>
                </CardContent>
            </Card>
        </div>
    </AdminLayout>
</template> 