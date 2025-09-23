<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow mb-8">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <div class="flex items-center">
            <Link href="/dashboard" class="text-xl font-bold text-blue-600 hover:text-blue-700">
              <i class="fas fa-arrow-left mr-2"></i>PH HRMS
            </Link>
          </div>
          <div class="flex items-center space-x-4">
            <span class="text-sm text-gray-700">Organization Management</span>
          </div>
        </div>
      </div>
    </nav>

    <!-- Header -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-8">
      <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex justify-between items-center">
          <div>
            <h1 class="text-2xl font-bold text-gray-900 flex items-center">
              <i class="fas fa-clock text-blue-600 mr-3"></i>
              Work Schedule Management
            </h1>
            <p class="text-gray-600 mt-1">Manage work schedules, shifts, and time configurations</p>
          </div>
          <div class="flex space-x-3">
            <button
              @click="showCreateModal = true"
              class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors"
            >
              <i class="fas fa-plus"></i>
              <span>Add Work Schedule</span>
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Search and Filter Bar -->
      <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
          <div class="flex-1 max-w-md">
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-search text-gray-400"></i>
              </div>
              <input
                v-model="searchQuery"
                type="text"
                placeholder="Search work schedules..."
                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
              />
            </div>
          </div>
          <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
            <select
              v-model="selectedType"
              class="block w-full sm:w-32 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
            >
              <option value="">All Types</option>
              <option value="Fixed">Fixed</option>
              <option value="Flexible">Flexible</option>
              <option value="Shift">Shift</option>
            </select>
            <select
              v-model="selectedStatus"
              class="block w-full sm:w-32 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
            >
              <option value="">All Status</option>
              <option value="1">Active</option>
              <option value="0">Inactive</option>
            </select>
          </div>
        </div>
      </div>

      <!-- Work Schedules Table -->
      <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Schedule</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Type</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Hours/Day</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Hours/Week</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Days/Week</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Break</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="workSchedule in filteredWorkSchedules" :key="workSchedule.id" class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div>
                    <div class="text-sm font-medium text-gray-900">{{ workSchedule.name }}</div>
                    <div class="text-sm text-gray-500">{{ workSchedule.code }}</div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                        :class="getTypeColor(workSchedule.type)">
                    {{ workSchedule.type }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  {{ workSchedule.hours_per_day }} hrs
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  {{ workSchedule.hours_per_week || 'N/A' }} hrs
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  {{ workSchedule.days_per_week }} days
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  {{ workSchedule.break_duration_minutes }} min
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                        :class="workSchedule.is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'">
                    <span class="w-1.5 h-1.5 mr-1.5 rounded-full"
                          :class="workSchedule.is_active ? 'bg-green-400' : 'bg-red-400'"></span>
                    {{ workSchedule.is_active ? 'Active' : 'Inactive' }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-center text-sm space-x-2">
                  <button
                    @click="editWorkSchedule(workSchedule)"
                    class="text-blue-600 hover:text-blue-900 transition-colors"
                    title="Edit Work Schedule"
                  >
                    <i class="fas fa-edit"></i>
                  </button>
                  <button
                    @click="confirmDelete(workSchedule)"
                    class="text-red-600 hover:text-red-900 transition-colors"
                    title="Delete Work Schedule"
                  >
                    <i class="fas fa-trash"></i>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
          <div class="flex-1 flex justify-between items-center">
            <div>
              <p class="text-sm text-gray-700">
                Showing
                <span class="font-medium">{{ workSchedules.from || 0 }}</span>
                to
                <span class="font-medium">{{ workSchedules.to || 0 }}</span>
                of
                <span class="font-medium">{{ workSchedules.total || 0 }}</span>
                results
              </p>
            </div>
            <div class="flex space-x-2">
              <Link
                v-if="workSchedules.prev_page_url"
                :href="workSchedules.prev_page_url"
                class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
              >
                Previous
              </Link>
              <Link
                v-if="workSchedules.next_page_url"
                :href="workSchedules.next_page_url"
                class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
              >
                Next
              </Link>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Create/Edit Modal -->
    <div v-if="showCreateModal || showEditModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" @click="closeModal">
      <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-2/3 shadow-lg rounded-md bg-white" @click.stop>
        <div class="mt-3">
          <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-medium text-gray-900">
              {{ showCreateModal ? 'Add New Work Schedule' : 'Edit Work Schedule' }}
            </h3>
            <button @click="closeModal" class="text-gray-400 hover:text-gray-600">
              <i class="fas fa-times"></i>
            </button>
          </div>

          <form @submit.prevent="showCreateModal ? createWorkSchedule() : updateWorkSchedule()">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <!-- Schedule Name -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Schedule Name *</label>
                <input
                  v-model="form.name"
                  type="text"
                  required
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                />
              </div>

              <!-- Schedule Code -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Schedule Code</label>
                <input
                  v-model="form.code"
                  type="text"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                  placeholder="Auto-generated if empty"
                />
              </div>

              <!-- Type -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Schedule Type *</label>
                <select
                  v-model="form.type"
                  required
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                >
                  <option value="Fixed">Fixed</option>
                  <option value="Flexible">Flexible</option>
                  <option value="Shift">Shift</option>
                </select>
              </div>

              <!-- Hours per Day -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Hours per Day *</label>
                <input
                  v-model="form.hours_per_day"
                  type="number"
                  step="0.25"
                  min="0"
                  max="24"
                  required
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                />
              </div>

              <!-- Days per Week -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Days per Week *</label>
                <input
                  v-model="form.days_per_week"
                  type="number"
                  min="1"
                  max="7"
                  required
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                />
              </div>

              <!-- Break Duration -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Break Duration (minutes)</label>
                <input
                  v-model="form.break_duration_minutes"
                  type="number"
                  min="0"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                />
              </div>

              <!-- Status -->
              <div class="md:col-span-2">
                <label class="flex items-center">
                  <input
                    v-model="form.is_active"
                    type="checkbox"
                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                  />
                  <span class="ml-2 text-sm text-gray-700">Active</span>
                </label>
              </div>

              <!-- Description -->
              <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea
                  v-model="form.description"
                  rows="3"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                ></textarea>
              </div>
            </div>

            <div class="flex justify-end space-x-3 mt-6">
              <button
                type="button"
                @click="closeModal"
                class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
              >
                Cancel
              </button>
              <button
                type="submit"
                class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
              >
                {{ showCreateModal ? 'Create Work Schedule' : 'Update Work Schedule' }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div v-if="showDeleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" @click="closeDeleteModal">
      <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white" @click.stop>
        <div class="mt-3 text-center">
          <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
            <i class="fas fa-exclamation-triangle text-red-600"></i>
          </div>
          <h3 class="text-lg font-medium text-gray-900 mb-2">Delete Work Schedule</h3>
          <p class="text-sm text-gray-500 mb-4">
            Are you sure you want to delete "{{ workScheduleToDelete?.name }}"? This action cannot be undone.
          </p>
          <div class="flex justify-center space-x-3">
            <button
              @click="closeDeleteModal"
              class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50"
            >
              Cancel
            </button>
            <button
              @click="deleteWorkSchedule"
              class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700"
            >
              Delete
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, reactive } from 'vue'
import { Link, router } from '@inertiajs/vue3'

// Props
const props = defineProps({
  workSchedules: Object,
})

// Reactive state
const searchQuery = ref('')
const selectedType = ref('')
const selectedStatus = ref('')
const showCreateModal = ref(false)
const showEditModal = ref(false)
const showDeleteModal = ref(false)
const workScheduleToDelete = ref(null)

// Form data
const form = reactive({
  id: null,
  name: '',
  code: '',
  description: '',
  type: 'Fixed',
  hours_per_day: 8,
  days_per_week: 5,
  break_duration_minutes: 60,
  is_active: true,
})

// Computed
const filteredWorkSchedules = computed(() => {
  let filtered = props.workSchedules.data || []

  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase()
    filtered = filtered.filter(workSchedule =>
      workSchedule.name.toLowerCase().includes(query) ||
      workSchedule.code.toLowerCase().includes(query) ||
      workSchedule.type.toLowerCase().includes(query)
    )
  }

  if (selectedType.value) {
    filtered = filtered.filter(workSchedule => workSchedule.type === selectedType.value)
  }

  if (selectedStatus.value !== '') {
    filtered = filtered.filter(workSchedule => workSchedule.is_active == (selectedStatus.value === '1'))
  }

  return filtered
})

// Methods
const getTypeColor = (type) => {
  const colors = {
    'Fixed': 'bg-blue-100 text-blue-800',
    'Flexible': 'bg-green-100 text-green-800',
    'Shift': 'bg-purple-100 text-purple-800',
  }
  return colors[type] || 'bg-gray-100 text-gray-800'
}

const resetForm = () => {
  Object.assign(form, {
    id: null,
    name: '',
    code: '',
    description: '',
    type: 'Fixed',
    hours_per_day: 8,
    days_per_week: 5,
    break_duration_minutes: 60,
    is_active: true,
  })
}

const closeModal = () => {
  showCreateModal.value = false
  showEditModal.value = false
  resetForm()
}

const editWorkSchedule = (workSchedule) => {
  Object.assign(form, {
    id: workSchedule.id,
    name: workSchedule.name,
    code: workSchedule.code,
    description: workSchedule.description || '',
    type: workSchedule.type,
    hours_per_day: workSchedule.hours_per_day,
    days_per_week: workSchedule.days_per_week,
    break_duration_minutes: workSchedule.break_duration_minutes,
    is_active: workSchedule.is_active,
  })
  showEditModal.value = true
}

const createWorkSchedule = () => {
  router.post('/work-schedules', form, {
    onSuccess: () => {
      window.$toast?.success('Success!', 'Work Schedule created successfully!')
      closeModal()
    },
    onError: (errors) => {
      console.error('Validation errors:', errors)
      window.$toast?.error('Validation Error', 'Please check the form for errors')
    }
  })
}

const updateWorkSchedule = () => {
  router.put(`/work-schedules/${form.id}`, form, {
    onSuccess: () => {
      window.$toast?.success('Success!', 'Work Schedule updated successfully!')
      closeModal()
    },
    onError: (errors) => {
      console.error('Validation errors:', errors)
      window.$toast?.error('Validation Error', 'Please check the form for errors')
    }
  })
}

const confirmDelete = (workSchedule) => {
  workScheduleToDelete.value = workSchedule
  showDeleteModal.value = true
}

const closeDeleteModal = () => {
  showDeleteModal.value = false
  workScheduleToDelete.value = null
}

const deleteWorkSchedule = () => {
  if (workScheduleToDelete.value) {
    router.delete(`/work-schedules/${workScheduleToDelete.value.id}`, {
      onSuccess: () => {
        window.$toast?.success('Success!', 'Work Schedule deleted successfully!')
        closeDeleteModal()
      },
      onError: (errors) => {
        console.error('Delete error:', errors)
        window.$toast?.error('Delete Failed', 'Failed to delete work schedule. It may have employees assigned.')
      }
    })
  }
}
</script>