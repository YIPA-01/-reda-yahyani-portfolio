<script setup>
import { useForm } from '@inertiajs/vue3';
import { Button, Label, Input, Textarea } from '@/components';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/Components/ui/dialog';
import { useToast } from '@/Composables/useToast';

const props = defineProps({
    triggerText: {
        type: String,
        default: 'Start a Conversation'
    },
    variant: {
        type: String,
        default: 'default'
    },
    size: {
        type: String,
        default: 'default'
    }
});

const { showSuccess, showError } = useToast();

const form = useForm({
    name: '',
    email: '',
    content: ''
});

const submit = () => {
    form.post(route('guest.contact.store'), {
        onSuccess: () => {
            form.reset();
            showSuccess('Message sent successfully! We will get back to you soon.');
        },
        onError: () => {
            showError('Failed to send message. Please try again.');
        }
    });
};
</script>

<template>
    <Dialog>
        <DialogTrigger asChild>
            <Button :variant="variant" :size="size">
                {{ triggerText }}
            </Button>
        </DialogTrigger>
        <DialogContent class="sm:max-w-[425px]">
            <DialogHeader>
                <DialogTitle>Send a Message</DialogTitle>
                <DialogDescription>
                    Send me a message and I'll get back to you as soon as possible.
                </DialogDescription>
            </DialogHeader>
            <form @submit.prevent="submit" class="space-y-6 mt-4">
                <div class="space-y-2">
                    <Label for="name">Name</Label>
                    <Input
                        id="name"
                        v-model="form.name"
                        type="text"
                        placeholder="Your name"
                        :class="{ 'border-destructive ring-destructive': form.errors.name }"
                    />
                    <p v-if="form.errors.name" class="text-sm text-destructive">
                        {{ form.errors.name }}
                    </p>
                </div>

                <div class="space-y-2">
                    <Label for="email">Email</Label>
                    <Input
                        id="email"
                        v-model="form.email"
                        type="email"
                        placeholder="your.email@example.com"
                        :class="{ 'border-destructive ring-destructive': form.errors.email }"
                    />
                    <p v-if="form.errors.email" class="text-sm text-destructive">
                        {{ form.errors.email }}
                    </p>
                </div>

                <div class="space-y-2">
                    <Label for="content">Message</Label>
                    <Textarea
                        id="content"
                        v-model="form.content"
                        placeholder="Your message..."
                        rows="4"
                        :class="{ 'border-destructive ring-destructive': form.errors.content }"
                    />
                    <p v-if="form.errors.content" class="text-sm text-destructive">
                        {{ form.errors.content }}
                    </p>
                </div>

                <div class="flex justify-end gap-3">
                    <DialogTrigger asChild>
                        <Button type="button" variant="outline">Cancel</Button>
                    </DialogTrigger>
                    <Button
                        type="submit"
                        :disabled="form.processing"
                    >
                        Send Message
                    </Button>
                </div>
            </form>
        </DialogContent>
    </Dialog>
</template> 