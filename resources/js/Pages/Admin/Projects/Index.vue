<script setup>
import { Head, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref } from 'vue';
import { useToast } from '@/Composables/useToast';
import { Button } from '@/components.js';
import { Card, CardContent, CardHeader, CardTitle } from '@/components.js';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components.js';

const props = defineProps({
    projects: {
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

const deleteProject = (projectId) => {
    if (confirm('Are you sure you want to delete this project?')) {
        router.delete(route('admin.projects.destroy', projectId));
    }
};

const toggleVisibility = (project) => {
    router.put(route('admin.projects.update', project.id), {
        ...project,
        is_visible: !project.is_visible
    });
};
</script>

<template>
    <Head title="Projects Management" />

    <AdminLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold text-foreground">Projects Management</h2>
                <Button :href="route('admin.projects.create')">
                    Add New Project
                </Button>
            </div>
        </template>

        <div class="container py-6">
            <Card>
                <CardHeader>
                    <CardTitle>Projects</CardTitle>
                </CardHeader>
                <CardContent>
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>Title</TableHead>
                                <TableHead>Technologies</TableHead>
                                <TableHead>Images</TableHead>
                                <TableHead>Visibility</TableHead>
                                <TableHead class="text-right">Actions</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <TableRow v-for="project in projects" :key="project.id">
                                <TableCell>
                                    <div>
                                        <div class="font-medium">{{ project.title }}</div>
                                        <div class="text-sm text-muted-foreground truncate max-w-xs">
                                            {{ project.description }}
                                        </div>
                                    </div>
                                </TableCell>
                                <TableCell>
                                    <div class="flex flex-wrap gap-1">
                                        <span 
                                            v-for="tech in project.technologies?.slice(0, 3)" 
                                            :key="tech"
                                            class="inline-flex items-center rounded-full bg-primary/10 px-2 py-1 text-xs text-primary"
                                        >
                                            {{ tech }}
                                        </span>
                                        <span 
                                            v-if="project.technologies?.length > 3"
                                            class="inline-flex items-center rounded-full bg-muted px-2 py-1 text-xs text-muted-foreground"
                                        >
                                            +{{ project.technologies.length - 3 }}
                                        </span>
                                    </div>
                                </TableCell>
                                <TableCell>
                                    <div class="flex items-center gap-2">
                                        <div 
                                            v-if="project.images?.length > 0"
                                            class="flex -space-x-2"
                                        >
                                            <img 
                                                v-for="(image, index) in project.images.slice(0, 3)" 
                                                :key="image.id"
                                                :src="image.url" 
                                                :alt="`Project image ${index + 1}`"
                                                class="h-8 w-8 rounded-full border-2 border-background object-cover"
                                            />
                                        </div>
                                        <span class="text-sm text-muted-foreground">
                                            {{ project.images?.length || 0 }} image{{ project.images?.length !== 1 ? 's' : '' }}
                                        </span>
                                    </div>
                                </TableCell>
                                <TableCell>
                                    <Button
                                        size="sm"
                                        :variant="project.is_visible ? 'outline' : 'ghost'"
                                        @click="toggleVisibility(project)"
                                    >
                                        {{ project.is_visible ? 'Visible' : 'Hidden' }}
                                    </Button>
                                </TableCell>
                                <TableCell class="text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <Button
                                            variant="ghost"
                                            size="sm"
                                            :href="route('admin.projects.edit', project.id)"
                                        >
                                            Edit
                                        </Button>
                                        <Button
                                            variant="destructive"
                                            size="sm"
                                            @click="deleteProject(project.id)"
                                        >
                                            Delete
                                        </Button>
                                    </div>
                                </TableCell>
                            </TableRow>
                            <TableRow v-if="projects.length === 0">
                                <TableCell
                                    colspan="5"
                                    class="h-24 text-center text-muted-foreground"
                                >
                                    No projects found. Start by adding a new project.
                                </TableCell>
                            </TableRow>
                        </TableBody>
                    </Table>
                </CardContent>
            </Card>
        </div>
    </AdminLayout>
</template> 