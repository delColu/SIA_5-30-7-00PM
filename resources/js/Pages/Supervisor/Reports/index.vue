<template>
  <AuthenticatedLayout title="Reports">
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">Intern Reports</h2>
    </template>

    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-6">
        <!-- Filters -->
        <div class="bg-white shadow sm:rounded-md p-6">
          <h3 class="text-lg font-medium text-gray-900 mb-4">Filters</h3>
          <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
              <InputLabel for="status" value="Status" />
              <select v-model="form.status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                <option value="">All</option>
                <option value="pending">Pending</option>
                <option value="approved">Approved</option>
                <option value="rejected">Rejected</option>
              </select>
              <InputError class="mt-2" :message="form.errors.status" />
            </div>
            <div>
              <InputLabel for="report_type" value="Type" />
              <select v-model="form.report_type" id="report_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                <option value="">All</option>
                <option value="weekly">Weekly</option>
                <option value="monthly">Monthly</option>
                <option value="final">Final</option>
              </select>
              <InputError class="mt-2" :message="form.errors.report_type" />
            </div>
            <div>
              <InputLabel for="date_from" value="From Date" />
              <TextInput id="date_from" type="date" class="mt-1 block w-full" v-model="form.date_from" autocomplete="date_from" />
              <InputError class="mt-2" :message="form.errors.date_from" />
            </div>
            <div class="flex items-end space-x-2">
              <div class="flex-1">
                <InputLabel for="date_to" value="To Date" />
                <TextInput id="date_to" type="date" class="mt-1 block w-full" v-model="form.date_to" autocomplete="date_to" />
                <InputError class="mt-2" :message="form.errors.date_to" />
              </div>
              <PrimaryButton @click.prevent="submitFilters" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Filter
              </PrimaryButton>
            </div>
          </div>
        </div>

        <!-- Table -->
        <div class="overflow-hidden bg-white shadow sm:rounded-md">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Intern</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">File</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
              </tr>
            </thead>
<tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="report in reports?.data ?? []" :key="report.id" class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ report.user?.name ?? 'Unknown' }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ report.report_type }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full" :class="report.status === 'pending' ? 'bg-yellow-100 text-yellow-800' : report.status === 'approved' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'">{{ report.status }}</span>
                </td>
<td class="px-6 py-4 whitespace-nowrap text-sm">
                  <a v-if="report.file_path" :href="report.file_path" target="_blank" class="text-blue-600 hover:text-blue-500">View File</a>
                  <span v-else class="text-gray-400">No file</span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  <Link :href="route('supervisor.reports.show', report.id)" class="text-indigo-600 hover:text-indigo-500">View Details</Link>
                </td>
              </tr>
            </tbody>
          </table>
          <div v-if="(reports?.data ?? []).length === 0" class="p-8 text-center text-gray-500">No reports found.</div>
        </div>
        <div v-if="reports?.links?.length" class="mt-6 flex justify-center">
          <nav class="flex space-x-2">
            <Link v-for="link in reports.links" :key="link.label" :href="link.url ?? '#'" preserve-query v-html="link.label" class="px-3 py-2 text-sm rounded-md" :class="link.active ? 'bg-blue-500 text-white' : 'text-gray-500 hover:text-gray-700'" />
          </nav>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { Link, useForm, usePage } from '@inertiajs/vue3'
import { computed, watch } from 'vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import InputLabel from '@/Components/InputLabel.vue'
import TextInput from '@/Components/TextInput.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import InputError from '@/Components/InputError.vue'

const props = defineProps({
  reports: Object,
  query: {
    type: Object,
    default: () => ({})
  },
  flash: {
    type: Object,
    default: () => ({})
  },
})

const form = useForm({
  status: props.query?.status || '',
  report_type: props.query?.report_type || '',
  date_from: props.query?.date_from || '',
  date_to: props.query?.date_to || '',
})

const submitFilters = () => {
  form.get(route('supervisor.reports.index'), { preserveState: true, preserveScroll: true })
}

watch(() => props.flash, () => {
  if (props.flash?.warning) {
    alert(props.flash.warning)
  }
}, { deep: true })

// Removed unused filteredReports computed - filtering is server-side
</script>

