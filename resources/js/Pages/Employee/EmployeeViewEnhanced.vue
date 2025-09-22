<template>
  <AppLayout>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50">
      <!-- Hero Section with Employee Header -->
      <div class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 text-white">
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
          <div class="flex items-center justify-between">
            <div class="flex items-center space-x-6">
              <!-- Back Button -->
              <Link href="/spa/employees" class="flex items-center text-blue-200 hover:text-white transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>
                <span class="hidden sm:inline">Back to Employees</span>
              </Link>

              <!-- Employee Photo -->
              <div class="flex-shrink-0">
                <div v-if="photoUrl" class="w-24 h-24 rounded-full overflow-hidden shadow-xl border-4 border-white/20">
                  <img :src="photoUrl" :alt="fullName" class="w-full h-full object-cover">
                </div>
                <div v-else class="w-24 h-24 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center shadow-xl border-4 border-white/20">
                  <i class="fas fa-user text-3xl text-white/80"></i>
                </div>
              </div>

              <!-- Employee Basic Info -->
              <div>
                <h1 class="text-3xl font-bold mb-2">{{ fullName }}</h1>
                <div class="flex flex-wrap items-center gap-3 mb-2">
                  <span class="inline-flex items-center bg-white/20 backdrop-blur-sm text-white px-3 py-1 rounded-full text-sm font-medium">
                    <i class="fas fa-id-badge mr-2"></i>{{ employee.employee_id }}
                  </span>
                  <span :class="statusBadgeClass" class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium">
                    <div :class="statusDotClass" class="w-2 h-2 rounded-full mr-2"></div>
                    {{ employee.employment_status?.name || 'No Status' }}
                  </span>
                  <span class="inline-flex items-center bg-white/20 backdrop-blur-sm text-white px-3 py-1 rounded-full text-sm">
                    <i class="fas fa-building mr-2"></i>{{ employee.department?.name || 'No Department' }}
                  </span>
                </div>
                <div class="flex items-center space-x-4 text-blue-100">
                  <span class="flex items-center">
                    <i class="fas fa-briefcase mr-2"></i>{{ employee.position?.title || 'No Position' }}
                  </span>
                  <span class="flex items-center">
                    <i class="fas fa-calendar mr-2"></i>{{ yearsOfServiceText }}
                  </span>
                </div>
              </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex space-x-3">
              <Link :href="`/spa/employees/${employee.id}/edit`"
                    class="bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white px-6 py-3 rounded-xl font-semibold transition-all duration-200 hover:scale-105 hover:shadow-xl">
                <i class="fas fa-edit mr-2"></i>Edit Employee
              </Link>
              <button @click="showDocumentModal = true"
                      class="bg-emerald-500/20 hover:bg-emerald-500/30 backdrop-blur-sm text-white px-6 py-3 rounded-xl font-semibold transition-all duration-200 hover:scale-105 hover:shadow-xl">
                <i class="fas fa-file-upload mr-2"></i>Upload Document
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Main Content -->
      <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 -mt-4 relative z-10">

        <!-- Key Metrics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
          <!-- Years of Service -->
          <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-white/20 p-6">
            <div class="flex items-center">
              <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center">
                <i class="fas fa-calendar-alt text-white text-xl"></i>
              </div>
              <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Years of Service</p>
                <p class="text-2xl font-bold text-gray-900">{{ yearsOfService }}</p>
                <p class="text-xs text-gray-500">Since {{ formatDate(employee.hire_date) }}</p>
              </div>
            </div>
          </div>

          <!-- Documents Count -->
          <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-white/20 p-6">
            <div class="flex items-center">
              <div class="w-12 h-12 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-xl flex items-center justify-center">
                <i class="fas fa-folder text-white text-xl"></i>
              </div>
              <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Documents</p>
                <p class="text-2xl font-bold text-gray-900">{{ documents.length }}</p>
                <p class="text-xs text-gray-500">
                  {{ expiredDocuments.length }} expired, {{ expiringDocuments.length }} expiring
                </p>
              </div>
            </div>
          </div>

          <!-- Employment Status -->
          <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-white/20 p-6">
            <div class="flex items-center">
              <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-pink-500 rounded-xl flex items-center justify-center">
                <i class="fas fa-user-tie text-white text-xl"></i>
              </div>
              <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Employment</p>
                <p class="text-lg font-bold text-gray-900">{{ employee.employment_type || 'N/A' }}</p>
                <p class="text-xs text-gray-500">{{ employee.pay_frequency || 'N/A' }} pay</p>
              </div>
            </div>
          </div>

          <!-- Salary -->
          <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-white/20 p-6">
            <div class="flex items-center">
              <div class="w-12 h-12 bg-gradient-to-r from-amber-500 to-orange-500 rounded-xl flex items-center justify-center">
                <i class="fas fa-coins text-white text-xl"></i>
              </div>
              <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Basic Salary</p>
                <p class="text-lg font-bold text-gray-900">
                  {{ employee.basic_salary ? '₱' + formatCurrency(employee.basic_salary) : 'Not Set' }}
                </p>
                <p class="text-xs text-gray-500">{{ employee.pay_frequency || 'Monthly' }}</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Navigation Tabs -->
        <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-white/20 mb-8 overflow-hidden">
          <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8 px-6">
              <button @click="activeTab = 'overview'"
                      :class="tabClass('overview')"
                      class="py-4 px-1 border-b-2 font-medium text-sm whitespace-nowrap">
                <i class="fas fa-user mr-2"></i>Personal Information
              </button>
              <button @click="activeTab = 'employment'"
                      :class="tabClass('employment')"
                      class="py-4 px-1 border-b-2 font-medium text-sm whitespace-nowrap">
                <i class="fas fa-briefcase mr-2"></i>Employment Details
              </button>
              <button @click="activeTab = 'documents'"
                      :class="tabClass('documents')"
                      class="py-4 px-1 border-b-2 font-medium text-sm whitespace-nowrap">
                <i class="fas fa-folder mr-2"></i>Documents
                <span v-if="documents.length > 0" class="ml-1 bg-blue-500 text-white rounded-full px-2 py-1 text-xs">
                  {{ documents.length }}
                </span>
              </button>
              <button @click="activeTab = 'emergency'"
                      :class="tabClass('emergency')"
                      class="py-4 px-1 border-b-2 font-medium text-sm whitespace-nowrap">
                <i class="fas fa-user-shield mr-2"></i>Emergency Contacts
              </button>
              <button @click="activeTab = 'audit'"
                      :class="tabClass('audit')"
                      class="py-4 px-1 border-b-2 font-medium text-sm whitespace-nowrap">
                <i class="fas fa-history mr-2"></i>Audit Trail
                <span v-if="timeline.length > 0" class="ml-1 bg-red-500 text-white rounded-full px-2 py-1 text-xs">
                  {{ timeline.length }}
                </span>
              </button>
            </nav>
          </div>
        </div>

        <!-- Tab Content -->
        <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-white/20 overflow-hidden">

          <!-- Personal Information Tab -->
          <div v-if="activeTab === 'overview'" class="p-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

              <!-- Basic Information -->
              <div class="space-y-6">
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6">
                  <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-user-circle mr-3 text-blue-600"></i>Basic Information
                  </h3>
                  <div class="grid grid-cols-2 gap-4">
                    <div>
                      <label class="text-sm font-medium text-gray-500">First Name</label>
                      <p class="text-gray-900 font-medium">{{ employee.first_name || 'Not set' }}</p>
                    </div>
                    <div>
                      <label class="text-sm font-medium text-gray-500">Middle Name</label>
                      <p class="text-gray-900 font-medium">{{ employee.middle_name || 'Not set' }}</p>
                    </div>
                    <div>
                      <label class="text-sm font-medium text-gray-500">Last Name</label>
                      <p class="text-gray-900 font-medium">{{ employee.last_name || 'Not set' }}</p>
                    </div>
                    <div>
                      <label class="text-sm font-medium text-gray-500">Suffix</label>
                      <p class="text-gray-900 font-medium">{{ employee.suffix || 'None' }}</p>
                    </div>
                    <div>
                      <label class="text-sm font-medium text-gray-500">Nickname</label>
                      <p class="text-gray-900 font-medium">{{ employee.nickname || 'None' }}</p>
                    </div>
                    <div>
                      <label class="text-sm font-medium text-gray-500">Maiden Name</label>
                      <p class="text-gray-900 font-medium">{{ employee.maiden_name || 'None' }}</p>
                    </div>
                  </div>
                </div>

                <!-- Personal Details -->
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl p-6">
                  <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-id-card mr-3 text-green-600"></i>Personal Details
                  </h3>
                  <div class="grid grid-cols-2 gap-4">
                    <div>
                      <label class="text-sm font-medium text-gray-500">Birth Date</label>
                      <p class="text-gray-900 font-medium">{{ formatDate(employee.birth_date) || 'Not set' }}</p>
                    </div>
                    <div>
                      <label class="text-sm font-medium text-gray-500">Age</label>
                      <p class="text-gray-900 font-medium">{{ calculateAge(employee.birth_date) || 'Unknown' }}</p>
                    </div>
                    <div>
                      <label class="text-sm font-medium text-gray-500">Birth Place</label>
                      <p class="text-gray-900 font-medium">{{ employee.birth_place || 'Not set' }}</p>
                    </div>
                    <div>
                      <label class="text-sm font-medium text-gray-500">Gender</label>
                      <p class="text-gray-900 font-medium">{{ employee.gender || 'Not set' }}</p>
                    </div>
                    <div>
                      <label class="text-sm font-medium text-gray-500">Civil Status</label>
                      <p class="text-gray-900 font-medium">{{ employee.civil_status || 'Not set' }}</p>
                    </div>
                    <div>
                      <label class="text-sm font-medium text-gray-500">Nationality</label>
                      <p class="text-gray-900 font-medium">{{ employee.nationality || 'Not set' }}</p>
                    </div>
                    <div>
                      <label class="text-sm font-medium text-gray-500">Religion</label>
                      <p class="text-gray-900 font-medium">{{ employee.religion || 'Not set' }}</p>
                    </div>
                    <div>
                      <label class="text-sm font-medium text-gray-500">Blood Type</label>
                      <p class="text-gray-900 font-medium">{{ employee.blood_type || 'Not set' }}</p>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Contact Information -->
              <div class="space-y-6">
                <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl p-6">
                  <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-address-book mr-3 text-purple-600"></i>Contact Information
                  </h3>

                  <!-- Email Addresses -->
                  <div class="mb-4">
                    <label class="text-sm font-medium text-gray-500 mb-2 block">Email Addresses</label>
                    <div v-if="employee.email_addresses && employee.email_addresses.length > 0" class="space-y-2">
                      <div v-for="(email, index) in employee.email_addresses" :key="index"
                           class="flex items-center justify-between bg-white rounded-lg p-3">
                        <div>
                          <p class="text-gray-900 font-medium">{{ email.email }}</p>
                          <p class="text-xs text-gray-500">{{ email.type }}</p>
                        </div>
                        <span v-if="email.is_primary" class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">Primary</span>
                      </div>
                    </div>
                    <p v-else class="text-gray-500 italic">No email addresses on file</p>
                  </div>

                  <!-- Phone Numbers -->
                  <div class="mb-4">
                    <label class="text-sm font-medium text-gray-500 mb-2 block">Phone Numbers</label>
                    <div v-if="employee.contact_numbers && employee.contact_numbers.length > 0" class="space-y-2">
                      <div v-for="(phone, index) in employee.contact_numbers" :key="index"
                           class="flex items-center justify-between bg-white rounded-lg p-3">
                        <div>
                          <p class="text-gray-900 font-medium">{{ phone.number }}</p>
                          <p class="text-xs text-gray-500">{{ phone.type }}</p>
                        </div>
                        <span v-if="phone.is_primary" class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">Primary</span>
                      </div>
                    </div>
                    <p v-else class="text-gray-500 italic">No phone numbers on file</p>
                  </div>

                  <!-- Addresses -->
                  <div>
                    <label class="text-sm font-medium text-gray-500 mb-2 block">Addresses</label>
                    <div v-if="employee.addresses && employee.addresses.length > 0" class="space-y-2">
                      <div v-for="(address, index) in employee.addresses" :key="index"
                           class="bg-white rounded-lg p-3">
                        <div class="flex items-center justify-between mb-2">
                          <p class="text-sm font-medium text-gray-700">{{ address.type }}</p>
                          <span v-if="address.is_primary" class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">Primary</span>
                        </div>
                        <p class="text-gray-900 text-sm">
                          {{ [address.street, address.barangay, address.city, address.province, address.country].filter(Boolean).join(', ') }}
                        </p>
                        <p v-if="address.postal_code" class="text-xs text-gray-500">{{ address.postal_code }}</p>
                      </div>
                    </div>
                    <p v-else class="text-gray-500 italic">No addresses on file</p>
                  </div>
                </div>

                <!-- Government IDs -->
                <div class="bg-gradient-to-r from-amber-50 to-orange-50 rounded-xl p-6">
                  <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-id-card-alt mr-3 text-amber-600"></i>Government IDs
                  </h3>
                  <div class="grid grid-cols-1 gap-4">
                    <div class="grid grid-cols-2 gap-4">
                      <div>
                        <label class="text-sm font-medium text-gray-500">SSS Number</label>
                        <p class="text-gray-900 font-medium">{{ employee.sss_number || 'Not set' }}</p>
                      </div>
                      <div>
                        <label class="text-sm font-medium text-gray-500">TIN</label>
                        <p class="text-gray-900 font-medium">{{ employee.tin || 'Not set' }}</p>
                      </div>
                      <div>
                        <label class="text-sm font-medium text-gray-500">PhilHealth</label>
                        <p class="text-gray-900 font-medium">{{ employee.philhealth_number || 'Not set' }}</p>
                      </div>
                      <div>
                        <label class="text-sm font-medium text-gray-500">Pag-IBIG</label>
                        <p class="text-gray-900 font-medium">{{ employee.pagibig_number || 'Not set' }}</p>
                      </div>
                      <div>
                        <label class="text-sm font-medium text-gray-500">Passport</label>
                        <p class="text-gray-900 font-medium">{{ employee.passport_number || 'Not set' }}</p>
                        <p v-if="employee.passport_expiry" class="text-xs text-gray-500">Expires: {{ formatDate(employee.passport_expiry) }}</p>
                      </div>
                      <div>
                        <label class="text-sm font-medium text-gray-500">Driver's License</label>
                        <p class="text-gray-900 font-medium">{{ employee.drivers_license || 'Not set' }}</p>
                        <p v-if="employee.license_expiry" class="text-xs text-gray-500">Expires: {{ formatDate(employee.license_expiry) }}</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Employment Details Tab -->
          <div v-if="activeTab === 'employment'" class="p-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

              <!-- Employment Information -->
              <div class="space-y-6">
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6">
                  <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-building mr-3 text-blue-600"></i>Employment Information
                  </h3>
                  <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                      <div>
                        <label class="text-sm font-medium text-gray-500">Employee ID</label>
                        <p class="text-gray-900 font-medium">{{ employee.employee_id }}</p>
                      </div>
                      <div>
                        <label class="text-sm font-medium text-gray-500">Badge Number</label>
                        <p class="text-gray-900 font-medium">{{ employee.badge_number || 'Not set' }}</p>
                      </div>
                      <div>
                        <label class="text-sm font-medium text-gray-500">Biometric ID</label>
                        <p class="text-gray-900 font-medium">{{ employee.biometric_id || 'Not set' }}</p>
                      </div>
                      <div>
                        <label class="text-sm font-medium text-gray-500">Employment Status</label>
                        <p class="text-gray-900 font-medium">{{ employee.employment_status?.name || 'Not set' }}</p>
                      </div>
                      <div>
                        <label class="text-sm font-medium text-gray-500">Employment Type</label>
                        <p class="text-gray-900 font-medium">{{ employee.employment_type || 'Not set' }}</p>
                      </div>
                      <div>
                        <label class="text-sm font-medium text-gray-500">Pay Frequency</label>
                        <p class="text-gray-900 font-medium">{{ employee.pay_frequency || 'Not set' }}</p>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Organizational Structure -->
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl p-6">
                  <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-sitemap mr-3 text-green-600"></i>Organizational Structure
                  </h3>
                  <div class="space-y-4">
                    <div>
                      <label class="text-sm font-medium text-gray-500">Department</label>
                      <p class="text-gray-900 font-medium">{{ employee.department?.name || 'Not assigned' }}</p>
                    </div>
                    <div>
                      <label class="text-sm font-medium text-gray-500">Position</label>
                      <p class="text-gray-900 font-medium">{{ employee.position?.title || 'Not assigned' }}</p>
                    </div>
                    <div>
                      <label class="text-sm font-medium text-gray-500">Job Grade</label>
                      <p class="text-gray-900 font-medium">{{ employee.job_grade?.name || 'Not assigned' }}</p>
                    </div>
                    <div>
                      <label class="text-sm font-medium text-gray-500">Branch/Office</label>
                      <p class="text-gray-900 font-medium">{{ employee.branch?.name || 'Not assigned' }}</p>
                    </div>
                    <div>
                      <label class="text-sm font-medium text-gray-500">Cost Center</label>
                      <p class="text-gray-900 font-medium">{{ employee.cost_center?.name || 'Not assigned' }}</p>
                    </div>
                    <div>
                      <label class="text-sm font-medium text-gray-500">Immediate Supervisor</label>
                      <p class="text-gray-900 font-medium">
                        {{ employee.supervisor ? `${employee.supervisor.first_name} ${employee.supervisor.last_name}` : 'None assigned' }}
                      </p>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Compensation & Benefits -->
              <div class="space-y-6">
                <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl p-6">
                  <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-coins mr-3 text-purple-600"></i>Compensation & Benefits
                  </h3>
                  <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                      <div>
                        <label class="text-sm font-medium text-gray-500">Basic Salary</label>
                        <p class="text-gray-900 font-medium">
                          {{ employee.basic_salary ? '₱' + formatCurrency(employee.basic_salary) : 'Not set' }}
                        </p>
                      </div>
                      <div>
                        <label class="text-sm font-medium text-gray-500">Daily Rate</label>
                        <p class="text-gray-900 font-medium">
                          {{ employee.daily_rate ? '₱' + formatCurrency(employee.daily_rate) : 'Not set' }}
                        </p>
                      </div>
                      <div>
                        <label class="text-sm font-medium text-gray-500">Hourly Rate</label>
                        <p class="text-gray-900 font-medium">
                          {{ employee.hourly_rate ? '₱' + formatCurrency(employee.hourly_rate) : 'Not set' }}
                        </p>
                      </div>
                      <div>
                        <label class="text-sm font-medium text-gray-500">Tax Status</label>
                        <p class="text-gray-900 font-medium">{{ employee.tax_status || 'Not set' }}</p>
                      </div>
                    </div>

                    <!-- Allowances -->
                    <div v-if="employee.allowances && employee.allowances.length > 0">
                      <label class="text-sm font-medium text-gray-500 mb-2 block">Allowances</label>
                      <div class="space-y-2">
                        <div v-for="(allowance, index) in employee.allowances" :key="index"
                             class="flex items-center justify-between bg-white rounded-lg p-3">
                          <div>
                            <p class="text-gray-900 font-medium">{{ allowance.type }}</p>
                            <p class="text-xs text-gray-500">{{ allowance.description }}</p>
                          </div>
                          <span class="text-green-600 font-semibold">₱{{ formatCurrency(allowance.amount) }}</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Important Dates -->
                <div class="bg-gradient-to-r from-amber-50 to-orange-50 rounded-xl p-6">
                  <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-calendar-check mr-3 text-amber-600"></i>Important Dates
                  </h3>
                  <div class="space-y-4">
                    <div class="grid grid-cols-1 gap-4">
                      <div>
                        <label class="text-sm font-medium text-gray-500">Hire Date</label>
                        <p class="text-gray-900 font-medium">{{ formatDate(employee.hire_date) || 'Not set' }}</p>
                      </div>
                      <div v-if="employee.original_hire_date">
                        <label class="text-sm font-medium text-gray-500">Original Hire Date</label>
                        <p class="text-gray-900 font-medium">{{ formatDate(employee.original_hire_date) }}</p>
                      </div>
                      <div v-if="employee.probation_end_date">
                        <label class="text-sm font-medium text-gray-500">Probation End Date</label>
                        <p class="text-gray-900 font-medium">{{ formatDate(employee.probation_end_date) }}</p>
                      </div>
                      <div v-if="employee.regularization_date">
                        <label class="text-sm font-medium text-gray-500">Regularization Date</label>
                        <p class="text-gray-900 font-medium">{{ formatDate(employee.regularization_date) }}</p>
                      </div>
                      <div v-if="employee.last_promotion_date">
                        <label class="text-sm font-medium text-gray-500">Last Promotion Date</label>
                        <p class="text-gray-900 font-medium">{{ formatDate(employee.last_promotion_date) }}</p>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Work Schedule -->
                <div class="bg-gradient-to-r from-cyan-50 to-blue-50 rounded-xl p-6">
                  <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-clock mr-3 text-cyan-600"></i>Work Schedule
                  </h3>
                  <div class="space-y-4">
                    <div>
                      <label class="text-sm font-medium text-gray-500">Schedule</label>
                      <p class="text-gray-900 font-medium">{{ employee.work_schedule?.name || 'Not assigned' }}</p>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                      <div>
                        <label class="text-sm font-medium text-gray-500">Flexible Time</label>
                        <p class="text-gray-900 font-medium">{{ employee.is_flexible_time ? 'Yes' : 'No' }}</p>
                      </div>
                      <div>
                        <label class="text-sm font-medium text-gray-500">Field Work</label>
                        <p class="text-gray-900 font-medium">{{ employee.is_field_work ? 'Yes' : 'No' }}</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Documents Tab -->
          <div v-if="activeTab === 'documents'" class="p-8">
            <div class="mb-6 flex items-center justify-between">
              <h3 class="text-lg font-semibold text-gray-900">Employee Documents</h3>
              <button @click="showDocumentModal = true" class="btn btn-primary">
                <i class="fas fa-upload mr-2"></i>Upload New Document
              </button>
            </div>

            <!-- Document Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
              <div class="bg-gradient-to-r from-green-500 to-emerald-600 rounded-xl p-6 text-white">
                <div class="flex items-center">
                  <i class="fas fa-check-circle text-2xl mr-4"></i>
                  <div>
                    <p class="text-lg font-bold">{{ documents.length - expiredDocuments.length - expiringDocuments.length }}</p>
                    <p class="text-green-100">Valid Documents</p>
                  </div>
                </div>
              </div>
              <div class="bg-gradient-to-r from-amber-500 to-orange-600 rounded-xl p-6 text-white">
                <div class="flex items-center">
                  <i class="fas fa-exclamation-triangle text-2xl mr-4"></i>
                  <div>
                    <p class="text-lg font-bold">{{ expiringDocuments.length }}</p>
                    <p class="text-amber-100">Expiring Soon</p>
                  </div>
                </div>
              </div>
              <div class="bg-gradient-to-r from-red-500 to-pink-600 rounded-xl p-6 text-white">
                <div class="flex items-center">
                  <i class="fas fa-times-circle text-2xl mr-4"></i>
                  <div>
                    <p class="text-lg font-bold">{{ expiredDocuments.length }}</p>
                    <p class="text-red-100">Expired Documents</p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Documents List -->
            <div v-if="documents.length > 0" class="space-y-4">
              <div v-for="document in documents" :key="document.id"
                   class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                  <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0">
                      <i class="fas fa-file-alt text-2xl text-blue-600"></i>
                    </div>
                    <div>
                      <h4 class="text-lg font-semibold text-gray-900">{{ document.document_name }}</h4>
                      <p class="text-sm text-gray-600">{{ getDocumentTypeLabel(document.document_type) }}</p>
                      <div class="flex items-center space-x-4 mt-2">
                        <span class="text-xs text-gray-500">
                          <i class="fas fa-calendar mr-1"></i>{{ formatDate(document.created_at) }}
                        </span>
                        <span v-if="document.expiry_date" class="text-xs text-gray-500">
                          <i class="fas fa-clock mr-1"></i>Expires: {{ formatDate(document.expiry_date) }}
                        </span>
                        <span v-if="document.is_verified" class="text-xs text-green-600">
                          <i class="fas fa-check-circle mr-1"></i>Verified
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="flex items-center space-x-2">
                    <button class="btn btn-sm btn-secondary">
                      <i class="fas fa-download mr-1"></i>Download
                    </button>
                    <button class="btn btn-sm btn-outline">
                      <i class="fas fa-eye mr-1"></i>View
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <div v-else class="text-center py-12 text-gray-500">
              <i class="fas fa-folder-open text-4xl mb-4"></i>
              <p class="text-lg">No documents uploaded</p>
              <p class="text-sm">Upload employee documents to get started</p>
            </div>
          </div>

          <!-- Emergency Contacts Tab -->
          <div v-if="activeTab === 'emergency'" class="p-8">
            <div class="mb-6">
              <h3 class="text-lg font-semibold text-gray-900 mb-2">Emergency Contacts</h3>
              <p class="text-gray-600">People to contact in case of emergency</p>
            </div>

            <div v-if="employee.emergency_contacts && employee.emergency_contacts.length > 0"
                 class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div v-for="(contact, index) in employee.emergency_contacts" :key="index"
                   class="bg-gradient-to-r from-red-50 to-pink-50 rounded-xl border border-red-200 p-6">
                <div class="flex items-start space-x-4">
                  <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                      <i class="fas fa-user-shield text-red-600 text-xl"></i>
                    </div>
                  </div>
                  <div class="flex-1">
                    <h4 class="text-lg font-semibold text-gray-900">{{ contact.name }}</h4>
                    <p class="text-sm text-gray-600 mb-3">{{ contact.relationship }}</p>
                    <div class="space-y-2">
                      <div v-if="contact.phone" class="flex items-center text-sm text-gray-700">
                        <i class="fas fa-phone mr-2 text-red-500"></i>{{ contact.phone }}
                      </div>
                      <div v-if="contact.email" class="flex items-center text-sm text-gray-700">
                        <i class="fas fa-envelope mr-2 text-red-500"></i>{{ contact.email }}
                      </div>
                      <div v-if="contact.address" class="flex items-start text-sm text-gray-700">
                        <i class="fas fa-map-marker-alt mr-2 text-red-500 mt-1"></i>
                        <span>{{ contact.address }}</span>
                      </div>
                    </div>
                    <div v-if="contact.is_primary" class="mt-3">
                      <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full">Primary Contact</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div v-else class="text-center py-12 text-gray-500">
              <i class="fas fa-user-shield text-4xl mb-4"></i>
              <p class="text-lg">No emergency contacts on file</p>
              <p class="text-sm">Emergency contact information should be added for safety</p>
            </div>
          </div>

          <!-- Audit Trail Tab -->
          <div v-if="activeTab === 'audit'" class="p-8">
            <div class="mb-6 flex items-center justify-between">
              <div>
                <h3 class="text-lg font-semibold text-gray-900">Audit Trail</h3>
                <p class="text-gray-600">Complete history of changes made to this employee record</p>
              </div>
              <button @click="loadTimeline" class="btn btn-secondary" :disabled="timelineLoading">
                <i class="fas fa-sync-alt mr-2" :class="{ 'animate-spin': timelineLoading }"></i>
                Refresh Timeline
              </button>
            </div>

            <!-- Timeline -->
            <div v-if="timeline.length > 0" class="space-y-6">
              <div v-for="(item, index) in timeline" :key="index" class="relative">
                <!-- Timeline Line -->
                <div v-if="index < timeline.length - 1"
                     class="absolute left-6 top-12 bottom-0 w-0.5 bg-gray-200"></div>

                <!-- Timeline Item -->
                <div class="flex items-start space-x-4">
                  <!-- Icon -->
                  <div :class="getTimelineIconClass(item.type)"
                       class="w-12 h-12 rounded-full flex items-center justify-center shadow-lg z-10">
                    <i :class="getTimelineIcon(item.type)" class="text-white"></i>
                  </div>

                  <!-- Content -->
                  <div class="flex-1 bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
                    <div class="flex items-center justify-between mb-3">
                      <div>
                        <h4 class="text-lg font-semibold text-gray-900">{{ item.description }}</h4>
                        <p class="text-sm text-gray-600">{{ item.user }} • {{ formatDateTime(item.date) }}</p>
                      </div>
                      <span :class="getActionBadgeClass(item.type)"
                            class="px-3 py-1 rounded-full text-xs font-medium">
                        {{ item.type.replace('_', ' ').toUpperCase() }}
                      </span>
                    </div>

                    <!-- Changes Detail -->
                    <div v-if="item.changes" class="mt-4">
                      <div class="bg-gray-50 rounded-lg p-4">
                        <h5 class="text-sm font-medium text-gray-700 mb-3">Changes Made:</h5>
                        <div v-html="item.changes" class="text-sm space-y-2"></div>
                      </div>
                    </div>

                    <!-- Additional Info -->
                    <div v-if="item.ip_address || item.user_agent" class="mt-4 pt-4 border-t border-gray-100">
                      <div class="flex items-center justify-between text-xs text-gray-500">
                        <span v-if="item.ip_address">
                          <i class="fas fa-globe mr-1"></i>{{ item.ip_address }}
                        </span>
                        <button v-if="item.user_agent" @click="toggleUserAgent(index)"
                                class="text-blue-600 hover:text-blue-800">
                          <i :class="showUserAgent[index] ? 'fas fa-chevron-up' : 'fas fa-chevron-down'" class="mr-1"></i>
                          {{ showUserAgent[index] ? 'Hide' : 'Show' }} Browser Details
                        </button>
                      </div>
                      <div v-if="showUserAgent[index] && item.user_agent"
                           class="mt-2 p-2 bg-gray-100 rounded text-xs text-gray-600 break-all">
                        {{ item.user_agent }}
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- No Timeline Data -->
            <div v-else-if="!timelineLoading" class="text-center py-12 text-gray-500">
              <i class="fas fa-history text-4xl mb-4"></i>
              <p class="text-lg">No audit trail data available</p>
              <p class="text-sm">Employee activity and changes will appear here</p>
            </div>

            <!-- Loading -->
            <div v-if="timelineLoading" class="text-center py-12">
              <i class="fas fa-spinner fa-spin text-4xl text-blue-600 mb-4"></i>
              <p class="text-lg text-gray-600">Loading audit trail...</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Document Upload Modal placeholder -->
    <!-- Add your document upload modal here -->
  </AppLayout>
</template>

<script setup>
import { ref, computed, onMounted, watch } from 'vue'
import { Link } from '@inertiajs/vue3'
import AppLayout from '../../Layouts/AppLayout.vue'

// Props
const props = defineProps({
  employee: Object,
  documents: Array,
  documentsByType: Object,
  expiredDocuments: Array,
  expiringDocuments: Array,
  documentTypes: Object,
})

// Reactive state
const activeTab = ref('overview')
const showDocumentModal = ref(false)
const timeline = ref([])
const timelineLoading = ref(false)
const showUserAgent = ref({})

// Computed properties
const fullName = computed(() => {
  const parts = [
    props.employee.first_name,
    props.employee.middle_name,
    props.employee.last_name,
    props.employee.suffix
  ].filter(Boolean)
  return parts.join(' ')
})

const yearsOfService = computed(() => {
  if (!props.employee.hire_date) return 0
  const hireDate = new Date(props.employee.hire_date)
  const today = new Date()
  const diffTime = Math.abs(today - hireDate)
  const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24))
  return Math.floor(diffDays / 365.25)
})

const yearsOfServiceText = computed(() => {
  const years = yearsOfService.value
  if (years === 0) return '0 years of service'
  if (years === 1) return '1 year of service'
  return `${years} years of service`
})

const photoUrl = computed(() => {
  if (!props.employee.photo) return null
  // If the photo path already starts with http or /, use it as is
  if (props.employee.photo.startsWith('http') || props.employee.photo.startsWith('/')) {
    return props.employee.photo
  }
  // Otherwise, prepend /storage/ to access via the public storage symlink
  return `/storage/${props.employee.photo}`
})

const statusBadgeClass = computed(() => {
  const status = props.employee.employment_status?.name?.toLowerCase()
  if (status?.includes('active') || status?.includes('regular')) {
    return 'bg-emerald-100 text-emerald-800 border border-emerald-200'
  } else if (status?.includes('probation')) {
    return 'bg-amber-100 text-amber-800 border border-amber-200'
  } else if (status?.includes('terminated') || status?.includes('resigned')) {
    return 'bg-red-100 text-red-800 border border-red-200'
  } else if (status?.includes('elected') || status?.includes('appointed')) {
    return 'bg-blue-100 text-blue-800 border border-blue-200'
  }
  return 'bg-gray-100 text-gray-800 border border-gray-200'
})

const statusDotClass = computed(() => {
  const status = props.employee.employment_status?.name?.toLowerCase()
  if (status?.includes('active') || status?.includes('regular')) {
    return 'bg-emerald-500'
  } else if (status?.includes('probation')) {
    return 'bg-amber-500'
  } else if (status?.includes('terminated') || status?.includes('resigned')) {
    return 'bg-red-500'
  } else if (status?.includes('elected') || status?.includes('appointed')) {
    return 'bg-blue-500'
  }
  return 'bg-gray-500'
})

// Methods
const tabClass = (tab) => {
  return activeTab.value === tab
    ? 'border-blue-500 text-blue-600'
    : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
}

const formatDate = (date) => {
  if (!date) return 'Not set'
  return new Date(date).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  })
}

const formatDateTime = (date) => {
  if (!date) return 'Unknown'
  return new Date(date).toLocaleString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
    hour: 'numeric',
    minute: '2-digit',
    hour12: true
  })
}

const formatCurrency = (amount) => {
  return new Intl.NumberFormat('en-PH').format(amount)
}

const calculateAge = (birthDate) => {
  if (!birthDate) return null
  const today = new Date()
  const birth = new Date(birthDate)
  let age = today.getFullYear() - birth.getFullYear()
  const monthDiff = today.getMonth() - birth.getMonth()
  if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birth.getDate())) {
    age--
  }
  return age
}

const getDocumentTypeLabel = (type) => {
  return props.documentTypes[type] || type.replace('_', ' ').toUpperCase()
}

const getTimelineIconClass = (type) => {
  switch (type) {
    case 'created':
      return 'bg-gradient-to-r from-green-500 to-emerald-600'
    case 'updated':
      return 'bg-gradient-to-r from-blue-500 to-cyan-600'
    case 'deleted':
      return 'bg-gradient-to-r from-red-500 to-pink-600'
    case 'document_uploaded':
      return 'bg-gradient-to-r from-purple-500 to-indigo-600'
    case 'document_verified':
      return 'bg-gradient-to-r from-emerald-500 to-teal-600'
    case 'milestone':
      return 'bg-gradient-to-r from-amber-500 to-orange-600'
    default:
      return 'bg-gradient-to-r from-gray-500 to-slate-600'
  }
}

const getTimelineIcon = (type) => {
  switch (type) {
    case 'created':
      return 'fas fa-plus'
    case 'updated':
      return 'fas fa-edit'
    case 'deleted':
      return 'fas fa-trash'
    case 'document_uploaded':
      return 'fas fa-file-upload'
    case 'document_verified':
      return 'fas fa-check-circle'
    case 'milestone':
      return 'fas fa-star'
    default:
      return 'fas fa-clock'
  }
}

const getActionBadgeClass = (type) => {
  switch (type) {
    case 'created':
      return 'bg-green-100 text-green-800'
    case 'updated':
      return 'bg-blue-100 text-blue-800'
    case 'deleted':
      return 'bg-red-100 text-red-800'
    case 'document_uploaded':
      return 'bg-purple-100 text-purple-800'
    case 'document_verified':
      return 'bg-emerald-100 text-emerald-800'
    case 'milestone':
      return 'bg-amber-100 text-amber-800'
    default:
      return 'bg-gray-100 text-gray-800'
  }
}

const toggleUserAgent = (index) => {
  showUserAgent.value[index] = !showUserAgent.value[index]
}

const loadTimeline = async () => {
  if (timelineLoading.value) return

  timelineLoading.value = true
  try {
    const response = await fetch(`/spa/employees/${props.employee.id}/timeline`)
    if (response.ok) {
      const data = await response.json()
      timeline.value = data.timeline
    }
  } catch (error) {
    console.error('Error loading timeline:', error)
  } finally {
    timelineLoading.value = false
  }
}

// Load timeline when audit tab is activated
watch(() => activeTab.value, (newTab) => {
  if (newTab === 'audit' && timeline.value.length === 0) {
    loadTimeline()
  }
})

// Load timeline on mount if audit tab is active
onMounted(() => {
  if (activeTab.value === 'audit') {
    loadTimeline()
  }
})
</script>

<style scoped>
.btn {
  padding: 0.5rem 1rem;
  border-radius: 0.5rem;
  font-weight: 500;
  font-size: 0.875rem;
  transition: all 0.2s ease-in-out;
}

.btn:focus {
  outline: none;
  box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5);
}

.btn-primary {
  background-color: #2563eb;
  color: white;
}

.btn-primary:hover {
  background-color: #1d4ed8;
}

.btn-secondary {
  background-color: #4b5563;
  color: white;
}

.btn-secondary:hover {
  background-color: #374151;
}

.btn-outline {
  border: 1px solid #d1d5db;
  color: #374151;
}

.btn-outline:hover {
  background-color: #f9fafb;
}

.btn-sm {
  padding: 0.25rem 0.75rem;
  font-size: 0.75rem;
}
</style>