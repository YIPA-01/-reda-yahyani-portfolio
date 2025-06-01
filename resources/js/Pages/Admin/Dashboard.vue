<script setup>
import { Head } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Link } from '@inertiajs/vue3';
import { formatDistanceToNow } from 'date-fns';
import {
    Card,
    CardHeader,
    CardTitle,
    CardDescription,
    CardContent,
    CardFooter
} from '@/components';

defineProps({
    stats: {
        type: Object,
        required: true
    },
    recentMessages: {
        type: Array,
        required: true
    }
});
</script>

<template>
    <Head title="Admin Dashboard" />

    <AdminLayout>
        <template #header>
            <h2 class="text-2xl font-semibold leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
                <!-- Stats Grid -->
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
                    <!-- Skills Stats -->
                    <Card>
                        <CardHeader>
                            <CardTitle>Skills</CardTitle>
                            <CardDescription>Manage your skills</CardDescription>
                        </CardHeader>
                        <CardContent>
                            <div class="space-y-1">
                                <p class="text-sm text-muted-foreground">Total: {{ stats.skills.total }}</p>
                                <p class="text-sm text-muted-foreground">Visible: {{ stats.skills.visible }}</p>
                            </div>
                        </CardContent>
                        <CardFooter>
                            <Link
                                :href="route('admin.skills.index')"
                                class="text-sm text-primary hover:text-primary/80"
                            >
                                Manage Skills →
                            </Link>
                        </CardFooter>
                    </Card>

                    <!-- Education Stats -->
                    <Card>
                        <CardHeader>
                            <CardTitle>Education</CardTitle>
                            <CardDescription>Manage your education</CardDescription>
                        </CardHeader>
                        <CardContent>
                            <div class="space-y-1">
                                <p class="text-sm text-muted-foreground">Total: {{ stats.education.total }}</p>
                                <p class="text-sm text-muted-foreground">Visible: {{ stats.education.visible }}</p>
                            </div>
                        </CardContent>
                        <CardFooter>
                            <Link
                                :href="route('admin.education.index')"
                                class="text-sm text-primary hover:text-primary/80"
                            >
                                Manage Education →
                            </Link>
                        </CardFooter>
                    </Card>

                    <!-- Projects Stats -->
                    <Card>
                        <CardHeader>
                            <CardTitle>Projects</CardTitle>
                            <CardDescription>Manage your projects</CardDescription>
                        </CardHeader>
                        <CardContent>
                            <div class="space-y-1">
                                <p class="text-sm text-muted-foreground">Total: {{ stats.projects.total }}</p>
                                <p class="text-sm text-muted-foreground">Visible: {{ stats.projects.visible }}</p>
                            </div>
                        </CardContent>
                        <CardFooter>
                            <Link
                                :href="route('admin.projects.index')"
                                class="text-sm text-primary hover:text-primary/80"
                            >
                                Manage Projects →
                            </Link>
                        </CardFooter>
                    </Card>

                    <!-- Messages Stats -->
                    <Card>
                        <CardHeader>
                            <CardTitle>Messages</CardTitle>
                            <CardDescription>View your messages</CardDescription>
                        </CardHeader>
                        <CardContent>
                            <div class="space-y-1">
                                <p class="text-sm text-muted-foreground">Total: {{ stats.messages.total }}</p>
                                <p class="text-sm text-muted-foreground">Unread: {{ stats.messages.unread }}</p>
                            </div>
                        </CardContent>
                        <CardFooter>
                            <Link
                                :href="route('admin.messages.index')"
                                class="text-sm text-primary hover:text-primary/80"
                            >
                                View All Messages →
                            </Link>
                        </CardFooter>
                    </Card>
                </div>

                <!-- Recent Messages -->
                <Card>
                    <CardHeader>
                        <div class="flex items-center justify-between">
                            <div>
                                <CardTitle>Recent Messages</CardTitle>
                                <CardDescription>Your latest messages</CardDescription>
                            </div>
                            <Link
                                v-if="recentMessages.length"
                                :href="route('admin.messages.index')"
                                class="text-sm text-primary hover:text-primary/80"
                            >
                                View All →
                            </Link>
                        </div>
                    </CardHeader>
                    <CardContent>
                        <div v-if="recentMessages.length" class="space-y-4">
                            <div
                                v-for="message in recentMessages"
                                :key="message.id"
                                class="border-b pb-4 last:border-0 last:pb-0"
                            >
                                <div class="flex items-start justify-between">
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <h4 class="font-medium">
                                                {{ message.name }}
                                            </h4>
                                            <span
                                                v-if="!message.is_read"
                                                class="inline-flex items-center rounded-full bg-primary/10 px-2 py-0.5 text-xs font-medium text-primary"
                                            >
                                                New
                                            </span>
                                        </div>
                                        <p class="text-sm text-muted-foreground">{{ message.email }}</p>
                                    </div>
                                    <Link
                                        :href="route('admin.messages.show', message.id)"
                                        class="text-sm text-primary hover:text-primary/80"
                                    >
                                        View →
                                    </Link>
                                </div>
                                <p class="mt-2 line-clamp-2 text-sm text-muted-foreground">
                                    {{ message.content }}
                                </p>
                                <p class="mt-1 text-xs text-muted-foreground">
                                    {{ formatDistanceToNow(new Date(message.created_at), { addSuffix: true }) }}
                                </p>
                            </div>
                        </div>
                        <p
                            v-else
                            class="py-4 text-center text-sm text-muted-foreground"
                        >
                            No messages yet.
                        </p>
                    </CardContent>
                </Card>
            </div>
        </div>
    </AdminLayout>
</template> 