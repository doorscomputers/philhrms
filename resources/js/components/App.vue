<template>
  <div id="app" class="min-h-screen bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow border-b border-gray-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <div class="flex">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
              <h1 class="text-xl font-bold text-gray-900">PH HRMS</h1>
            </div>

            <!-- Navigation Links -->
            <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
              <router-link
                to="/employees"
                class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm"
                active-class="border-blue-500 text-blue-600"
              >
                Employees
              </router-link>

              <!-- Management Dropdown -->
              <div class="relative" @click="showManagementDropdown = !showManagementDropdown">
                <button class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm flex items-center">
                  Management
                  <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                  </svg>
                </button>

                <!-- Dropdown menu -->
                <div v-show="showManagementDropdown" class="absolute left-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                  <div class="py-1">
                    <router-link to="/management/departments" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Departments</router-link>
                    <router-link to="/management/offices" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Offices</router-link>
                    <router-link to="/management/positions" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Positions</router-link>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- User menu -->
          <div class="flex items-center">
            <span class="text-sm text-gray-700">Welcome, Admin</span>
          </div>
        </div>
      </div>
    </nav>

    <!-- Main content -->
    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
      <!-- Loading spinner -->
      <div v-if="loading" class="flex justify-center items-center py-12">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
      </div>

      <!-- Router view -->
      <router-view v-else @loading="setLoading" />
    </main>

    <!-- Global notifications -->
    <div v-if="notification" class="fixed top-4 right-4 z-50">
      <div class="bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg">
        {{ notification }}
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'App',
  data() {
    return {
      loading: false,
      notification: null,
      showManagementDropdown: false
    }
  },
  methods: {
    setLoading(value) {
      this.loading = value
    },
    showNotification(message) {
      this.notification = message
      setTimeout(() => {
        this.notification = null
      }, 3000)
    }
  },
  mounted() {
    // Global click handler to close dropdowns
    document.addEventListener('click', (e) => {
      if (!e.target.closest('.relative')) {
        this.showManagementDropdown = false
      }
    })

    // Global notification handler
    window.showNotification = this.showNotification
  }
}
</script>

<style>
/* Any global styles if needed */
</style>