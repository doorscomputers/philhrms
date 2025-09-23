<template>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white shadow rounded-lg mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Audit Trail</h1>
                            <p class="mt-1 text-sm text-gray-600">
                                Complete change history for {{ employee.first_name }} {{ employee.last_name }}
                            </p>
                        </div>
                        <button
                            @click="$inertia.visit(route('spa.employees.show', employee.id))"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50"
                        >
                            <i class="fas fa-arrow-left mr-2"></i>
                            Back to Employee
                        </button>
                    </div>
                </div>

                <!-- Employee Quick Info -->
                <div class="px-6 py-4 bg-gray-50">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10">
                            <div class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center">
                                <span class="text-sm font-medium text-white">
                                    {{ employee.first_name?.[0] }}{{ employee.last_name?.[0] }}
                                </span>
                            </div>
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-900">
                                {{ employee.first_name }} {{ employee.last_name }}
                            </div>
                            <div class="text-sm text-gray-500">
                                Employee ID: {{ employee.employee_id }} |
                                {{ employee.department?.name || 'No Department' }} |
                                {{ employee.position?.name || 'No Position' }}
                            </div>
                        </div>
                        <div class="ml-auto">
                            <span :class="employee.is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"
                                  class="inline-flex px-2 py-1 text-xs font-semibold rounded-full">
                                {{ employee.is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Audit Trail Table -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Change History</h3>
                    <p class="mt-1 text-sm text-gray-600">
                        All modifications, additions, and updates made to this employee record
                    </p>
                </div>

                <div v-if="auditTrails.data.length > 0">
                    <div class="overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date & Time
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Action
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        User
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Changes Made
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Summary
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="trail in auditTrails.data" :key="trail.id" class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <div class="font-medium">{{ formatDate(trail.created_at) }}</div>
                                        <div class="text-gray-500">{{ formatTime(trail.created_at) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span :class="getActionClass(trail.action)"
                                              class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium">
                                            <i :class="getActionIcon(trail.action)" class="mr-1"></i>
                                            {{ trail.action.charAt(0).toUpperCase() + trail.action.slice(1) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <div class="font-medium text-gray-900">
                                            {{ trail.user?.name || trail.user_name || 'System' }}
                                        </div>
                                        <div class="text-gray-500" v-if="trail.ip_address">
                                            IP: {{ trail.ip_address }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        <div v-if="trail.changed_fields && Object.keys(trail.changed_fields).length > 0"
                                             class="space-y-1">
                                            <div v-for="(change, field) in trail.changed_fields" :key="field"
                                                 class="text-xs border-b border-gray-100 pb-1 last:border-b-0">
                                                <div class="font-medium text-gray-700 mb-1">
                                                    {{ formatFieldName(field) }}:
                                                </div>
                                                <div class="flex items-start space-x-2">
                                                    <div class="flex-1">
                                                        <div class="text-gray-500">From:</div>
                                                        <div class="bg-red-50 text-red-800 px-2 py-1 rounded text-xs mt-1 max-w-xs truncate"
                                                             :title="change.old">
                                                            {{ change.old || 'N/A' }}
                                                        </div>
                                                    </div>
                                                    <div class="flex-shrink-0 pt-6">
                                                        <i class="fas fa-arrow-right text-gray-400 text-xs"></i>
                                                    </div>
                                                    <div class="flex-1">
                                                        <div class="text-gray-500">To:</div>
                                                        <div class="bg-green-50 text-green-800 px-2 py-1 rounded text-xs mt-1 max-w-xs truncate"
                                                             :title="change.new">
                                                            {{ change.new || 'N/A' }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div v-else class="text-gray-400 text-xs italic">
                                            No specific field changes recorded
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        <div class="max-w-xs">
                                            {{ trail.description || 'No description available' }}
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div v-if="auditTrails.links && auditTrails.links.length > 3"
                         class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-700">
                                Showing {{ auditTrails.from }} to {{ auditTrails.to }} of {{ auditTrails.total }} entries
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
                                        'bg-white text-gray-700 hover:bg-gray-50 border-gray-300': link.url && !link.active
                                    }"
                                    class="px-3 py-2 text-sm font-medium border rounded-md"
                                    v-html="link.label"
                                ></button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- No Data -->
                <div v-else class="text-center py-12">
                    <i class="fas fa-history text-4xl text-gray-300 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No audit trail data</h3>
                    <p class="text-gray-500">
                        No changes have been recorded for this employee yet.
                        Changes will appear here once the employee record is modified.
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { router } from '@inertiajs/vue3'

const props = defineProps({
    employee: Object,
    auditTrails: Object
})

const changePage = (url) => {
    if (url) {
        router.visit(url, {
            preserveState: true,
            replace: true
        })
    }
}

const formatDate = (dateString) => {
    const date = new Date(dateString)
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    })
}

const formatTime = (dateString) => {
    const date = new Date(dateString)
    return date.toLocaleTimeString('en-US', {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit'
    })
}

const formatFieldName = (fieldName) => {
    return fieldName
        .replace(/_/g, ' ')
        .replace(/\b\w/g, l => l.toUpperCase())
        .replace(/Id$/, 'ID')
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
</script>