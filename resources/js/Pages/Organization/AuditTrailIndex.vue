<template>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <!-- Header -->
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <div>
                            <!-- Breadcrumb Navigation -->
                            <nav class="flex items-center space-x-2 text-sm text-gray-500 mb-4">
                                <button @click="navigateToHome" class="hover:text-blue-600 transition-colors">
                                    <i class="fas fa-home"></i>
                                    Dashboard
                                </button>
                                <i class="fas fa-chevron-right text-xs"></i>
                                <button @click="navigateToEmployees" class="hover:text-blue-600 transition-colors">
                                    <i class="fas fa-users"></i>
                                    Employees
                                </button>
                                <i class="fas fa-chevron-right text-xs"></i>
                                <span class="text-gray-700 font-medium">
                                    <i class="fas fa-history"></i>
                                    Audit Trail
                                </span>
                            </nav>
                            <h2 class="text-xl font-semibold text-gray-900">System Audit Trail</h2>
                            <p class="text-sm text-gray-600">Track all changes made to system records</p>
                        </div>
                        <div class="flex space-x-3">
                            <button
                                @click="navigateToEmployees"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50"
                            >
                                <i class="fas fa-users mr-2"></i>
                                Back to Employees
                            </button>
                            <button
                                @click="navigateToHome"
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm bg-blue-600 text-sm font-medium text-white hover:bg-blue-700"
                            >
                                <i class="fas fa-home mr-2"></i>
                                Dashboard
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Filters -->
                <div class="p-6 bg-gray-50 border-b border-gray-200">
                    <form @submit.prevent="applyFilters" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                            <input
                                v-model="localFilters.search"
                                type="text"
                                placeholder="Search descriptions..."
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Model Type</label>
                            <select
                                v-model="localFilters.model_type"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            >
                                <option value="">All Types</option>
                                <option v-for="type in modelTypes" :key="type.value" :value="type.value">
                                    {{ type.label }}
                                </option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Action</label>
                            <select
                                v-model="localFilters.action"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            >
                                <option value="">All Actions</option>
                                <option v-for="action in actions" :key="action" :value="action">
                                    {{ action.charAt(0).toUpperCase() + action.slice(1) }}
                                </option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">User</label>
                            <select
                                v-model="localFilters.user_id"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            >
                                <option value="">All Users</option>
                                <option v-for="user in users" :key="user.id" :value="user.id">
                                    {{ user.name }}
                                </option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Date From</label>
                            <input
                                v-model="localFilters.date_from"
                                type="date"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Date To</label>
                            <input
                                v-model="localFilters.date_to"
                                type="date"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            >
                        </div>

                        <div class="flex items-end">
                            <button
                                type="submit"
                                class="w-full px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                            >
                                Apply Filters
                            </button>
                        </div>

                        <div class="flex items-end">
                            <button
                                type="button"
                                @click="clearFilters"
                                class="w-full px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150"
                            >
                                Clear
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Timestamp
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    User
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Action
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Model
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Description
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Changes
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="trail in auditTrails.data" :key="trail.id" class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ formatDateTime(trail.created_at) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ trail.user?.name || trail.user_name || 'System' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span :class="getActionClass(trail.action)" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium">
                                        <i :class="getActionIcon(trail.action)" class="mr-1"></i>
                                        {{ trail.action.charAt(0).toUpperCase() + trail.action.slice(1) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <div>
                                        <div class="font-medium">{{ getModelName(trail.model_type) }}</div>
                                        <div class="text-gray-500">ID: {{ trail.model_id }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ trail.description }}
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <div v-if="trail.changed_fields && Object.keys(trail.changed_fields).length > 0" class="space-y-1">
                                        <div v-for="(change, field) in trail.changed_fields" :key="field" class="text-xs">
                                            <span class="font-medium text-gray-600">{{ formatFieldName(field) }}:</span>
                                            <div class="flex items-center space-x-2 mt-1">
                                                <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs">{{ change.old || 'N/A' }}</span>
                                                <i class="fas fa-arrow-right text-gray-400 text-xs"></i>
                                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">{{ change.new || 'N/A' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <span v-else class="text-gray-500 text-xs">No changes recorded</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div v-if="auditTrails.links && auditTrails.links.length > 3" class="p-6 bg-white border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-700">
                            Showing {{ auditTrails.from }} to {{ auditTrails.to }} of {{ auditTrails.total }} results
                        </div>
                        <div class="flex space-x-1">
                            <button
                                v-for="link in auditTrails.links"
                                :key="link.label"
                                @click="changePage(link.url)"
                                :disabled="!link.url"
                                :class="{
                                    'bg-blue-600 text-white': link.active,
                                    'bg-gray-300 text-gray-500 cursor-not-allowed': !link.url,
                                    'bg-white text-gray-700 hover:bg-gray-50': link.url && !link.active
                                }"
                                class="px-3 py-2 text-sm font-medium border border-gray-300 rounded-md"
                                v-html="link.label"
                            ></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({
    auditTrails: Object,
    modelTypes: Array,
    actions: Array,
    users: Array,
    filters: Object
})

const localFilters = ref({
    search: props.filters.search || '',
    model_type: props.filters.model_type || '',
    action: props.filters.action || '',
    user_id: props.filters.user_id || '',
    date_from: props.filters.date_from || '',
    date_to: props.filters.date_to || ''
})

const applyFilters = () => {
    router.get('/audit-trails', localFilters.value, {
        preserveState: true,
        replace: true
    })
}

const clearFilters = () => {
    localFilters.value = {
        search: '',
        model_type: '',
        action: '',
        user_id: '',
        date_from: '',
        date_to: ''
    }
    applyFilters()
}

const changePage = (url) => {
    if (url) {
        router.visit(url, {
            preserveState: true,
            replace: true
        })
    }
}

const formatDateTime = (dateString) => {
    const date = new Date(dateString)
    return date.toLocaleString()
}

const getModelName = (modelType) => {
    return modelType.split('\\').pop()
}

const formatFieldName = (fieldName) => {
    return fieldName.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase())
}

const getActionClass = (action) => {
    switch (action) {
        case 'created':
            return 'bg-green-100 text-green-800'
        case 'updated':
            return 'bg-blue-100 text-blue-800'
        case 'deleted':
            return 'bg-red-100 text-red-800'
        default:
            return 'bg-gray-100 text-gray-800'
    }
}

const getActionIcon = (action) => {
    switch (action) {
        case 'created':
            return 'fas fa-plus'
        case 'updated':
            return 'fas fa-pencil'
        case 'deleted':
            return 'fas fa-trash'
        default:
            return 'fas fa-info'
    }
}

const navigateToHome = () => {
    router.visit('/dashboard')
}

const navigateToEmployees = () => {
    router.visit('/employees')
}
</script>