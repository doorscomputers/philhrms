<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 flex">
    <!-- Sidebar -->
    <Sidebar />

    <!-- Main Content Area -->
    <div class="flex-1 overflow-hidden">
      <!-- Top Header -->
      <header class="bg-white/80 backdrop-blur-sm shadow-sm border-b border-gray-200">
        <div class="px-6 py-4">
          <div class="flex items-center justify-between">
            <div>
              <h1 class="text-2xl font-bold text-gray-900">Admin Dashboard</h1>
              <p class="text-sm text-gray-600">Welcome back, manage your HR operations efficiently</p>
            </div>
            <div class="flex items-center space-x-4">
              <div class="relative">
                <button class="flex items-center space-x-2 text-gray-700 hover:text-gray-900 transition-colors">
                  <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center">
                    <span class="text-white text-sm font-medium">AU</span>
                  </div>
                  <span class="text-sm font-medium">Admin User</span>
                  <i class="fas fa-chevron-down text-xs"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
      </header>

      <!-- Dashboard Content -->
      <main class="p-6 overflow-y-auto" style="height: calc(100vh - 5rem);">
        <!-- Welcome Section -->
        <div class="mb-8 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-2xl p-6 text-white">
          <div class="flex items-center space-x-4">
            <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center">
              <span class="text-2xl font-bold">AU</span>
            </div>
            <div>
              <h2 class="text-2xl font-bold">Welcome Back, Admin User!</h2>
              <p class="text-blue-100">You have <span class="font-semibold">21 Pending Approvals</span> & <span class="font-semibold text-orange-200">14 Leave Requests</span></p>
            </div>
          </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
          <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="flex items-center justify-between">
              <div>
                <h3 class="text-lg font-semibold text-gray-900">Employee Management</h3>
                <p class="text-gray-600 text-sm">Manage your team</p>
              </div>
              <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-users text-blue-600 text-xl"></i>
              </div>
            </div>
            <div class="mt-4">
              <router-link to="/employees" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-arrow-right mr-2"></i>
                View Details
              </router-link>
            </div>
          </div>

          <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="flex items-center justify-between">
              <div>
                <h3 class="text-lg font-semibold text-gray-900">Add Employee</h3>
                <p class="text-gray-600 text-sm">Onboard new team member</p>
              </div>
              <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-plus text-green-600 text-xl"></i>
              </div>
            </div>
            <div class="mt-4">
              <router-link to="/employees/create" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                <i class="fas fa-user-plus mr-2"></i>
                Add Employee
              </router-link>
            </div>
          </div>

          <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="flex items-center justify-between">
              <div>
                <h3 class="text-lg font-semibold text-gray-900">Reports</h3>
                <p class="text-gray-600 text-sm">Analytics & insights</p>
              </div>
              <div class="w-12 h-12 bg-teal-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-chart-bar text-teal-600 text-xl"></i>
              </div>
            </div>
            <div class="mt-4">
              <button class="inline-flex items-center px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition-colors">
                <i class="fas fa-chart-line mr-2"></i>
                View Reports
              </button>
            </div>
          </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-2 lg:grid-cols-6 gap-6 mb-8">
          <!-- Attendance Overview -->
          <div class="lg:col-span-2 bg-white rounded-xl shadow-lg p-6 border-l-4 border-orange-400">
            <div class="flex items-center justify-between mb-4">
              <h3 class="text-lg font-semibold text-gray-900">Attendance Overview</h3>
              <button class="text-orange-600 hover:text-orange-700">
                <i class="fas fa-eye"></i>
                View Details
              </button>
            </div>
            <div class="text-3xl font-bold text-orange-600 mb-2">120/154</div>
            <div class="flex items-center text-sm text-green-600">
              <i class="fas fa-arrow-up mr-1"></i>
              +2.1%
            </div>
          </div>

          <!-- Infrastructure Projects -->
          <div class="lg:col-span-2 bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-400">
            <div class="flex items-center justify-between mb-4">
              <h3 class="text-lg font-semibold text-gray-900">Infrastructure Projects</h3>
              <button class="text-blue-600 hover:text-blue-700">
                <i class="fas fa-eye"></i>
                View Projects
              </button>
            </div>
            <div class="text-3xl font-bold text-blue-600 mb-2">12/18</div>
            <div class="flex items-center text-sm text-green-600">
              <i class="fas fa-arrow-up mr-1"></i>
              +8.2%
            </div>
          </div>

          <!-- Citizen Requests -->
          <div class="lg:col-span-2 bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between mb-4">
              <h3 class="text-lg font-semibold text-gray-900">Citizen Requests</h3>
              <button class="text-blue-600 hover:text-blue-700">
                <i class="fas fa-eye"></i>
                View Requests
              </button>
            </div>
            <div class="text-3xl font-bold text-blue-600 mb-2">156</div>
            <div class="flex items-center text-sm text-green-600">
              <i class="fas fa-arrow-up mr-1"></i>
              +15.4%
            </div>
          </div>

          <!-- Permits Issued -->
          <div class="lg:col-span-2 bg-white rounded-xl shadow-lg p-6 border-l-4 border-purple-400">
            <div class="flex items-center justify-between mb-4">
              <h3 class="text-lg font-semibold text-gray-900">Permits Issued</h3>
              <button class="text-purple-600 hover:text-purple-700">
                <i class="fas fa-eye"></i>
                View Permits
              </button>
            </div>
            <div class="text-3xl font-bold text-purple-600 mb-2">89</div>
            <div class="flex items-center text-sm text-green-600">
              <i class="fas fa-arrow-up mr-1"></i>
              +22.1%
            </div>
          </div>

          <!-- Budget Utilization -->
          <div class="lg:col-span-2 bg-white rounded-xl shadow-lg p-6 border-l-4 border-purple-500">
            <div class="flex items-center justify-between mb-4">
              <h3 class="text-lg font-semibold text-gray-900">Budget Utilization</h3>
              <button class="text-purple-600 hover:text-purple-700">
                <i class="fas fa-eye"></i>
                View Budget
              </button>
            </div>
            <div class="text-xl font-bold text-purple-600 mb-1">₱2.4M/₱3.2M</div>
            <div class="text-sm text-green-600">75% utilized</div>
          </div>

          <!-- Public Services -->
          <div class="lg:col-span-2 bg-white rounded-xl shadow-lg p-6 border-l-4 border-red-400">
            <div class="flex items-center justify-between mb-4">
              <h3 class="text-lg font-semibold text-gray-900">Public Services</h3>
              <button class="text-red-600 hover:text-red-700">
                <i class="fas fa-eye"></i>
                View Services
              </button>
            </div>
            <div class="text-3xl font-bold text-red-600 mb-2">245</div>
            <div class="flex items-center text-sm text-green-600">
              <i class="fas fa-arrow-up mr-1"></i>
              +12.3%
            </div>
          </div>
        </div>

        <!-- Bottom Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
          <!-- Employee Status -->
          <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Employee Status - This Week</h3>
            <div class="space-y-4">
              <div class="flex items-center justify-between">
                <div class="flex items-center">
                  <div class="w-2 h-2 bg-orange-400 rounded-full mr-3"></div>
                  <span class="text-sm text-gray-600">Fulltime (48%)</span>
                </div>
                <span class="text-sm font-medium">112</span>
              </div>
              <div class="text-2xl font-bold text-gray-900">154</div>
              <div class="text-sm text-gray-500">Total Employee</div>
            </div>
          </div>

          <!-- Attendance Overview -->
          <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Attendance Overview - Today</h3>
            <div class="flex items-center justify-center">
              <div class="relative w-32 h-32">
                <div class="absolute inset-0 flex items-center justify-center">
                  <div class="text-center">
                    <div class="text-2xl font-bold text-gray-900">120</div>
                    <div class="text-sm text-gray-500">Total Attendance</div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Clock In/Out -->
          <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
              <h3 class="text-lg font-semibold text-gray-900">Clock-In/Out</h3>
              <select class="text-sm border border-gray-300 rounded-lg px-3 py-1">
                <option>All Departments</option>
              </select>
            </div>
            <div class="space-y-3">
              <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                  <span class="text-xs font-medium text-blue-600">DE</span>
                </div>
                <div class="flex-1">
                  <div class="text-sm font-medium text-gray-900">Daniel Esbella</div>
                  <div class="text-xs text-gray-500">UI/UX Designer</div>
                </div>
                <div class="text-xs text-gray-500">09:15</div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import Sidebar from '@/components/Sidebar.vue'

// Sample data - replace with actual API calls
const stats = ref({
  totalEmployees: 154,
  activeEmployees: 112,
  attendance: 120,
  pendingApprovals: 21
})
</script>

<style scoped>
/* Custom styles for the dashboard */
.card {
  @apply bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow;
}
</style>