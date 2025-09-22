<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <div class="flex">
            <div class="flex-shrink-0 flex items-center">
              <h1 class="text-xl font-bold text-gray-900">PH HRMS</h1>
            </div>
            <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
              <router-link
                to="/employees"
                class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm"
                active-class="border-blue-500 text-blue-600"
              >
                <i class="fas fa-users mr-2"></i>Employees
              </router-link>

              <div class="relative" @mouseenter="showManagement = true" @mouseleave="showManagement = false">
                <button class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm flex items-center">
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

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
      <!-- Header -->
      <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
        <p class="mt-2 text-gray-600">Welcome to PH HRMS - Employee Management System</p>
      </div>

      <!-- Stats Grid -->
      <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">
        <!-- Total Employees -->
        <div class="card">
          <div class="p-6">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                  <i class="fas fa-users text-blue-600"></i>
                </div>
              </div>
              <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Total Employees</p>
                <p class="text-2xl font-bold text-gray-900">{{ stats.totalEmployees }}</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Active Employees -->
        <div class="card">
          <div class="p-6">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                  <i class="fas fa-user-check text-green-600"></i>
                </div>
              </div>
              <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Active Employees</p>
                <p class="text-2xl font-bold text-gray-900">{{ stats.activeEmployees }}</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Departments -->
        <div class="card">
          <div class="p-6">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                  <i class="fas fa-building text-purple-600"></i>
                </div>
              </div>
              <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Departments</p>
                <p class="text-2xl font-bold text-gray-900">{{ stats.departments }}</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Positions -->
        <div class="card">
          <div class="p-6">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center">
                  <i class="fas fa-briefcase text-orange-600"></i>
                </div>
              </div>
              <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Positions</p>
                <p class="text-2xl font-bold text-gray-900">{{ stats.positions }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Quick Actions -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-rocket mr-3 text-blue-600"></i>Quick Actions
            </h3>
            <p class="card-description">Frequently used actions</p>
          </div>
          <div class="card-content">
            <div class="space-y-3">
              <router-link to="/employees/create" class="btn btn-primary w-full">
                <i class="fas fa-user-plus mr-2"></i>Add New Employee
              </router-link>
              <router-link to="/employees" class="btn btn-secondary w-full">
                <i class="fas fa-list mr-2"></i>View All Employees
              </router-link>
              <router-link to="/management/departments" class="btn btn-secondary w-full">
                <i class="fas fa-cogs mr-2"></i>Manage Data
              </router-link>
            </div>
          </div>
        </div>

        <!-- Recent Activity -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-clock mr-3 text-green-600"></i>Recent Activity
            </h3>
            <p class="card-description">Latest system activities</p>
          </div>
          <div class="card-content">
            <div class="space-y-4">
              <div v-for="activity in recentActivity" :key="activity.id" class="flex items-center space-x-3">
                <div class="flex-shrink-0">
                  <div class="w-2 h-2 bg-blue-400 rounded-full"></div>
                </div>
                <div class="flex-1 min-w-0">
                  <p class="text-sm text-gray-900">{{ activity.description }}</p>
                  <p class="text-xs text-gray-500">{{ formatDate(activity.created_at) }}</p>
                </div>
              </div>

              <div v-if="recentActivity.length === 0" class="text-center py-4">
                <p class="text-sm text-gray-500">No recent activity</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Notification -->
    <div v-if="notification" class="fixed top-4 right-4 z-50">
      <div class="bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg">
        {{ notification }}
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Dashboard',
  data() {
    return {
      showManagement: false,
      notification: null,
      stats: {
        totalEmployees: 0,
        activeEmployees: 0,
        departments: 0,
        positions: 0
      },
      recentActivity: []
    }
  },
  methods: {
    async fetchStats() {
      try {
        const response = await this.$http.get('/api/dashboard/stats')
        this.stats = response.data
      } catch (error) {
        console.error('Error fetching stats:', error)
      }
    },

    async fetchRecentActivity() {
      try {
        const response = await this.$http.get('/api/dashboard/recent-activity')
        this.recentActivity = response.data
      } catch (error) {
        console.error('Error fetching recent activity:', error)
      }
    },

    formatDate(date) {
      if (!date) return ''
      return new Date(date).toLocaleDateString()
    },

    showNotification(message) {
      this.notification = message
      setTimeout(() => {
        this.notification = null
      }, 3000)
    }
  },

  mounted() {
    this.fetchStats()
    this.fetchRecentActivity()

    // Global notification handler
    window.showNotification = this.showNotification
  }
}
</script>