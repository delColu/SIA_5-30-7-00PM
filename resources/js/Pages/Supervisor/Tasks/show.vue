<template>
  <AuthenticatedLayout title="Task Details">
    <template #header>
      <div class="flex justify-between items-center">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">{{ task.title }}</h2>
        <Link :href="route('supervisor.tasks.index')" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">← Back to Tasks</Link>
      </div>
    </template>

    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-6">
        <div class="bg-white shadow sm:rounded-lg p-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Intern</label>
              <p class="text-lg font-medium text-gray-900">{{ task.user.name }}</p>
              <p class="text-sm text-gray-500 mt-1">{{ task.user.email }}</p>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Department</label>
              <p class="text-lg font-medium text-gray-900">{{ task.user.department?.name ?? 'N/A' }}</p>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
              <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full"
                :class="{
                  'bg-green-100 text-green-800': task.status === 'completed',
                  'bg-yellow-100 text-yellow-800': task.status === 'pending',
                  'bg-blue-100 text-blue-800': task.status === 'in_progress'
                }">
                {{ task.status }}
              </span>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Due Date</label>
              <p class="text-lg font-medium text-gray-900">{{ new Date(task.due_date).toLocaleDateString() }}</p>
            </div>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-4">Description</label>
            <div class="prose max-w-none bg-gray-50 p-4 rounded-lg">
              <p v-html="task.description || 'No description provided'"></p>
            </div>
          </div>

          <div v-if="task.supervisor_comments">
            <label class="block text-sm font-medium text-gray-700 mb-2 mt-6">Supervisor Comments</label>
            <div class="bg-blue-50 border border-blue-200 p-4 rounded-lg">
              <p class="text-gray-900">{{ task.supervisor_comments }}</p>
            </div>
          </div>
        </div>

        <div v-if="task.status !== 'completed'" class="bg-white shadow sm:rounded-lg p-6">
          <h3 class="text-lg font-medium text-gray-900 mb-4">Update Task</h3>
          <div class="flex space-x-4 mb-4">
            <form @submit.prevent="completeTask">
              <PrimaryButton type="submit">Mark Complete</PrimaryButton>
            </form>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Comments (optional)</label>
            <textarea v-model="form.comments" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { Link, useForm, router } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import DangerButton from '@/Components/DangerButton.vue'

const props = defineProps({
  task: Object,
})

const form = useForm({
  comments: '',
  status: 'completed'
})

const completeTask = () => {
  form.put(route('supervisor.tasks.update', props.task.id), {
    onSuccess: () => form.reset(),
  })
}
</script>

