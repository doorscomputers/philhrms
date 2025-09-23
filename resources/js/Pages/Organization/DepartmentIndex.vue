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
              <i class="fas fa-building text-blue-600 mr-3"></i>
              Department Management
            </h1>
            <p class="text-gray-600 mt-1">Manage organizational departments and their structure</p>
          </div>
          <div class="flex space-x-3">
            <button
              @click="showCreateModal = true"
              class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors"
            >
              <i class="fas fa-plus"></i>
              <span>Add Department</span>
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
                v-model="searchTerm"
                type="text"
                placeholder="Search departments..."
                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
              >
            </div>
          </div>
          <div class="flex items-center space-x-4">
            <select
              v-model="filterStatus"
              class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
            >
              <option value="">All Status</option>
              <option value="1">Active</option>
              <option value="0">Inactive</option>
            </select>
          </div>
        </div>
      </div>

      <!-- Departments Table -->
      <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Department
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Code
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Parent Department
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Employees
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Status
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Actions
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr
                v-for="department in filteredDepartments"
                :key="department.id"
                class="hover:bg-gray-50"
              >
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center">
                    <div class="flex-shrink-0 h-10 w-10">
                      <div class="h-10 w-10 rounded-lg bg-blue-100 flex items-center justify-center">
                        <i class="fas fa-building text-blue-600"></i>
                      </div>
                    </div>
                    <div class="ml-4">
                      <div class="text-sm font-medium text-gray-900">
                        {{ department.name }}
                      </div>
                      <div class="text-sm text-gray-500">
                        {{ department.description || 'No description' }}
                      </div>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  {{ department.code }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  {{ department.parent?.name || 'None' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    {{ department.employees_count || 0 }} employees
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span
                    :class="[
                      'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                      department.is_active
                        ? 'bg-green-100 text-green-800'
                        : 'bg-red-100 text-red-800'
                    ]"
                  >
                    {{ department.is_active ? 'Active' : 'Inactive' }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  <div class="flex items-center space-x-2">
                    <button
                      @click="editDepartment(department)"
                      class="text-blue-600 hover:text-blue-900 p-1 rounded"
                      title="Edit"
                    >
                      <i class="fas fa-edit"></i>
                    </button>
                    <button
                      @click="viewDepartment(department)"
                      class="text-green-600 hover:text-green-900 p-1 rounded"
                      title="View"
                    >
                      <i class="fas fa-eye"></i>
                    </button>
                    <button
                      @click="confirmDelete(department)"
                      class="text-red-600 hover:text-red-900 p-1 rounded"
                      title="Delete"
                    >
                      <i class="fas fa-trash"></i>
                    </button>
                  </div>
                </td>
              </tr>
              <tr v-if="filteredDepartments.length === 0">
                <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                  <div class="flex flex-col items-center">
                    <i class="fas fa-building text-gray-300 text-4xl mb-4"></i>
                    <p class="text-lg font-medium">No departments found</p>
                    <p class="text-sm">{{ searchTerm ? 'Try adjusting your search criteria' : 'Get started by creating your first department' }}</p>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div v-if="departments.data && departments.data.length > 0" class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
          <div class="flex-1 flex justify-between sm:hidden">
            <Link
              v-if="departments.prev_page_url"
              :href="departments.prev_page_url"
              class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
            >
              Previous
            </Link>
            <Link
              v-if="departments.next_page_url"
              :href="departments.next_page_url"
              class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
            >
              Next
            </Link>
          </div>
          <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
              <p class="text-sm text-gray-700">
                Showing
                <span class="font-medium">{{ departments.from }}</span>
                to
                <span class="font-medium">{{ departments.to }}</span>
                of
                <span class="font-medium">{{ departments.total }}</span>
                results
              </p>
            </div>
            <div>
              <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">
                <Link
                  v-for="link in departments.links"
                  :key="link.label"
                  :href="link.url"
                  v-html="link.label"
                  :class="[
                    'relative inline-flex items-center px-2 py-2 border text-sm font-medium',
                    link.active
                      ? 'z-10 bg-blue-50 border-blue-500 text-blue-600'
                      : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50',
                    link.url === null ? 'cursor-not-allowed opacity-50' : 'cursor-pointer'
                  ]"
                />
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Create/Edit Modal -->
    <div
      v-if="showCreateModal || showEditModal"
      class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50"
      @click="closeModal"
    >
      <div
        class="relative top-20 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white"
        @click.stop
      >
        <div class="mt-3">
          <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-medium text-gray-900">
              {{ showCreateModal ? 'Create New Department' : 'Edit Department' }}
            </h3>
            <button @click="closeModal" class="text-gray-400 hover:text-gray-600">
              <i class="fas fa-times"></i>
            </button>
          </div>

          <form @submit.prevent="submitForm" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                  Department Name *
                </label>
                <input
                  v-model="form.name"
                  type="text"
                  required
                  class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                  placeholder="Enter department name"
                >
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                  Department Code *
                </label>
                <input
                  v-model="form.code"
                  type="text"
                  required
                  class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                  placeholder="Enter department code"
                >
              </div>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">
                Description
              </label>
              <textarea
                v-model="form.description"
                rows="3"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                placeholder="Enter department description"
              ></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                  Parent Department
                </label>
                <select
                  v-model="form.parent_id"
                  class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                >
                  <option value="">None (Top Level)</option>
                  <option
                    v-for="parent in parentDepartments"
                    :key="parent.id"
                    :value="parent.id"
                  >
                    {{ parent.name }}
                  </option>
                </select>
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                  Level
                </label>
                <input
                  v-model="form.level"
                  type="number"
                  min="1"
                  class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                  placeholder="Department level"
                >
              </div>
            </div>

            <div class="flex items-center">
              <input
                v-model="form.is_active"
                type="checkbox"
                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
              >
              <label class="ml-2 block text-sm text-gray-900">
                Active Department
              </label>
            </div>

            <div class="flex justify-end space-x-3 pt-4">
              <button
                type="button"
                @click="closeModal"
                class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50"
              >
                Cancel
              </button>
              <button
                type="submit"
                :disabled="isSubmitting"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50"
              >
                <i v-if="isSubmitting" class="fas fa-spinner fa-spin mr-2"></i>
                {{ showCreateModal ? 'Create Department' : 'Update Department' }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div
      v-if="showDeleteModal"
      class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50"
      @click="closeDeleteModal"
    >
      <div
        class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white"
        @click.stop
      >
        <div class="mt-3 text-center">
          <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
            <i class="fas fa-exclamation-triangle text-red-600"></i>
          </div>
          <h3 class="text-lg font-medium text-gray-900 mt-4">Delete Department</h3>
          <div class="mt-2 px-7 py-3">
            <p class="text-sm text-gray-500">
              Are you sure you want to delete "{{ departmentToDelete?.name }}"? This action cannot be undone.
            </p>
          </div>
          <div class="flex justify-center space-x-3 mt-4">
            <button
              @click="closeDeleteModal"
              class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400"
            >
              Cancel
            </button>
            <button
              @click="deleteDepartment"
              :disabled="isDeleting"
              class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 disabled:opacity-50"
            >
              <i v-if="isDeleting" class="fas fa-spinner fa-spin mr-2"></i>
              Delete
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { Link, router } from '@inertiajs/vue3'

// Props
const props = defineProps({
  departments: Object,
  companies: Array,
  parentDepartments: Array,
})

// Reactive data
const showCreateModal = ref(false)
const showEditModal = ref(false)
const showDeleteModal = ref(false)
const isSubmitting = ref(false)
const isDeleting = ref(false)
const searchTerm = ref('')
const filterStatus = ref('')
const departmentToDelete = ref(null)
const editingDepartment = ref(null)

// Form data
const form = ref({
  name: '',
  code: '',
  description: '',
  parent_id: '',
  level: 1,
  is_active: true,
  company_id: 1
})

// Computed
const filteredDepartments = computed(() => {
  if (!props.departments.data) return []

  let filtered = props.departments.data

  // Search filter
  if (searchTerm.value) {
    const search = searchTerm.value.toLowerCase()
    filtered = filtered.filter(dept =>
      dept.name.toLowerCase().includes(search) ||
      dept.code.toLowerCase().includes(search) ||
      (dept.description && dept.description.toLowerCase().includes(search))
    )
  }

  // Status filter
  if (filterStatus.value !== '') {
    filtered = filtered.filter(dept => dept.is_active == filterStatus.value)
  }

  return filtered
})

// Methods
const closeModal = () => {
  showCreateModal.value = false
  showEditModal.value = false
  resetForm()
}

const closeDeleteModal = () => {
  showDeleteModal.value = false
  departmentToDelete.value = null
}

const resetForm = () => {
  form.value = {
    name: '',
    code: '',
    description: '',
    parent_id: '',
    level: 1,
    is_active: true,
    company_id: 1
  }
  editingDepartment.value = null
}

const editDepartment = (department) => {
  editingDepartment.value = department
  form.value = {
    name: department.name,
    code: department.code,
    description: department.description || '',
    parent_id: department.parent_id || '',
    level: department.level || 1,
    is_active: department.is_active,
    company_id: department.company_id
  }
  showEditModal.value = true
}

const viewDepartment = (department) => {
  router.visit(`/departments/${department.id}`)
}

const confirmDelete = (department) => {
  departmentToDelete.value = department
  showDeleteModal.value = true
}

const submitForm = () => {
  isSubmitting.value = true

  if (showCreateModal.value) {
    router.post('/departments', form.value, {
      onSuccess: () => {
        closeModal()
        // Add toast notification here
      },
      onError: () => {
        // Add error toast notification here
      },
      onFinish: () => {
        isSubmitting.value = false
      }
    })
  } else {
    router.put(`/departments/${editingDepartment.value.id}`, form.value, {
      onSuccess: () => {
        closeModal()
        // Add toast notification here
      },
      onError: () => {
        // Add error toast notification here
      },
      onFinish: () => {
        isSubmitting.value = false
      }
    })
  }
}

const deleteDepartment = () => {
  isDeleting.value = true

  router.delete(`/departments/${departmentToDelete.value.id}`, {
    onSuccess: () => {
      closeDeleteModal()
      // Add toast notification here
    },
    onError: () => {
      // Add error toast notification here
    },
    onFinish: () => {
      isDeleting.value = false
    }
  })
}
</script>