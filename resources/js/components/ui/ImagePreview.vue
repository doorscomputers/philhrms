<template>
  <div class="space-y-4">
    <!-- Image Preview -->
    <div class="relative">
      <div
        v-if="imageUrl"
        class="relative group inline-block"
      >
        <img
          :src="imageUrl"
          :alt="alt"
          :class="[
            'rounded-lg border-2 border-gray-200 dark:border-gray-700 shadow-sm transition-all duration-200',
            'group-hover:shadow-md',
            sizeClasses
          ]"
          @error="handleImageError"
        />

        <!-- Remove button (shows on hover) -->
        <button
          v-if="removable"
          @click="$emit('remove')"
          type="button"
          class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 hover:bg-red-600 text-white rounded-full shadow-lg opacity-0 group-hover:opacity-100 transition-all duration-200 flex items-center justify-center"
        >
          <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>

        <!-- Image actions overlay -->
        <div
          v-if="showActions"
          class="absolute inset-0 bg-black bg-opacity-50 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex items-center justify-center space-x-2"
        >
          <button
            v-if="downloadable"
            @click="downloadImage"
            type="button"
            class="p-2 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-full transition-all duration-200"
            title="Download image"
          >
            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
          </button>

          <button
            v-if="expandable"
            @click="expandImage"
            type="button"
            class="p-2 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-full transition-all duration-200"
            title="View full size"
          >
            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
            </svg>
          </button>
        </div>
      </div>

      <!-- Placeholder when no image -->
      <div
        v-else
        :class="[
          'border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-800 flex items-center justify-center',
          sizeClasses
        ]"
      >
        <div class="text-center">
          <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
          </svg>
          <p class="text-xs text-gray-500 dark:text-gray-400">{{ placeholder }}</p>
        </div>
      </div>
    </div>

    <!-- Image Info -->
    <div v-if="showInfo && imageUrl" class="text-xs text-gray-500 dark:text-gray-400 space-y-1">
      <div v-if="fileName">
        <span class="font-medium">File:</span> {{ fileName }}
      </div>
      <div v-if="fileSize">
        <span class="font-medium">Size:</span> {{ formatFileSize(fileSize) }}
      </div>
    </div>

    <!-- Error Message -->
    <div v-if="error" class="text-sm text-red-600 dark:text-red-400">
      {{ error }}
    </div>
  </div>

  <!-- Full Screen Modal -->
  <teleport to="body">
    <div
      v-if="showModal"
      @click="showModal = false"
      class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 p-4"
    >
      <div @click.stop class="relative max-w-4xl max-h-full">
        <img
          :src="imageUrl"
          :alt="alt"
          class="max-w-full max-h-full rounded-lg shadow-2xl"
        />
        <button
          @click="showModal = false"
          class="absolute top-4 right-4 w-8 h-8 bg-black bg-opacity-50 hover:bg-opacity-70 text-white rounded-full flex items-center justify-center transition-all duration-200"
        >
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
      </div>
    </div>
  </teleport>
</template>

<script setup>
import { ref, computed } from 'vue'

const props = defineProps({
  src: {
    type: String,
    default: null
  },
  alt: {
    type: String,
    default: 'Image'
  },
  size: {
    type: String,
    default: 'md',
    validator: (value) => ['xs', 'sm', 'md', 'lg', 'xl'].includes(value)
  },
  removable: {
    type: Boolean,
    default: false
  },
  downloadable: {
    type: Boolean,
    default: false
  },
  expandable: {
    type: Boolean,
    default: true
  },
  showActions: {
    type: Boolean,
    default: true
  },
  showInfo: {
    type: Boolean,
    default: false
  },
  fileName: {
    type: String,
    default: null
  },
  fileSize: {
    type: Number,
    default: null
  },
  placeholder: {
    type: String,
    default: 'No image'
  }
})

const emit = defineEmits(['remove', 'error'])

const showModal = ref(false)
const error = ref(null)

const imageUrl = computed(() => {
  if (!props.src) return null

  // Handle different URL formats
  if (props.src.startsWith('http') || props.src.startsWith('data:')) {
    return props.src
  }

  // Handle Laravel storage URLs
  if (props.src.startsWith('/storage/')) {
    return props.src
  }

  // Assume it's a storage path that needs the /storage/ prefix
  return `/storage/${props.src}`
})

const sizeClasses = computed(() => {
  const sizes = {
    xs: 'w-16 h-16',
    sm: 'w-24 h-24',
    md: 'w-32 h-32',
    lg: 'w-48 h-48',
    xl: 'w-64 h-64'
  }
  return sizes[props.size]
})

const handleImageError = () => {
  error.value = 'Failed to load image'
  emit('error', error.value)
}

const expandImage = () => {
  showModal.value = true
}

const downloadImage = () => {
  if (!imageUrl.value) return

  const link = document.createElement('a')
  link.href = imageUrl.value
  link.download = props.fileName || 'image'
  document.body.appendChild(link)
  link.click()
  document.body.removeChild(link)
}

const formatFileSize = (bytes) => {
  if (!bytes || bytes === 0) return '0 Bytes'
  const k = 1024
  const sizes = ['Bytes', 'KB', 'MB', 'GB']
  const i = Math.floor(Math.log(bytes) / Math.log(k))
  return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i]
}
</script>