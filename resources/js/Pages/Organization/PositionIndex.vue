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
              <i class="fas fa-briefcase text-blue-600 mr-3"></i>
              Position Management
            </h1>
            <p class="text-gray-600 mt-1">Manage organizational positions and job roles</p>
          </div>
          <div class="flex space-x-3">
            <button
              @click="showCreateModal = true"
              class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors"
            >
              <i class="fas fa-plus"></i>
              <span>Add Position</span>
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
                placeholder="Search positions..."
                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
              />
            </div>
          </div>
          <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
            <select
              v-model="selectedDepartment"
              class="block w-full sm:w-48 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
            >
              <option value="">All Departments</option>
              <option v-for="department in departments" :key="department.id" :value="department.id">
                {{ department.name }}
              </option>
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

      <!-- Positions Table -->
      <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Position</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Department</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Job Grade</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Type</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Level</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Created</th>
                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="position in filteredPositions" :key="position.id" class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div>
                    <div class="text-sm font-medium text-gray-900">{{ position.title }}</div>
                    <div class="text-sm text-gray-500">{{ position.code }}</div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900">
                    {{ position.department?.name || 'N/A' }}
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900">
                    {{ position.job_grade?.name || 'N/A' }}
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                        :class="getTypeColor(position.type)">
                    {{ position.type }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900">{{ position.level }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                        :class="position.is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'">
                    <span class="w-1.5 h-1.5 mr-1.5 rounded-full"
                          :class="position.is_active ? 'bg-green-400' : 'bg-red-400'"></span>
                    {{ position.is_active ? 'Active' : 'Inactive' }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ formatDate(position.created_at) }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-center text-sm space-x-2">
                  <button
                    @click="editPosition(position)"
                    class="text-blue-600 hover:text-blue-900 transition-colors"
                    title="Edit Position"
                  >
                    <i class="fas fa-edit"></i>
                  </button>
                  <button
                    @click="confirmDelete(position)"
                    class="text-red-600 hover:text-red-900 transition-colors"
                    title="Delete Position"
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
                <span class="font-medium">{{ positions.from || 0 }}</span>
                to
                <span class="font-medium">{{ positions.to || 0 }}</span>
                of
                <span class="font-medium">{{ positions.total || 0 }}</span>
                results
              </p>
            </div>
            <div class="flex space-x-2">
              <Link
                v-if="positions.prev_page_url"
                :href="positions.prev_page_url"
                class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
              >
                Previous
              </Link>
              <Link
                v-if="positions.next_page_url"
                :href="positions.next_page_url"
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
              {{ showCreateModal ? 'Add New Position' : 'Edit Position' }}
            </h3>
            <button @click="closeModal" class="text-gray-400 hover:text-gray-600">
              <i class="fas fa-times"></i>
            </button>
          </div>

          <form @submit.prevent="showCreateModal ? createPosition() : updatePosition()">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <!-- Position Title -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Position Title *</label>
                <input
                  v-model="form.title"
                  type="text"
                  required
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                />
              </div>

              <!-- Position Code -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Position Code *</label>
                <input
                  v-model="form.code"
                  type="text"
                  required
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                />
              </div>

              <!-- Department -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Department *</label>
                <select
                  v-model="form.department_id"
                  required
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                >
                  <option value="">Select Department</option>
                  <option v-for="department in departments" :key="department.id" :value="department.id">
                    {{ department.name }}
                  </option>
                </select>
              </div>

              <!-- Job Grade -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Job Grade</label>
                <select
                  v-model="form.job_grade_id"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                >
                  <option value="">Select Job Grade</option>
                  <option v-for="jobGrade in jobGrades" :key="jobGrade.id" :value="jobGrade.id">
                    {{ jobGrade.name }}
                  </option>
                </select>
              </div>

              <!-- Type -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                <select
                  v-model="form.type"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                >
                  <option value="Regular">Regular</option>
                  <option value="Contractual">Contractual</option>
                  <option value="Casual">Casual</option>
                  <option value="Consultant">Consultant</option>
                </select>
              </div>

              <!-- Level -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Level</label>
                <select
                  v-model="form.level"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                >
                  <option value="Executive">Executive</option>
                  <option value="Management">Management</option>
                  <option value="Supervisory">Supervisory</option>
                  <option value="Rank and File">Rank and File</option>
                </select>
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
                {{ showCreateModal ? 'Create Position' : 'Update Position' }}
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
          <h3 class="text-lg font-medium text-gray-900 mb-2">Delete Position</h3>
          <p class="text-sm text-gray-500 mb-4">
            Are you sure you want to delete "{{ positionToDelete?.title }}"? This action cannot be undone.
          </p>
          <div class="flex justify-center space-x-3">
            <button
              @click="closeDeleteModal"
              class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50"
            >
              Cancel
            </button>
            <button
              @click="deletePosition"
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
  positions: Object,
  departments: Array,
  jobGrades: Array,
})

// Reactive state
const searchQuery = ref('')
const selectedDepartment = ref('')
const selectedStatus = ref('')
const showCreateModal = ref(false)
const showEditModal = ref(false)
const showDeleteModal = ref(false)
const positionToDelete = ref(null)

// Form data
const form = reactive({
  id: null,
  title: '',
  code: '',
  department_id: '',
  job_grade_id: '',
  type: 'Regular',
  level: 'Rank and File',
  description: '',
  is_active: true,
})

// Computed
const filteredPositions = computed(() => {
  let filtered = props.positions.data || []

  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase()
    filtered = filtered.filter(position =>
      position.title.toLowerCase().includes(query) ||
      position.code.toLowerCase().includes(query) ||
      (position.department?.name || '').toLowerCase().includes(query)
    )
  }

  if (selectedDepartment.value) {
    filtered = filtered.filter(position => position.department_id == selectedDepartment.value)
  }

  if (selectedStatus.value !== '') {
    filtered = filtered.filter(position => position.is_active == (selectedStatus.value === '1'))
  }

  return filtered
})

// Methods
const getTypeColor = (type) => {
  const colors = {
    'Regular': 'bg-blue-100 text-blue-800',
    'Contractual': 'bg-yellow-100 text-yellow-800',
    'Casual': 'bg-green-100 text-green-800',
    'Consultant': 'bg-purple-100 text-purple-800',
  }
  return colors[type] || 'bg-gray-100 text-gray-800'
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
    title: '',
    code: '',
    department_id: '',
    job_grade_id: '',
    type: 'Regular',
    level: 'Rank and File',
    description: '',
    is_active: true,
  })
}

const closeModal = () => {
  showCreateModal.value = false
  showEditModal.value = false
  resetForm()
}

const editPosition = (position) => {
  Object.assign(form, {
    id: position.id,
    title: position.title,
    code: position.code,
    department_id: position.department_id,
    job_grade_id: position.job_grade_id,
    type: position.type,
    level: position.level,
    description: position.description || '',
    is_active: position.is_active,
  })
  showEditModal.value = true
}

const createPosition = () => {
  router.post('/positions', form, {
    onSuccess: () => {
      window.$toast?.success('Success!', 'Position created successfully!')
      closeModal()
    },
    onError: (errors) => {
      console.error('Validation errors:', errors)
      window.$toast?.error('Validation Error', 'Please check the form for errors')
    }
  })
}

const updatePosition = () => {
  router.put(`/positions/${form.id}`, form, {
    onSuccess: () => {
      window.$toast?.success('Success!', 'Position updated successfully!')
      closeModal()
    },
    onError: (errors) => {
      console.error('Validation errors:', errors)
      window.$toast?.error('Validation Error', 'Please check the form for errors')
    }
  })
}

const confirmDelete = (position) => {
  positionToDelete.value = position
  showDeleteModal.value = true
}

const closeDeleteModal = () => {
  showDeleteModal.value = false
  positionToDelete.value = null
}

const deletePosition = () => {
  if (positionToDelete.value) {
    router.delete(`/positions/${positionToDelete.value.id}`, {
      onSuccess: () => {
        window.$toast?.success('Success!', 'Position deleted successfully!')
        closeDeleteModal()
      },
      onError: (errors) => {
        console.error('Delete error:', errors)
        window.$toast?.error('Delete Failed', 'Failed to delete position. It may have employees assigned.')
      }
    })
  }
}
</script>