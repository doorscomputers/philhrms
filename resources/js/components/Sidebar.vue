<template>
  <div class="bg-gradient-to-b from-blue-50 to-indigo-50 w-64 min-h-screen shadow-xl border-r border-blue-100">
    <!-- Logo -->
    <div class="flex items-center justify-center h-16 px-6 border-b border-blue-200 bg-white/50 backdrop-blur-sm">
      <div class="flex items-center space-x-2">
        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center">
          <i class="fas fa-users text-white text-sm"></i>
        </div>
        <h1 class="text-xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">PH HRMS</h1>
      </div>
    </div>

    <!-- Navigation -->
    <nav class="mt-6">
      <div class="px-4">
        <!-- Dashboard -->
        <a
          href="/dashboard"
          class="flex items-center px-4 py-3 text-gray-700 rounded-xl hover:bg-white/70 hover:shadow-md transition-all duration-200 mb-2 group"
        >
          <div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-blue-500 rounded-lg flex items-center justify-center mr-3 group-hover:scale-105 transition-transform">
            <i class="fas fa-home text-white text-sm"></i>
          </div>
          <span class="font-medium">Dashboard</span>
        </a>

        <!-- Employee Management Section -->
        <div class="mt-6">
          <h3 class="px-4 text-xs font-bold text-indigo-600 uppercase tracking-wider mb-4 flex items-center">
            <div class="w-1 h-4 bg-gradient-to-b from-indigo-400 to-indigo-600 rounded-full mr-2"></div>
            Employee Management
          </h3>

          <router-link
            to="/employees"
            class="flex items-center px-4 py-3 text-gray-700 rounded-xl hover:bg-white/70 hover:shadow-md transition-all duration-200 mb-2 group"
            active-class="bg-white shadow-lg text-indigo-700"
          >
            <div class="w-8 h-8 bg-gradient-to-br from-green-400 to-green-500 rounded-lg flex items-center justify-center mr-3 group-hover:scale-105 transition-transform">
              <i class="fas fa-users text-white text-sm"></i>
            </div>
            <span class="font-medium">Employee Management</span>
          </router-link>

          <router-link
            to="/employees/create"
            class="flex items-center px-4 py-3 text-gray-700 rounded-xl hover:bg-white/70 hover:shadow-md transition-all duration-200 mb-2 group"
            active-class="bg-white shadow-lg text-indigo-700"
          >
            <div class="w-8 h-8 bg-gradient-to-br from-emerald-400 to-emerald-500 rounded-lg flex items-center justify-center mr-3 group-hover:scale-105 transition-transform">
              <i class="fas fa-user-plus text-white text-sm"></i>
            </div>
            <span class="font-medium">Add Employee</span>
          </router-link>
        </div>

        <!-- Time & Attendance Section (Admin/HR only) -->
        <div class="mt-6" v-if="hasAccess(['admin', 'hr'])">
          <h3 class="px-4 text-xs font-bold text-indigo-600 uppercase tracking-wider mb-4 flex items-center">
            <div class="w-1 h-4 bg-gradient-to-b from-orange-400 to-orange-600 rounded-full mr-2"></div>
            Time & Attendance
          </h3>

          <button
            @click="toggleSubmenu('timeAttendance')"
            class="flex items-center justify-between w-full px-4 py-3 text-gray-700 rounded-xl hover:bg-white/70 hover:shadow-md transition-all duration-200 mb-2 group"
          >
            <div class="flex items-center">
              <div class="w-8 h-8 bg-gradient-to-br from-orange-400 to-orange-500 rounded-lg flex items-center justify-center mr-3 group-hover:scale-105 transition-transform">
                <i class="fas fa-clock text-white text-sm"></i>
              </div>
              <span class="font-medium">Time & Attendance</span>
            </div>
            <i class="fas fa-chevron-down text-gray-400 transition-transform"
               :class="{ 'rotate-180': openSubmenus.timeAttendance }"></i>
          </button>

          <div v-show="openSubmenus.timeAttendance" class="ml-6 mt-1 space-y-1">
            <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100">
              <i class="fas fa-list mr-3 text-gray-400"></i>Time Logs
            </a>
            <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100">
              <i class="fas fa-clock mr-3 text-gray-400"></i>Overtime Requests
            </a>
            <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100">
              <i class="fas fa-calendar-alt mr-3 text-gray-400"></i>Work Schedules
            </a>
          </div>
        </div>

        <!-- Leave Management Section (Admin/HR only) -->
        <div class="mt-6" v-if="hasAccess(['admin', 'hr'])">
          <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">
            Leave Management
          </h3>

          <button
            @click="toggleSubmenu('leaveManagement')"
            class="flex items-center justify-between w-full px-4 py-3 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors mb-1"
          >
            <div class="flex items-center">
              <i class="fas fa-calendar-times mr-3 text-gray-500"></i>
              Leave Management
            </div>
            <i class="fas fa-chevron-down text-gray-400 transition-transform"
               :class="{ 'rotate-180': openSubmenus.leaveManagement }"></i>
          </button>

          <div v-show="openSubmenus.leaveManagement" class="ml-6 mt-1 space-y-1">
            <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100">
              <i class="fas fa-file-alt mr-3 text-gray-400"></i>Leave Applications
            </a>
            <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100">
              <i class="fas fa-chart-bar mr-3 text-gray-400"></i>Leave Balances
            </a>
            <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100">
              <i class="fas fa-tags mr-3 text-gray-400"></i>Leave Types
            </a>
          </div>
        </div>

        <!-- Payroll Section (Admin/Finance only) -->
        <div class="mt-6" v-if="hasAccess(['admin', 'finance'])">
          <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">
            Payroll
          </h3>

          <button
            @click="toggleSubmenu('payroll')"
            class="flex items-center justify-between w-full px-4 py-3 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors mb-1"
          >
            <div class="flex items-center">
              <i class="fas fa-dollar-sign mr-3 text-gray-500"></i>
              Payroll
            </div>
            <i class="fas fa-chevron-down text-gray-400 transition-transform"
               :class="{ 'rotate-180': openSubmenus.payroll }"></i>
          </button>

          <div v-show="openSubmenus.payroll" class="ml-6 mt-1 space-y-1">
            <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100">
              <i class="fas fa-play-circle mr-3 text-gray-400"></i>Payroll Runs
            </a>
            <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100">
              <i class="fas fa-edit mr-3 text-gray-400"></i>Salary Adjustments
            </a>
            <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100">
              <i class="fas fa-file-invoice mr-3 text-gray-400"></i>Government Reports
            </a>
          </div>
        </div>

        <!-- Organization Section (Admin only) -->
        <div class="mt-6" v-if="hasAccess(['admin'])">
          <h3 class="px-4 text-xs font-bold text-indigo-600 uppercase tracking-wider mb-4 flex items-center">
            <div class="w-1 h-4 bg-gradient-to-b from-purple-400 to-purple-600 rounded-full mr-2"></div>
            Organization
          </h3>

          <button
            @click="toggleSubmenu('organization')"
            class="flex items-center justify-between w-full px-4 py-3 text-gray-700 rounded-xl hover:bg-white/70 hover:shadow-md transition-all duration-200 mb-2 group"
          >
            <div class="flex items-center">
              <div class="w-8 h-8 bg-gradient-to-br from-purple-400 to-purple-500 rounded-lg flex items-center justify-center mr-3 group-hover:scale-105 transition-transform">
                <i class="fas fa-sitemap text-white text-sm"></i>
              </div>
              <span class="font-medium">Organization</span>
            </div>
            <i class="fas fa-chevron-down text-gray-400 transition-transform"
               :class="{ 'rotate-180': openSubmenus.organization }"></i>
          </button>

          <div v-show="openSubmenus.organization" class="ml-4 mt-2 space-y-1 bg-white/30 rounded-xl p-3 backdrop-blur-sm">
            <router-link to="/companies" class="flex items-center px-3 py-2 text-sm text-gray-600 rounded-lg hover:bg-white/50 hover:shadow-sm transition-all">
              <i class="fas fa-building mr-3 text-blue-500"></i>Company Profile
            </router-link>
            <router-link to="/company-branches" class="flex items-center px-3 py-2 text-sm text-gray-600 rounded-lg hover:bg-white/50 hover:shadow-sm transition-all">
              <i class="fas fa-map-marker-alt mr-3 text-green-500"></i>Branches/Offices
            </router-link>
            <router-link to="/departments" class="flex items-center px-3 py-2 text-sm text-gray-600 rounded-lg hover:bg-white/50 hover:shadow-sm transition-all">
              <i class="fas fa-building mr-3 text-purple-500"></i>Departments
            </router-link>
            <router-link to="/positions" class="flex items-center px-3 py-2 text-sm text-gray-600 rounded-lg hover:bg-white/50 hover:shadow-sm transition-all">
              <i class="fas fa-briefcase mr-3 text-orange-500"></i>Positions
            </router-link>
            <router-link to="/job-grades" class="flex items-center px-3 py-2 text-sm text-gray-600 rounded-lg hover:bg-white/50 hover:shadow-sm transition-all">
              <i class="fas fa-layer-group mr-3 text-indigo-500"></i>Job Grades
            </router-link>
            <router-link to="/cost-centers" class="flex items-center px-3 py-2 text-sm text-gray-600 rounded-lg hover:bg-white/50 hover:shadow-sm transition-all">
              <i class="fas fa-calculator mr-3 text-teal-500"></i>Cost Centers
            </router-link>
            <router-link to="/work-schedules" class="flex items-center px-3 py-2 text-sm text-gray-600 rounded-lg hover:bg-white/50 hover:shadow-sm transition-all">
              <i class="fas fa-calendar mr-3 text-pink-500"></i>Work Schedules
            </router-link>
            <router-link to="/employment-statuses" class="flex items-center px-3 py-2 text-sm text-gray-600 rounded-lg hover:bg-white/50 hover:shadow-sm transition-all">
              <i class="fas fa-user-check mr-3 text-emerald-500"></i>Employment Statuses
            </router-link>
            <hr class="my-3 border-white/50">
            <router-link to="/manage-data" class="flex items-center px-3 py-2 text-sm text-blue-700 font-semibold rounded-lg bg-blue-100/50 hover:bg-blue-200/50 transition-all">
              <i class="fas fa-cogs mr-3 text-blue-600"></i>⭐ Manage All Data
            </router-link>
          </div>
        </div>

        <!-- Reports Section -->
        <div class="mt-6">
          <h3 class="px-4 text-xs font-bold text-indigo-600 uppercase tracking-wider mb-4 flex items-center">
            <div class="w-1 h-4 bg-gradient-to-b from-cyan-400 to-cyan-600 rounded-full mr-2"></div>
            Reports & Analytics
          </h3>

          <router-link
            to="/audit-trails"
            class="flex items-center px-4 py-3 text-gray-700 rounded-xl hover:bg-white/70 hover:shadow-md transition-all duration-200 mb-2 group"
            active-class="bg-white shadow-lg text-indigo-700"
          >
            <div class="w-8 h-8 bg-gradient-to-br from-cyan-400 to-cyan-500 rounded-lg flex items-center justify-center mr-3 group-hover:scale-105 transition-transform">
              <i class="fas fa-history text-white text-sm"></i>
            </div>
            <span class="font-medium">Audit Trail</span>
          </router-link>

          <a href="#" class="flex items-center px-4 py-3 text-gray-700 rounded-xl hover:bg-white/70 hover:shadow-md transition-all duration-200 mb-2 group">
            <div class="w-8 h-8 bg-gradient-to-br from-teal-400 to-teal-500 rounded-lg flex items-center justify-center mr-3 group-hover:scale-105 transition-transform">
              <i class="fas fa-chart-line text-white text-sm"></i>
            </div>
            <span class="font-medium">Reports</span>
          </a>
        </div>

        <!-- Settings Section (Admin only) -->
        <div class="mt-6" v-if="hasAccess(['admin'])">
          <h3 class="px-4 text-xs font-bold text-indigo-600 uppercase tracking-wider mb-4 flex items-center">
            <div class="w-1 h-4 bg-gradient-to-b from-red-400 to-red-600 rounded-full mr-2"></div>
            System
          </h3>

          <a href="#" class="flex items-center px-4 py-3 text-gray-700 rounded-xl hover:bg-white/70 hover:shadow-md transition-all duration-200 mb-2 group">
            <div class="w-8 h-8 bg-gradient-to-br from-red-400 to-red-500 rounded-lg flex items-center justify-center mr-3 group-hover:scale-105 transition-transform">
              <i class="fas fa-cog text-white text-sm"></i>
            </div>
            <span class="font-medium">Settings</span>
          </a>
        </div>
      </div>
    </nav>
  </div>
</template>

<script>
export default {
  name: 'Sidebar',
  data() {
    return {
      openSubmenus: {
        timeAttendance: false,
        leaveManagement: false,
        payroll: false,
        organization: false
      },
      // This would typically come from authentication/user store
      userRole: 'admin' // Example: 'admin', 'hr', 'finance', 'employee'
    }
  },
  methods: {
    toggleSubmenu(submenuName) {
      this.openSubmenus[submenuName] = !this.openSubmenus[submenuName]
    },

    hasAccess(roles) {
      // Simple role-based access control
      return roles.includes(this.userRole)
    }
  }
}
</script>

<style scoped>
.router-link-active {
  background-color: #f3f4f6; /* bg-gray-100 equivalent */
  color: #4338ca; /* text-indigo-700 equivalent */
  border-right: 2px solid #6366f1;
}

.rotate-180 {
  transform: rotate(180deg);
}
</style>