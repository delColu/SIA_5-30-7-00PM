<template>
  <AuthenticatedLayout title="Submission Details">
    <template #header>
      <div class="flex justify-between items-center">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">Submission Details</h2>
        <Link :href="route('supervisor.submissions.index')" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">← Back to Submissions</Link>
      </div>
    </template>

    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-6">
        <div class="bg-white shadow sm:rounded-lg p-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Intern</label>
              <p class="text-lg font-medium text-gray-900">{{ report.user.name }}</p>
              <p class="text-sm text-gray-500 mt-1">{{ report.user.email }}</p>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Report Type</label>
              <p class="text-lg font-medium text-gray-900">{{ report.report_type }}</p>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
              <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                {{ report.status }}
              </span>
            </div>
            <div v-if="report.file_path">
              <label class="block text-sm font-medium text-gray-700 mb-2">File</label>
              <a :href="report.file_path" target="_blank" class="text-blue-600 hover:text-blue-500 font-medium">View File</a>
            </div>
          </div>

          <div v-if="report.content">
            <label class="block text-sm font-medium text-gray-700 mb-4">Content</label>
            <div class="prose max-w-none bg-gray-50 p-4 rounded-lg">
              <p v-html="report.content"></p>
            </div>
          </div>

          <div v-if="report.supervisor_comments">
            <label class="block text-sm font-medium text-gray-700 mb-2 mt-6">Supervisor Comments</label>
            <div class="bg-blue-50 border border-blue-200 p-4 rounded-lg">
              <p class="text-gray-900">{{ report.supervisor_comments }}</p>
            </div>
          </div>
        </div>

        <div v-if="report.status === 'pending'" class="bg-white shadow sm:rounded-lg p-6">
          <h3 class="text-lg font-medium text-gray-900 mb-4">Review Actions</h3>
          <div class="flex space-x-4">
            <form @submit.prevent="approveReport">
              <PrimaryButton type="submit" class="mr-3">Approve</PrimaryButton>
            </form>
            <form @submit.prevent="rejectReport">
              <DangerButton type="submit">Reject</DangerButton>
            </form>
          </div>
          <div class="mt-4">
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
  report: Object,
})

const form = useForm({
  comments: '',
})

const approveReport = () => {
  form.status = 'approved'
  form.post(route('supervisor.submissions.update', props.report.id), {
    onSuccess: () => form.reset(),
  })
}

const rejectReport = () => {
  form.status = 'rejected'
  form.post(route('supervisor.submissions.update', props.report.id), {
    onSuccess: () => form.reset(),
  })
}
</script>
