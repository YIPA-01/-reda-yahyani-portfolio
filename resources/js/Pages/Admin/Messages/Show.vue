<script setup>
import { Head, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Button } from '@/components.js';
import { Card, CardContent, CardHeader, CardTitle, CardFooter } from '@/components.js';

const props = defineProps({
    message: {
        type: Object,
        required: true
    }
});

const deleteMessage = () => {
    if (confirm('Are you sure you want to delete this message?')) {
        router.delete(route('admin.messages.destroy', props.message.id));
    }
};

const toggleRead = () => {
    router.put(route('admin.messages.toggleRead', props.message.id));
};

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
};
</script>

<template>
    <Head title="View Message" />

    <AdminLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold text-foreground">View Message</h2>
                <div class="flex items-center gap-2">
                    <Button
                        variant="outline"
                        :href="route('admin.messages.index')"
                    >
                        Back to Messages
                    </Button>
                </div>
            </div>
        </template>

        <div class="container py-6">
            <Card>
                <CardHeader>
                    <div class="flex items-center justify-between">
                        <div>
                            <CardTitle>Message from {{ message.name }}</CardTitle>
                            <p class="text-sm text-muted-foreground mt-1">
                                {{ message.email }}
                            </p>
                        </div>
                        <div class="flex items-center gap-2">
                            <Button
                                size="sm"
                                :variant="message.is_read ? 'ghost' : 'outline'"
                                @click="toggleRead"
                            >
                                {{ message.is_read ? 'Mark as Unread' : 'Mark as Read' }}
                            </Button>
                            <Button
                                variant="destructive"
                                size="sm"
                                @click="deleteMessage"
                            >
                                Delete
                            </Button>
                        </div>
                    </div>
                </CardHeader>
                <CardContent>
                    <div class="space-y-4">
                        <div class="text-sm text-muted-foreground">
                            Received on {{ formatDate(message.created_at) }}
                        </div>
                        <div class="prose prose-sm dark:prose-invert max-w-none">
                            <p class="whitespace-pre-wrap">{{ message.content }}</p>
                        </div>
                    </div>
                </CardContent>
                <CardFooter>
                    <div class="flex items-center gap-2">
                        <Button
                            variant="outline"
                            size="sm"
                            component="a"
                            :href="`mailto:${message.email}`"
                            target="_blank"
                        >
                            Reply via Email
                        </Button>
                    </div>
                </CardFooter>
            </Card>
        </div>
    </AdminLayout>
</template> 