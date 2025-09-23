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
              <i class="fas fa-layer-group text-blue-600 mr-3"></i>
              Job Grade Management
            </h1>
            <p class="text-gray-600 mt-1">Manage organizational job grades and salary ranges</p>
          </div>
          <div class="flex space-x-3">
            <button
              @click="showCreateModal = true"
              class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors"
            >
              <i class="fas fa-plus"></i>
              <span>Add Job Grade</span>
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
                placeholder="Search job grades..."
                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
              />
            </div>
          </div>
          <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
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

      <!-- Job Grades Table -->
      <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Job Grade</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Level</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Min Salary</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Mid Salary</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Max Salary</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Created</th>
                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="jobGrade in filteredJobGrades" :key="jobGrade.id" class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div>
                    <div class="text-sm font-medium text-gray-900">{{ jobGrade.name }}</div>
                    <div class="text-sm text-gray-500">{{ jobGrade.code }}</div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    Level {{ jobGrade.level }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  ₱{{ formatCurrency(jobGrade.min_salary) }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  ₱{{ formatCurrency(jobGrade.mid_salary) }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  ₱{{ formatCurrency(jobGrade.max_salary) }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                        :class="jobGrade.is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'">
                    <span class="w-1.5 h-1.5 mr-1.5 rounded-full"
                          :class="jobGrade.is_active ? 'bg-green-400' : 'bg-red-400'"></span>
                    {{ jobGrade.is_active ? 'Active' : 'Inactive' }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ formatDate(jobGrade.created_at) }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-center text-sm space-x-2">
                  <button
                    @click="editJobGrade(jobGrade)"
                    class="text-blue-600 hover:text-blue-900 transition-colors"
                    title="Edit Job Grade"
                  >
                    <i class="fas fa-edit"></i>
                  </button>
                  <button
                    @click="confirmDelete(jobGrade)"
                    class="text-red-600 hover:text-red-900 transition-colors"
                    title="Delete Job Grade"
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
                <span class="font-medium">{{ jobGrades.from || 0 }}</span>
                to
                <span class="font-medium">{{ jobGrades.to || 0 }}</span>
                of
                <span class="font-medium">{{ jobGrades.total || 0 }}</span>
                results
              </p>
            </div>
            <div class="flex space-x-2">
              <Link
                v-if="jobGrades.prev_page_url"
                :href="jobGrades.prev_page_url"
                class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
              >
                Previous
              </Link>
              <Link
                v-if="jobGrades.next_page_url"
                :href="jobGrades.next_page_url"
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
      <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white" @click.stop>
        <div class="mt-3">
          <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-medium text-gray-900">
              {{ showCreateModal ? 'Add New Job Grade' : 'Edit Job Grade' }}
            </h3>
            <button @click="closeModal" class="text-gray-400 hover:text-gray-600">
              <i class="fas fa-times"></i>
            </button>
          </div>

          <form @submit.prevent="showCreateModal ? createJobGrade() : updateJobGrade()">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <!-- Job Grade Name -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Job Grade Name *</label>
                <input
                  v-model="form.name"
                  type="text"
                  required
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                />
              </div>

              <!-- Job Grade Code -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Job Grade Code *</label>
                <input
                  v-model="form.code"
                  type="text"
                  required
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                />
              </div>

              <!-- Level -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Level *</label>
                <input
                  v-model="form.level"
                  type="number"
                  min="1"
                  required
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                />
              </div>

              <!-- Status -->
              <div class="flex items-center mt-6">
                <label class="flex items-center">
                  <input
                    v-model="form.is_active"
                    type="checkbox"
                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                  />
                  <span class="ml-2 text-sm text-gray-700">Active</span>
                </label>
              </div>

              <!-- Min Salary -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Minimum Salary *</label>
                <input
                  v-model="form.min_salary"
                  type="number"
                  step="0.01"
                  min="0"
                  required
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                />
              </div>

              <!-- Max Salary -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Maximum Salary *</label>
                <input
                  v-model="form.max_salary"
                  type="number"
                  step="0.01"
                  min="0"
                  required
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                />
              </div>

              <!-- Mid Salary (Auto-calculated) -->
              <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Mid Salary (Auto-calculated)</label>
                <input
                  :value="midSalary"
                  type="text"
                  readonly
                  class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50 text-gray-600"
                />
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
                {{ showCreateModal ? 'Create Job Grade' : 'Update Job Grade' }}
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
          <h3 class="text-lg font-medium text-gray-900 mb-2">Delete Job Grade</h3>
          <p class="text-sm text-gray-500 mb-4">
            Are you sure you want to delete "{{ jobGradeToDelete?.name }}"? This action cannot be undone.
          </p>
          <div class="flex justify-center space-x-3">
            <button
              @click="closeDeleteModal"
              class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50"
            >
              Cancel
            </button>
            <button
              @click="deleteJobGrade"
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
  jobGrades: Object,
})

// Reactive state
const searchQuery = ref('')
const selectedStatus = ref('')
const showCreateModal = ref(false)
const showEditModal = ref(false)
const showDeleteModal = ref(false)
const jobGradeToDelete = ref(null)

// Form data
const form = reactive({
  id: null,
  name: '',
  code: '',
  level: 1,
  min_salary: '',
  max_salary: '',
  description: '',
  is_active: true,
})

// Computed
const filteredJobGrades = computed(() => {
  let filtered = props.jobGrades.data || []

  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase()
    filtered = filtered.filter(jobGrade =>
      jobGrade.name.toLowerCase().includes(query) ||
      jobGrade.code.toLowerCase().includes(query)
    )
  }

  if (selectedStatus.value !== '') {
    filtered = filtered.filter(jobGrade => jobGrade.is_active == (selectedStatus.value === '1'))
  }

  return filtered
})

const midSalary = computed(() => {
  if (form.min_salary && form.max_salary) {
    const min = parseFloat(form.min_salary)
    const max = parseFloat(form.max_salary)
    return ((min + max) / 2).toLocaleString('en-US', { minimumFractionDigits: 2 })
  }
  return '0.00'
})

// Methods
const formatCurrency = (amount) => {
  return parseFloat(amount || 0).toLocaleString('en-US', { minimumFractionDigits: 2 })
}

const formatDate = (dateString) => {
  return new Date(dateString).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  })
}

const resetForm = () => {
  Object.assign(form, {
    id: null,
    name: '',
    code: '',
    level: 1,
    min_salary: '',
    max_salary: '',
    description: '',
    is_active: true,
  })
}

const closeModal = () => {
  showCreateModal.value = false
  showEditModal.value = false
  resetForm()
}

const editJobGrade = (jobGrade) => {
  Object.assign(form, {
    id: jobGrade.id,
    name: jobGrade.name,
    code: jobGrade.code,
    level: jobGrade.level,
    min_salary: jobGrade.min_salary,
    max_salary: jobGrade.max_salary,
    description: jobGrade.description || '',
    is_active: jobGrade.is_active,
  })
  showEditModal.value = true
}

const createJobGrade = () => {
  router.post('/job-grades', form, {
    onSuccess: () => {
      window.$toast?.success('Success!', 'Job Grade created successfully!')
      closeModal()
    },
    onError: (errors) => {
      console.error('Validation errors:', errors)
      window.$toast?.error('Validation Error', 'Please check the form for errors')
    }
  })
}

const updateJobGrade = () => {
  router.put(`/job-grades/${form.id}`, form, {
    onSuccess: () => {
      window.$toast?.success('Success!', 'Job Grade updated successfully!')
      closeModal()
    },
    onError: (errors) => {
      console.error('Validation errors:', errors)
      window.$toast?.error('Validation Error', 'Please check the form for errors')
    }
  })
}

const confirmDelete = (jobGrade) => {
  jobGradeToDelete.value = jobGrade
  showDeleteModal.value = true
}

const closeDeleteModal = () => {
  showDeleteModal.value = false
  jobGradeToDelete.value = null
}

const deleteJobGrade = () => {
  if (jobGradeToDelete.value) {
    router.delete(`/job-grades/${jobGradeToDelete.value.id}`, {
      onSuccess: () => {
        window.$toast?.success('Success!', 'Job Grade deleted successfully!')
        closeDeleteModal()
      },
      onError: (errors) => {
        console.error('Delete error:', errors)
        window.$toast?.error('Delete Failed', 'Failed to delete job grade. It may have employees or positions assigned.')
      }
    })
  }
}
</script>