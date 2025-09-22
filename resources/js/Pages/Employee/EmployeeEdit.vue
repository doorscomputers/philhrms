<template>
  <AppLayout>
    <div class="container mx-auto py-8">
      <div class="max-w-6xl mx-auto">
        <h1 class="text-3xl font-bold mb-8 text-gray-900">Edit Employee - {{ employee.first_name }} {{ employee.last_name }}</h1>

        <form @submit.prevent="submitForm" class="bg-white shadow-lg rounded-lg overflow-hidden">

          <!-- Employee Identification -->
          <div class="border-b border-gray-200 p-6">
            <h2 class="text-xl font-semibold mb-4 text-gray-900 flex items-center">
              <i class="fas fa-id-badge mr-3 text-blue-600"></i>Employee Identification
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
              <div class="form-group">
                <label class="form-label">Employee ID</label>
                <input v-model="form.employee_id" type="text" class="form-input" placeholder="Auto-generated if empty">
              </div>
              <div class="form-group">
                <label class="form-label">Badge Number</label>
                <input v-model="form.badge_number" type="text" class="form-input">
              </div>
              <div class="form-group">
                <label class="form-label">Biometric ID</label>
                <input v-model="form.biometric_id" type="text" class="form-input">
              </div>
            </div>
          </div>

          <!-- Personal Information -->
          <div class="border-b border-gray-200 p-6">
            <h2 class="text-xl font-semibold mb-4 text-gray-900 flex items-center">
              <i class="fas fa-user mr-3 text-green-600"></i>Personal Information
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
              <div class="form-group">
                <label class="form-label">First Name *</label>
                <input v-model="form.first_name" type="text" class="form-input" required>
              </div>
              <div class="form-group">
                <label class="form-label">Middle Name</label>
                <input v-model="form.middle_name" type="text" class="form-input">
              </div>
              <div class="form-group">
                <label class="form-label">Last Name *</label>
                <input v-model="form.last_name" type="text" class="form-input" required>
              </div>
              <div class="form-group">
                <label class="form-label">Suffix</label>
                <input v-model="form.suffix" type="text" class="form-input" placeholder="Jr., Sr., III">
              </div>
              <div class="form-group">
                <label class="form-label">Maiden Name</label>
                <input v-model="form.maiden_name" type="text" class="form-input">
              </div>
              <div class="form-group">
                <label class="form-label">Nickname</label>
                <input v-model="form.nickname" type="text" class="form-input">
              </div>
              <div class="form-group">
                <label class="form-label">Birth Date</label>
                <input v-model="form.birth_date" type="date" class="form-input">
              </div>
              <div class="form-group">
                <label class="form-label">Birth Place</label>
                <input v-model="form.birth_place" type="text" class="form-input">
              </div>
              <div class="form-group">
                <label class="form-label">Gender</label>
                <select v-model="form.gender" class="form-select">
                  <option value="">Select Gender</option>
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                  <option value="Other">Other</option>
                </select>
              </div>
              <div class="form-group">
                <label class="form-label">Civil Status</label>
                <select v-model="form.civil_status" class="form-select">
                  <option value="">Select Status</option>
                  <option value="Single">Single</option>
                  <option value="Married">Married</option>
                  <option value="Divorced">Divorced</option>
                  <option value="Widowed">Widowed</option>
                </select>
              </div>
              <div class="form-group">
                <label class="form-label">Nationality</label>
                <input v-model="form.nationality" type="text" class="form-input" placeholder="Filipino">
              </div>
              <div class="form-group">
                <label class="form-label">Religion</label>
                <input v-model="form.religion" type="text" class="form-input">
              </div>
              <div class="form-group">
                <label class="form-label">Blood Type</label>
                <select v-model="form.blood_type" class="form-select">
                  <option value="">Select Blood Type</option>
                  <option value="A+">A+</option>
                  <option value="A-">A-</option>
                  <option value="B+">B+</option>
                  <option value="B-">B-</option>
                  <option value="AB+">AB+</option>
                  <option value="AB-">AB-</option>
                  <option value="O+">O+</option>
                  <option value="O-">O-</option>
                </select>
              </div>
              <div class="form-group">
                <label class="form-label">Height (cm)</label>
                <input v-model="form.height" type="number" class="form-input">
              </div>
              <div class="form-group">
                <label class="form-label">Weight (kg)</label>
                <input v-model="form.weight" type="number" class="form-input">
              </div>
            </div>
          </div>

          <!-- Government IDs -->
          <div class="border-b border-gray-200 p-6">
            <h2 class="text-xl font-semibold mb-4 text-gray-900 flex items-center">
              <i class="fas fa-id-card mr-3 text-purple-600"></i>Government IDs
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
              <div class="form-group">
                <label class="form-label">SSS Number</label>
                <input v-model="form.sss_number" type="text" class="form-input" @input="formatSSS($event)" placeholder="12-3456789-0" maxlength="13">
              </div>
              <div class="form-group">
                <label class="form-label">TIN</label>
                <input v-model="form.tin" type="text" class="form-input" @input="formatTIN($event)" placeholder="123-456-789-000" maxlength="15">
              </div>
              <div class="form-group">
                <label class="form-label">PhilHealth Number</label>
                <input v-model="form.philhealth_number" type="text" class="form-input" @input="formatPhilHealth($event)" placeholder="12-345678901-2" maxlength="14">
              </div>
              <div class="form-group">
                <label class="form-label">Pag-IBIG Number</label>
                <input v-model="form.pagibig_number" type="text" class="form-input" @input="formatPagIbig($event)" placeholder="1234-5678-9012" maxlength="14">
              </div>
              <div class="form-group">
                <label class="form-label">Passport Number</label>
                <input v-model="form.passport_number" type="text" class="form-input">
              </div>
              <div class="form-group">
                <label class="form-label">Driver's License</label>
                <input v-model="form.drivers_license" type="text" class="form-input">
              </div>
              <div class="form-group">
                <label class="form-label">Voter's ID</label>
                <input v-model="form.voters_id" type="text" class="form-input">
              </div>
            </div>
          </div>

          <!-- Contact Information -->
          <div class="border-b border-gray-200 p-6">
            <h2 class="text-xl font-semibold mb-4 text-gray-900 flex items-center">
              <i class="fas fa-envelope mr-3 text-blue-600"></i>Contact Information
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div class="form-group">
                <label class="form-label">Primary Email</label>
                <input v-model="form.email" type="email" class="form-input">
              </div>
              <div class="form-group">
                <label class="form-label">Primary Phone</label>
                <input v-model="form.phone" type="text" class="form-input" @input="formatPhoneNumber($event, 'phone')" placeholder="0917-123-4567" maxlength="13">
              </div>
              <div class="form-group">
                <label class="form-label">Secondary Phone</label>
                <input v-model="form.phone_secondary" type="text" class="form-input" @input="formatPhoneNumber($event, 'phone_secondary')" placeholder="0917-123-4567" maxlength="13">
              </div>
              <div class="form-group">
                <label class="form-label">Emergency Contact Name</label>
                <input v-model="form.emergency_contact_name" type="text" class="form-input">
              </div>
              <div class="form-group">
                <label class="form-label">Emergency Contact Phone</label>
                <input v-model="form.emergency_contact_phone" type="text" class="form-input" @input="formatPhoneNumber($event, 'emergency_contact_phone')" placeholder="0917-123-4567" maxlength="13">
              </div>
              <div class="form-group">
                <label class="form-label">Emergency Contact Relationship</label>
                <input v-model="form.emergency_contact_relationship" type="text" class="form-input" placeholder="Spouse, Parent, Sibling">
              </div>
            </div>

            <!-- Address -->
            <div class="mt-6">
              <h3 class="text-lg font-medium mb-3 text-gray-900">Current Address</h3>
              <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="form-group">
                  <label class="form-label">Street Address</label>
                  <input v-model="form.address_street" type="text" class="form-input">
                </div>
                <div class="form-group">
                  <label class="form-label">Barangay</label>
                  <input v-model="form.address_barangay" type="text" class="form-input">
                </div>
                <div class="form-group">
                  <label class="form-label">City</label>
                  <input v-model="form.address_city" type="text" class="form-input">
                </div>
                <div class="form-group">
                  <label class="form-label">Province</label>
                  <input v-model="form.address_province" type="text" class="form-input">
                </div>
                <div class="form-group">
                  <label class="form-label">Postal Code</label>
                  <input v-model="form.address_postal_code" type="text" class="form-input">
                </div>
              </div>
            </div>
          </div>

          <!-- Employment Information -->
          <div class="border-b border-gray-200 p-6">
            <h2 class="text-xl font-semibold mb-4 text-gray-900 flex items-center">
              <i class="fas fa-briefcase mr-3 text-indigo-600"></i>Employment Information
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
              <div class="form-group">
                <label class="form-label">Department *</label>
                <div class="flex gap-2">
                  <select v-model="form.department_id" class="form-select flex-1" required>
                    <option value="">Select Department</option>
                    <option v-for="dept in departments" :key="dept.id" :value="dept.id">
                      {{ dept.name }}
                    </option>
                  </select>
                  <button type="button" @click="showQuickAddModal('department')" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-lg text-sm font-medium whitespace-nowrap" title="Add New Department">
                    <i class="fas fa-plus"></i>
                  </button>
                </div>
              </div>
              <div class="form-group">
                <label class="form-label">Position *</label>
                <div class="flex gap-2">
                  <select v-model="form.position_id" class="form-select flex-1" required>
                    <option value="">Select Position</option>
                    <option v-for="pos in positions" :key="pos.id" :value="pos.id">
                      {{ pos.title }}
                    </option>
                  </select>
                  <button type="button" @click="showQuickAddModal('position')" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-lg text-sm font-medium whitespace-nowrap" title="Add New Position">
                    <i class="fas fa-plus"></i>
                  </button>
                </div>
              </div>
              <div class="form-group">
                <label class="form-label">Job Grade</label>
                <div class="flex gap-2">
                  <select v-model="form.job_grade_id" class="form-select flex-1">
                    <option value="">Select Job Grade</option>
                    <option v-for="grade in jobGrades" :key="grade.id" :value="grade.id">
                      {{ grade.name }}
                    </option>
                  </select>
                  <button type="button" @click="showQuickAddModal('jobGrade')" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-lg text-sm font-medium whitespace-nowrap" title="Add New Job Grade">
                    <i class="fas fa-plus"></i>
                  </button>
                </div>
              </div>
              <div class="form-group">
                <label class="form-label">Branch/Office</label>
                <div class="flex gap-2">
                  <select v-model="form.branch_id" class="form-select flex-1">
                    <option value="">Select Branch</option>
                    <option v-for="branch in branches" :key="branch.id" :value="branch.id">
                      {{ branch.name }}
                    </option>
                  </select>
                  <button type="button" @click="showQuickAddModal('branch')" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-lg text-sm font-medium whitespace-nowrap" title="Add New Branch">
                    <i class="fas fa-plus"></i>
                  </button>
                </div>
              </div>
              <div class="form-group">
                <label class="form-label">Work Schedule</label>
                <div class="flex gap-2">
                  <select v-model="form.work_schedule_id" class="form-select flex-1">
                    <option value="">Select Schedule</option>
                    <option v-for="schedule in workSchedules" :key="schedule.id" :value="schedule.id">
                      {{ schedule.name }}
                    </option>
                  </select>
                  <button type="button" @click="showQuickAddModal('workSchedule')" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-lg text-sm font-medium whitespace-nowrap" title="Add New Work Schedule">
                    <i class="fas fa-plus"></i>
                  </button>
                </div>
              </div>
              <div class="form-group">
                <label class="form-label">Employment Status</label>
                <div class="flex gap-2">
                  <select v-model="form.employment_status" class="form-select flex-1">
                    <option value="">Select Status</option>
                    <option v-for="status in employmentStatuses" :key="status.id" :value="status.name">
                      {{ status.name }}
                    </option>
                  </select>
                  <button type="button" @click="showQuickAddModal('employmentStatus')" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-lg text-sm font-medium whitespace-nowrap" title="Add New Employment Status">
                    <i class="fas fa-plus"></i>
                  </button>
                </div>
              </div>
              <div class="form-group">
                <label class="form-label">Employment Type</label>
                <select v-model="form.employment_type" class="form-select">
                  <option value="">Select Type</option>
                  <option value="Full-time">Full-time</option>
                  <option value="Part-time">Part-time</option>
                  <option value="Contract">Contract</option>
                  <option value="Temporary">Temporary</option>
                  <option value="Intern">Intern</option>
                </select>
              </div>
              <div class="form-group">
                <label class="form-label">Hire Date</label>
                <input v-model="form.hire_date" type="date" class="form-input">
              </div>
              <div class="form-group">
                <label class="form-label">Supervisor</label>
                <select v-model="form.supervisor_id" class="form-select">
                  <option value="">Select Supervisor</option>
                  <option v-for="emp in employees" :key="emp.id" :value="emp.id">
                    {{ emp.first_name }} {{ emp.last_name }}
                  </option>
                </select>
              </div>
            </div>
          </div>

          <!-- Compensation -->
          <div class="border-b border-gray-200 p-6">
            <h2 class="text-xl font-semibold mb-4 text-gray-900 flex items-center">
              <i class="fas fa-dollar-sign mr-3 text-green-600"></i>Compensation & Benefits
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
              <div class="form-group">
                <label class="form-label">Basic Salary</label>
                <input v-model="form.basic_salary" type="number" step="0.01" class="form-input">
              </div>
              <div class="form-group">
                <label class="form-label">Daily Rate</label>
                <input v-model="form.daily_rate" type="number" step="0.01" class="form-input">
              </div>
              <div class="form-group">
                <label class="form-label">Hourly Rate</label>
                <input v-model="form.hourly_rate" type="number" step="0.01" class="form-input">
              </div>
              <div class="form-group">
                <label class="form-label">Pay Frequency</label>
                <div class="flex gap-2">
                  <select v-model="form.pay_frequency" class="form-select flex-1">
                    <option value="">Select Frequency</option>
                    <option v-for="frequency in payFrequencies" :key="frequency" :value="frequency">
                      {{ frequency }}
                    </option>
                  </select>
                  <button type="button" @click="showQuickAddModal('payFrequency')" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-lg text-sm font-medium whitespace-nowrap" title="Add New Pay Frequency">
                    <i class="fas fa-plus"></i>
                  </button>
                </div>
              </div>
              <div class="form-group">
                <label class="form-label">Tax Status</label>
                <div class="flex gap-2">
                  <select v-model="form.tax_status" class="form-select flex-1">
                    <option value="">Select Status</option>
                    <option v-for="status in taxStatuses" :key="status.value" :value="status.value">
                      {{ status.label }}
                    </option>
                  </select>
                  <button type="button" @click="showQuickAddModal('taxStatus')" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-lg text-sm font-medium whitespace-nowrap" title="Add New Tax Status">
                    <i class="fas fa-plus"></i>
                  </button>
                </div>
              </div>
              <div class="form-group">
                <label class="form-label">Tax Shield</label>
                <input v-model="form.tax_shield" type="number" step="0.01" class="form-input">
              </div>
            </div>

            <!-- Leave Balances -->
            <div class="mt-6">
              <h3 class="text-lg font-medium mb-3 text-gray-900">Leave Balances</h3>
              <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="form-group">
                  <label class="form-label">Vacation Leave Balance</label>
                  <input v-model="form.vacation_leave_balance" type="number" step="0.5" class="form-input">
                </div>
                <div class="form-group">
                  <label class="form-label">Sick Leave Balance</label>
                  <input v-model="form.sick_leave_balance" type="number" step="0.5" class="form-input">
                </div>
                <div class="form-group">
                  <label class="form-label">Emergency Leave Balance</label>
                  <input v-model="form.emergency_leave_balance" type="number" step="0.5" class="form-input">
                </div>
              </div>
            </div>

            <!-- Employment Settings -->
            <div class="mt-6">
              <h3 class="text-lg font-medium mb-3 text-gray-900">Employment Settings</h3>
              <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="form-group">
                  <label class="form-label flex items-center">
                    <input v-model="form.is_active" type="checkbox" class="mr-2">
                    Active Employee
                  </label>
                </div>
                <div class="form-group">
                  <label class="form-label flex items-center">
                    <input v-model="form.is_exempt" type="checkbox" class="mr-2">
                    Tax Exempt
                  </label>
                </div>
                <div class="form-group">
                  <label class="form-label flex items-center">
                    <input v-model="form.is_flexible_time" type="checkbox" class="mr-2">
                    Flexible Time
                  </label>
                </div>
                <div class="form-group">
                  <label class="form-label flex items-center">
                    <input v-model="form.is_field_work" type="checkbox" class="mr-2">
                    Field Work
                  </label>
                </div>
                <div class="form-group">
                  <label class="form-label flex items-center">
                    <input v-model="form.is_minimum_wage" type="checkbox" class="mr-2">
                    Minimum Wage
                  </label>
                </div>
              </div>
            </div>
          </div>

          <!-- Medical Information -->
          <div class="border-b border-gray-200 p-6">
            <h2 class="text-xl font-semibold mb-4 text-gray-900 flex items-center">
              <i class="fas fa-heart mr-3 text-red-600"></i>Medical Information
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div class="form-group">
                <label class="form-label">Medical Conditions</label>
                <textarea v-model="form.medical_conditions" class="form-textarea" rows="3" placeholder="List any medical conditions, separated by commas"></textarea>
              </div>
              <div class="form-group">
                <label class="form-label">Allergies</label>
                <textarea v-model="form.allergies" class="form-textarea" rows="3" placeholder="List any allergies, separated by commas"></textarea>
              </div>
            </div>
          </div>

          <!-- Documents & Photo -->
          <div class="border-b border-gray-200 p-6">
            <h2 class="text-xl font-semibold mb-4 text-gray-900 flex items-center">
              <i class="fas fa-file-upload mr-3 text-orange-600"></i>Documents & Photo
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div class="form-group">
                <label class="form-label">Employee Photo</label>
                <input @change="handlePhotoUpload" type="file" accept="image/*" class="form-input">
                <p class="text-sm text-gray-500 mt-1">Accepted formats: JPG, PNG (Max: 5MB)</p>
              </div>
              <div class="form-group">
                <label class="form-label">Documents</label>
                <input @change="handleDocumentsUpload" type="file" multiple accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" class="form-input">
                <p class="text-sm text-gray-500 mt-1">Accepted formats: PDF, DOC, DOCX, JPG, PNG (Max: 10MB each)</p>
              </div>
            </div>
          </div>

          <!-- Additional Information -->
          <div class="p-6">
            <h2 class="text-xl font-semibold mb-4 text-gray-900 flex items-center">
              <i class="fas fa-sticky-note mr-3 text-yellow-600"></i>Additional Information
            </h2>
            <div class="form-group">
              <label class="form-label">Remarks/Notes</label>
              <textarea v-model="form.remarks" class="form-textarea" rows="4" placeholder="Any additional notes or remarks about the employee"></textarea>
            </div>
          </div>

          <!-- Submit Buttons -->
          <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-4">
            <Link href="/spa/employees" class="btn btn-secondary">Cancel</Link>
            <button type="submit" :disabled="form.processing" class="btn btn-primary">
              <span v-if="form.processing">Updating Employee...</span>
              <span v-else>Update Employee</span>
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Quick Add Modal -->
    <div v-if="showModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" @click="closeQuickAddModal">
      <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white" @click.stop>
        <div class="mt-3">
          <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-medium text-gray-900">{{ modalTitle }}</h3>
            <button @click="closeQuickAddModal" class="text-gray-400 hover:text-gray-600">
              <i class="fas fa-times"></i>
            </button>
          </div>

          <form @submit.prevent="submitQuickAdd" class="space-y-4">
            <!-- Common Fields -->
            <div v-if="modalType !== 'position' && modalType !== 'payFrequency' && modalType !== 'taxStatus'">
              <label class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
              <input v-model="quickAddForm.name" type="text" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter name">
            </div>

            <!-- Pay Frequency specific fields -->
            <div v-if="modalType === 'payFrequency'">
              <label class="block text-sm font-medium text-gray-700 mb-1">Frequency Name *</label>
              <input v-model="quickAddForm.name" type="text" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter frequency name (e.g., Bi-weekly, Daily)">
            </div>

            <!-- Tax Status specific fields -->
            <div v-if="modalType === 'taxStatus'">
              <div class="space-y-3">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Tax Status Label *</label>
                  <input v-model="quickAddForm.label" type="text" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter tax status description">
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Tax Code *</label>
                  <input v-model="quickAddForm.code" type="text" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter tax code (e.g., S, ME, S1)">
                </div>
              </div>
            </div>

            <!-- Position specific field -->
            <div v-if="modalType === 'position'">
              <label class="block text-sm font-medium text-gray-700 mb-1">Title *</label>
              <input v-model="quickAddForm.title" type="text" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter position title">
            </div>

            <!-- Code field for database entities (not payFrequency or taxStatus) -->
            <div v-if="modalType !== 'payFrequency' && modalType !== 'taxStatus'">
              <label class="block text-sm font-medium text-gray-700 mb-1">Code *</label>
              <input v-model="quickAddForm.code" type="text" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter code">
            </div>

            <!-- Description for positions -->
            <div v-if="modalType === 'position'">
              <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
              <textarea v-model="quickAddForm.description" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" rows="3" placeholder="Enter description"></textarea>
            </div>

            <!-- Position required fields -->
            <div v-if="modalType === 'position'" class="space-y-3">
              <div class="grid grid-cols-2 gap-3">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Department *</label>
                  <select v-model="quickAddForm.department_id" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Select Department</option>
                    <option v-for="dept in departments" :key="dept.id" :value="dept.id">{{ dept.name }}</option>
                  </select>
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Job Grade *</label>
                  <select v-model="quickAddForm.job_grade_id" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Select Job Grade</option>
                    <option v-for="grade in jobGrades" :key="grade.id" :value="grade.id">{{ grade.name }}</option>
                  </select>
                </div>
              </div>
              <div class="grid grid-cols-2 gap-3">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Type *</label>
                  <select v-model="quickAddForm.type" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Select Type</option>
                    <option value="Regular">Regular</option>
                    <option value="Contractual">Contractual</option>
                    <option value="Consultant">Consultant</option>
                    <option value="Intern">Intern</option>
                  </select>
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Level *</label>
                  <select v-model="quickAddForm.level" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Select Level</option>
                    <option value="Executive">Executive</option>
                    <option value="Managerial">Managerial</option>
                    <option value="Supervisory">Supervisory</option>
                    <option value="Rank and File">Rank and File</option>
                  </select>
                </div>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Authorized Headcount *</label>
                <input v-model="quickAddForm.authorized_headcount" type="number" min="1" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter authorized headcount">
              </div>
            </div>

            <!-- Job Grade required fields -->
            <div v-if="modalType === 'jobGrade'" class="space-y-3">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Level *</label>
                <input v-model="quickAddForm.job_level" type="number" min="1" max="99" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter level (1-99)">
              </div>
              <div class="grid grid-cols-2 gap-3">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Min Salary *</label>
                  <input v-model="quickAddForm.min_salary" type="number" min="0" step="0.01" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter minimum salary">
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Max Salary *</label>
                  <input v-model="quickAddForm.max_salary" type="number" min="0" step="0.01" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter maximum salary">
                </div>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Mid Salary</label>
                <input v-model="quickAddForm.mid_salary" type="number" min="0" step="0.01" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter middle salary (optional)">
              </div>
            </div>

            <!-- Work Schedule specific fields -->
            <div v-if="modalType === 'workSchedule'" class="space-y-3">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Type *</label>
                <select v-model="quickAddForm.schedule_type" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                  <option value="">Select Type</option>
                  <option value="Fixed">Fixed</option>
                  <option value="Flexible">Flexible</option>
                  <option value="Shift">Shift</option>
                  <option value="Compressed">Compressed</option>
                </select>
              </div>
              <div class="grid grid-cols-2 gap-3">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Start Time</label>
                  <input v-model="quickAddForm.start_time" type="time" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">End Time</label>
                  <input v-model="quickAddForm.end_time" type="time" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
              </div>
              <div class="grid grid-cols-2 gap-3">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Hours per Day</label>
                  <input v-model="quickAddForm.hours_per_day" type="number" min="1" max="24" step="0.5" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="8.0">
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Days per Week</label>
                  <input v-model="quickAddForm.days_per_week" type="number" min="1" max="7" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="5">
                </div>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Break Duration (minutes)</label>
                <input v-model="quickAddForm.break_duration_minutes" type="number" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="60">
              </div>
            </div>

            <!-- Branch specific fields -->
            <div v-if="modalType === 'branch'" class="space-y-3">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                <input v-model="quickAddForm.address" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter address">
              </div>
              <div class="grid grid-cols-2 gap-3">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">City</label>
                  <input v-model="quickAddForm.city" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter city">
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">State</label>
                  <input v-model="quickAddForm.state" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter state">
                </div>
              </div>
              <div class="grid grid-cols-2 gap-3">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Postal Code</label>
                  <input v-model="quickAddForm.postal_code" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter postal code">
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                  <input v-model="quickAddForm.country" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
              </div>
            </div>

            <!-- Active checkbox -->
            <div class="flex items-center">
              <input v-model="quickAddForm.is_active" type="checkbox" id="is_active" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
              <label for="is_active" class="ml-2 block text-sm text-gray-700">Active</label>
            </div>

            <!-- Modal Actions -->
            <div class="flex items-center justify-end space-x-3 pt-4">
              <button type="button" @click="closeQuickAddModal" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md">
                Cancel
              </button>
              <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-md">
                Create
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { useForm, Link } from '@inertiajs/vue3'
import { ref } from 'vue'
import AppLayout from '../../Layouts/AppLayout.vue'

// Props
const props = defineProps({
  employee: Object,
  departments: Array,
  positions: Array,
  jobGrades: Array,
  branches: Array,
  workSchedules: Array,
  employmentStatuses: Array,
  employees: Array,
})

// Reactive data for non-database dropdown options
const payFrequencies = ref(['Daily', 'Weekly', 'Bi-weekly', 'Semi-monthly', 'Monthly'])
const taxStatuses = ref([
  { value: 'S', label: 'Single' },
  { value: 'ME', label: 'Married with Exemption' },
  { value: 'S1', label: 'Single with 1 Dependent' },
  { value: 'ME1', label: 'Married with Exemption, 1 Dependent' },
  { value: 'S2', label: 'Single with 2 Dependents' },
  { value: 'ME2', label: 'Married with Exemption, 2 Dependents' },
  { value: 'S3', label: 'Single with 3 Dependents' },
  { value: 'ME3', label: 'Married with Exemption, 3 Dependents' },
  { value: 'S4', label: 'Single with 4 Dependents' },
  { value: 'ME4', label: 'Married with Exemption, 4 Dependents' }
])

// Form with all comprehensive fields - pre-filled with employee data
const form = useForm({
  // Identification
  employee_id: props.employee.employee_id || '',
  badge_number: props.employee.badge_number || '',
  biometric_id: props.employee.biometric_id || '',

  // Personal Information
  first_name: props.employee.first_name || '',
  middle_name: props.employee.middle_name || '',
  last_name: props.employee.last_name || '',
  suffix: props.employee.suffix || '',
  maiden_name: props.employee.maiden_name || '',
  nickname: props.employee.nickname || '',
  birth_date: props.employee.birth_date || '',
  birth_place: props.employee.birth_place || '',
  gender: props.employee.gender || '',
  civil_status: props.employee.civil_status || '',
  nationality: props.employee.nationality || 'Filipino',
  religion: props.employee.religion || '',
  blood_type: props.employee.blood_type || '',
  height: props.employee.height || '',
  weight: props.employee.weight || '',

  // Government IDs
  sss_number: props.employee.sss_number || '',
  tin: props.employee.tin || '',
  philhealth_number: props.employee.philhealth_number || '',
  pagibig_number: props.employee.pagibig_number || '',
  passport_number: props.employee.passport_number || '',
  drivers_license: props.employee.drivers_license || '',
  voters_id: props.employee.voters_id || '',

  // Contact Information
  email: props.employee.email || '',
  phone: props.employee.phone || '',
  phone_secondary: props.employee.phone_secondary || '',
  emergency_contact_name: props.employee.emergency_contact_name || '',
  emergency_contact_phone: props.employee.emergency_contact_phone || '',
  emergency_contact_relationship: props.employee.emergency_contact_relationship || '',

  // Address
  address_street: props.employee.address_street || '',
  address_barangay: props.employee.address_barangay || '',
  address_city: props.employee.address_city || '',
  address_province: props.employee.address_province || '',
  address_postal_code: props.employee.address_postal_code || '',

  // Employment
  department_id: props.employee.department_id || '',
  position_id: props.employee.position_id || '',
  job_grade_id: props.employee.job_grade_id || '',
  branch_id: props.employee.branch_id || '',
  work_schedule_id: props.employee.work_schedule_id || '',
  employment_status: props.employee.employment_status || '',
  employment_type: props.employee.employment_type || '',
  hire_date: props.employee.hire_date || '',
  supervisor_id: props.employee.supervisor_id || '',

  // Compensation
  basic_salary: props.employee.basic_salary || '',
  daily_rate: props.employee.daily_rate || '',
  hourly_rate: props.employee.hourly_rate || '',
  pay_frequency: props.employee.pay_frequency || '',
  tax_status: props.employee.tax_status || '',
  tax_shield: props.employee.tax_shield || '',
  vacation_leave_balance: props.employee.vacation_leave_balance || '',
  sick_leave_balance: props.employee.sick_leave_balance || '',
  emergency_leave_balance: props.employee.emergency_leave_balance || '',

  // Employment Settings
  is_active: props.employee.is_active !== undefined ? props.employee.is_active : true,
  is_exempt: props.employee.is_exempt || false,
  is_flexible_time: props.employee.is_flexible_time || false,
  is_field_work: props.employee.is_field_work || false,
  is_minimum_wage: props.employee.is_minimum_wage || false,

  // Medical
  medical_conditions: props.employee.medical_conditions || '',
  allergies: props.employee.allergies || '',

  // Additional
  remarks: props.employee.remarks || '',

  // Files
  photo: null,
  documents: null,
})

// Submit form for updating employee
const submitForm = () => {
  console.log('=== EMPLOYEE UPDATE SUBMISSION STARTED ===')
  console.log('Form data before submission:', form.data())

  if (!form.first_name || !form.last_name) {
    console.log('Validation failed: Missing first_name or last_name')
    alert('Please enter First Name and Last Name')
    return
  }

  console.log('Validation passed, submitting to: /spa/employees/' + props.employee.id)

  // Check if files are present for proper form data handling
  const hasFiles = form.photo || (form.documents && form.documents.length > 0)
  console.log('Files detected:', { hasPhoto: !!form.photo, hasDocuments: !!(form.documents && form.documents.length > 0) })

  // Submit to update route
  const submitUrl = `/spa/employees/${props.employee.id}`
  console.log('Submitting to update route:', submitUrl)

  form.put(submitUrl, {
    forceFormData: hasFiles, // Use FormData when files are present
    onStart: () => {
      console.log('Form submission started - onStart triggered')
    },
    onSuccess: (response) => {
      console.log('Form submission SUCCESS:', response)
      alert('Employee updated successfully!')
    },
    onError: (errors) => {
      console.error('Form submission ERROR:', errors)
      console.log('Full error details:', form.errors)
      alert('Error updating employee. Check console for details.')
    },
    onFinish: () => {
      console.log('Form submission finished - onFinish triggered')
    }
  })

  console.log('form.put() called, waiting for response...')
}

// Handle file uploads
const handlePhotoUpload = (event) => {
  form.photo = event.target.files[0]
}

const handleDocumentsUpload = (event) => {
  form.documents = Array.from(event.target.files)
}

// Quick Add Modal functionality
const showModal = ref(false)
const modalType = ref('')
const modalTitle = ref('')
const quickAddForm = ref({
  name: '',
  title: '',
  code: '',
  label: '',
  description: '',
  start_time: '09:00:00',
  end_time: '17:00:00',
  break_duration: 60,
  working_days: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
  address: '',
  city: '',
  state: '',
  postal_code: '',
  country: 'Philippines',
  // Position specific fields
  department_id: '',
  job_grade_id: '',
  type: '',
  level: '',
  authorized_headcount: 1,
  // Job Grade specific fields
  job_level: 1,
  min_salary: 0,
  mid_salary: 0,
  max_salary: 0,
  // Work Schedule specific fields
  schedule_type: '',
  hours_per_day: 8.0,
  hours_per_week: 40.0,
  days_per_week: 5,
  break_duration_minutes: 60,
  is_active: true
})

const showQuickAddModal = (type) => {
  modalType.value = type
  showModal.value = true

  // Reset form
  quickAddForm.value = {
    name: '',
    title: '',
    code: '',
    label: '',
    description: '',
    start_time: '09:00:00',
    end_time: '17:00:00',
    break_duration: 60,
    working_days: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
    address: '',
    city: '',
    state: '',
    postal_code: '',
    country: 'Philippines',
    // Position specific fields
    department_id: '',
    job_grade_id: '',
    type: '',
    level: '',
    authorized_headcount: 1,
    // Job Grade specific fields
    job_level: 1,
    min_salary: 0,
    mid_salary: 0,
    max_salary: 0,
    // Work Schedule specific fields
    schedule_type: '',
    hours_per_day: 8.0,
    hours_per_week: 40.0,
    days_per_week: 5,
    break_duration_minutes: 60,
    is_active: true
  }

  // Set modal title
  const titles = {
    department: 'Add New Department',
    position: 'Add New Position',
    jobGrade: 'Add New Job Grade',
    branch: 'Add New Branch',
    workSchedule: 'Add New Work Schedule',
    employmentStatus: 'Add New Employment Status',
    payFrequency: 'Add New Pay Frequency',
    taxStatus: 'Add New Tax Status'
  }
  modalTitle.value = titles[type] || 'Add New Item'
}

const closeQuickAddModal = () => {
  showModal.value = false
  modalType.value = ''
}

const submitQuickAdd = async () => {
  try {
    const routes = {
      department: '/spa/departments',
      position: '/spa/positions',
      jobGrade: '/spa/job-grades',
      branch: '/spa/company-branches',
      workSchedule: '/spa/work-schedules',
      employmentStatus: '/spa/employment-statuses'
    }

    const route = routes[modalType.value]
    if (!route) return

    // Prepare data based on type - all need company_id (using 1 as default)
    let data = {
      company_id: 1, // Default company ID
      is_active: quickAddForm.value.is_active
    }

    if (modalType.value === 'position') {
      Object.assign(data, {
        title: quickAddForm.value.title || quickAddForm.value.name,
        code: quickAddForm.value.code,
        description: quickAddForm.value.description,
        department_id: quickAddForm.value.department_id,
        job_grade_id: quickAddForm.value.job_grade_id,
        type: quickAddForm.value.type,
        level: quickAddForm.value.level,
        authorized_headcount: quickAddForm.value.authorized_headcount || 1
      })
    } else if (modalType.value === 'workSchedule') {
      // Calculate hours per week based on days per week and hours per day
      const hoursPerWeek = quickAddForm.value.hours_per_day * quickAddForm.value.days_per_week;

      // Create schedule details JSON with basic daily schedule
      const scheduleDetails = {
        daily_schedule: {
          monday: { start_time: quickAddForm.value.start_time, end_time: quickAddForm.value.end_time, is_working_day: true },
          tuesday: { start_time: quickAddForm.value.start_time, end_time: quickAddForm.value.end_time, is_working_day: true },
          wednesday: { start_time: quickAddForm.value.start_time, end_time: quickAddForm.value.end_time, is_working_day: true },
          thursday: { start_time: quickAddForm.value.start_time, end_time: quickAddForm.value.end_time, is_working_day: true },
          friday: { start_time: quickAddForm.value.start_time, end_time: quickAddForm.value.end_time, is_working_day: true },
          saturday: { start_time: '00:00:00', end_time: '00:00:00', is_working_day: false },
          sunday: { start_time: '00:00:00', end_time: '00:00:00', is_working_day: false }
        }
      };

      Object.assign(data, {
        name: quickAddForm.value.name,
        code: quickAddForm.value.code,
        description: quickAddForm.value.description || null,
        type: quickAddForm.value.schedule_type,
        hours_per_day: quickAddForm.value.hours_per_day,
        hours_per_week: hoursPerWeek,
        days_per_week: quickAddForm.value.days_per_week,
        break_duration_minutes: quickAddForm.value.break_duration_minutes,
        schedule_details: scheduleDetails
      })
    } else if (modalType.value === 'branch') {
      Object.assign(data, {
        name: quickAddForm.value.name,
        code: quickAddForm.value.code,
        address: quickAddForm.value.address,
        city: quickAddForm.value.city,
        state: quickAddForm.value.state,
        postal_code: quickAddForm.value.postal_code,
        country: quickAddForm.value.country
      })
    } else if (modalType.value === 'jobGrade') {
      Object.assign(data, {
        name: quickAddForm.value.name,
        code: quickAddForm.value.code,
        description: quickAddForm.value.description,
        level: quickAddForm.value.job_level,
        min_salary: quickAddForm.value.min_salary,
        mid_salary: quickAddForm.value.mid_salary || null,
        max_salary: quickAddForm.value.max_salary
      })
    } else if (modalType.value === 'employmentStatus') {
      // For employmentStatus - doesn't use company_id
      Object.assign(data, {
        name: quickAddForm.value.name,
        code: quickAddForm.value.code,
        color: '#6B7280' // Default gray color
      })
      // Remove company_id for employment status as it doesn't have this field
      delete data.company_id
    } else if (modalType.value === 'payFrequency') {
      // Handle Pay Frequency - client-side only, add to reactive array
      if (quickAddForm.value.name && !payFrequencies.value.includes(quickAddForm.value.name)) {
        payFrequencies.value.push(quickAddForm.value.name)
        form.pay_frequency = quickAddForm.value.name
        closeQuickAddModal()
        alert('Pay Frequency added successfully!')
        return
      } else {
        alert('Pay Frequency already exists or invalid name!')
        return
      }
    } else if (modalType.value === 'taxStatus') {
      // Handle Tax Status - client-side only, add to reactive array
      if (quickAddForm.value.label && quickAddForm.value.code) {
        const exists = taxStatuses.value.some(status => status.value === quickAddForm.value.code)
        if (!exists) {
          taxStatuses.value.push({
            value: quickAddForm.value.code,
            label: quickAddForm.value.label
          })
          form.tax_status = quickAddForm.value.code
          closeQuickAddModal()
          alert('Tax Status added successfully!')
          return
        } else {
          alert('Tax Status code already exists!')
          return
        }
      } else {
        alert('Please fill all required fields!')
        return
      }
    } else {
      // For department
      Object.assign(data, {
        name: quickAddForm.value.name,
        code: quickAddForm.value.code
      })
    }

    // Submit via Inertia
    const response = await fetch(route, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        'X-Requested-With': 'XMLHttpRequest'
      },
      body: JSON.stringify(data)
    })

    if (response.ok) {
      const result = await response.json()

      // Refresh the page to get updated data
      window.location.reload()
    } else {
      console.error('Failed to create item')
      alert('Failed to create item. Please try again.')
    }
  } catch (error) {
    console.error('Error creating item:', error)
    alert('Error creating item. Please try again.')
  }
}

// Input masking functions for Philippine formats
const formatPhoneNumber = (event, fieldName) => {
  let value = event.target.value.replace(/\D/g, '') // Remove non-digits

  // Philippine mobile format: 0917-123-4567
  if (value.length > 0) {
    if (value.length <= 4) {
      value = value
    } else if (value.length <= 7) {
      value = value.substring(0, 4) + '-' + value.substring(4)
    } else {
      value = value.substring(0, 4) + '-' + value.substring(4, 7) + '-' + value.substring(7, 11)
    }
  }

  if (form && form[fieldName] !== undefined) {
    form[fieldName] = value
  }
}

const formatSSS = (event) => {
  let value = event.target.value.replace(/\D/g, '') // Remove non-digits

  // SSS format: 12-3456789-0
  if (value.length > 0) {
    if (value.length <= 2) {
      value = value
    } else if (value.length <= 9) {
      value = value.substring(0, 2) + '-' + value.substring(2)
    } else {
      value = value.substring(0, 2) + '-' + value.substring(2, 9) + '-' + value.substring(9, 10)
    }
  }

  if (form && form.sss_number !== undefined) {
    form.sss_number = value
  }
}

const formatTIN = (event) => {
  let value = event.target.value.replace(/\D/g, '') // Remove non-digits

  // TIN format: 123-456-789-000
  if (value.length > 0) {
    if (value.length <= 3) {
      value = value
    } else if (value.length <= 6) {
      value = value.substring(0, 3) + '-' + value.substring(3)
    } else if (value.length <= 9) {
      value = value.substring(0, 3) + '-' + value.substring(3, 6) + '-' + value.substring(6)
    } else {
      value = value.substring(0, 3) + '-' + value.substring(3, 6) + '-' + value.substring(6, 9) + '-' + value.substring(9, 12)
    }
  }

  if (form && form.tin !== undefined) {
    form.tin = value
  }
}

const formatPhilHealth = (event) => {
  let value = event.target.value.replace(/\D/g, '') // Remove non-digits

  // PhilHealth format: 12-345678901-2
  if (value.length > 0) {
    if (value.length <= 2) {
      value = value
    } else if (value.length <= 11) {
      value = value.substring(0, 2) + '-' + value.substring(2)
    } else {
      value = value.substring(0, 2) + '-' + value.substring(2, 11) + '-' + value.substring(11, 12)
    }
  }

  if (form && form.philhealth_number !== undefined) {
    form.philhealth_number = value
  }
}

const formatPagIbig = (event) => {
  let value = event.target.value.replace(/\D/g, '') // Remove non-digits

  // Pag-IBIG format: 1234-5678-9012
  if (value.length > 0) {
    if (value.length <= 4) {
      value = value
    } else if (value.length <= 8) {
      value = value.substring(0, 4) + '-' + value.substring(4)
    } else {
      value = value.substring(0, 4) + '-' + value.substring(4, 8) + '-' + value.substring(8, 12)
    }
  }

  if (form && form.pagibig_number !== undefined) {
    form.pagibig_number = value
  }
}
</script>