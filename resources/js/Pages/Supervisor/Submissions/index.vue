<template>
  <AuthenticatedLayout title="Submissions">
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">Pending Submissions</h2>
    </template>

    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-8">
        <div>
          <h3 class="text-lg font-medium text-gray-900 mb-4">Pending Reports</h3>
          <div class="overflow-hidden bg-white shadow sm:rounded-md">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Intern</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">File</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="report in pendingReports.data" :key="report.id" class="hover:bg-gray-50">
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ report.user.name }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ report.report_type }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm">
                    <a v-if="report.file_path" :href="report.file_path" target="_blank" class="text-blue-600 hover:text-blue-500">View File</a>
                    <span v-else class="text-gray-400">No file</span>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm">
                    <Link :href="`/supervisor/submissions/${report.id}`" class="text-indigo-600 hover:text-indigo-500">View Submission</Link>
                  </td>
                </tr>
              </tbody>
            </table>
            <div v-if="pendingReports.data.length === 0" class="p-8 text-center text-gray-500">No pending reports.</div>
          </div>
        </div>

        <div>
          <h3 class="text-lg font-medium text-gray-900 mb-4">Pending Tasks</h3>
          <div class="overflow-hidden bg-white shadow sm:rounded-md">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Intern</th>
<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="task in pendingTasks.data" :key="task.id" class="hover:bg-gray-50">
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ task.title }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ task.user.name }}</td>
<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ task.due_date }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <Link :href="route('supervisor.tasks.show', task.id)" class="text-indigo-600 hover:text-indigo-500">View</Link>
                  </td>
                </tr>
              </tbody>
            </table>
            <div v-if="pendingTasks.data.length === 0" class="p-8 text-center text-gray-500">No pending tasks.</div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

defineProps({
  pendingReports: Object,
  pendingTasks: Object,
});
</script>

