<template>
  <div class="fixed top-6 right-6 z-[9999] space-y-3 pointer-events-none">
    <Transition
      v-for="toast in toasts"
      :key="toast.id"
      name="toast"
      appear
    >
      <div
        :class="[
          'max-w-sm w-full bg-white shadow-xl rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden transform transition-all duration-300',
          toast.type === 'success' && 'border-l-4 border-green-500',
          toast.type === 'error' && 'border-l-4 border-red-500',
          toast.type === 'warning' && 'border-l-4 border-yellow-500',
          toast.type === 'info' && 'border-l-4 border-blue-500'
        ]"
      >
        <div class="p-4">
          <div class="flex items-start">
            <div class="flex-shrink-0">
              <i
                :class="[
                  'text-xl',
                  toast.type === 'success' && 'fas fa-check-circle text-green-500',
                  toast.type === 'error' && 'fas fa-exclamation-circle text-red-500',
                  toast.type === 'warning' && 'fas fa-exclamation-triangle text-yellow-500',
                  toast.type === 'info' && 'fas fa-info-circle text-blue-500'
                ]"
              ></i>
            </div>
            <div class="ml-3 w-0 flex-1 pt-0.5">
              <p class="text-sm font-medium text-gray-900">
                {{ toast.title }}
              </p>
              <p v-if="toast.message" class="mt-1 text-sm text-gray-500">
                {{ toast.message }}
              </p>
            </div>
            <div class="ml-4 flex-shrink-0 flex">
              <button
                @click="removeToast(toast.id)"
                class="bg-white rounded-md inline-flex text-gray-400 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
              >
                <span class="sr-only">Close</span>
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
        </div>
        <!-- Progress bar for auto-dismiss -->
        <div
          v-if="toast.duration"
          class="h-1 bg-gray-200"
        >
          <div
            :class="[
              'h-full transition-all ease-linear',
              toast.type === 'success' && 'bg-green-500',
              toast.type === 'error' && 'bg-red-500',
              toast.type === 'warning' && 'bg-yellow-500',
              toast.type === 'info' && 'bg-blue-500'
            ]"
            :style="{ width: `${toast.progress}%` }"
          ></div>
        </div>
      </div>
    </Transition>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

// Toast state
const toasts = ref([])
let toastId = 0

// Animation classes
const toastClasses = {
  'toast-enter-active': 'transition ease-out duration-300',
  'toast-enter-from': 'transform opacity-0 translate-x-full',
  'toast-enter-to': 'transform opacity-100 translate-x-0',
  'toast-leave-active': 'transition ease-in duration-200',
  'toast-leave-from': 'transform opacity-100 translate-x-0',
  'toast-leave-to': 'transform opacity-0 translate-x-full'
}

// Add toast method
const addToast = (type, title, message = null, duration = 5000) => {
  const id = ++toastId
  const toast = {
    id,
    type,
    title,
    message,
    duration,
    progress: 100
  }

  toasts.value.push(toast)

  // Auto-dismiss with progress bar
  if (duration) {
    const startTime = Date.now()
    const interval = setInterval(() => {
      const elapsed = Date.now() - startTime
      const remaining = Math.max(0, duration - elapsed)
      toast.progress = (remaining / duration) * 100

      if (remaining === 0) {
        clearInterval(interval)
        removeToast(id)
      }
    }, 50)
  }

  return id
}

// Remove toast method
const removeToast = (id) => {
  const index = toasts.value.findIndex(toast => toast.id === id)
  if (index > -1) {
    toasts.value.splice(index, 1)
  }
}

// Success toast
const success = (title, message = null, duration = 5000) => {
  return addToast('success', title, message, duration)
}

// Error toast
const error = (title, message = null, duration = 7000) => {
  return addToast('error', title, message, duration)
}

// Warning toast
const warning = (title, message = null, duration = 6000) => {
  return addToast('warning', title, message, duration)
}

// Info toast
const info = (title, message = null, duration = 5000) => {
  return addToast('info', title, message, duration)
}

// Clear all toasts
const clear = () => {
  toasts.value = []
}

// Global toast instance
let toastInstance = null

// Create global toast methods
const createGlobalToast = () => {
  return {
    success,
    error,
    warning,
    info,
    clear,
    removeToast
  }
}

// Mount/unmount logic
onMounted(() => {
  // Make toast globally available
  if (!window.$toast) {
    window.$toast = createGlobalToast()
    toastInstance = window.$toast
  }
})

onUnmounted(() => {
  if (toastInstance === window.$toast) {
    delete window.$toast
  }
})

// Expose methods for component usage
defineExpose({
  success,
  error,
  warning,
  info,
  clear,
  removeToast
})
</script>

<style scoped>
/* Toast animations */
.toast-enter-active {
  transition: all 0.3s ease-out;
}

.toast-enter-from {
  transform: translateX(100%);
  opacity: 0;
}

.toast-enter-to {
  transform: translateX(0);
  opacity: 1;
}

.toast-leave-active {
  transition: all 0.2s ease-in;
}

.toast-leave-from {
  transform: translateX(0);
  opacity: 1;
}

.toast-leave-to {
  transform: translateX(100%);
  opacity: 0;
}
</style>