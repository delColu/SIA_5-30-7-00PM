<template>
  <AuthenticatedLayout title="Interns">
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">Interns</h2>
    </template>

    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-6">
        <!-- Filters -->
        <div class="bg-white shadow sm:rounded-md p-6">
          <h3 class="text-lg font-medium text-gray-900 mb-4">Filters</h3>
          <div class="flex items-end space-x-2">
            <div class="flex-1">
              <InputLabel for="search" value="Search Interns" />
              <TextInput id="search" type="text" class="mt-1 block w-full" v-model="form.search" autocomplete="search" />
              <InputError class="mt-2" :message="form.errors.search" />
            </div>
            <PrimaryButton @click.prevent="submitFilters" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
              Search
            </PrimaryButton>
          </div>
        </div>

        <div class="overflow-hidden bg-white shadow sm:rounded-md">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reports</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tasks</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="(intern, index) in filteredInterns" :key="intern?.id ?? `intern-${index}`" class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ intern.name }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ intern.email }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ intern.reports_count ?? 0 }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ intern.tasks_count ?? 0 }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                  <Link :href="intern.id ? `/supervisor/reports?user_id=${intern.id}` : '#'" class="text-indigo-600 hover:text-indigo-500 mr-3">Reports</Link>
                  <Link v-if="intern.id" :href="route('supervisor.interns.show', intern.id)" class="text-indigo-600 hover:text-indigo-500 mr-3 ml-2">Show</Link>
                </td>
              </tr>
            </tbody>
          </table>
          <div v-if="!interns?.data?.length" class="p-8 text-center text-gray-500">No interns found.</div>
        </div>
        <div v-if="interns.links" class="mt-6 flex justify-center">
          <nav class="flex space-x-2">
            <Link v-for="link in interns.links" :key="link.label" :href="link.url ?? '#'" preserve-query v-html="link.label" class="px-3 py-2 text-sm rounded-md" :class="link.active ? 'bg-blue-500 text-white' : 'text-gray-500 hover:text-gray-700'" />
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
  interns: Object,
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
  search: props.query?.search || '',
})

const submitFilters = () => {
  form.get(route('supervisor.interns.index'), { preserveState: true, preserveScroll: true })
}

watch(() => props.flash, () => {
  if (props.flash?.warning) {
    alert(props.flash.warning)
  }
}, { deep: true })

const filteredInterns = computed(() => props.interns.data || [])
</script>

