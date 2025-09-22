<template>
  <div class="space-y-4">
    <!-- Header -->
    <div class="flex items-center justify-between">
      <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300">
        {{ title }} <span v-if="documents.length > 0" class="text-gray-500">({{ documents.length }})</span>
      </h4>
      <slot name="actions" />
    </div>

    <!-- Document List -->
    <div v-if="documents.length > 0" class="space-y-2 max-h-60 overflow-y-auto">
      <div
        v-for="(document, index) in documents"
        :key="getDocumentKey(document, index)"
        :class="[
          'flex items-center justify-between p-3 rounded-lg border transition-all duration-200',
          getDocumentTypeClasses(document)
        ]"
      >
        <div class="flex items-center space-x-3 min-w-0 flex-1">
          <!-- File Icon -->
          <div :class="['w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0', getIconClasses(document)]">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
              <path v-if="isImageFile(document)" fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
              <path v-else-if="isPdfFile(document)" fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path>
              <path v-else fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
            </svg>
          </div>

          <!-- File Info -->
          <div class="min-w-0 flex-1">
            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 truncate">
              {{ getDocumentName(document) }}
            </p>
            <div class="flex items-center space-x-2 text-xs text-gray-500 dark:text-gray-400">
              <span>{{ getDocumentStatus(document) }}</span>
              <span v-if="getDocumentSize(document)">• {{ formatFileSize(getDocumentSize(document)) }}</span>
              <span v-if="getDocumentUploadDate(document)">• {{ formatDate(getDocumentUploadDate(document)) }}</span>
            </div>
          </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center space-x-2 ml-3">
          <!-- View Button -->
          <button
            v-if="canView(document)"
            @click="viewDocument(document)"
            type="button"
            class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 transition-colors"
            title="View document"
          >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
            </svg>
          </button>

          <!-- Download Button -->
          <button
            v-if="canDownload(document)"
            @click="downloadDocument(document)"
            type="button"
            class="text-green-600 hover:text-green-700 dark:text-green-400 dark:hover:text-green-300 transition-colors"
            title="Download document"
          >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
          </button>

          <!-- Remove Button -->
          <button
            v-if="removable"
            @click="removeDocument(document, index)"
            type="button"
            class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 transition-colors"
            title="Remove document"
          >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </button>
        </div>
      </div>
    </div>

    <!-- Empty State -->
    <div v-else class="text-center py-8">
      <div class="w-16 h-16 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4">
        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
      </div>
      <p class="text-sm text-gray-500 dark:text-gray-400">{{ emptyMessage }}</p>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  documents: {
    type: Array,
    default: () => []
  },
  title: {
    type: String,
    default: 'Documents'
  },
  removable: {
    type: Boolean,
    default: false
  },
  emptyMessage: {
    type: String,
    default: 'No documents uploaded'
  }
})

const emit = defineEmits(['view', 'download', 'remove'])

// Document helper functions
const getDocumentKey = (document, index) => {
  return document.id || document.path || `doc-${index}`
}

const getDocumentName = (document) => {
  return document.name || document.original_name || document.filename || 'Unknown Document'
}

const getDocumentSize = (document) => {
  return document.size || document.file_size || null
}

const getDocumentUploadDate = (document) => {
  return document.uploaded_at || document.created_at || document.upload_date || null
}

const getDocumentStatus = (document) => {
  if (document.status === 'existing' || document.path) {
    return 'Existing file'
  }
  if (document.status === 'new' || document instanceof File) {
    return 'New file'
  }
  return 'File'
}

const getDocumentTypeClasses = (document) => {
  if (document.status === 'existing' || document.path) {
    return 'bg-blue-50 border-blue-200 dark:bg-blue-950/20 dark:border-blue-800'
  }
  if (document.status === 'new' || document instanceof File) {
    return 'bg-green-50 border-green-200 dark:bg-green-950/20 dark:border-green-800'
  }
  return 'bg-gray-50 border-gray-200 dark:bg-gray-800 dark:border-gray-700'
}

const getIconClasses = (document) => {
  if (isImageFile(document)) {
    return 'bg-purple-100 text-purple-600 dark:bg-purple-900 dark:text-purple-400'
  }
  if (isPdfFile(document)) {
    return 'bg-red-100 text-red-600 dark:bg-red-900 dark:text-red-400'
  }
  return 'bg-blue-100 text-blue-600 dark:bg-blue-900 dark:text-blue-400'
}

const isImageFile = (document) => {
  const name = getDocumentName(document).toLowerCase()
  const type = document.type || document.mime_type || ''
  return type.startsWith('image/') || name.match(/\.(jpg|jpeg|png|gif|webp)$/i)
}

const isPdfFile = (document) => {
  const name = getDocumentName(document).toLowerCase()
  const type = document.type || document.mime_type || ''
  return type === 'application/pdf' || name.endsWith('.pdf')
}

const canView = (document) => {
  return document.path || document.url || (document instanceof File && isImageFile(document))
}

const canDownload = (document) => {
  return document.path || document.url || document instanceof File
}

const viewDocument = (document) => {
  emit('view', document)
}

const downloadDocument = (document) => {
  emit('download', document)
}

const removeDocument = (document, index) => {
  emit('remove', document, index)
}

const formatFileSize = (bytes) => {
  if (!bytes || bytes === 0) return '0 Bytes'
  const k = 1024
  const sizes = ['Bytes', 'KB', 'MB', 'GB']
  const i = Math.floor(Math.log(bytes) / Math.log(k))
  return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i]
}

const formatDate = (dateString) => {
  if (!dateString) return ''
  try {
    const date = new Date(dateString)
    return date.toLocaleDateString('en-US', {
      year: 'numeric',
      month: 'short',
      day: 'numeric'
    })
  } catch (e) {
    return dateString
  }
}
</script>