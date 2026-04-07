<template>
  <AuthenticatedLayout title="Intern Detail">
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">Intern: {{ intern.name }}</h2>
    </template>

    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-6">
        <!-- Intern Details -->
        <div class="bg-white shadow sm:rounded-md p-6">
          <h3 class="text-lg font-medium text-gray-900 mb-4">Details</h3>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
              <p class="text-gray-900">{{ intern.name }}</p>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
              <p class="text-gray-900">{{ intern.email }}</p>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Department</label>
              <p class="text-gray-900">{{ intern.department?.name ?? 'N/A' }}</p>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Total Reports</label>
              <p class="text-gray-900">{{ intern.reports_count ?? 0 }}</p>
            </div>
          </div>
        </div>

        <!-- Reports Table -->
        <div class="overflow-hidden bg-white shadow sm:rounded-md">
          <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Reports</h3>
          </div>
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="report in reports.data" :key="report.id" class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ report.title ?? 'No title' }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ new Date(report.created_at).toLocaleDateString() }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                    :class="{
                      'bg-green-100 text-green-800': report.status === 'approved',
                      'bg-yellow-100 text-yellow-800': report.status === 'pending',
                      'bg-red-100 text-red-800': report.status === 'rejected'
                    }">
                    {{ report.status }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                  <Link :href="route('supervisor.submissions.show', report.id)" class="text-indigo-600 hover:text-indigo-500">View</Link>
                </td>
              </tr>
            </tbody>
          </table>
          <div v-if="!reports.data?.length" class="p-8 text-center text-gray-500">No reports found for this intern.</div>
        </div>

        <!-- Pagination -->
        <div v-if="reports.links" class="mt-6 flex justify-center">
          <nav class="flex space-x-2">
            <Link v-for="link in reports.links" :key="link.label" :href="link.url ?? '#'" preserve-query v-html="link.label" class="px-3 py-2 text-sm rounded-md" :class="link.active ? 'bg-blue-500 text-white' : 'text-gray-500 hover:text-gray-700'" />
          </nav>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

defineProps({
  intern: Object,
  reports: Object,
})
</script>

