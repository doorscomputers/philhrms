<template>
  <div class="px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="sm:flex sm:items-center">
      <div class="sm:flex-auto">
        <h1 class="text-2xl font-semibold text-gray-900">Employees</h1>
        <p class="mt-2 text-sm text-gray-700">A list of all employees in your system including their basic information.</p>
      </div>
      <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
        <router-link
          to="/employees/create"
          class="inline-flex items-center justify-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
        >
          Add Employee
        </router-link>
      </div>
    </div>

    <!-- Search and Filters -->
    <div class="mt-6 flex items-center space-x-4">
      <div class="flex-1 max-w-md">
        <input
          v-model="searchTerm"
          type="text"
          placeholder="Search employees..."
          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
          @input="searchEmployees"
        >
      </div>
      <div>
        <select
          v-model="filterDepartment"
          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
          @change="filterEmployees"
        >
          <option value="">All Departments</option>
          <option v-for="dept in departments" :key="dept" :value="dept">{{ dept }}</option>
        </select>
      </div>
    </div>

    <!-- Employee Table -->
    <div class="mt-8 flow-root">
      <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
          <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
            <table class="min-w-full divide-y divide-gray-300">
              <thead class="bg-gray-50">
                <tr>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">
                    Employee
                  </th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">
                    Position
                  </th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">
                    Department
                  </th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">
                    Status
                  </th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">
                    Hire Date
                  </th>
                  <th scope="col" class="relative px-6 py-3">
                    <span class="sr-only">Actions</span>
                  </th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200 bg-white">
                <tr v-for="employee in filteredEmployees" :key="employee.id">
                  <td class="whitespace-nowrap px-6 py-4 text-sm">
                    <div class="flex items-center">
                      <div class="h-10 w-10 flex-shrink-0">
                        <img
                          v-if="employee.photo"
                          :src="'/storage/' + employee.photo"
                          :alt="employee.first_name"
                          class="h-10 w-10 rounded-full object-cover"
                        >
                        <div
                          v-else
                          class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center"
                        >
                          <span class="text-sm font-medium text-gray-700">
                            {{ employee.first_name?.charAt(0) }}{{ employee.last_name?.charAt(0) }}
                          </span>
                        </div>
                      </div>
                      <div class="ml-4">
                        <div class="font-medium text-gray-900">
                          {{ employee.first_name }} {{ employee.last_name }}
                        </div>
                        <div class="text-gray-500">{{ employee.employee_id }}</div>
                      </div>
                    </div>
                  </td>
                  <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">
                    {{ employee.position || 'N/A' }}
                  </td>
                  <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">
                    {{ employee.department || 'N/A' }}
                  </td>
                  <td class="whitespace-nowrap px-6 py-4 text-sm">
                    <span
                      :class="{
                        'bg-green-100 text-green-800': employee.status === 'Active',
                        'bg-red-100 text-red-800': employee.status === 'Inactive',
                        'bg-gray-100 text-gray-800': employee.status === 'Terminated'
                      }"
                      class="inline-flex rounded-full px-2 text-xs font-semibold leading-5"
                    >
                      {{ employee.status || 'Active' }}
                    </span>
                  </td>
                  <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">
                    {{ formatDate(employee.hire_date) }}
                  </td>
                  <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                    <router-link
                      :to="`/employees/${employee.id}`"
                      class="text-blue-600 hover:text-blue-900 mr-4"
                    >
                      View
                    </router-link>
                    <router-link
                      :to="`/employees/${employee.id}/edit`"
                      class="text-blue-600 hover:text-blue-900 mr-4"
                    >
                      Edit
                    </router-link>
                    <button
                      @click="deleteEmployee(employee)"
                      class="text-red-600 hover:text-red-900"
                    >
                      Delete
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>

            <!-- Empty state -->
            <div v-if="filteredEmployees.length === 0" class="text-center py-12">
              <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
              </svg>
              <h3 class="mt-2 text-sm font-medium text-gray-900">No employees found</h3>
              <p class="mt-1 text-sm text-gray-500">Get started by creating a new employee.</p>
              <div class="mt-6">
                <router-link
                  to="/employees/create"
                  class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700"
                >
                  Add Employee
                </router-link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Pagination -->
    <div v-if="pagination && pagination.last_page > 1" class="mt-6 flex items-center justify-between">
      <div class="flex-1 flex justify-between sm:hidden">
        <button
          @click="changePage(pagination.current_page - 1)"
          :disabled="pagination.current_page <= 1"
          class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
        >
          Previous
        </button>
        <button
          @click="changePage(pagination.current_page + 1)"
          :disabled="pagination.current_page >= pagination.last_page"
          class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
        >
          Next
        </button>
      </div>
      <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
        <div>
          <p class="text-sm text-gray-700">
            Showing
            <span class="font-medium">{{ pagination.from }}</span>
            to
            <span class="font-medium">{{ pagination.to }}</span>
            of
            <span class="font-medium">{{ pagination.total }}</span>
            results
          </p>
        </div>
        <div>
          <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
            <!-- Pagination buttons -->
            <button
              v-for="page in paginationPages"
              :key="page"
              @click="changePage(page)"
              :class="{
                'bg-blue-50 border-blue-500 text-blue-600': page === pagination.current_page,
                'bg-white border-gray-300 text-gray-500 hover:bg-gray-50': page !== pagination.current_page
              }"
              class="relative inline-flex items-center px-4 py-2 border text-sm font-medium"
            >
              {{ page }}
            </button>
          </nav>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'EmployeeIndex',
  data() {
    return {
      employees: [],
      filteredEmployees: [],
      departments: [],
      searchTerm: '',
      filterDepartment: '',
      pagination: null,
      loading: false
    }
  },
  computed: {
    paginationPages() {
      if (!this.pagination) return []

      const pages = []
      const start = Math.max(1, this.pagination.current_page - 2)
      const end = Math.min(this.pagination.last_page, this.pagination.current_page + 2)

      for (let i = start; i <= end; i++) {
        pages.push(i)
      }

      return pages
    }
  },
  methods: {
    async fetchEmployees(page = 1) {
      this.loading = true
      this.$emit('loading', true)

      try {
        const response = await this.$http.get(`/api/employees?page=${page}`)
        this.employees = response.data.data
        this.filteredEmployees = [...this.employees]
        this.pagination = {
          current_page: response.data.current_page,
          last_page: response.data.last_page,
          from: response.data.from,
          to: response.data.to,
          total: response.data.total
        }

        // Extract unique departments
        this.departments = [...new Set(this.employees.map(emp => emp.department).filter(dept => dept))]
      } catch (error) {
        console.error('Error fetching employees:', error)
        window.showNotification?.('Error fetching employees')
      } finally {
        this.loading = false
        this.$emit('loading', false)
      }
    },

    searchEmployees() {
      this.filterEmployees()
    },

    filterEmployees() {
      let filtered = [...this.employees]

      if (this.searchTerm) {
        const term = this.searchTerm.toLowerCase()
        filtered = filtered.filter(emp =>
          emp.first_name?.toLowerCase().includes(term) ||
          emp.last_name?.toLowerCase().includes(term) ||
          emp.employee_id?.toLowerCase().includes(term) ||
          emp.email?.toLowerCase().includes(term)
        )
      }

      if (this.filterDepartment) {
        filtered = filtered.filter(emp => emp.department === this.filterDepartment)
      }

      this.filteredEmployees = filtered
    },

    changePage(page) {
      if (page >= 1 && page <= this.pagination.last_page) {
        this.fetchEmployees(page)
      }
    },

    async deleteEmployee(employee) {
      if (confirm(`Are you sure you want to delete ${employee.first_name} ${employee.last_name}?`)) {
        try {
          await this.$http.delete(`/api/employees/${employee.id}`)
          window.showNotification?.('Employee deleted successfully')
          this.fetchEmployees()
        } catch (error) {
          console.error('Error deleting employee:', error)
          window.showNotification?.('Error deleting employee')
        }
      }
    },

    formatDate(date) {
      if (!date) return 'N/A'
      return new Date(date).toLocaleDateString()
    }
  },

  mounted() {
    this.fetchEmployees()
  }
}
</script>