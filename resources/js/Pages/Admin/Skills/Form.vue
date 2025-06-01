<script setup>
import { useForm } from '@inertiajs/vue3';
import {
    Button,
    Card,
    CardHeader,
    CardTitle,
    CardContent,
    CardFooter,
    Label,
    Input,
    Switch,
    SkillLevel
} from '@/components';

const props = defineProps({
    mode: {
        type: String,
        required: true,
        validator: (value) => ['create', 'edit'].includes(value)
    },
    skill: {
        type: Object,
        default: () => ({
            name: '',
            level: '',
            is_visible: true
        })
    }
});

const form = useForm({
    name: props.skill.name,
    level: String(props.skill.level || ''),
    is_visible: Boolean(props.skill.is_visible)
});

const submit = () => {
    if (props.mode === 'create') {
        form.post(route('admin.skills.store'));
    } else {
        form.put(route('admin.skills.update', props.skill.id));
    }
};
</script>

<template>
    <Card>
        <CardHeader>
            <CardTitle>{{ mode === 'create' ? 'Add New Skill' : 'Edit Skill' }}</CardTitle>
        </CardHeader>
        <form @submit.prevent="submit">
            <CardContent class="space-y-6">
                <!-- Name Input -->
                <div class="space-y-2">
                    <Label for="name">Name</Label>
                    <Input
                        id="name"
                        v-model="form.name"
                        type="text"
                        placeholder="Enter skill name"
                        :class="{ 'border-destructive ring-destructive': form.errors.name }"
                    />
                    <p v-if="form.errors.name" class="text-sm text-destructive">
                        {{ form.errors.name }}
                    </p>
                </div>

                <!-- Level Input -->
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <Label for="level">Level</Label>
                        <span class="text-sm text-muted-foreground">{{ form.level }}%</span>
                    </div>
                    <div class="grid gap-4">
                        <Input
                            id="level"
                            v-model="form.level"
                            type="text"
                            inputmode="numeric"
                            pattern="[0-9]*"
                            placeholder="Enter skill level (0-100)"
                            :class="{ 'ring-destructive': form.errors.level }"
                        />
                        <SkillLevel :level="Number(form.level) || 0" className="w-full" />
                    </div>
                    <p v-if="form.errors.level" class="text-sm text-destructive">
                        {{ form.errors.level }}
                    </p>
                </div>

                <!-- Visibility Toggle -->
                <div class="space-y-4">
                    <div class="flex items-center justify-between space-x-2">
                        <div class="space-y-0.5">
                            <Label for="is_visible">Visibility</Label>
                            <p class="text-sm text-muted-foreground">
                                Make this skill visible on your portfolio
                            </p>
                        </div>
                        <Switch
                            id="is_visible"
                            v-model="form.is_visible"
                            :class="{ 'ring-destructive': form.errors.is_visible }"
                        />
                    </div>
                    <p v-if="form.errors.is_visible" class="text-sm text-destructive">
                        {{ form.errors.is_visible }}
                    </p>
                </div>
            </CardContent>

            <CardFooter class="flex justify-end space-x-2">
                <Button
                    type="submit"
                    :disabled="form.processing"
                >
                    {{ mode === 'create' ? 'Create Skill' : 'Update Skill' }}
                </Button>
            </CardFooter>
        </form>
    </Card>
</template> 