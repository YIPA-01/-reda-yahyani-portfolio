<script setup>
import { Head, Link } from '@inertiajs/vue3'
import { ref } from 'vue'
import {
  Button,
  Card,
  CardContent,
  CardHeader,
  CardTitle,
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
  Switch
} from '@/components'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { useToast } from '@/Composables/useToast'

const props = defineProps({
  education: {
    type: Array,
    required: true
  },
  flash: {
    type: Object,
    default: () => ({})
  }
})

const toast = useToast()

if (props.flash.message) {
  toast.add({
    title: 'Success',
    description: props.flash.message,
    type: 'success'
  })
}

function deleteEducation(id) {
  if (confirm('Are you sure you want to delete this education entry?')) {
    router.delete(route('admin.education.destroy', id))
  }
}

function toggleVisibility(education) {
  router.put(route('admin.education.update', education.id), {
    ...education,
    is_visible: !education.is_visible
  })
}
</script>

<template>
  <Head title="Education Management" />

  <AdminLayout>
    <template #header>
      <h2 class="text-xl font-semibold text-foreground">Education Management</h2>
    </template>

    <div class="container py-6">
      <Card>
        <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
          <CardTitle class="text-sm font-medium">Education List</CardTitle>
          <Link :href="route('admin.education.create')">
            <Button>Add New Education</Button>
          </Link>
        </CardHeader>
        <CardContent>
          <Table>
            <TableHeader>
              <TableRow>
                <TableHead>School</TableHead>
                <TableHead>Degree</TableHead>
                <TableHead>Field</TableHead>
                <TableHead>Period</TableHead>
                <TableHead>Visible</TableHead>
                <TableHead class="text-right">Actions</TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              <TableRow v-if="education.length === 0">
                <TableCell colspan="6" class="text-center">No education entries found.</TableCell>
              </TableRow>
              <TableRow v-for="item in education" :key="item.id">
                <TableCell>{{ item.school }}</TableCell>
                <TableCell>{{ item.degree }}</TableCell>
                <TableCell>{{ item.field }}</TableCell>
                <TableCell>{{ item.start_date }} - {{ item.end_date || 'Present' }}</TableCell>
                <TableCell>
                  <Switch
                    :model-value="item.is_visible"
                    @update:model-value="toggleVisibility(item)"
                  />
                </TableCell>
                <TableCell class="text-right">
                  <div class="flex justify-end gap-2">
                    <Link :href="route('admin.education.edit', item.id)">
                      <Button variant="outline" size="sm">Edit</Button>
                    </Link>
                    <Button
                      variant="destructive"
                      size="sm"
                      @click="deleteEducation(item.id)"
                    >
                      Delete
                    </Button>
                  </div>
                </TableCell>
              </TableRow>
            </TableBody>
          </Table>
        </CardContent>
      </Card>
    </div>
  </AdminLayout>
</template> 