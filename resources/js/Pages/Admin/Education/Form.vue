<script setup>
import { useForm } from '@inertiajs/vue3'
import {
  Button,
  Card,
  CardContent,
  CardFooter,
  CardHeader,
  CardTitle,
  Input,
  Label,
  Switch
} from '@/components'

const props = defineProps({
  mode: {
    type: String,
    required: true,
    validator: value => ['create', 'edit'].includes(value)
  },
  education: {
    type: Object,
    default: () => ({
      school: '',
      degree: '',
      field: '',
      start_date: '',
      end_date: '',
      description: '',
      is_visible: true
    })
  }
})

const form = useForm({
  school: props.education.school,
  degree: props.education.degree,
  field: props.education.field,
  start_date: props.education.start_date,
  end_date: props.education.end_date,
  description: props.education.description,
  is_visible: props.education.is_visible
})

function submit() {
  if (props.mode === 'create') {
    form.post(route('admin.education.store'))
  } else {
    form.put(route('admin.education.update', props.education.id))
  }
}
</script>

<template>
  <Card>
    <CardHeader>
      <CardTitle>{{ mode === 'create' ? 'Add New Education' : 'Edit Education' }}</CardTitle>
    </CardHeader>
    <CardContent>
      <form @submit.prevent="submit" class="space-y-4">
        <div>
          <Label for="school">School</Label>
          <Input
            id="school"
            v-model="form.school"
            type="text"
            placeholder="Enter school name"
            :error="form.errors.school"
          />
          <span v-if="form.errors.school" class="text-sm text-destructive">{{ form.errors.school }}</span>
        </div>

        <div>
          <Label for="degree">Degree</Label>
          <Input
            id="degree"
            v-model="form.degree"
            type="text"
            placeholder="Enter degree"
            :error="form.errors.degree"
          />
          <span v-if="form.errors.degree" class="text-sm text-destructive">{{ form.errors.degree }}</span>
        </div>

        <div>
          <Label for="field">Field of Study</Label>
          <Input
            id="field"
            v-model="form.field"
            type="text"
            placeholder="Enter field of study"
            :error="form.errors.field"
          />
          <span v-if="form.errors.field" class="text-sm text-destructive">{{ form.errors.field }}</span>
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div>
            <Label for="start_date">Start Date</Label>
            <Input
              id="start_date"
              v-model="form.start_date"
              type="date"
              :error="form.errors.start_date"
            />
            <span v-if="form.errors.start_date" class="text-sm text-destructive">{{ form.errors.start_date }}</span>
          </div>

          <div>
            <Label for="end_date">End Date</Label>
            <Input
              id="end_date"
              v-model="form.end_date"
              type="date"
              :error="form.errors.end_date"
            />
            <span v-if="form.errors.end_date" class="text-sm text-destructive">{{ form.errors.end_date }}</span>
          </div>
        </div>

        <div>
          <Label for="description">Description</Label>
          <textarea
            id="description"
            v-model="form.description"
            rows="4"
            class="w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
            placeholder="Enter education description"
            :class="{ 'border-destructive': form.errors.description }"
          />
          <span v-if="form.errors.description" class="text-sm text-destructive">{{ form.errors.description }}</span>
        </div>

        <div class="flex items-center space-x-2">
          <Switch id="is_visible" v-model="form.is_visible" />
          <Label for="is_visible">Visible</Label>
        </div>
      </form>
    </CardContent>
    <CardFooter class="flex justify-end">
      <Button type="submit" @click="submit" :disabled="form.processing">
        {{ mode === 'create' ? 'Create Education' : 'Update Education' }}
      </Button>
    </CardFooter>
  </Card>
</template> 