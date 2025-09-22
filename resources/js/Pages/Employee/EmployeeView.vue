<template>
  <AppLayout>
    <div class="container mx-auto py-8">
      <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
          <div class="flex items-center space-x-4">
            <Link href="/spa/employees" class="text-blue-600 hover:text-blue-800">
              <i class="fas fa-arrow-left mr-2"></i>Back to Employees
            </Link>
            <div>
              <h1 class="text-3xl font-bold text-gray-900">{{ fullName }}</h1>
              <div class="flex items-center space-x-4 mt-2">
                <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                  {{ employee.employee_id }}
                </span>
                <span :class="statusClass" class="px-3 py-1 rounded-full text-sm font-medium">
                  {{ employee.employment_status?.name || 'No Status' }}
                </span>
                <span class="text-gray-600">{{ employee.department?.name || 'No Department' }}</span>
              </div>
            </div>
          </div>
          <div class="flex space-x-3">
            <Link :href="`/spa/employees/${employee.id}/edit`" class="btn btn-primary">
              <i class="fas fa-edit mr-2"></i>Edit Employee
            </Link>
            <button @click="showDocumentModal = true" class="btn btn-secondary">
              <i class="fas fa-file-upload mr-2"></i>Upload Document
            </button>
          </div>
        </div>

        <!-- Navigation Tabs -->
        <div class="bg-white shadow rounded-lg mb-6">
          <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8 px-6">
              <button @click="activeTab = 'overview'"
                      :class="tabClass('overview')"
                      class="py-4 px-1 border-b-2 font-medium text-sm">
                <i class="fas fa-user mr-2"></i>Overview
              </button>
              <button @click="activeTab = 'documents'"
                      :class="tabClass('documents')"
                      class="py-4 px-1 border-b-2 font-medium text-sm">
                <i class="fas fa-folder mr-2"></i>Documents
                <span v-if="documents.length > 0" class="ml-1 bg-blue-500 text-white rounded-full px-2 py-1 text-xs">
                  {{ documents.length }}
                </span>
              </button>
              <button @click="activeTab = 'timeline'"
                      :class="tabClass('timeline')"
                      class="py-4 px-1 border-b-2 font-medium text-sm">
                <i class="fas fa-history mr-2"></i>Timeline
              </button>
            </nav>
          </div>
        </div>

        <!-- Tab Content -->
        <div class="bg-white shadow rounded-lg">
          <!-- Overview Tab -->
          <div v-if="activeTab === 'overview'" class="p-6">
            <!-- Employee Photo and Basic Info -->
            <div class="flex items-start space-x-8 mb-8">
              <div class="flex-shrink-0">
                <div v-if="employee.photo" class="w-32 h-32 rounded-lg overflow-hidden shadow-lg">
                  <img :src="employee.photo" :alt="fullName" class="w-full h-full object-cover">
                </div>
                <div v-else class="w-32 h-32 bg-gray-200 rounded-lg flex items-center justify-center shadow-lg">
                  <i class="fas fa-user text-4xl text-gray-400"></i>
                </div>
              </div>

              <div class="flex-1 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                  <h3 class="text-lg font-semibold text-gray-900 mb-4">Basic Information</h3>
                  <div class="space-y-3">
                    <div>
                      <span class="text-sm font-medium text-gray-500">Full Name</span>
                      <p class="text-gray-900">{{ fullName }}</p>
                    </div>
                    <div v-if="employee.nickname">
                      <span class="text-sm font-medium text-gray-500">Nickname</span>
                      <p class="text-gray-900">{{ employee.nickname }}</p>
                    </div>
                    <div>
                      <span class="text-sm font-medium text-gray-500">Employee ID</span>
                      <p class="text-gray-900">{{ employee.employee_id }}</p>
                    </div>
                    <div v-if="employee.badge_number">
                      <span class="text-sm font-medium text-gray-500">Badge Number</span>
                      <p class="text-gray-900">{{ employee.badge_number }}</p>
                    </div>
                  </div>
                </div>

                <div>
                  <h3 class="text-lg font-semibold text-gray-900 mb-4">Contact Information</h3>
                  <div class="space-y-3">
                    <div v-if="employee.email">
                      <span class="text-sm font-medium text-gray-500">Email</span>
                      <p class="text-gray-900">{{ employee.email }}</p>
                    </div>
                    <div v-if="employee.phone">
                      <span class="text-sm font-medium text-gray-500">Phone</span>
                      <p class="text-gray-900">{{ employee.phone }}</p>
                    </div>
                    <div v-if="employee.phone_secondary">
                      <span class="text-sm font-medium text-gray-500">Secondary Phone</span>
                      <p class="text-gray-900">{{ employee.phone_secondary }}</p>
                    </div>
                  </div>
                </div>

                <div>
                  <h3 class="text-lg font-semibold text-gray-900 mb-4">Employment Details</h3>
                  <div class="space-y-3">
                    <div>
                      <span class="text-sm font-medium text-gray-500">Department</span>
                      <p class="text-gray-900">{{ employee.department?.name || 'Not assigned' }}</p>
                    </div>
                    <div>
                      <span class="text-sm font-medium text-gray-500">Position</span>
                      <p class="text-gray-900">{{ employee.position?.name || 'Not assigned' }}</p>
                    </div>
                    <div>
                      <span class="text-sm font-medium text-gray-500">Hire Date</span>
                      <p class="text-gray-900">{{ formatDate(employee.hire_date) }}</p>
                    </div>
                    <div v-if="employee.basic_salary">
                      <span class="text-sm font-medium text-gray-500">Basic Salary</span>
                      <p class="text-gray-900">₱{{ formatCurrency(employee.basic_salary) }}</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Emergency Contacts -->
            <div v-if="employee.emergency_contacts && employee.emergency_contacts.length > 0" class="mb-8">
              <h3 class="text-lg font-semibold text-gray-900 mb-4">Emergency Contacts</h3>
              <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div v-for="(contact, index) in employee.emergency_contacts" :key="index"
                     class="border border-gray-200 rounded-lg p-4">
                  <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0">
                      <i class="fas fa-user-shield text-green-600"></i>
                    </div>
                    <div>
                      <h4 class="font-medium text-gray-900">{{ contact.name }}</h4>
                      <p class="text-sm text-gray-600">{{ contact.relationship }}</p>
                      <p class="text-sm text-gray-600">{{ contact.phone }}</p>
                      <p v-if="contact.email" class="text-sm text-gray-600">{{ contact.email }}</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Document Alerts -->
            <div v-if="expiredDocuments.length > 0 || expiringDocuments.length > 0" class="mb-8">
              <h3 class="text-lg font-semibold text-gray-900 mb-4">Document Alerts</h3>

              <!-- Expired Documents -->
              <div v-if="expiredDocuments.length > 0" class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
                <div class="flex items-center">
                  <i class="fas fa-exclamation-triangle text-red-600 mr-3"></i>
                  <h4 class="font-medium text-red-800">Expired Documents ({{ expiredDocuments.length }})</h4>
                </div>
                <ul class="mt-2 list-disc list-inside text-sm text-red-700">
                  <li v-for="doc in expiredDocuments" :key="doc.id">
                    {{ doc.document_name }} (Expired {{ formatDate(doc.expiry_date) }})
                  </li>
                </ul>
              </div>

              <!-- Expiring Documents -->
              <div v-if="expiringDocuments.length > 0" class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <div class="flex items-center">
                  <i class="fas fa-clock text-yellow-600 mr-3"></i>
                  <h4 class="font-medium text-yellow-800">Expiring Soon ({{ expiringDocuments.length }})</h4>
                </div>
                <ul class="mt-2 list-disc list-inside text-sm text-yellow-700">
                  <li v-for="doc in expiringDocuments" :key="doc.id">
                    {{ doc.document_name }} (Expires {{ formatDate(doc.expiry_date) }})
                  </li>
                </ul>
              </div>
            </div>
          </div>

          <!-- Documents Tab -->
          <div v-if="activeTab === 'documents'" class="p-6">
            <div class="flex justify-between items-center mb-6">
              <h3 class="text-lg font-semibold text-gray-900">Employee Documents</h3>
              <button @click="showDocumentModal = true" class="btn btn-primary">
                <i class="fas fa-plus mr-2"></i>Upload Document
              </button>
            </div>

            <!-- Documents List -->
            <div v-if="documents.length > 0" class="space-y-4">
              <div v-for="document in documents" :key="document.id"
                   class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                  <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0">
                      <i class="fas fa-file-alt text-blue-600 text-xl"></i>
                    </div>
                    <div>
                      <h4 class="font-medium text-gray-900">{{ document.document_name }}</h4>
                      <div class="text-sm text-gray-600 space-x-4">
                        <span class="inline-block bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs">
                          {{ getDocumentTypeLabel(document.document_type) }}
                        </span>
                        <span>{{ formatFileSize(document.file_size) }}</span>
                        <span v-if="document.expiry_date">
                          Expires: {{ formatDate(document.expiry_date) }}
                        </span>
                        <span v-if="document.is_verified" class="text-green-600">
                          <i class="fas fa-check-circle mr-1"></i>Verified
                        </span>
                      </div>
                      <p v-if="document.notes" class="text-sm text-gray-500 mt-1">{{ document.notes }}</p>
                    </div>
                  </div>
                  <div class="flex items-center space-x-2">
                    <a :href="`/api/employee-documents/${document.id}/download`"
                       class="text-blue-600 hover:text-blue-800 p-2"
                       title="Download">
                      <i class="fas fa-download"></i>
                    </a>
                    <button @click="verifyDocument(document)"
                            class="text-green-600 hover:text-green-800 p-2"
                            title="Verify">
                      <i class="fas fa-check"></i>
                    </button>
                    <button @click="deleteDocument(document)"
                            class="text-red-600 hover:text-red-800 p-2"
                            title="Delete">
                      <i class="fas fa-trash"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Empty State -->
            <div v-else class="text-center py-12 text-gray-500">
              <i class="fas fa-folder-open text-4xl mb-4"></i>
              <p class="text-lg">No documents uploaded yet</p>
              <p class="text-sm">Upload documents to get started</p>
            </div>
          </div>

          <!-- Timeline Tab -->
          <div v-if="activeTab === 'timeline'" class="p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Employee Timeline</h3>

            <!-- Timeline Loading -->
            <div v-if="timelineLoading" class="text-center py-12">
              <i class="fas fa-spinner fa-spin text-4xl text-blue-500 mb-4"></i>
              <p class="text-lg text-gray-600">Loading timeline...</p>
            </div>

            <!-- Timeline Content -->
            <div v-else-if="timeline.length > 0" class="relative">
              <!-- Timeline Line -->
              <div class="absolute left-6 top-0 bottom-0 w-0.5 bg-gray-200"></div>

              <!-- Timeline Items -->
              <div class="space-y-6">
                <div v-for="(item, index) in timeline" :key="index" class="relative flex items-start">
                  <!-- Timeline Dot -->
                  <div :class="getTimelineIconClass(item)" class="relative z-10 flex items-center justify-center w-12 h-12 rounded-full border-4 border-white shadow-lg">
                    <i :class="`fas fa-${item.action_icon} text-white`"></i>
                  </div>

                  <!-- Timeline Content -->
                  <div class="ml-6 flex-1 bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                    <div class="flex items-center justify-between mb-2">
                      <h4 class="text-sm font-medium text-gray-900">{{ item.description }}</h4>
                      <span class="text-xs text-gray-500">{{ formatTimelineDate(item.date) }}</span>
                    </div>

                    <div class="flex items-center text-sm text-gray-600 mb-2">
                      <i class="fas fa-user mr-2"></i>
                      <span>{{ item.user }}</span>
                      <span v-if="item.ip_address" class="ml-4">
                        <i class="fas fa-globe mr-1"></i>
                        {{ item.ip_address }}
                      </span>
                    </div>

                    <!-- Changes Details -->
                    <div v-if="item.changes" class="mt-3 p-3 bg-gray-50 rounded-md">
                      <h5 class="text-xs font-medium text-gray-700 mb-2">Changes Made:</h5>
                      <div v-html="item.changes" class="text-sm"></div>
                    </div>

                    <!-- User Agent (collapsible) -->
                    <div v-if="item.user_agent" class="mt-2">
                      <button @click="toggleUserAgent(index)" class="text-xs text-blue-600 hover:text-blue-800">
                        <i :class="showUserAgent[index] ? 'fas fa-chevron-up' : 'fas fa-chevron-down'" class="mr-1"></i>
                        {{ showUserAgent[index] ? 'Hide' : 'Show' }} Browser Details
                      </button>
                      <div v-if="showUserAgent[index]" class="mt-2 p-2 bg-gray-100 rounded text-xs text-gray-600 break-all">
                        {{ item.user_agent }}
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Empty Timeline -->
            <div v-else class="text-center py-12 text-gray-500">
              <i class="fas fa-history text-4xl mb-4"></i>
              <p class="text-lg">No timeline data available</p>
              <p class="text-sm">Employee activity will appear here</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref, computed, watch } from 'vue'
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

const statusClass = computed(() => {
  const status = props.employee.employment_status?.name?.toLowerCase()
  if (status?.includes('active') || status?.includes('regular')) {
    return 'bg-green-100 text-green-800'
  } else if (status?.includes('probation')) {
    return 'bg-yellow-100 text-yellow-800'
  } else if (status?.includes('terminated') || status?.includes('resigned')) {
    return 'bg-red-100 text-red-800'
  }
  return 'bg-gray-100 text-gray-800'
})

// Methods
const tabClass = (tab) => {
  return activeTab.value === tab
    ? 'border-blue-500 text-blue-600'
    : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
}

const formatDate = (date) => {
  if (!date) return 'Not set'
  return new Date(date).toLocaleDateString()
}

const formatCurrency = (amount) => {
  return new Intl.NumberFormat('en-PH').format(amount)
}

const formatFileSize = (bytes) => {
  if (!bytes) return '0 B'
  const k = 1024
  const sizes = ['B', 'KB', 'MB', 'GB']
  const i = Math.floor(Math.log(bytes) / Math.log(k))
  return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i]
}

const getDocumentTypeLabel = (type) => {
  return props.documentTypes[type] || type
}

const verifyDocument = async (document) => {
  try {
    const response = await fetch(`/api/employee-documents/${document.id}`, {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
      },
      body: JSON.stringify({
        document_name: document.document_name,
        expiry_date: document.expiry_date,
        notes: document.notes,
        is_required: document.is_required,
        is_verified: true,
      })
    })

    if (response.ok) {
      window.location.reload()
    } else {
      alert('Failed to verify document')
    }
  } catch (error) {
    console.error('Error verifying document:', error)
    alert('Error verifying document')
  }
}

const deleteDocument = async (document) => {
  if (!confirm('Are you sure you want to delete this document?')) return

  try {
    const response = await fetch(`/api/employee-documents/${document.id}`, {
      method: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
      }
    })

    if (response.ok) {
      window.location.reload()
    } else {
      alert('Failed to delete document')
    }
  } catch (error) {
    console.error('Error deleting document:', error)
    alert('Error deleting document')
  }
}

// Timeline Methods
const loadTimeline = async () => {
  if (timeline.value.length > 0) return // Already loaded

  timelineLoading.value = true
  try {
    const response = await fetch(`/spa/employees/${props.employee.id}/timeline`)
    if (response.ok) {
      const data = await response.json()
      timeline.value = data.timeline
    } else {
      console.error('Failed to load timeline')
    }
  } catch (error) {
    console.error('Error loading timeline:', error)
  } finally {
    timelineLoading.value = false
  }
}

const getTimelineIconClass = (item) => {
  const baseClass = 'bg-'
  const color = item.action_color
  return `${baseClass}${color}-500`
}

const formatTimelineDate = (date) => {
  return new Date(date).toLocaleString()
}

const toggleUserAgent = (index) => {
  showUserAgent.value[index] = !showUserAgent.value[index]
}

// Watch for tab changes to load timeline
watch(activeTab, (newTab) => {
  if (newTab === 'timeline') {
    loadTimeline()
  }
})
</script>

<style>
.btn {
  @apply inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2;
}

.btn-primary {
  @apply text-white bg-blue-600 hover:bg-blue-700 focus:ring-blue-500;
}

.btn-secondary {
  @apply text-gray-700 bg-white hover:bg-gray-50 focus:ring-blue-500 border-gray-300;
}
</style>