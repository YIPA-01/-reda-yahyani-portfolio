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
    messages: {
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

const deleteMessage = (messageId) => {
    if (confirm('Are you sure you want to delete this message?')) {
        router.delete(route('admin.messages.destroy', messageId));
    }
};

const toggleRead = (message) => {
    router.put(route('admin.messages.toggleRead', message.id));
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
    <Head title="Messages Management" />

    <AdminLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold text-foreground">Messages Management</h2>
            </div>
        </template>

        <div class="container py-6">
            <Card>
                <CardHeader>
                    <CardTitle>Messages</CardTitle>
                </CardHeader>
                <CardContent>
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>Status</TableHead>
                                <TableHead>From</TableHead>
                                <TableHead>Message</TableHead>
                                <TableHead>Date</TableHead>
                                <TableHead class="text-right">Actions</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <TableRow 
                                v-for="message in messages" 
                                :key="message.id"
                                :class="{ 'bg-muted/50': !message.is_read }"
                            >
                                <TableCell>
                                    <Button
                                        size="sm"
                                        :variant="message.is_read ? 'ghost' : 'outline'"
                                        @click="toggleRead(message)"
                                    >
                                        {{ message.is_read ? 'Read' : 'Unread' }}
                                    </Button>
                                </TableCell>
                                <TableCell>
                                    <div>
                                        <div class="font-medium">{{ message.name }}</div>
                                        <div class="text-sm text-muted-foreground">
                                            {{ message.email }}
                                        </div>
                                    </div>
                                </TableCell>
                                <TableCell>
                                    <div class="max-w-md">
                                        <p class="truncate text-sm">{{ message.content }}</p>
                                    </div>
                                </TableCell>
                                <TableCell>
                                    <div class="text-sm text-muted-foreground">
                                        {{ formatDate(message.created_at) }}
                                    </div>
                                </TableCell>
                                <TableCell class="text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <Button
                                            variant="ghost"
                                            size="sm"
                                            :href="route('admin.messages.show', message.id)"
                                        >
                                            View
                                        </Button>
                                        <Button
                                            variant="destructive"
                                            size="sm"
                                            @click="deleteMessage(message.id)"
                                        >
                                            Delete
                                        </Button>
                                    </div>
                                </TableCell>
                            </TableRow>
                            <TableRow v-if="messages.length === 0">
                                <TableCell
                                    colspan="5"
                                    class="h-24 text-center text-muted-foreground"
                                >
                                    No messages found.
                                </TableCell>
                            </TableRow>
                        </TableBody>
                    </Table>
                </CardContent>
            </Card>
        </div>
    </AdminLayout>
</template> 