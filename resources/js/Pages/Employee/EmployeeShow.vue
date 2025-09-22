<template>
  <div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-cyan-50">
    <!-- Navigation -->
    <nav class="bg-white/80 backdrop-blur-lg shadow-xl border-b border-white/20">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <div class="flex items-center">
            <div class="flex-shrink-0 flex items-center">
              <div class="w-10 h-10 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl flex items-center justify-center mr-3">
                <i class="fas fa-building text-white text-lg"></i>
              </div>
              <router-link to="/" class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                PH HRMS
              </router-link>
            </div>
            <div class="hidden sm:ml-8 sm:flex sm:space-x-8">
              <router-link
                to="/employees"
                class="border-indigo-500 text-indigo-600 inline-flex items-center px-4 py-2 border-b-2 font-medium text-sm transition-all duration-200 hover:border-indigo-600"
              >
                <i class="fas fa-users mr-2"></i>Employees
              </router-link>
              <div ref="managementDropdown" class="relative">
                <button @click="toggleManagement" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 inline-flex items-center px-4 py-2 border-b-2 font-medium text-sm transition-all duration-200">
                  <i class="fas fa-cog mr-2"></i>Management
                  <i :class="showManagement ? 'fas fa-chevron-up' : 'fas fa-chevron-down'" class="ml-1 text-xs transition-transform"></i>
                </button>

                <div v-show="showManagement" class="absolute left-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50" @click="showManagement = false">
                  <div class="py-1">
                    <router-link to="/management/departments" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                      <i class="fas fa-building mr-2"></i>Departments
                    </router-link>
                    <router-link to="/management/offices" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                      <i class="fas fa-map-marker-alt mr-2"></i>Offices
                    </router-link>
                    <router-link to="/management/positions" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                      <i class="fas fa-briefcase mr-2"></i>Positions
                    </router-link>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="flex items-center space-x-4">
            <div class="relative">
              <button class="p-2 text-gray-400 hover:text-gray-600 transition-colors">
                <i class="fas fa-bell text-lg"></i>
                <span class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full"></span>
              </button>
            </div>
            <div class="flex items-center space-x-3">
              <div class="w-8 h-8 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-full flex items-center justify-center">
                <span class="text-white text-sm font-semibold">A</span>
              </div>
              <span class="text-sm font-medium text-gray-700">Welcome, Admin</span>
            </div>
          </div>
        </div>
      </div>
    </nav>

    <!-- Header -->
    <div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 text-white">
      <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between">
          <div>
            <nav class="flex mb-4" aria-label="Breadcrumb">
              <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                  <button @click="navigateToDashboard" class="inline-flex items-center text-sm font-medium text-white/80 hover:text-white">
                    <i class="fas fa-home mr-2"></i>Dashboard
                  </button>
                </li>
                <li>
                  <div class="flex items-center">
                    <i class="fas fa-chevron-right text-white/60 mx-2"></i>
                    <router-link to="/employees" class="text-sm font-medium text-white/80 hover:text-white">Employees</router-link>
                  </div>
                </li>
                <li aria-current="page">
                  <div class="flex items-center">
                    <i class="fas fa-chevron-right text-white/60 mx-2"></i>
                    <span class="text-sm font-medium text-white/90">Employee Details</span>
                  </div>
                </li>
              </ol>
            </nav>
            <h1 class="text-4xl font-bold text-white mb-2">
              {{ employee.first_name }} {{ employee.last_name }}
            </h1>
            <p class="text-xl text-white/90">{{ employee.position?.title || 'No Position Assigned' }}</p>
            <p class="text-lg text-white/80">{{ employee.department?.name || 'No Department Assigned' }}</p>
          </div>
          <div class="flex space-x-3">
            <button
              @click="navigateToEdit"
              class="bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white px-6 py-3 rounded-xl font-semibold transition-all duration-200 hover:scale-105 hover:shadow-xl"
            >
              <i class="fas fa-edit mr-2"></i>Edit Employee
            </button>
            <button
              @click="deleteEmployee"
              class="bg-red-500/20 hover:bg-red-500/30 backdrop-blur-sm text-white px-6 py-3 rounded-xl font-semibold transition-all duration-200 hover:scale-105 hover:shadow-xl"
            >
              <i class="fas fa-trash mr-2"></i>Delete
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Loading State -->
    <div v-if="loading" class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
      <div class="text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-2xl mb-4">
          <i class="fas fa-spinner fa-spin text-white text-2xl"></i>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Loading Employee Data</h3>
        <p class="text-gray-600">Please wait while we fetch the employee information...</p>
      </div>
    </div>

    <!-- Main Content -->
    <div v-else class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 -mt-4 relative z-10">
      <!-- Employee Profile Card -->
      <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-white/20 mb-8 overflow-hidden">
        <div class="p-8">
          <div class="flex items-center space-x-8">
            <div class="flex-shrink-0">
              <img
                v-if="employee.photo"
                :src="'/storage/' + employee.photo"
                :alt="employee.first_name"
                class="h-32 w-32 rounded-2xl object-cover border-4 border-white shadow-xl"
              >
              <div
                v-else
                class="h-32 w-32 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center border-4 border-white shadow-xl"
              >
                <span class="text-3xl font-bold text-white">
                  {{ getInitials(employee.first_name, employee.last_name) }}
                </span>
              </div>
            </div>
            <div class="flex-1">
              <h2 class="text-3xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent mb-2">
                {{ employee.first_name }} {{ employee.middle_name }} {{ employee.last_name }} {{ employee.suffix }}
              </h2>
              <p class="text-xl text-gray-700 mb-1">{{ employee.position?.title || 'No Position Assigned' }}</p>
              <p class="text-lg text-gray-600 mb-4">{{ employee.department?.name || 'No Department Assigned' }}</p>
              <div class="flex items-center space-x-6">
                <span
                  :class="getStatusClass(employee.is_active ? 'Active' : 'Inactive')"
                  class="inline-flex items-center px-4 py-2 text-sm font-semibold rounded-xl"
                >
                  <div class="w-2 h-2 rounded-full mr-2" :class="employee.is_active ? 'bg-green-400' : 'bg-red-400'"></div>
                  {{ employee.is_active ? 'Active' : 'Inactive' }}
                </span>
                <span class="text-sm font-medium text-gray-600">
                  <i class="fas fa-id-badge mr-2 text-indigo-500"></i>
                  Employee ID: {{ employee.employee_id || 'Not Assigned' }}
                </span>
                <span v-if="employee.hire_date" class="text-sm font-medium text-gray-600">
                  <i class="fas fa-calendar mr-2 text-purple-500"></i>
                  Hired: {{ formatDate(employee.hire_date) }}
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Employee Dashboard Grid -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        <!-- Quick Stats -->
        <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-white/20 p-6">
          <h3 class="text-lg font-semibold text-gray-900 mb-4">
            <i class="fas fa-chart-bar mr-2 text-indigo-500"></i>Quick Stats
          </h3>
          <div class="space-y-4">
            <div class="flex justify-between items-center">
              <span class="text-sm text-gray-600">Years of Service</span>
              <span class="font-semibold text-gray-900">{{ calculateYearsOfService() }}</span>
            </div>
            <div class="flex justify-between items-center">
              <span class="text-sm text-gray-600">Employment Type</span>
              <span class="font-semibold text-gray-900">{{ employee.employment_type || 'N/A' }}</span>
            </div>
            <div class="flex justify-between items-center">
              <span class="text-sm text-gray-600">Basic Salary</span>
              <span class="font-semibold text-gray-900">₱{{ formatCurrency(employee.basic_salary) || 'N/A' }}</span>
            </div>
          </div>
        </div>

        <!-- Leave Balances -->
        <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-white/20 p-6">
          <h3 class="text-lg font-semibold text-gray-900 mb-4">
            <i class="fas fa-umbrella mr-2 text-yellow-500"></i>Leave Balances
          </h3>
          <div class="space-y-4">
            <div class="flex justify-between items-center">
              <span class="text-sm text-gray-600">Vacation Leave</span>
              <span class="font-semibold text-gray-900">{{ employee.vacation_leave_balance || '0' }} days</span>
            </div>
            <div class="flex justify-between items-center">
              <span class="text-sm text-gray-600">Sick Leave</span>
              <span class="font-semibold text-gray-900">{{ employee.sick_leave_balance || '0' }} days</span>
            </div>
            <div class="flex justify-between items-center">
              <span class="text-sm text-gray-600">Emergency Leave</span>
              <span class="font-semibold text-gray-900">{{ employee.emergency_leave_balance || '0' }} days</span>
            </div>
          </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-white/20 p-6">
          <h3 class="text-lg font-semibold text-gray-900 mb-4">
            <i class="fas fa-clock mr-2 text-purple-500"></i>Recent Activity
          </h3>
          <div class="space-y-3">
            <div class="flex items-start space-x-3">
              <div class="w-2 h-2 bg-green-400 rounded-full mt-2"></div>
              <div>
                <p class="text-sm text-gray-900">Record Updated</p>
                <p class="text-xs text-gray-500">{{ formatDateTime(employee.updated_at) }}</p>
              </div>
            </div>
            <div class="flex items-start space-x-3">
              <div class="w-2 h-2 bg-blue-400 rounded-full mt-2"></div>
              <div>
                <p class="text-sm text-gray-900">Record Created</p>
                <p class="text-xs text-gray-500">{{ formatDateTime(employee.created_at) }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Detailed Information Tabs -->
      <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-white/20 overflow-hidden">
        <!-- Tab Navigation -->
        <div class="border-b border-gray-200">
          <nav class="-mb-px flex space-x-8 px-6" aria-label="Tabs">
            <button
              v-for="tab in tabs"
              :key="tab.id"
              @click="activeTab = tab.id"
              :class="[
                activeTab === tab.id
                  ? 'border-indigo-500 text-indigo-600'
                  : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300',
                'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm'
              ]"
            >
              <i :class="tab.icon" class="mr-2"></i>{{ tab.name }}
            </button>
          </nav>
        </div>

        <!-- Tab Content -->
        <div class="p-6">
          <!-- Personal Information Tab -->
          <div v-if="activeTab === 'personal'">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
              <div>
                <h4 class="text-lg font-semibold text-gray-900 mb-4">Basic Information</h4>
                <dl class="space-y-4">
                  <div v-if="employee.birth_date">
                    <dt class="text-sm font-medium text-gray-500">Date of Birth</dt>
                    <dd class="text-sm text-gray-900">{{ formatDate(employee.birth_date) }}</dd>
                  </div>
                  <div v-if="employee.birth_place">
                    <dt class="text-sm font-medium text-gray-500">Birth Place</dt>
                    <dd class="text-sm text-gray-900">{{ employee.birth_place }}</dd>
                  </div>
                  <div v-if="employee.gender">
                    <dt class="text-sm font-medium text-gray-500">Gender</dt>
                    <dd class="text-sm text-gray-900">{{ employee.gender }}</dd>
                  </div>
                  <div v-if="employee.civil_status">
                    <dt class="text-sm font-medium text-gray-500">Civil Status</dt>
                    <dd class="text-sm text-gray-900">{{ employee.civil_status }}</dd>
                  </div>
                  <div v-if="employee.nationality">
                    <dt class="text-sm font-medium text-gray-500">Nationality</dt>
                    <dd class="text-sm text-gray-900">{{ employee.nationality }}</dd>
                  </div>
                  <div v-if="employee.religion">
                    <dt class="text-sm font-medium text-gray-500">Religion</dt>
                    <dd class="text-sm text-gray-900">{{ employee.religion }}</dd>
                  </div>
                  <div v-if="employee.blood_type">
                    <dt class="text-sm font-medium text-gray-500">Blood Type</dt>
                    <dd class="text-sm text-gray-900">{{ employee.blood_type }}</dd>
                  </div>
                </dl>
              </div>
              <div>
                <h4 class="text-lg font-semibold text-gray-900 mb-4">Physical Information</h4>
                <dl class="space-y-4">
                  <div v-if="employee.height">
                    <dt class="text-sm font-medium text-gray-500">Height</dt>
                    <dd class="text-sm text-gray-900">{{ employee.height }} cm</dd>
                  </div>
                  <div v-if="employee.weight">
                    <dt class="text-sm font-medium text-gray-500">Weight</dt>
                    <dd class="text-sm text-gray-900">{{ employee.weight }} kg</dd>
                  </div>
                  <div v-if="employee.nickname">
                    <dt class="text-sm font-medium text-gray-500">Nickname</dt>
                    <dd class="text-sm text-gray-900">{{ employee.nickname }}</dd>
                  </div>
                  <div v-if="employee.maiden_name">
                    <dt class="text-sm font-medium text-gray-500">Maiden Name</dt>
                    <dd class="text-sm text-gray-900">{{ employee.maiden_name }}</dd>
                  </div>
                </dl>
              </div>
            </div>
          </div>

          <!-- Contact Information Tab -->
          <div v-if="activeTab === 'contact'">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
              <div>
                <h4 class="text-lg font-semibold text-gray-900 mb-4">Contact Details</h4>
                <dl class="space-y-4">
                  <div v-if="employee.contact_numbers">
                    <dt class="text-sm font-medium text-gray-500">Contact Numbers</dt>
                    <dd class="text-sm text-gray-900">
                      <div v-for="(contact, index) in parseJsonField(employee.contact_numbers)" :key="index" class="mb-1">
                        <span class="font-medium">{{ contact.type }}:</span> {{ contact.number }}
                      </div>
                    </dd>
                  </div>
                  <div v-if="employee.email_addresses">
                    <dt class="text-sm font-medium text-gray-500">Email Addresses</dt>
                    <dd class="text-sm text-gray-900">
                      <div v-for="(email, index) in parseJsonField(employee.email_addresses)" :key="index" class="mb-1">
                        <span class="font-medium">{{ email.type }}:</span>
                        <a :href="`mailto:${email.email}`" class="text-indigo-600 hover:text-indigo-800 ml-1">
                          {{ email.email }}
                        </a>
                      </div>
                    </dd>
                  </div>
                </dl>
              </div>
              <div>
                <h4 class="text-lg font-semibold text-gray-900 mb-4">Emergency Contacts</h4>
                <dl class="space-y-4">
                  <div v-if="employee.emergency_contacts">
                    <dt class="text-sm font-medium text-gray-500">Emergency Contacts</dt>
                    <dd class="text-sm text-gray-900">
                      <div v-for="(contact, index) in parseJsonField(employee.emergency_contacts)" :key="index" class="mb-2 p-3 bg-red-50 rounded-lg">
                        <div><span class="font-medium">Name:</span> {{ contact.name }}</div>
                        <div><span class="font-medium">Relationship:</span> {{ contact.relationship }}</div>
                        <div><span class="font-medium">Phone:</span> {{ contact.phone }}</div>
                      </div>
                    </dd>
                  </div>
                </dl>
              </div>
            </div>
          </div>

          <!-- Employment Information Tab -->
          <div v-if="activeTab === 'employment'">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
              <div>
                <h4 class="text-lg font-semibold text-gray-900 mb-4">Current Employment</h4>
                <dl class="space-y-4">
                  <div v-if="employee.department">
                    <dt class="text-sm font-medium text-gray-500">Department</dt>
                    <dd class="text-sm text-gray-900">{{ employee.department.name }}</dd>
                  </div>
                  <div v-if="employee.position">
                    <dt class="text-sm font-medium text-gray-500">Position</dt>
                    <dd class="text-sm text-gray-900">{{ employee.position.title }}</dd>
                  </div>
                  <div v-if="employee.job_grade">
                    <dt class="text-sm font-medium text-gray-500">Job Grade</dt>
                    <dd class="text-sm text-gray-900">{{ employee.job_grade.name }}</dd>
                  </div>
                  <div v-if="employee.employment_type">
                    <dt class="text-sm font-medium text-gray-500">Employment Type</dt>
                    <dd class="text-sm text-gray-900">{{ employee.employment_type }}</dd>
                  </div>
                  <div v-if="employee.employment_status">
                    <dt class="text-sm font-medium text-gray-500">Employment Status</dt>
                    <dd class="text-sm text-gray-900">{{ employee.employment_status }}</dd>
                  </div>
                  <div v-if="employee.branch">
                    <dt class="text-sm font-medium text-gray-500">Branch/Office</dt>
                    <dd class="text-sm text-gray-900">{{ employee.branch.name }}</dd>
                  </div>
                  <div v-if="employee.cost_center">
                    <dt class="text-sm font-medium text-gray-500">Cost Center</dt>
                    <dd class="text-sm text-gray-900">{{ employee.cost_center.name }}</dd>
                  </div>
                </dl>
              </div>
              <div>
                <h4 class="text-lg font-semibold text-gray-900 mb-4">Employment Dates</h4>
                <dl class="space-y-4">
                  <div v-if="employee.hire_date">
                    <dt class="text-sm font-medium text-gray-500">Hire Date</dt>
                    <dd class="text-sm text-gray-900">{{ formatDate(employee.hire_date) }}</dd>
                  </div>
                  <div v-if="employee.original_hire_date">
                    <dt class="text-sm font-medium text-gray-500">Original Hire Date</dt>
                    <dd class="text-sm text-gray-900">{{ formatDate(employee.original_hire_date) }}</dd>
                  </div>
                  <div v-if="employee.probation_end_date">
                    <dt class="text-sm font-medium text-gray-500">Probation End Date</dt>
                    <dd class="text-sm text-gray-900">{{ formatDate(employee.probation_end_date) }}</dd>
                  </div>
                  <div v-if="employee.regularization_date">
                    <dt class="text-sm font-medium text-gray-500">Regularization Date</dt>
                    <dd class="text-sm text-gray-900">{{ formatDate(employee.regularization_date) }}</dd>
                  </div>
                  <div v-if="employee.last_promotion_date">
                    <dt class="text-sm font-medium text-gray-500">Last Promotion Date</dt>
                    <dd class="text-sm text-gray-900">{{ formatDate(employee.last_promotion_date) }}</dd>
                  </div>
                </dl>
              </div>
            </div>
          </div>

          <!-- Compensation Tab -->
          <div v-if="activeTab === 'compensation'">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
              <div>
                <h4 class="text-lg font-semibold text-gray-900 mb-4">Salary Information</h4>
                <dl class="space-y-4">
                  <div v-if="employee.basic_salary">
                    <dt class="text-sm font-medium text-gray-500">Basic Salary</dt>
                    <dd class="text-sm text-gray-900">₱{{ formatCurrency(employee.basic_salary) }}</dd>
                  </div>
                  <div v-if="employee.daily_rate">
                    <dt class="text-sm font-medium text-gray-500">Daily Rate</dt>
                    <dd class="text-sm text-gray-900">₱{{ formatCurrency(employee.daily_rate) }}</dd>
                  </div>
                  <div v-if="employee.hourly_rate">
                    <dt class="text-sm font-medium text-gray-500">Hourly Rate</dt>
                    <dd class="text-sm text-gray-900">₱{{ formatCurrency(employee.hourly_rate) }}</dd>
                  </div>
                  <div v-if="employee.pay_frequency">
                    <dt class="text-sm font-medium text-gray-500">Pay Frequency</dt>
                    <dd class="text-sm text-gray-900">{{ employee.pay_frequency }}</dd>
                  </div>
                  <div v-if="employee.tax_status">
                    <dt class="text-sm font-medium text-gray-500">Tax Status</dt>
                    <dd class="text-sm text-gray-900">{{ employee.tax_status }}</dd>
                  </div>
                </dl>
              </div>
              <div>
                <h4 class="text-lg font-semibold text-gray-900 mb-4">Benefits & Allowances</h4>
                <dl class="space-y-4">
                  <div v-if="employee.allowances">
                    <dt class="text-sm font-medium text-gray-500">Allowances</dt>
                    <dd class="text-sm text-gray-900">
                      <div v-for="(allowance, index) in parseJsonField(employee.allowances)" :key="index" class="mb-1">
                        <span class="font-medium">{{ allowance.type }}:</span> ₱{{ formatCurrency(allowance.amount) }}
                      </div>
                    </dd>
                  </div>
                  <div>
                    <dt class="text-sm font-medium text-gray-500">Employee Classifications</dt>
                    <dd class="text-sm text-gray-900">
                      <div class="flex flex-wrap gap-2 mt-1">
                        <span v-if="employee.is_exempt" class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                          Exempt Employee
                        </span>
                        <span v-if="employee.is_minimum_wage" class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                          Minimum Wage Earner
                        </span>
                        <span v-if="employee.is_flexible_time" class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                          Flexible Time
                        </span>
                        <span v-if="employee.is_field_work" class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                          Field Work
                        </span>
                      </div>
                    </dd>
                  </div>
                </dl>
              </div>
            </div>
          </div>

          <!-- Government IDs Tab -->
          <div v-if="activeTab === 'government'">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
              <div>
                <h4 class="text-lg font-semibold text-gray-900 mb-4">Government IDs</h4>
                <dl class="space-y-4">
                  <div v-if="employee.sss_number">
                    <dt class="text-sm font-medium text-gray-500">SSS Number</dt>
                    <dd class="text-sm text-gray-900">{{ employee.sss_number }}</dd>
                  </div>
                  <div v-if="employee.tin">
                    <dt class="text-sm font-medium text-gray-500">TIN</dt>
                    <dd class="text-sm text-gray-900">{{ employee.tin }}</dd>
                  </div>
                  <div v-if="employee.philhealth_number">
                    <dt class="text-sm font-medium text-gray-500">PhilHealth Number</dt>
                    <dd class="text-sm text-gray-900">{{ employee.philhealth_number }}</dd>
                  </div>
                  <div v-if="employee.pagibig_number">
                    <dt class="text-sm font-medium text-gray-500">Pag-IBIG Number</dt>
                    <dd class="text-sm text-gray-900">{{ employee.pagibig_number }}</dd>
                  </div>
                  <div v-if="employee.voters_id">
                    <dt class="text-sm font-medium text-gray-500">Voter's ID</dt>
                    <dd class="text-sm text-gray-900">{{ employee.voters_id }}</dd>
                  </div>
                </dl>
              </div>
              <div>
                <h4 class="text-lg font-semibold text-gray-900 mb-4">Travel Documents</h4>
                <dl class="space-y-4">
                  <div v-if="employee.passport_number">
                    <dt class="text-sm font-medium text-gray-500">Passport Number</dt>
                    <dd class="text-sm text-gray-900">{{ employee.passport_number }}</dd>
                  </div>
                  <div v-if="employee.passport_expiry">
                    <dt class="text-sm font-medium text-gray-500">Passport Expiry</dt>
                    <dd class="text-sm text-gray-900">{{ formatDate(employee.passport_expiry) }}</dd>
                  </div>
                  <div v-if="employee.drivers_license">
                    <dt class="text-sm font-medium text-gray-500">Driver's License</dt>
                    <dd class="text-sm text-gray-900">{{ employee.drivers_license }}</dd>
                  </div>
                  <div v-if="employee.license_expiry">
                    <dt class="text-sm font-medium text-gray-500">License Expiry</dt>
                    <dd class="text-sm text-gray-900">{{ formatDate(employee.license_expiry) }}</dd>
                  </div>
                </dl>
              </div>
            </div>
          </div>

          <!-- Medical Information Tab -->
          <div v-if="activeTab === 'medical'">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
              <div>
                <h4 class="text-lg font-semibold text-gray-900 mb-4">Medical Conditions</h4>
                <dl class="space-y-4">
                  <div v-if="employee.medical_conditions">
                    <dt class="text-sm font-medium text-gray-500">Medical Conditions</dt>
                    <dd class="text-sm text-gray-900">
                      <div class="space-y-1">
                        <span v-for="(condition, index) in parseJsonField(employee.medical_conditions)" :key="index"
                              class="inline-block bg-red-100 text-red-800 text-xs px-2 py-1 rounded mr-1">
                          {{ condition }}
                        </span>
                      </div>
                    </dd>
                  </div>
                  <div v-if="employee.allergies">
                    <dt class="text-sm font-medium text-gray-500">Allergies</dt>
                    <dd class="text-sm text-gray-900">
                      <div class="space-y-1">
                        <span v-for="(allergy, index) in parseJsonField(employee.allergies)" :key="index"
                              class="inline-block bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded mr-1">
                          {{ allergy }}
                        </span>
                      </div>
                    </dd>
                  </div>
                  <div v-if="employee.medications">
                    <dt class="text-sm font-medium text-gray-500">Medications</dt>
                    <dd class="text-sm text-gray-900">
                      <div class="space-y-1">
                        <span v-for="(medication, index) in parseJsonField(employee.medications)" :key="index"
                              class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded mr-1">
                          {{ medication }}
                        </span>
                      </div>
                    </dd>
                  </div>
                </dl>
              </div>
            </div>
          </div>

          <!-- Audit Trail Tab -->
          <div v-if="activeTab === 'audit'">
            <div>
              <h4 class="text-lg font-semibold text-gray-900 mb-4">Audit Trail</h4>
              <div class="space-y-4">
                <div class="border-l-4 border-green-400 pl-4 py-2 bg-green-50 rounded-r-lg">
                  <div class="flex justify-between items-start">
                    <div>
                      <p class="font-medium text-green-800">Employee Record Created</p>
                      <p class="text-sm text-green-600">Initial employee record was created in the system</p>
                      <p class="text-xs text-green-500 mt-1">{{ formatDateTime(employee.created_at) }}</p>
                    </div>
                    <span class="text-green-600 text-sm">System</span>
                  </div>
                </div>
                <div class="border-l-4 border-blue-400 pl-4 py-2 bg-blue-50 rounded-r-lg">
                  <div class="flex justify-between items-start">
                    <div>
                      <p class="font-medium text-blue-800">Employee Record Updated</p>
                      <p class="text-sm text-blue-600">Employee information was last modified</p>
                      <p class="text-xs text-blue-500 mt-1">{{ formatDateTime(employee.updated_at) }}</p>
                    </div>
                    <span class="text-blue-600 text-sm">Admin</span>
                  </div>
                </div>
                <!-- Add more audit trail entries as needed -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'EmployeeShow',
  data() {
    return {
      loading: true,
      employee: {},
      activeTab: 'personal',
      showManagement: false,
      tabs: [
        { id: 'personal', name: 'Personal Info', icon: 'fas fa-user' },
        { id: 'contact', name: 'Contact', icon: 'fas fa-address-book' },
        { id: 'employment', name: 'Employment', icon: 'fas fa-briefcase' },
        { id: 'compensation', name: 'Compensation', icon: 'fas fa-dollar-sign' },
        { id: 'government', name: 'Government IDs', icon: 'fas fa-id-card' },
        { id: 'medical', name: 'Medical', icon: 'fas fa-heartbeat' },
        { id: 'audit', name: 'Audit Trail', icon: 'fas fa-history' }
      ]
    }
  },
  methods: {
    navigateToEdit() {
      this.$router.push(`/employees/${this.employee.id}/edit`)
    },
    async fetchEmployee() {
      try {
        const response = await this.$http.get(`/api/employees/${this.$route.params.id}`)
        this.employee = response.data
      } catch (error) {
        console.error('Error fetching employee:', error)
        window.showNotification?.('Error loading employee data')
        this.$router.push('/employees')
      } finally {
        this.loading = false
      }
    },

    async deleteEmployee() {
      if (confirm(`Are you sure you want to delete ${this.employee.first_name} ${this.employee.last_name}?`)) {
        try {
          await this.$http.delete(`/api/employees/${this.employee.id}`)
          window.showNotification?.('Employee deleted successfully')
          this.$router.push('/employees')
        } catch (error) {
          console.error('Error deleting employee:', error)
          window.showNotification?.('Error deleting employee')
        }
      }
    },

    getInitials(firstName, lastName) {
      const first = firstName ? firstName.charAt(0).toUpperCase() : ''
      const last = lastName ? lastName.charAt(0).toUpperCase() : ''
      return first + last
    },

    getStatusClass(status) {
      switch (status) {
        case 'Active':
          return 'bg-green-100 text-green-800 border border-green-200'
        case 'Inactive':
          return 'bg-yellow-100 text-yellow-800 border border-yellow-200'
        case 'Terminated':
          return 'bg-red-100 text-red-800 border border-red-200'
        default:
          return 'bg-green-100 text-green-800 border border-green-200'
      }
    },

    formatDate(date) {
      if (!date) return 'N/A'
      return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      })
    },

    formatDateTime(date) {
      if (!date) return 'N/A'
      return new Date(date).toLocaleString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
      })
    },

    formatCurrency(amount) {
      if (!amount || amount === 0) return '0.00'
      return parseFloat(amount).toLocaleString('en-US', { minimumFractionDigits: 2 })
    },

    calculateYearsOfService() {
      if (!this.employee.hire_date) return 'N/A'
      const hireDate = new Date(this.employee.hire_date)
      const today = new Date()
      const yearsDiff = today.getFullYear() - hireDate.getFullYear()
      const monthsDiff = today.getMonth() - hireDate.getMonth()

      if (monthsDiff < 0 || (monthsDiff === 0 && today.getDate() < hireDate.getDate())) {
        return `${yearsDiff - 1} years`
      }
      return `${yearsDiff} years`
    },

    parseJsonField(field) {
      if (!field) return []
      try {
        return Array.isArray(field) ? field : JSON.parse(field)
      } catch (e) {
        return []
      }
    },

    toggleManagement() {
      this.showManagement = !this.showManagement
    },

    navigateToDashboard() {
      // Use window.location for faster navigation to Laravel routes
      window.location.href = '/dashboard'
    },

    handleClickOutside(event) {
      const dropdown = this.$refs.managementDropdown
      if (dropdown && !dropdown.contains(event.target)) {
        this.showManagement = false
      }
    }
  },

  mounted() {
    this.fetchEmployee()
    document.addEventListener('click', this.handleClickOutside)
  },

  beforeUnmount() {
    document.removeEventListener('click', this.handleClickOutside)
  }
}
</script>