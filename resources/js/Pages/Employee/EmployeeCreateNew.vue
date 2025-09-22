<template>
  <AppLayout>
    <div class="container mx-auto py-8">
      <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-8">
          <h1 class="text-3xl font-bold text-gray-900">Create New Employee - Full Profile</h1>
          <button type="button" @click="autofillForm" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2">
            <i class="fas fa-magic"></i>
            Autofill Test Data
          </button>
        </div>

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
                  <select v-model="form.employment_status_id" class="form-select flex-1">
                    <option value="">Select Status</option>
                    <option v-for="status in employmentStatuses" :key="status.id" :value="status.id">
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
                <div class="flex gap-2">
                  <select v-model="form.employment_type" class="form-select flex-1">
                    <option value="">Select Type</option>
                    <option v-for="type in employmentTypes" :key="type.value" :value="type.value">
                      {{ type.label }}
                    </option>
                  </select>
                  <button type="button" @click="showQuickAddModal('employmentType')" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-lg text-sm font-medium whitespace-nowrap" title="Add New Employment Type">
                    <i class="fas fa-plus"></i>
                  </button>
                </div>
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
                <div v-if="photoPreview" class="mt-2">
                  <img :src="photoPreview" alt="Photo Preview" class="w-32 h-32 object-cover rounded border">
                </div>
              </div>
              <div class="form-group">
                <label class="form-label">Documents</label>
                <input @change="handleDocumentsUpload" type="file" multiple accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" class="form-input">
                <p class="text-sm text-gray-500 mt-1">Accepted formats: PDF, DOC, DOCX, JPG, PNG (Max: 10MB each)</p>
                <div v-if="documentsInfo.length > 0" class="mt-2">
                  <p class="text-sm text-gray-600">{{ documentsInfo.length }} document(s) selected</p>
                  <ul class="text-xs text-gray-500">
                    <li v-for="(doc, index) in documentsInfo" :key="index">{{ doc.name }}</li>
                  </ul>
                </div>
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
              <span v-if="form.processing">Creating Employee...</span>
              <span v-else>Create Employee</span>
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

            <!-- Other modals common fields -->
            <div v-if="modalType !== 'payFrequency' && modalType !== 'taxStatus'">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
                <input v-model="quickAddForm.name" type="text" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter name">
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Code *</label>
                <input v-model="quickAddForm.code" type="text" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter code">
              </div>
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
import { ref, onMounted } from 'vue'
import AppLayout from '../../Layouts/AppLayout.vue'

// Props
const props = defineProps({
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

// Employment Types (loaded dynamically from API)
const employmentTypes = ref([
  { value: 'Full-time', label: 'Full-time' },
  { value: 'Part-time', label: 'Part-time' },
  { value: 'Contract', label: 'Contract' },
  { value: 'Temporary', label: 'Temporary' },
  { value: 'Intern', label: 'Intern' },
  { value: 'Casual', label: 'Casual' }
])

// File handling refs
const photoPreview = ref(null)
const documentsInfo = ref([])

// Form with all comprehensive fields - using working pattern
const form = useForm({
  // Identification
  employee_id: '',
  badge_number: '',
  biometric_id: '',

  // Personal Information
  first_name: '',
  middle_name: '',
  last_name: '',
  suffix: '',
  maiden_name: '',
  nickname: '',
  birth_date: '',
  birth_place: '',
  gender: '',
  civil_status: '',
  nationality: 'Filipino',
  religion: '',
  blood_type: '',
  height: '',
  weight: '',

  // Government IDs
  sss_number: '',
  tin: '',
  philhealth_number: '',
  pagibig_number: '',
  passport_number: '',
  drivers_license: '',
  voters_id: '',

  // Contact Information
  email: '',
  phone: '',
  phone_secondary: '',
  emergency_contact_name: '',
  emergency_contact_phone: '',
  emergency_contact_relationship: '',

  // Address
  address_street: '',
  address_barangay: '',
  address_city: '',
  address_province: '',
  address_postal_code: '',

  // Employment
  department_id: '',
  position_id: '',
  job_grade_id: '',
  branch_id: '',
  work_schedule_id: '',
  employment_status_id: '',
  employment_type: '',
  hire_date: '',
  supervisor_id: '',

  // Compensation
  basic_salary: '',
  daily_rate: '',
  hourly_rate: '',
  pay_frequency: '',
  tax_status: '',
  tax_shield: '',
  vacation_leave_balance: '',
  sick_leave_balance: '',
  emergency_leave_balance: '',

  // Employment Settings
  is_active: true,
  is_exempt: false,
  is_flexible_time: false,
  is_field_work: false,
  is_minimum_wage: false,

  // Medical
  medical_conditions: '',
  allergies: '',

  // Additional
  remarks: '',

  // Files
  photo: null,
  documents: null,
})

// Submit form using the PROVEN WORKING approach - exactly like EmployeeTestMinimal.vue
const submitForm = () => {
  // Validate required fields
  if (!form.first_name || !form.last_name) {
    alert('Please fill in all required fields: First Name and Last Name');
    return;
  }

  console.log('Submitting comprehensive employee form...', form.data());

  // Submit using Inertia with proper error handling - EXACT SAME PATTERN as working minimal form
  form.post('/spa/employees', {
    onBefore: () => {
      console.log('Form submission started...');
    },
    onSuccess: () => {
      alert('Employee created successfully!');
      window.location.href = '/spa/employees';
    },
    onError: (errors) => {
      console.error('Validation errors:', errors);
      alert('Please check the form for errors: ' + JSON.stringify(errors));
    },
    onFinish: () => {
      console.log('Form submission completed');
    }
  });
}

// Handle file uploads
const handlePhotoUpload = (event) => {
  const file = event.target.files[0]
  if (file) {
    form.photo = file
    // Create preview
    const reader = new FileReader()
    reader.onload = (e) => {
      photoPreview.value = e.target.result
    }
    reader.readAsDataURL(file)
  }
}

const handleDocumentsUpload = (event) => {
  const files = Array.from(event.target.files)
  form.documents = files
  documentsInfo.value = files.map(file => ({ name: file.name, size: file.size }))
}

// Quick Add Modal functionality - simplified working version
const showModal = ref(false)
const modalType = ref('')
const modalTitle = ref('')
const quickAddForm = ref({
  name: '',
  code: '',
  label: ''
})

const showQuickAddModal = (type) => {
  modalType.value = type
  showModal.value = true
  quickAddForm.value = { name: '', code: '', label: '' }

  const titles = {
    department: 'Add New Department',
    position: 'Add New Position',
    jobGrade: 'Add New Job Grade',
    branch: 'Add New Branch',
    workSchedule: 'Add New Work Schedule',
    employmentStatus: 'Add New Employment Status',
    employmentType: 'Add New Employment Type',
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
    // Handle Pay Frequency - client-side only
    if (modalType.value === 'payFrequency') {
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
    }

    // Handle Tax Status - client-side only
    if (modalType.value === 'taxStatus') {
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
    }

    // Handle database-backed entities
    const routes = {
      department: '/spa/departments',
      position: '/spa/positions',
      jobGrade: '/spa/job-grades',
      branch: '/spa/company-branches',
      workSchedule: '/spa/work-schedules',
      employmentStatus: '/spa/employment-statuses',
      employmentType: '/api/employment-types'
    }

    const route = routes[modalType.value]
    if (!route) return

    const data = {
      name: quickAddForm.value.name,
      code: quickAddForm.value.code,
      company_id: 1,
      is_active: true
    }

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
      if (result.success && result.item) {
        // Add the new item to the appropriate array and auto-select it
        if (modalType.value === 'department') {
          props.departments.push(result.item)
          form.department_id = result.item.id
        } else if (modalType.value === 'position') {
          props.positions.push(result.item)
          form.position_id = result.item.id
        } else if (modalType.value === 'jobGrade') {
          props.jobGrades.push(result.item)
          form.job_grade_id = result.item.id
        } else if (modalType.value === 'branch') {
          props.branches.push(result.item)
          form.branch_id = result.item.id
        } else if (modalType.value === 'workSchedule') {
          props.workSchedules.push(result.item)
          form.work_schedule_id = result.item.id
        } else if (modalType.value === 'employmentStatus') {
          props.employmentStatuses.push(result.item)
          form.employment_status_id = result.item.id
        } else if (modalType.value === 'employmentType') {
          employmentTypes.value.push(result.item)
          form.employment_type = result.item.value
        }

        closeQuickAddModal()
        alert(result.message || 'Item created successfully!')
      } else {
        alert('Failed to create item. Please try again.')
      }
    } else {
      const errorResult = await response.json().catch(() => ({}))
      alert(errorResult.message || 'Failed to create item. Please try again.')
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

// Autofill function for easy testing with random unique values
const autofillForm = () => {
  // Generate random unique values
  const timestamp = Date.now()
  const randomNum = Math.floor(Math.random() * 9999) + 1000
  const randomId = Math.floor(Math.random() * 999999) + 100000

  // Random names arrays
  const firstNames = ['Juan', 'Maria', 'Jose', 'Ana', 'Carlos', 'Isabel', 'Miguel', 'Carmen', 'Antonio', 'Rosa', 'Pedro', 'Sofia', 'Luis', 'Elena', 'Rafael', 'Luz']
  const middleNames = ['Santos', 'Garcia', 'Cruz', 'Torres', 'Reyes', 'Flores', 'Ramos', 'Gutierrez', 'Ortiz', 'Morales', 'Jimenez', 'Herrera']
  const lastNames = ['Dela Cruz', 'Rodriguez', 'Gonzalez', 'Martinez', 'Lopez', 'Perez', 'Sanchez', 'Ramirez', 'Rivera', 'Gomez', 'Fernandez', 'Moreno']
  const suffixes = ['Jr.', 'Sr.', 'III', 'IV', '']
  const genders = ['Male', 'Female']
  const civilStatuses = ['Single', 'Married', 'Divorced', 'Widowed']
  const bloodTypes = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']
  const religions = ['Catholic', 'Protestant', 'Islam', 'Buddhism', 'INC', 'Born Again', 'Seventh Day Adventist']
  const employmentTypes = ['Full-time', 'Part-time', 'Contract', 'Temporary']
  const relationships = ['Spouse', 'Parent', 'Sibling', 'Child', 'Guardian', 'Friend']

  // Random selection helper
  const randomChoice = (array) => array[Math.floor(Math.random() * array.length)]

  // Generate random birth date (between 1970-2000)
  const randomYear = Math.floor(Math.random() * 30) + 1970
  const randomMonth = Math.floor(Math.random() * 12) + 1
  const randomDay = Math.floor(Math.random() * 28) + 1
  const birthDate = `${randomYear}-${randomMonth.toString().padStart(2, '0')}-${randomDay.toString().padStart(2, '0')}`

  // Generate random hire date (within last 2 years)
  const hireYear = Math.floor(Math.random() * 2) + 2023
  const hireMonth = Math.floor(Math.random() * 12) + 1
  const hireDay = Math.floor(Math.random() * 28) + 1
  const hireDate = `${hireYear}-${hireMonth.toString().padStart(2, '0')}-${hireDay.toString().padStart(2, '0')}`

  // Random selections
  const firstName = randomChoice(firstNames)
  const middleName = randomChoice(middleNames)
  const lastName = randomChoice(lastNames)
  const suffix = randomChoice(suffixes)
  const gender = randomChoice(genders)
  const civilStatus = randomChoice(civilStatuses)
  const bloodType = randomChoice(bloodTypes)
  const religion = randomChoice(religions)
  const employmentType = randomChoice(employmentTypes)
  const relationship = randomChoice(relationships)

  // Employee Identification - UNIQUE VALUES
  form.employee_id = `EMP-${timestamp.toString().slice(-6)}`
  form.badge_number = `BADGE-${randomNum}`
  form.biometric_id = `BIO-${randomId}`

  // Personal Information
  form.first_name = firstName
  form.middle_name = middleName
  form.last_name = lastName
  form.suffix = suffix
  form.maiden_name = suffix === '' ? randomChoice(lastNames) : ''
  form.nickname = firstName.substring(0, 3) + randomNum.toString().slice(-2)
  form.birth_date = birthDate
  form.birth_place = randomChoice(['Manila', 'Quezon City', 'Cebu City', 'Davao City', 'Makati', 'Pasig', 'Taguig']) + ', Philippines'
  form.gender = gender
  form.civil_status = civilStatus
  form.nationality = 'Filipino'
  form.religion = religion
  form.blood_type = bloodType
  form.height = (Math.floor(Math.random() * 40) + 150).toString() // 150-190 cm
  form.weight = (Math.floor(Math.random() * 50) + 50).toString()  // 50-100 kg

  // Government IDs - UNIQUE VALUES
  const sssRandom = Math.floor(Math.random() * 9999999) + 1000000
  const tinRandom1 = Math.floor(Math.random() * 999) + 100
  const tinRandom2 = Math.floor(Math.random() * 999) + 100
  const tinRandom3 = Math.floor(Math.random() * 999) + 100
  const tinRandom4 = Math.floor(Math.random() * 999) + 100
  const philHealthRandom = Math.floor(Math.random() * 99999999999) + 10000000000
  const pagibigRandom = Math.floor(Math.random() * 999999999999) + 100000000000

  form.sss_number = `${sssRandom.toString().substring(0,2)}-${sssRandom.toString().substring(2,9)}-${Math.floor(Math.random() * 9)}`
  form.tin = `${tinRandom1}-${tinRandom2}-${tinRandom3}-${tinRandom4.toString().substring(0,3)}`
  form.philhealth_number = `${philHealthRandom.toString().substring(0,2)}-${philHealthRandom.toString().substring(2,13)}-${Math.floor(Math.random() * 9)}`
  form.pagibig_number = `${pagibigRandom.toString().substring(0,4)}-${pagibigRandom.toString().substring(4,8)}-${pagibigRandom.toString().substring(8,12)}`
  form.passport_number = `P${Math.floor(Math.random() * 9999999) + 1000000}`
  form.drivers_license = `${String.fromCharCode(65 + Math.floor(Math.random() * 26))}${Math.floor(Math.random() * 99) + 10}-${Math.floor(Math.random() * 99) + 10}-${Math.floor(Math.random() * 999999) + 100000}`
  form.voters_id = `VID-${Math.floor(Math.random() * 99999999) + 10000000}`

  // Contact Information - UNIQUE EMAIL
  const emailDomains = ['gmail.com', 'yahoo.com', 'hotmail.com', 'outlook.com', 'email.com']
  form.email = `${firstName.toLowerCase()}.${lastName.toLowerCase().replace(' ', '')}${randomNum}@${randomChoice(emailDomains)}`
  form.phone = `09${Math.floor(Math.random() * 9) + 1}${Math.floor(Math.random() * 9)}${Math.floor(Math.random() * 99999999).toString().padStart(7, '0')}`
  form.phone_secondary = `09${Math.floor(Math.random() * 9) + 1}${Math.floor(Math.random() * 9)}${Math.floor(Math.random() * 99999999).toString().padStart(7, '0')}`
  form.emergency_contact_name = `${randomChoice(firstNames)} ${randomChoice(lastNames)}`
  form.emergency_contact_phone = `09${Math.floor(Math.random() * 9) + 1}${Math.floor(Math.random() * 9)}${Math.floor(Math.random() * 99999999).toString().padStart(7, '0')}`
  form.emergency_contact_relationship = relationship

  // Address
  const streets = ['Rizal Street', 'Bonifacio Ave', 'Mabini St', 'Del Pilar St', 'Quezon Ave', 'EDSA', 'Taft Ave', 'Ortigas Ave']
  const barangays = ['Barangay San Miguel', 'Barangay Santa Cruz', 'Barangay San Antonio', 'Barangay San Jose', 'Barangay Poblacion']
  const cities = ['Manila', 'Quezon City', 'Makati', 'Pasig', 'Taguig', 'Mandaluyong', 'San Juan', 'Marikina']

  form.address_street = `${Math.floor(Math.random() * 999) + 1} ${randomChoice(streets)}`
  form.address_barangay = randomChoice(barangays)
  form.address_city = randomChoice(cities)
  form.address_province = 'Metro Manila'
  form.address_postal_code = (Math.floor(Math.random() * 9000) + 1000).toString()

  // Employment Information (using random available options)
  if (props.departments && props.departments.length > 0) {
    const randomIndex = Math.floor(Math.random() * props.departments.length)
    form.department_id = props.departments[randomIndex].id
  }
  if (props.positions && props.positions.length > 0) {
    const randomIndex = Math.floor(Math.random() * props.positions.length)
    form.position_id = props.positions[randomIndex].id
  }
  if (props.jobGrades && props.jobGrades.length > 0) {
    const randomIndex = Math.floor(Math.random() * props.jobGrades.length)
    form.job_grade_id = props.jobGrades[randomIndex].id
  }
  if (props.branches && props.branches.length > 0) {
    const randomIndex = Math.floor(Math.random() * props.branches.length)
    form.branch_id = props.branches[randomIndex].id
  }
  if (props.workSchedules && props.workSchedules.length > 0) {
    const randomIndex = Math.floor(Math.random() * props.workSchedules.length)
    form.work_schedule_id = props.workSchedules[randomIndex].id
  }
  if (props.employmentStatuses && props.employmentStatuses.length > 0) {
    const randomIndex = Math.floor(Math.random() * props.employmentStatuses.length)
    form.employment_status_id = props.employmentStatuses[randomIndex].id
  }
  form.employment_type = employmentType
  form.hire_date = hireDate

  // Compensation - Random but realistic values
  const baseSalary = (Math.floor(Math.random() * 80000) + 20000) // 20k-100k
  const dailyRate = (baseSalary / 21.75).toFixed(2) // Assuming 21.75 working days per month
  const hourlyRate = (baseSalary / 174).toFixed(2)  // Assuming 174 working hours per month

  form.basic_salary = baseSalary.toString()
  form.daily_rate = dailyRate
  form.hourly_rate = hourlyRate
  form.pay_frequency = randomChoice(['Daily', 'Weekly', 'Bi-weekly', 'Semi-monthly', 'Monthly'])
  form.tax_status = randomChoice(['S', 'ME', 'S1', 'ME1', 'S2', 'ME2'])
  form.tax_shield = (Math.floor(Math.random() * 5000)).toString()
  form.vacation_leave_balance = (Math.floor(Math.random() * 20) + 5).toString()
  form.sick_leave_balance = (Math.floor(Math.random() * 20) + 5).toString()
  form.emergency_leave_balance = (Math.floor(Math.random() * 10) + 1).toString()

  // Employment Settings - Random
  form.is_active = true
  form.is_exempt = Math.random() > 0.8
  form.is_flexible_time = Math.random() > 0.7
  form.is_field_work = Math.random() > 0.8
  form.is_minimum_wage = Math.random() > 0.9

  // Medical Information
  const conditions = ['None', 'Hypertension', 'Diabetes', 'Asthma', 'None known']
  const allergies = ['None known', 'Peanuts', 'Shellfish', 'Dust', 'Pollen', 'None']
  form.medical_conditions = randomChoice(conditions)
  form.allergies = randomChoice(allergies)

  // Additional Information
  form.remarks = `Random test employee data generated on ${new Date().toLocaleString()} for system testing purposes.`

  console.log(`Form autofilled with unique random test data! Employee ID: ${form.employee_id}, Email: ${form.email}`)
}

// Load employment types from API on component mount
onMounted(async () => {
  try {
    const response = await fetch('/api/employment-types')
    if (response.ok) {
      const types = await response.json()
      employmentTypes.value = types
    }
  } catch (error) {
    console.error('Error loading employment types:', error)
    // Keep default values if API fails
  }
})
</script>