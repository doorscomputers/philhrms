<template>
  <div class="space-y-4">
    <!-- Upload Area -->
    <div
      @drop="handleDrop"
      @dragover.prevent="dragOver = true"
      @dragleave.prevent="dragOver = false"
      :class="[
        'relative border-2 border-dashed rounded-lg p-6 text-center cursor-pointer transition-all duration-200',
        dragOver
          ? 'border-blue-500 bg-blue-50 dark:bg-blue-950/50'
          : 'border-gray-300 dark:border-gray-600 hover:border-gray-400 dark:hover:border-gray-500',
        'hover:bg-gray-50 dark:hover:bg-gray-800'
      ]"
    >
      <input
        ref="fileInput"
        :id="inputId"
        @change="handleFileSelect"
        type="file"
        :multiple="multiple"
        :accept="accept"
        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
      />

      <div class="space-y-3">
        <div class="flex justify-center">
          <slot name="icon">
            <svg class="w-12 h-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
              <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
          </slot>
        </div>

        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300">
            <slot name="title">
              {{ multiple ? 'Drop files here or click to browse' : 'Drop file here or click to browse' }}
            </slot>
          </p>
          <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
            <slot name="description">
              {{ acceptDescription }}
            </slot>
          </p>
        </div>
      </div>
    </div>

    <!-- File List -->
    <div v-if="files.length > 0" class="space-y-2">
      <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300">
        {{ multiple ? 'Selected Files' : 'Selected File' }} ({{ files.length }})
      </h4>

      <div class="space-y-2 max-h-40 overflow-y-auto">
        <div
          v-for="(file, index) in files"
          :key="index"
          class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700"
        >
          <div class="flex items-center space-x-3 min-w-0 flex-1">
            <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center flex-shrink-0">
              <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
              </svg>
            </div>
            <div class="min-w-0 flex-1">
              <p class="text-sm font-medium text-gray-700 dark:text-gray-300 truncate">
                {{ file.name }}
              </p>
              <p class="text-xs text-gray-500 dark:text-gray-400">
                {{ formatFileSize(file.size) }}
              </p>
            </div>
          </div>

          <button
            @click="removeFile(index)"
            type="button"
            class="ml-3 text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 transition-colors flex-shrink-0"
          >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </button>
        </div>
      </div>
    </div>

    <!-- Error Messages -->
    <div v-if="errors.length > 0" class="space-y-1">
      <div
        v-for="(error, index) in errors"
        :key="index"
        class="text-sm text-red-600 dark:text-red-400"
      >
        {{ error }}
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, nextTick } from 'vue'

const props = defineProps({
  multiple: {
    type: Boolean,
    default: false
  },
  accept: {
    type: String,
    default: '*/*'
  },
  maxSize: {
    type: Number,
    default: 10 * 1024 * 1024 // 10MB default
  },
  maxFiles: {
    type: Number,
    default: 10
  },
  modelValue: {
    type: [File, Array],
    default: null
  }
})

const emit = defineEmits(['update:modelValue', 'change', 'error'])

const fileInput = ref(null)
const dragOver = ref(false)
const files = ref([])
const errors = ref([])

const inputId = computed(() => `file-upload-${Math.random().toString(36).substr(2, 9)}`)

const acceptDescription = computed(() => {
  if (props.accept === 'image/*') {
    return `Images up to ${formatFileSize(props.maxSize)}`
  }
  if (props.accept.includes('pdf')) {
    return `PDF files up to ${formatFileSize(props.maxSize)}`
  }
  return `Files up to ${formatFileSize(props.maxSize)}`
})


const handleFileSelect = (event) => {
  const selectedFiles = Array.from(event.target.files)
  addFiles(selectedFiles)
}

const handleDrop = (event) => {
  event.preventDefault()
  dragOver.value = false
  const droppedFiles = Array.from(event.dataTransfer.files)
  addFiles(droppedFiles)
}

const addFiles = (newFiles) => {
  errors.value = []
  const validFiles = []

  for (const file of newFiles) {
    // Check file size
    if (file.size > props.maxSize) {
      errors.value.push(`${file.name} is too large (max ${formatFileSize(props.maxSize)})`)
      continue
    }

    // Check file type if accept is specified
    if (props.accept !== '*/*' && !isFileTypeAccepted(file)) {
      errors.value.push(`${file.name} is not an accepted file type`)
      continue
    }

    validFiles.push(file)
  }

  if (props.multiple) {
    const totalFiles = files.value.length + validFiles.length
    if (totalFiles > props.maxFiles) {
      const allowedCount = props.maxFiles - files.value.length
      validFiles.splice(allowedCount)
      errors.value.push(`Maximum ${props.maxFiles} files allowed`)
    }

    files.value = [...files.value, ...validFiles]
    emit('update:modelValue', files.value)
  } else {
    if (validFiles.length > 0) {
      files.value = [validFiles[0]]
      emit('update:modelValue', validFiles[0])
    }
  }

  emit('change', files.value)

  if (errors.value.length > 0) {
    emit('error', errors.value)
  }
}

const removeFile = (index) => {
  files.value.splice(index, 1)

  if (props.multiple) {
    emit('update:modelValue', files.value)
  } else {
    emit('update:modelValue', null)
  }

  emit('change', files.value)
}

const isFileTypeAccepted = (file) => {
  const acceptedTypes = props.accept.split(',').map(type => type.trim())

  return acceptedTypes.some(acceptedType => {
    if (acceptedType.endsWith('/*')) {
      const baseType = acceptedType.replace('/*', '')
      return file.type.startsWith(baseType)
    }
    return file.type === acceptedType || file.name.toLowerCase().endsWith(acceptedType.replace('.', ''))
  })
}

const formatFileSize = (bytes) => {
  if (bytes === 0) return '0 Bytes'
  const k = 1024
  const sizes = ['Bytes', 'KB', 'MB', 'GB']
  const i = Math.floor(Math.log(bytes) / Math.log(k))
  return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i]
}

// Initialize with existing value
if (props.modelValue) {
  if (props.multiple && Array.isArray(props.modelValue)) {
    files.value = [...props.modelValue]
  } else if (!props.multiple && props.modelValue) {
    files.value = [props.modelValue]
  }
}
</script>