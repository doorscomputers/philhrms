<template>
  <div class="bg-white w-64 min-h-screen shadow-lg border-r border-gray-200">
    <!-- Logo -->
    <div class="flex items-center justify-center h-16 px-6 border-b border-gray-200">
      <h1 class="text-xl font-bold text-gray-800">PH HRMS</h1>
    </div>

    <!-- Navigation -->
    <nav class="mt-6">
      <div class="px-4">
        <!-- Dashboard -->
        <a
          href="/dashboard"
          class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors mb-1"
        >
          <i class="fas fa-home mr-3 text-gray-500"></i>
          Dashboard
        </a>

        <!-- Employee Management Section -->
        <div class="mt-6">
          <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">
            Employee Management
          </h3>

          <router-link
            to="/employees"
            class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors mb-1"
            active-class="bg-gray-100 text-indigo-700 border-r-2 border-indigo-500"
          >
            <i class="fas fa-users mr-3 text-gray-500"></i>
            Employee Management
          </router-link>

          <router-link
            to="/employees/create"
            class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors mb-1"
            active-class="bg-gray-100 text-indigo-700 border-r-2 border-indigo-500"
          >
            <i class="fas fa-user-plus mr-3 text-gray-500"></i>
            Add Employee
          </router-link>
        </div>

        <!-- Time & Attendance Section (Admin/HR only) -->
        <div class="mt-6" v-if="hasAccess(['admin', 'hr'])">
          <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">
            Time & Attendance
          </h3>

          <button
            @click="toggleSubmenu('timeAttendance')"
            class="flex items-center justify-between w-full px-4 py-3 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors mb-1"
          >
            <div class="flex items-center">
              <i class="fas fa-clock mr-3 text-gray-500"></i>
              Time & Attendance
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
          <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">
            Organization
          </h3>

          <button
            @click="toggleSubmenu('organization')"
            class="flex items-center justify-between w-full px-4 py-3 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors mb-1"
          >
            <div class="flex items-center">
              <i class="fas fa-sitemap mr-3 text-gray-500"></i>
              Organization
            </div>
            <i class="fas fa-chevron-down text-gray-400 transition-transform"
               :class="{ 'rotate-180': openSubmenus.organization }"></i>
          </button>

          <div v-show="openSubmenus.organization" class="ml-6 mt-1 space-y-1">
            <router-link to="/companies" class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100">
              <i class="fas fa-building mr-3 text-gray-400"></i>Company Profile
            </router-link>
            <router-link to="/company-branches" class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100">
              <i class="fas fa-map-marker-alt mr-3 text-gray-400"></i>Branches/Offices
            </router-link>
            <router-link to="/api/departments" class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100">
              <i class="fas fa-building mr-3 text-gray-400"></i>Departments
            </router-link>
            <router-link to="/api/positions" class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100">
              <i class="fas fa-briefcase mr-3 text-gray-400"></i>Positions
            </router-link>
            <router-link to="/api/job-grades" class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100">
              <i class="fas fa-layer-group mr-3 text-gray-400"></i>Job Grades
            </router-link>
            <router-link to="/api/cost-centers" class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100">
              <i class="fas fa-calculator mr-3 text-gray-400"></i>Cost Centers
            </router-link>
            <router-link to="/api/work-schedules" class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100">
              <i class="fas fa-calendar mr-3 text-gray-400"></i>Work Schedules
            </router-link>
          </div>
        </div>

        <!-- Reports Section -->
        <div class="mt-6">
          <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">
            Reports & Analytics
          </h3>

          <router-link
            to="/audit-trails"
            class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors mb-1"
            active-class="bg-gray-100 text-indigo-700 border-r-2 border-indigo-500"
          >
            <i class="fas fa-history mr-3 text-gray-500"></i>
            Audit Trail
          </router-link>

          <a href="#" class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors mb-1">
            <i class="fas fa-chart-line mr-3 text-gray-500"></i>
            Reports
          </a>
        </div>

        <!-- Settings Section (Admin only) -->
        <div class="mt-6" v-if="hasAccess(['admin'])">
          <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">
            System
          </h3>

          <a href="#" class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors mb-1">
            <i class="fas fa-cog mr-3 text-gray-500"></i>
            Settings
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