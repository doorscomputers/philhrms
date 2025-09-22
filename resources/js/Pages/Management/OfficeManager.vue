<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <div class="flex">
            <div class="flex-shrink-0 flex items-center">
              <router-link to="/" class="text-xl font-bold text-gray-900">PH HRMS</router-link>
            </div>
            <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
              <router-link to="/employees" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                <i class="fas fa-users mr-2"></i>Employees
              </router-link>
              <div class="relative" @mouseenter="showManagement = true" @mouseleave="showManagement = false">
                <button class="border-blue-500 text-blue-600 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm flex items-center">
                  <i class="fas fa-cog mr-2"></i>Management
                  <i class="fas fa-chevron-down ml-1 text-xs"></i>
                </button>

                <div v-show="showManagement" class="absolute left-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                  <div class="py-1">
                    <router-link to="/management/departments" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                      <i class="fas fa-building mr-2"></i>Departments
                    </router-link>
                    <router-link to="/management/offices" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                      <i class="fas fa-map-marker-alt mr-2"></i>Offices
                    </router-link>
                    <router-link to="/management/positions" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                      <i class="fas fa-briefcase mr-2"></i>Positions
                    </router-link>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="flex items-center">
            <span class="text-sm text-gray-700">Welcome, Admin</span>
          </div>
        </div>
      </div>
    </nav>

    <!-- Header -->
    <div class="bg-white shadow">
      <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between">
          <div>
            <nav class="flex" aria-label="Breadcrumb">
              <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                  <router-link to="/" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                    <i class="fas fa-home mr-2"></i>Dashboard
                  </router-link>
                </li>
                <li>
                  <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <span class="text-sm font-medium text-gray-500">Management</span>
                  </div>
                </li>
                <li aria-current="page">
                  <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <span class="text-sm font-medium text-gray-500">Offices</span>
                  </div>
                </li>
              </ol>
            </nav>
            <h1 class="mt-2 text-2xl font-bold text-gray-900">Office Management</h1>
          </div>
          <div>
            <button @click="showAddModal = true" class="btn btn-primary">
              <i class="fas fa-plus mr-2"></i>Add Office
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
      <!-- Office List -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">
            <i class="fas fa-map-marker-alt mr-3 text-green-600"></i>Offices
          </h3>
          <p class="card-description">Manage company offices and branches</p>
        </div>
        <div class="card-content p-0">
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Name
                  </th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Address
                  </th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Status
                  </th>
                  <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Actions
                  </th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="office in offices" :key="office.id" class="hover:bg-gray-50">
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900">{{ office.name }}</div>
                  </td>
                  <td class="px-6 py-4">
                    <div class="text-sm text-gray-900">{{ office.address || 'No address specified' }}</div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                      Active
                    </span>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <div class="flex items-center justify-end space-x-2">
                      <button
                        @click="editOffice(office)"
                        class="text-green-600 hover:text-green-900"
                        title="Edit Office"
                      >
                        <i class="fas fa-edit"></i>
                      </button>
                      <button
                        @click="deleteOffice(office)"
                        class="text-red-600 hover:text-red-900"
                        title="Delete Office"
                      >
                        <i class="fas fa-trash"></i>
                      </button>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>

            <!-- Empty state -->
            <div v-if="offices.length === 0 && !loading" class="text-center py-12">
              <i class="fas fa-map-marker-alt text-gray-400 text-4xl mb-4"></i>
              <h3 class="text-lg font-medium text-gray-900 mb-2">No offices found</h3>
              <p class="text-gray-500 mb-6">Get started by creating your first office.</p>
              <button @click="showAddModal = true" class="btn btn-primary">
                <i class="fas fa-plus mr-2"></i>Add Office
              </button>
            </div>

            <!-- Loading state -->
            <div v-if="loading" class="text-center py-12">
              <i class="fas fa-spinner fa-spin text-gray-400 text-2xl mb-4"></i>
              <p class="text-gray-500">Loading offices...</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Add/Edit Modal -->
    <div v-if="showAddModal || showEditModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
      <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
          <h3 class="text-lg font-medium text-gray-900 mb-4">
            {{ showEditModal ? 'Edit Office' : 'Add New Office' }}
          </h3>
          <form @submit.prevent="saveOffice">
            <div class="form-group mb-4">
              <label class="form-label">Name *</label>
              <input v-model="form.name" type="text" class="form-input" required>
            </div>
            <div class="form-group mb-4">
              <label class="form-label">Address</label>
              <textarea v-model="form.address" rows="3" class="form-input" placeholder="Office address"></textarea>
            </div>
            <div class="flex justify-end space-x-3">
              <button @click="closeModal" type="button" class="btn btn-secondary">Cancel</button>
              <button type="submit" class="btn btn-primary" :disabled="!form.name || saving">
                <span v-if="saving">Saving...</span>
                <span v-else>{{ showEditModal ? 'Update' : 'Save' }}</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'OfficeManager',
  data() {
    return {
      loading: true,
      saving: false,
      showManagement: false,
      showAddModal: false,
      showEditModal: false,
      offices: [],
      form: {
        name: '',
        address: ''
      },
      editingOffice: null
    }
  },
  methods: {
    async fetchOffices() {
      this.loading = true
      try {
        const response = await this.$http.get('/api/offices')
        this.offices = response.data
      } catch (error) {
        console.error('Error fetching offices:', error)
        window.showNotification?.('Error loading offices')
      } finally {
        this.loading = false
      }
    },

    editOffice(office) {
      this.editingOffice = office
      this.form = {
        name: office.name,
        address: office.address || ''
      }
      this.showEditModal = true
    },

    async deleteOffice(office) {
      if (confirm(`Are you sure you want to delete the office "${office.name}"?`)) {
        try {
          await this.$http.delete(`/api/offices/${office.id}`)
          window.showNotification?.('Office deleted successfully')
          this.fetchOffices()
        } catch (error) {
          console.error('Error deleting office:', error)
          window.showNotification?.('Error deleting office')
        }
      }
    },

    async saveOffice() {
      if (!this.form.name) {
        window.showNotification?.('Office name is required')
        return
      }

      this.saving = true
      try {
        if (this.showEditModal) {
          // Update existing office
          await this.$http.put(`/api/offices/${this.editingOffice.id}`, this.form)
          window.showNotification?.('Office updated successfully')
        } else {
          // Create new office
          await this.$http.post('/api/offices', this.form)
          window.showNotification?.('Office created successfully')
        }
        this.closeModal()
        this.fetchOffices()
      } catch (error) {
        console.error('Error saving office:', error)
        const message = error.response?.data?.message || 'Error saving office'
        window.showNotification?.(message)
      } finally {
        this.saving = false
      }
    },

    closeModal() {
      this.showAddModal = false
      this.showEditModal = false
      this.editingOffice = null
      this.form = {
        name: '',
        address: ''
      }
    }
  },

  mounted() {
    this.fetchOffices()
  }
}
</script>