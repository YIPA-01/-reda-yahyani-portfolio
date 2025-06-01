<script setup>
import { useForm, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import {
    Button,
    Card,
    CardHeader,
    CardTitle,
    CardContent,
    CardFooter,
    Label,
    Input,
    Textarea,
    Switch
} from '@/components.js';

const props = defineProps({
    mode: {
        type: String,
        required: true,
        validator: (value) => ['create', 'edit'].includes(value)
    },
    project: {
        type: Object,
        default: () => ({
            title: '',
            description: '',
            technologies: [],
            is_visible: true,
            images: []
        })
    }
});

const form = useForm({
    title: props.project.title,
    description: props.project.description,
    technologies: props.project.technologies || [],
    is_visible: Boolean(props.project.is_visible),
    images: []
});

const newTechnology = ref('');

const addTechnology = () => {
    if (newTechnology.value.trim() && !form.technologies.includes(newTechnology.value.trim())) {
        form.technologies.push(newTechnology.value.trim());
        newTechnology.value = '';
    }
};

const removeTechnology = (index) => {
    form.technologies.splice(index, 1);
};

const handleImageSelection = (event) => {
    const files = Array.from(event.target.files);
    console.log('Selected files:', files);
    form.images = files;
};

const removeImage = (index) => {
    const newImages = Array.from(form.images);
    newImages.splice(index, 1);
    form.images = newImages;
};

const setMainImage = (imageId) => {
    if (props.mode === 'edit') {
        router.put(route('admin.projects.setMainImage', [props.project.id, imageId]), {}, {
            preserveState: true,
            onSuccess: () => {
                console.log('Main image updated');
            }
        });
    }
};

const deleteImage = (imageId) => {
    if (props.mode === 'edit' && confirm('Are you sure you want to delete this image?')) {
        router.delete(route('admin.projects.deleteImage', [props.project.id, imageId]), {
            preserveState: true,
            onSuccess: () => {
                console.log('Image deleted');
            }
        });
    }
};

const submit = () => {
    console.log('Submitting form with data:', {
        title: form.title,
        description: form.description,
        technologies: form.technologies,
        is_visible: form.is_visible,
        images: form.images,
        imageCount: form.images.length
    });

    // Log each image file details
    if (form.images.length > 0) {
        form.images.forEach((file, index) => {
            console.log(`Image ${index + 1}:`, {
                name: file.name,
                size: file.size,
                type: file.type
            });
        });
    }

    if (props.mode === 'create') {
        form.post(route('admin.projects.store'), {
            onSuccess: () => {
                console.log('Project created successfully');
            },
            onError: (errors) => {
                console.error('Form submission errors:', errors);
            }
        });
    } else {
        form.patch(route('admin.projects.update', props.project.id), {
            onSuccess: () => {
                console.log('Project updated successfully');
            },
            onError: (errors) => {
                console.error('Form submission errors:', errors);
            }
        });
    }
};
</script>

<template>
    <Card>
        <CardHeader>
            <CardTitle>{{ mode === 'create' ? 'Add New Project' : 'Edit Project' }}</CardTitle>
        </CardHeader>
        <form @submit.prevent="submit">
            <CardContent class="space-y-6">
                <!-- Title Input -->
                <div class="space-y-2">
                    <Label for="title">Title</Label>
                    <Input
                        id="title"
                        v-model="form.title"
                        type="text"
                        placeholder="Enter project title"
                        :class="{ 'border-destructive ring-destructive': form.errors.title }"
                    />
                    <p v-if="form.errors.title" class="text-sm text-destructive">
                        {{ form.errors.title }}
                    </p>
                </div>

                <!-- Description Input -->
                <div class="space-y-2">
                    <Label for="description">Description</Label>
                    <Textarea
                        id="description"
                        v-model="form.description"
                        placeholder="Enter project description"
                        rows="4"
                        :class="{ 'border-destructive ring-destructive': form.errors.description }"
                    />
                    <p v-if="form.errors.description" class="text-sm text-destructive">
                        {{ form.errors.description }}
                    </p>
                </div>

                <!-- Technologies Input -->
                <div class="space-y-4">
                    <Label>Technologies</Label>
                    <div class="flex gap-2">
                        <Input
                            v-model="newTechnology"
                            type="text"
                            placeholder="Add a technology"
                            @keyup.enter="addTechnology"
                            class="flex-1"
                        />
                        <Button
                            type="button"
                            variant="outline"
                            @click="addTechnology"
                        >
                            Add
                        </Button>
                    </div>
                    <div v-if="form.technologies.length > 0" class="flex flex-wrap gap-2">
                        <span
                            v-for="(tech, index) in form.technologies"
                            :key="index"
                            class="inline-flex items-center gap-1 rounded-full bg-primary/10 px-3 py-1 text-sm text-primary"
                        >
                            {{ tech }}
                            <button
                                type="button"
                                @click="removeTechnology(index)"
                                class="ml-1 hover:text-destructive"
                            >
                                ×
                            </button>
                        </span>
                    </div>
                    <p v-if="form.errors.technologies" class="text-sm text-destructive">
                        {{ form.errors.technologies }}
                    </p>
                </div>

                <!-- Images Upload -->
                <div class="space-y-4">
                    <Label for="images">Project Images</Label>
                    <Input
                        id="images"
                        type="file"
                        multiple
                        accept="image/*"
                        @change="handleImageSelection"
                        :class="{ 'border-destructive ring-destructive': form.errors.images }"
                    />
                    <p class="text-sm text-muted-foreground">
                        Select multiple images for your project. Supported formats: JPEG, PNG, JPG, GIF, SVG, WebP (max 2MB each)
                    </p>
                    
                    <!-- Image Preview -->
                    <div v-if="form.images.length > 0" class="space-y-2">
                        <Label>Selected Images ({{ form.images.length }})</Label>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            <div
                                v-for="(file, index) in form.images"
                                :key="index"
                                class="relative group"
                            >
                                <div class="aspect-video bg-muted rounded-lg flex items-center justify-center text-sm text-muted-foreground border-2 border-dashed">
                                    <div class="text-center p-2">
                                        <div class="font-medium truncate">{{ file.name }}</div>
                                        <div class="text-xs">{{ (file.size / 1024 / 1024).toFixed(2) }}MB</div>
                                    </div>
                                </div>
                                <Button
                                    type="button"
                                    variant="destructive"
                                    size="sm"
                                    class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity"
                                    @click="removeImage(index)"
                                >
                                    ×
                                </Button>
                            </div>
                        </div>
                    </div>

                    <!-- Existing Images (for edit mode) -->
                    <div v-if="mode === 'edit' && project.images?.length > 0" class="space-y-2">
                        <Label>Current Images</Label>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            <div
                                v-for="image in project.images"
                                :key="image.id"
                                class="relative group"
                            >
                                <img
                                    :src="image.url"
                                    :alt="project.title"
                                    class="aspect-video object-cover rounded-lg border"
                                />
                                <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg flex items-center justify-center">
                                    <div class="flex gap-2">
                                        <Button
                                            type="button"
                                            variant="secondary"
                                            size="sm"
                                            @click="setMainImage(image.id)"
                                        >
                                            {{ project.main_image_id === image.id ? 'Main' : 'Set Main' }}
                                        </Button>
                                        <Button
                                            type="button"
                                            variant="destructive"
                                            size="sm"
                                            @click="deleteImage(image.id)"
                                        >
                                            Delete
                                        </Button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <p v-if="form.errors.images" class="text-sm text-destructive">
                        {{ form.errors.images }}
                    </p>
                </div>

                <!-- Visibility Toggle -->
                <div class="space-y-4">
                    <div class="flex items-center justify-between space-x-2">
                        <div class="space-y-0.5">
                            <Label for="is_visible">Visibility</Label>
                            <p class="text-sm text-muted-foreground">
                                Make this project visible on your portfolio
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
                    {{ mode === 'create' ? 'Create Project' : 'Update Project' }}
                </Button>
            </CardFooter>
        </form>
    </Card>
</template> 