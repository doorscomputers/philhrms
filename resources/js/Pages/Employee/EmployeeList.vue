<template>
  <AppLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Employee Management
      </h2>
    </template>

    <div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-cyan-50">

    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 text-white">
      <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between">
          <div>
            <nav class="flex items-center space-x-2 text-indigo-200 mb-4">
              <button @click="navigateToDashboard" class="hover:text-white transition-colors">
                <i class="fas fa-home"></i>
              </button>
              <i class="fas fa-chevron-right text-xs"></i>
              <span class="text-white font-medium">Employees</span>
            </nav>
            <h1 class="text-4xl font-bold mb-2">Employee Management</h1>
            <p class="text-indigo-100 text-lg">Manage your team with powerful tools and insights</p>
          </div>
          <div class="hidden md:block">
            <div class="flex items-center space-x-4">
              <div class="text-center">
                <div class="text-2xl font-bold">{{ props.employees.data?.length || 0 }}</div>
                <div class="text-indigo-200 text-sm">Total Employees</div>
              </div>
              <div class="w-px h-12 bg-indigo-400"></div>
              <div class="text-center">
                <div class="text-2xl font-bold">{{ activeEmployees }}</div>
                <div class="text-indigo-200 text-sm">Active</div>
              </div>
              <div class="w-px h-12 bg-indigo-400"></div>
              <Link
                href="/spa/employees/create"
                class="bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white px-6 py-3 rounded-xl font-semibold transition-all duration-200 hover:scale-105 hover:shadow-xl"
              >
                <i class="fas fa-plus mr-2"></i>Add Employee
              </Link>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 -mt-4 relative z-10">

      <!-- HR Dashboard Insights -->
      <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-8">
        <!-- Quick Stats Row -->
        <div class="lg:col-span-4 grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
          <!-- Total Employees -->
          <div class="bg-gradient-to-r from-blue-500 to-cyan-500 rounded-2xl p-6 text-white">
            <div class="flex items-center">
              <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mr-4">
                <i class="fas fa-users text-xl"></i>
              </div>
              <div>
                <p class="text-blue-100 text-sm">Total Employees</p>
                <p class="text-2xl font-bold">{{ hrInsights?.totalEmployees || 0 }}</p>
              </div>
            </div>
          </div>

          <!-- Active Employees -->
          <div class="bg-gradient-to-r from-emerald-500 to-teal-500 rounded-2xl p-6 text-white">
            <div class="flex items-center">
              <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mr-4">
                <i class="fas fa-user-check text-xl"></i>
              </div>
              <div>
                <p class="text-emerald-100 text-sm">Active Employees</p>
                <p class="text-2xl font-bold">{{ hrInsights?.activeEmployees || 0 }}</p>
              </div>
            </div>
          </div>

          <!-- Gender Distribution -->
          <div class="bg-gradient-to-r from-purple-500 to-pink-500 rounded-2xl p-6 text-white">
            <div class="flex items-center">
              <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mr-4">
                <i class="fas fa-venus-mars text-xl"></i>
              </div>
              <div>
                <p class="text-purple-100 text-sm">Gender Split</p>
                <p class="text-sm font-medium">
                  M: {{ hrInsights?.genderStats?.Male || 0 }} |
                  F: {{ hrInsights?.genderStats?.Female || 0 }}
                </p>
              </div>
            </div>
          </div>

          <!-- Birthdays This Month -->
          <div class="bg-gradient-to-r from-amber-500 to-orange-500 rounded-2xl p-6 text-white cursor-pointer hover:shadow-lg transition-all"
               @click="showBirthdayModal = true">
            <div class="flex items-center">
              <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mr-4">
                <i class="fas fa-birthday-cake text-xl"></i>
              </div>
              <div>
                <p class="text-amber-100 text-sm">{{ hrInsights?.currentMonth }} Birthdays</p>
                <p class="text-2xl font-bold">{{ hrInsights?.birthdaysThisMonth?.length || 0 }}</p>
                <p class="text-xs text-amber-200">Click to view</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Department Distribution Chart -->
        <div class="lg:col-span-2 bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-white/20 p-6">
          <div class="flex items-center mb-4">
            <div class="w-10 h-10 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-xl flex items-center justify-center mr-3">
              <i class="fas fa-sitemap text-white"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-800">Department Distribution</h3>
          </div>
          <div class="space-y-3">
            <div v-for="(count, department) in hrInsights?.departmentStats" :key="department"
                 class="flex items-center justify-between">
              <div class="flex items-center">
                <div class="w-3 h-3 bg-indigo-500 rounded-full mr-3"></div>
                <span class="text-sm font-medium text-gray-700">{{ department }}</span>
              </div>
              <div class="flex items-center">
                <span class="text-sm font-bold text-gray-900 mr-2">{{ count }}</span>
                <div class="w-20 h-2 bg-gray-200 rounded-full overflow-hidden">
                  <div class="h-full bg-indigo-500 transition-all duration-300"
                       :style="{ width: `${(count / hrInsights?.totalEmployees) * 100}%` }"></div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Recent Activity -->
        <div class="lg:col-span-2 bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-white/20 p-6">
          <div class="flex items-center mb-4">
            <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-emerald-500 rounded-xl flex items-center justify-center mr-3">
              <i class="fas fa-clock text-white"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-800">Recent Activity</h3>
          </div>

          <!-- Recent Hires -->
          <div class="mb-4">
            <h4 class="text-sm font-medium text-gray-600 mb-2">Recent Hires (Last 30 days)</h4>
            <div v-if="hrInsights?.recentHires?.length > 0" class="space-y-2">
              <div v-for="hire in hrInsights.recentHires.slice(0, 3)" :key="hire.id"
                   class="flex items-center justify-between bg-green-50 rounded-lg p-2">
                <div>
                  <p class="text-sm font-medium text-gray-900">{{ hire.first_name }} {{ hire.last_name }}</p>
                  <p class="text-xs text-gray-500">{{ hire.department?.name || 'No Department' }}</p>
                </div>
                <span class="text-xs text-green-600 font-medium">{{ formatDate(hire.hire_date) }}</span>
              </div>
              <button v-if="hrInsights.recentHires.length > 3"
                      @click="showRecentHiresModal = true"
                      class="text-xs text-indigo-600 hover:text-indigo-800 font-medium">
                View all {{ hrInsights.recentHires.length }} recent hires
              </button>
            </div>
            <p v-else class="text-sm text-gray-500 italic">No recent hires</p>
          </div>

          <!-- Upcoming Events -->
          <div>
            <h4 class="text-sm font-medium text-gray-600 mb-2">Upcoming Events</h4>
            <div v-if="hrInsights?.upcomingEvents?.length > 0" class="space-y-2">
              <div v-for="event in hrInsights.upcomingEvents.slice(0, 3)" :key="event.id"
                   class="flex items-center justify-between bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-3 border border-blue-100">
                <div class="flex items-center space-x-3">
                  <div class="w-8 h-8 rounded-full flex items-center justify-center"
                       :style="{ backgroundColor: event.color + '20', color: event.color }">
                    <i :class="getEventIcon(event.event_type)" class="text-xs"></i>
                  </div>
                  <div>
                    <p class="text-sm font-medium text-gray-900">{{ event.title }}</p>
                    <p class="text-xs text-gray-500">{{ getEventTypeName(event.event_type) }}</p>
                    <p class="text-xs text-blue-600">{{ formatDate(event.event_date) }}</p>
                  </div>
                </div>
                <div class="text-right">
                  <span class="text-xs font-medium" :class="getPriorityClass(event.priority)">
                    {{ event.priority.toUpperCase() }}
                  </span>
                  <p v-if="event.formatted_time" class="text-xs text-gray-500">{{ event.formatted_time }}</p>
                </div>
              </div>
              <button v-if="hrInsights.upcomingEvents.length > 3"
                      @click="showUpcomingEventsModal = true"
                      class="text-xs text-indigo-600 hover:text-indigo-800 font-medium">
                View all {{ hrInsights.upcomingEvents.length }} upcoming events
              </button>
            </div>
            <p v-else class="text-sm text-gray-500 italic">No upcoming events</p>
          </div>
        </div>

        <!-- Age & Employment Type Distribution -->
        <div class="lg:col-span-2 bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-white/20 p-6">
          <div class="flex items-center mb-4">
            <div class="w-10 h-10 bg-gradient-to-r from-rose-500 to-pink-500 rounded-xl flex items-center justify-center mr-3">
              <i class="fas fa-chart-pie text-white"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-800">Demographics</h3>
          </div>

          <!-- Age Distribution -->
          <div class="mb-4">
            <h4 class="text-sm font-medium text-gray-600 mb-2">Age Groups</h4>
            <div class="space-y-2">
              <div v-for="(count, ageGroup) in hrInsights?.ageStats" :key="ageGroup"
                   class="flex items-center justify-between">
                <span class="text-sm text-gray-700">{{ ageGroup }}</span>
                <div class="flex items-center">
                  <span class="text-sm font-medium text-gray-900 mr-2">{{ count }}</span>
                  <div class="w-16 h-2 bg-gray-200 rounded-full overflow-hidden">
                    <div class="h-full bg-rose-500 transition-all duration-300"
                         :style="{ width: `${(count / hrInsights?.totalEmployees) * 100}%` }"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Employment Type Distribution -->
          <div>
            <h4 class="text-sm font-medium text-gray-600 mb-2">Employment Types</h4>
            <div class="space-y-2">
              <div v-for="(count, type) in hrInsights?.employmentTypeStats" :key="type"
                   class="flex items-center justify-between">
                <span class="text-sm text-gray-700">{{ type }}</span>
                <div class="flex items-center">
                  <span class="text-sm font-medium text-gray-900 mr-2">{{ count }}</span>
                  <div class="w-16 h-2 bg-gray-200 rounded-full overflow-hidden">
                    <div class="h-full bg-pink-500 transition-all duration-300"
                         :style="{ width: `${(count / hrInsights?.totalEmployees) * 100}%` }"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Quick Actions -->
        <div class="lg:col-span-2 bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-white/20 p-6">
          <div class="flex items-center mb-4">
            <div class="w-10 h-10 bg-gradient-to-r from-violet-500 to-purple-500 rounded-xl flex items-center justify-center mr-3">
              <i class="fas fa-bolt text-white"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-800">Quick Actions</h3>
          </div>
          <div class="grid grid-cols-2 gap-3">
            <Link href="/spa/employees/create"
                  class="flex items-center justify-center bg-gradient-to-r from-blue-500 to-cyan-500 text-white rounded-xl p-3 hover:shadow-lg transition-all">
              <i class="fas fa-plus mr-2"></i>
              <span class="text-sm font-medium">Add Employee</span>
            </Link>
            <button @click="exportEmployees"
                    class="flex items-center justify-center bg-gradient-to-r from-emerald-500 to-teal-500 text-white rounded-xl p-3 hover:shadow-lg transition-all">
              <i class="fas fa-download mr-2"></i>
              <span class="text-sm font-medium">Export Data</span>
            </button>
            <button @click="showBirthdayModal = true"
                    class="flex items-center justify-center bg-gradient-to-r from-amber-500 to-orange-500 text-white rounded-xl p-3 hover:shadow-lg transition-all">
              <i class="fas fa-birthday-cake mr-2"></i>
              <span class="text-sm font-medium">Birthdays</span>
            </button>
            <button @click="generateReport"
                    class="flex items-center justify-center bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-xl p-3 hover:shadow-lg transition-all">
              <i class="fas fa-chart-bar mr-2"></i>
              <span class="text-sm font-medium">Reports</span>
            </button>
          </div>
        </div>
      </div>

      <!-- Search and Filters Card -->
      <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-white/20 mb-8 overflow-hidden">
        <div class="p-6">
          <div class="flex items-center mb-6">
            <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center mr-3">
              <i class="fas fa-search text-white"></i>
            </div>
            <h2 class="text-xl font-semibold text-gray-800">Search & Filter</h2>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Search Input -->
            <div class="relative group">
              <label class="block text-sm font-medium text-gray-700 mb-2">Search Employees</label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                  <i class="fas fa-search text-gray-400 group-focus-within:text-indigo-500 transition-colors"></i>
                </div>
                <input
                  v-model="filters.search"
                  type="text"
                  placeholder="Name, ID, email..."
                  class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 hover:bg-white"
                  @input="debounceSearch"
                >
              </div>
            </div>

            <!-- Department Filter -->
            <div class="relative group">
              <label class="block text-sm font-medium text-gray-700 mb-2">Department</label>
              <select
                v-model="filters.department"
                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 hover:bg-white appearance-none cursor-pointer"
                @change="filterEmployees"
              >
                <option value="">All Departments</option>
                <option v-for="dept in props.departments" :key="dept.id" :value="dept.name">{{ dept.name }}</option>
              </select>
              <i class="fas fa-chevron-down absolute right-4 top-11 text-gray-400 pointer-events-none"></i>
            </div>

            <!-- Status Filter -->
            <div class="relative group">
              <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
              <select
                v-model="filters.status"
                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 hover:bg-white appearance-none cursor-pointer"
                @change="filterEmployees"
              >
                <option value="">All Status</option>
                <option v-for="status in props.employmentStatuses" :key="status.id" :value="status.name">
                  {{ status.name }}
                </option>
              </select>
              <i class="fas fa-chevron-down absolute right-4 top-11 text-gray-400 pointer-events-none"></i>
            </div>

            <!-- Employment Type Filter -->
            <div class="relative group">
              <label class="block text-sm font-medium text-gray-700 mb-2">Employment Type</label>
              <select
                v-model="filters.employment_type"
                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 hover:bg-white appearance-none cursor-pointer"
                @change="filterEmployees"
              >
                <option value="">All Types</option>
                <option v-for="type in props.employmentTypes" :key="type.value" :value="type.value">
                  {{ type.label }}
                </option>
              </select>
              <i class="fas fa-chevron-down absolute right-4 top-11 text-gray-400 pointer-events-none"></i>
            </div>
          </div>
        </div>
      </div>

      <!-- Employee Grid/Table -->
      <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-white/20 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
          <div class="flex items-center justify-between">
            <div class="flex items-center">
              <div class="w-10 h-10 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-xl flex items-center justify-center mr-3">
                <i class="fas fa-users text-white"></i>
              </div>
              <div>
                <h2 class="text-xl font-semibold text-gray-800">Employee Directory</h2>
                <p class="text-gray-600 text-sm">Manage and view all employees in your organization</p>
              </div>
            </div>
            <div class="flex items-center space-x-3">
              <button class="p-2 text-gray-400 hover:text-gray-600 transition-colors" title="Grid View">
                <i class="fas fa-th-large"></i>
              </button>
              <button class="p-2 text-indigo-600 transition-colors" title="List View">
                <i class="fas fa-list"></i>
              </button>
            </div>
          </div>
        </div>

        <!-- Employee Table -->
        <div v-if="filteredEmployees.length > 0" class="overflow-x-auto">
          <table class="w-full">
            <thead class="bg-gray-50/50">
              <tr>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Employee</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Position</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Department</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Hire Date</th>
                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
              <tr
                v-for="employee in filteredEmployees"
                :key="employee.id"
                class="hover:bg-gray-100/50 transition-all duration-200 group"
              >
                <td class="px-6 py-5">
                  <div class="flex items-center">
                    <div class="relative">
                      <img
                        v-if="getPhotoUrl(employee)"
                        :src="getPhotoUrl(employee)"
                        :alt="employee.first_name"
                        class="w-12 h-12 rounded-full object-cover ring-2 ring-white shadow-lg"
                        @error="$event.target.style.display = 'none'"
                      >
                      <div
                        v-else
                        class="w-12 h-12 rounded-full bg-gradient-to-r from-indigo-500 to-purple-500 flex items-center justify-center ring-2 ring-white shadow-lg"
                      >
                        <span class="text-white font-semibold">
                          {{ getInitials(employee.first_name, employee.last_name) }}
                        </span>
                      </div>
                      <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-400 rounded-full border-2 border-white"></div>
                    </div>
                    <div class="ml-4">
                      <div class="font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors">
                        {{ employee.first_name }} {{ employee.last_name }}
                      </div>
                      <div class="text-sm text-gray-500">{{ employee.employee_id || 'No ID' }}</div>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-5 text-sm text-gray-900 font-medium">
                  {{ employee.position?.title || 'Not Assigned' }}
                </td>
                <td class="px-6 py-5 text-sm text-gray-600">
                  {{ employee.department?.name || 'Not Assigned' }}
                </td>
                <td class="px-6 py-5">
                  <span
                    :class="getStatusClass(employee.employment_status?.name)"
                    class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full"
                  >
                    <div :class="getStatusDotClass(employee.employment_status?.name)" class="w-1.5 h-1.5 rounded-full mr-2"></div>
                    {{ employee.employment_status?.name || 'Active Employee' }}
                  </span>
                </td>
                <td class="px-6 py-5 text-sm text-gray-600">
                  {{ formatDate(employee.hire_date) }}
                </td>
                <td class="px-6 py-5 text-right">
                  <div class="flex items-center justify-end space-x-2">
                    <Link
                      :href="`/spa/employees/${employee.id}`"
                      class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-gray-100 rounded-lg transition-all duration-200"
                      title="View Employee"
                    >
                      <i class="fas fa-eye"></i>
                    </Link>
                    <Link
                      :href="`/spa/employees/${employee.id}/edit`"
                      class="p-2 text-gray-400 hover:text-emerald-600 hover:bg-emerald-100 rounded-lg transition-all duration-200"
                      title="Edit Employee"
                    >
                      <i class="fas fa-edit"></i>
                    </Link>
                    <button
                      @click="deleteEmployee(employee)"
                      class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-100 rounded-lg transition-all duration-200"
                      title="Delete Employee"
                    >
                      <i class="fas fa-trash"></i>
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Empty State -->
        <div v-else class="text-center py-20">
          <div class="max-w-md mx-auto">
            <div class="w-24 h-24 bg-gradient-to-r from-gray-100 to-gray-200 rounded-full flex items-center justify-center mx-auto mb-6">
              <i class="fas fa-users text-gray-400 text-3xl"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">No employees found</h3>
            <p class="text-gray-500 mb-8">Get started by creating your first employee or adjust your search filters.</p>
            <Link
              href="/spa/employees/create"
              class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-xl hover:shadow-lg transition-all duration-200 hover:scale-105"
            >
              <i class="fas fa-plus mr-2"></i>Add Your First Employee
            </Link>
          </div>
        </div>

        <!-- Pagination -->
        <div v-if="props.employees.last_page && props.employees.last_page > 1" class="px-6 py-4 bg-gray-50/50 border-t border-gray-100">
          <div class="flex items-center justify-between">
            <div class="text-sm text-gray-600">
              Showing {{ props.employees.from }} to {{ props.employees.to }} of {{ props.employees.total }} employees
            </div>
            <div class="flex items-center space-x-2">
              <Link
                v-if="props.employees.prev_page_url"
                :href="props.employees.prev_page_url"
                class="px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-all duration-200"
              >
                Previous
              </Link>
              <span v-else class="px-4 py-2 text-sm font-medium text-gray-300 bg-gray-100 border border-gray-200 rounded-lg">
                Previous
              </span>

              <div class="flex items-center space-x-1">
                <span class="px-3 py-2 text-sm font-medium bg-indigo-600 text-white border border-gray-200 rounded-lg">
                  {{ props.employees.current_page }}
                </span>
                <span class="text-sm text-gray-500">of {{ props.employees.last_page }}</span>
              </div>

              <Link
                v-if="props.employees.next_page_url"
                :href="props.employees.next_page_url"
                class="px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-all duration-200"
              >
                Next
              </Link>
              <span v-else class="px-4 py-2 text-sm font-medium text-gray-300 bg-gray-100 border border-gray-200 rounded-lg">
                Next
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Quick Add FAB -->
    <Link
      href="/spa/employees/create"
      class="fixed bottom-8 right-8 w-16 h-16 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-full flex items-center justify-center shadow-2xl hover:shadow-3xl transition-all duration-300 hover:scale-110 z-50"
      title="Add Employee"
    >
      <i class="fas fa-plus text-xl"></i>
    </Link>

    <!-- Birthday Modal -->
    <div v-if="showBirthdayModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white rounded-2xl p-6 max-w-md w-full mx-4 max-h-96 overflow-y-auto">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-lg font-semibold text-gray-900">{{ hrInsights?.currentMonth }} Birthdays</h3>
          <button @click="showBirthdayModal = false" class="text-gray-400 hover:text-gray-600">
            <i class="fas fa-times"></i>
          </button>
        </div>
        <div v-if="hrInsights?.birthdaysThisMonth?.length > 0" class="space-y-3">
          <div v-for="birthday in hrInsights.birthdaysThisMonth" :key="birthday.id"
               class="flex items-center justify-between bg-amber-50 rounded-lg p-3">
            <div>
              <p class="font-medium text-gray-900">{{ birthday.first_name }} {{ birthday.last_name }}</p>
              <p class="text-sm text-gray-600">{{ formatDate(birthday.birth_date) }}</p>
            </div>
            <div class="text-amber-600">
              <i class="fas fa-birthday-cake"></i>
            </div>
          </div>
        </div>
        <p v-else class="text-gray-500 text-center py-4">No birthdays this month!</p>
      </div>
    </div>

    <!-- Recent Hires Modal -->
    <div v-if="showRecentHiresModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white rounded-2xl p-6 max-w-lg w-full mx-4 max-h-96 overflow-y-auto">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-lg font-semibold text-gray-900">Recent Hires (Last 30 Days)</h3>
          <button @click="showRecentHiresModal = false" class="text-gray-400 hover:text-gray-600">
            <i class="fas fa-times"></i>
          </button>
        </div>
        <div v-if="hrInsights?.recentHires?.length > 0" class="space-y-3">
          <div v-for="hire in hrInsights.recentHires" :key="hire.id"
               class="flex items-center justify-between bg-green-50 rounded-lg p-3">
            <div>
              <p class="font-medium text-gray-900">{{ hire.first_name }} {{ hire.last_name }}</p>
              <p class="text-sm text-gray-600">{{ hire.department?.name || 'No Department' }}</p>
              <p class="text-xs text-green-600">Hired: {{ formatDate(hire.hire_date) }}</p>
            </div>
            <Link :href="`/spa/employees/${hire.id}`"
                  class="text-indigo-600 hover:text-indigo-800">
              <i class="fas fa-eye"></i>
            </Link>
          </div>
        </div>
        <p v-else class="text-gray-500 text-center py-4">No recent hires!</p>
      </div>
    </div>

    <!-- Upcoming Events Modal -->
    <div v-if="showUpcomingEventsModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white rounded-2xl p-6 max-w-2xl w-full mx-4 max-h-96 overflow-y-auto">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-lg font-semibold text-gray-900">Upcoming Events (Next 30 Days)</h3>
          <button @click="showUpcomingEventsModal = false" class="text-gray-400 hover:text-gray-600">
            <i class="fas fa-times"></i>
          </button>
        </div>
        <div v-if="hrInsights?.upcomingEvents?.length > 0" class="space-y-4">
          <div v-for="event in hrInsights.upcomingEvents" :key="event.id"
               class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-4 border border-blue-100 hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between">
              <div class="flex items-start space-x-4">
                <div class="w-12 h-12 rounded-full flex items-center justify-center flex-shrink-0"
                     :style="{ backgroundColor: event.color + '20', color: event.color }">
                  <i :class="getEventIcon(event.event_type)" class="text-lg"></i>
                </div>
                <div class="flex-1">
                  <h4 class="font-semibold text-gray-900 mb-1">{{ event.title }}</h4>
                  <p class="text-sm text-gray-600 mb-2">{{ getEventTypeName(event.event_type) }}</p>
                  <div class="flex items-center space-x-4 text-xs text-gray-500">
                    <span class="flex items-center">
                      <i class="fas fa-calendar mr-1"></i>{{ formatDate(event.event_date) }}
                    </span>
                    <span v-if="event.formatted_time" class="flex items-center">
                      <i class="fas fa-clock mr-1"></i>{{ event.formatted_time }}
                    </span>
                    <span v-if="event.location" class="flex items-center">
                      <i class="fas fa-map-marker-alt mr-1"></i>{{ event.location }}
                    </span>
                  </div>
                  <p v-if="event.description" class="text-sm text-gray-700 mt-2">{{ event.description }}</p>
                </div>
              </div>
              <div class="flex flex-col items-end space-y-2">
                <span class="text-xs font-medium" :class="getPriorityClass(event.priority)">
                  {{ event.priority.toUpperCase() }}
                </span>
                <span v-if="event.days_until !== undefined" class="text-xs text-gray-500">
                  {{ event.days_until === 0 ? 'Today' : event.days_until > 0 ? `In ${event.days_until} days` : `${Math.abs(event.days_until)} days ago` }}
                </span>
              </div>
            </div>
          </div>
        </div>
        <p v-else class="text-gray-500 text-center py-4">No upcoming events!</p>
      </div>
    </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Link, router, useForm } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({
  employees: Object,
  departments: Array,
  positions: Array,
  employmentStatuses: Array,
  employmentTypes: Array,
  hrInsights: Object
})

const showManagement = ref(false)
const showBirthdayModal = ref(false)
const showRecentHiresModal = ref(false)
const showUpcomingEventsModal = ref(false)
const filters = ref({
  search: '',
  department: '',
  status: '',
  employment_type: ''
})
const filteredEmployees = computed(() => {
  if (!props.employees?.data) return []

  let filtered = props.employees.data

  // Apply search filter
  if (filters.value.search) {
    const search = filters.value.search.toLowerCase()
    filtered = filtered.filter(emp =>
      emp.first_name?.toLowerCase().includes(search) ||
      emp.last_name?.toLowerCase().includes(search) ||
      emp.employee_id?.toLowerCase().includes(search) ||
      emp.email_addresses?.some(email => email.email?.toLowerCase().includes(search))
    )
  }

  // Apply department filter
  if (filters.value.department) {
    filtered = filtered.filter(emp => emp.department?.name === filters.value.department)
  }

  // Apply status filter
  if (filters.value.status) {
    filtered = filtered.filter(emp => emp.employment_status?.name === filters.value.status)
  }

  // Apply employment type filter
  if (filters.value.employment_type) {
    filtered = filtered.filter(emp => emp.employment_type === filters.value.employment_type)
  }

  return filtered
})

const activeEmployees = computed(() => {
  if (!props.employees?.data) return 0
  return props.employees.data.filter(emp => !emp.employment_status?.name || emp.employment_status?.name === 'Active Employee').length
})
const deleteEmployee = async (employee) => {
  console.log('Employee object:', employee)

  if (confirm(`Are you sure you want to delete ${employee.first_name} ${employee.last_name}?\n\nThis action cannot be undone.`)) {
    console.log(`Deleting employee ID: ${employee.id}`)

    // Use POST with method spoofing instead of DELETE
    const deleteForm = useForm({
      _method: 'DELETE'
    })

    deleteForm.post(`/spa/employees/${employee.id}`, {
      onSuccess: () => {
        console.log('Delete successful')
      },
      onError: (errors) => {
        console.error('Error deleting employee:', errors)
        alert('Failed to delete employee. Please try again.')
      }
    })
  }
}

const getInitials = (firstName, lastName) => {
  const first = firstName ? firstName.charAt(0).toUpperCase() : ''
  const last = lastName ? lastName.charAt(0).toUpperCase() : ''
  return first + last || 'E'
}

const getStatusClass = (status) => {
  if (!status) return 'bg-emerald-100 text-emerald-700 border border-emerald-200'

  const lowerStatus = status.toLowerCase()
  if (lowerStatus.includes('active') || lowerStatus.includes('employed')) {
    return 'bg-emerald-100 text-emerald-700 border border-emerald-200'
  } else if (lowerStatus.includes('inactive') || lowerStatus.includes('suspended')) {
    return 'bg-amber-100 text-amber-700 border border-amber-200'
  } else if (lowerStatus.includes('terminated') || lowerStatus.includes('resigned')) {
    return 'bg-red-100 text-red-700 border border-red-200'
  } else if (lowerStatus.includes('elected') || lowerStatus.includes('appointed')) {
    return 'bg-blue-100 text-blue-700 border border-blue-200'
  } else {
    return 'bg-gray-100 text-gray-700 border border-gray-200'
  }
}

const getStatusDotClass = (status) => {
  if (!status) return 'bg-emerald-500'

  const lowerStatus = status.toLowerCase()
  if (lowerStatus.includes('active') || lowerStatus.includes('employed')) {
    return 'bg-emerald-500'
  } else if (lowerStatus.includes('inactive') || lowerStatus.includes('suspended')) {
    return 'bg-amber-500'
  } else if (lowerStatus.includes('terminated') || lowerStatus.includes('resigned')) {
    return 'bg-red-500'
  } else if (lowerStatus.includes('elected') || lowerStatus.includes('appointed')) {
    return 'bg-blue-500'
  } else {
    return 'bg-gray-500'
  }
}

const formatDate = (date) => {
  if (!date) return 'Not Set'
  return new Date(date).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  })
}

const toggleManagement = () => {
  showManagement.value = !showManagement.value
}

const getPhotoUrl = (employee) => {
  if (!employee?.photo) return null
  if (employee.photo.startsWith('http')) return employee.photo
  return `/storage/${employee.photo}`
}

// HR Dashboard methods
const getYearsOfService = (hireDate) => {
  if (!hireDate) return 0
  const today = new Date()
  const hire = new Date(hireDate)
  return Math.floor((today - hire) / (365.25 * 24 * 60 * 60 * 1000))
}

const exportEmployees = () => {
  // TODO: Implement CSV export functionality
  alert('Export functionality will be implemented soon!')
}

const generateReport = () => {
  // TODO: Implement comprehensive HR report generation
  alert('Report generation functionality will be implemented soon!')
}

const navigateToDashboard = () => {
  router.visit('/dashboard')
}

// Events management methods
const getEventIcon = (eventType) => {
  const icons = {
    'company_meeting': 'fas fa-users',
    'training': 'fas fa-graduation-cap',
    'holiday': 'fas fa-calendar-day',
    'birthday': 'fas fa-birthday-cake',
    'work_anniversary': 'fas fa-award',
    'team_building': 'fas fa-handshake',
    'performance_review': 'fas fa-chart-line',
    'compliance_training': 'fas fa-shield-alt',
    'benefits_enrollment': 'fas fa-file-medical',
    'social_event': 'fas fa-glass-cheers',
    'conference': 'fas fa-microphone',
    'deadline': 'fas fa-clock',
    'other': 'fas fa-calendar'
  }
  return icons[eventType] || 'fas fa-calendar'
}

const getEventTypeName = (eventType) => {
  const types = {
    'company_meeting': 'Company Meeting',
    'training': 'Training',
    'holiday': 'Holiday',
    'birthday': 'Birthday',
    'work_anniversary': 'Work Anniversary',
    'team_building': 'Team Building',
    'performance_review': 'Performance Review',
    'compliance_training': 'Compliance Training',
    'benefits_enrollment': 'Benefits Enrollment',
    'social_event': 'Social Event',
    'conference': 'Conference',
    'deadline': 'Deadline',
    'other': 'Other Event'
  }
  return types[eventType] || 'Event'
}

const getPriorityClass = (priority) => {
  const classes = {
    'low': 'text-green-600 bg-green-100 px-2 py-1 rounded-full',
    'medium': 'text-blue-600 bg-blue-100 px-2 py-1 rounded-full',
    'high': 'text-orange-600 bg-orange-100 px-2 py-1 rounded-full',
    'critical': 'text-red-600 bg-red-100 px-2 py-1 rounded-full'
  }
  return classes[priority] || 'text-gray-600 bg-gray-100 px-2 py-1 rounded-full'
}
</script>

<style scoped>
/* Custom scrollbar */
::-webkit-scrollbar {
  width: 6px;
  height: 6px;
}

::-webkit-scrollbar-track {
  background: #f1f5f9;
}

::-webkit-scrollbar-thumb {
  background: #cbd5e1;
  border-radius: 3px;
}

::-webkit-scrollbar-thumb:hover {
  background: #94a3b8;
}

/* Smooth animations */
* {
  transition: all 0.2s ease;
}

/* Floating animation for FAB */
@keyframes float {
  0%, 100% { transform: translateY(0px); }
  50% { transform: translateY(-10px); }
}

.fixed.bottom-8.right-8 {
  animation: float 3s ease-in-out infinite;
}
</style>