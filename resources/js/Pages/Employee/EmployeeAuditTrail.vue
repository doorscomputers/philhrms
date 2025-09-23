<template>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white shadow rounded-lg mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
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
                                <button @click="navigateToEmployee" class="hover:text-blue-600 transition-colors">
                                    <i class="fas fa-user"></i>
                                    {{ employee.first_name }} {{ employee.last_name }}
                                </button>
                                <i class="fas fa-chevron-right text-xs"></i>
                                <span class="text-gray-700 font-medium">
                                    <i class="fas fa-history"></i>
                                    Audit Trail
                                </span>
                            </nav>
                            <h1 class="text-2xl font-bold text-gray-900">Employee Audit Trail</h1>
                            <p class="mt-1 text-sm text-gray-600">
                                Complete change history for {{ employee.first_name }} {{ employee.last_name }}
                            </p>
                        </div>
                        <div class="flex space-x-3">
                            <button
                                @click="navigateToEmployee"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50"
                            >
                                <i class="fas fa-user mr-2"></i>
                                View Employee
                            </button>
                            <button
                                @click="navigateToEmployees"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50"
                            >
                                <i class="fas fa-users mr-2"></i>
                                All Employees
                            </button>
                            <button
                                @click="navigateToSystemAudit"
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm bg-blue-600 text-sm font-medium text-white hover:bg-blue-700"
                            >
                                <i class="fas fa-history mr-2"></i>
                                System Audit Trail
                            </button>
                        </div>
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
                                {{ employee.position?.title || 'No Position' }}
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
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 flex items-center">
                                <i class="fas fa-history text-blue-500 mr-2"></i>
                                Change History & Activity Log
                            </h3>
                            <p class="mt-1 text-sm text-gray-600">
                                Complete record of all changes made to this employee's information, showing what was changed, when, and by whom
                            </p>
                        </div>
                        <div class="text-right">
                            <div class="text-sm text-gray-500">
                                Total Records: {{ auditTrails.total || auditTrails.data.length }}
                            </div>
                            <div class="text-xs text-gray-400">
                                Showing detailed change tracking
                            </div>
                        </div>
                    </div>
                </div>

                <div v-if="auditTrails.data.length > 0">
                    <!-- Desktop Table View -->
                    <div class="hidden lg:block overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <i class="fas fa-calendar mr-1"></i>
                                        When
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <i class="fas fa-cog mr-1"></i>
                                        Action Type
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <i class="fas fa-user mr-1"></i>
                                        Made By
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <i class="fas fa-edit mr-1"></i>
                                        Field Changes
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Description
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
                                              class="inline-flex items-center px-3 py-2 rounded-full text-sm font-medium">
                                            <i :class="getActionIcon(trail.action)" class="mr-2"></i>
                                            {{ getActionDisplayName(trail.action) }}
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
                                             class="space-y-2">
                                            <div v-for="(change, field) in trail.changed_fields" :key="field"
                                                 class="border border-gray-200 rounded-lg p-3 bg-gray-50">
                                                <div class="font-semibold text-gray-800 mb-2 flex items-center">
                                                    <i class="fas fa-edit text-blue-500 mr-2"></i>
                                                    {{ getFieldDisplayName(field) }}
                                                </div>
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                                    <div class="space-y-1">
                                                        <div class="text-xs font-medium text-gray-600 uppercase tracking-wide">Previous Value</div>
                                                        <div class="bg-red-50 border border-red-200 text-red-900 px-3 py-2 rounded-md text-sm">
                                                            {{ formatDisplayValue(field, change.old) }}
                                                        </div>
                                                    </div>
                                                    <div class="space-y-1">
                                                        <div class="text-xs font-medium text-gray-600 uppercase tracking-wide">New Value</div>
                                                        <div class="bg-green-50 border border-green-200 text-green-900 px-3 py-2 rounded-md text-sm">
                                                            {{ formatDisplayValue(field, change.new) }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div v-else class="text-gray-500 text-sm italic flex items-center">
                                            <i class="fas fa-info-circle mr-2"></i>
                                            No specific field changes recorded
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        <div class="max-w-xs">
                                            {{ getActionSummary(trail) }}
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Card View -->
                    <div class="lg:hidden">
                        <div class="space-y-4 p-4">
                            <div v-for="trail in auditTrails.data" :key="trail.id"
                                 class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                                <div class="p-4">
                                    <!-- Header -->
                                    <div class="flex items-center justify-between mb-3">
                                        <span :class="getActionClass(trail.action)"
                                              class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium">
                                            <i :class="getActionIcon(trail.action)" class="mr-2"></i>
                                            {{ getActionDisplayName(trail.action) }}
                                        </span>
                                        <div class="text-sm text-gray-500">
                                            {{ formatDate(trail.created_at) }}
                                        </div>
                                    </div>

                                    <!-- Summary -->
                                    <div class="mb-3">
                                        <h4 class="font-medium text-gray-900 mb-1">{{ getActionSummary(trail) }}</h4>
                                        <p class="text-sm text-gray-600">
                                            By {{ trail.user?.name || trail.user_name || 'System' }} at {{ formatTime(trail.created_at) }}
                                        </p>
                                    </div>

                                    <!-- Changes -->
                                    <div v-if="trail.changed_fields && Object.keys(trail.changed_fields).length > 0"
                                         class="space-y-3">
                                        <div v-for="(change, field) in trail.changed_fields" :key="field"
                                             class="border border-gray-200 rounded-lg p-3 bg-gray-50">
                                            <div class="font-medium text-gray-800 mb-2 text-sm">
                                                {{ getFieldDisplayName(field) }}
                                            </div>
                                            <div class="space-y-2">
                                                <div>
                                                    <div class="text-xs text-gray-600 mb-1">From:</div>
                                                    <div class="bg-red-50 border border-red-200 text-red-900 px-2 py-1 rounded text-sm">
                                                        {{ formatDisplayValue(field, change.old) }}
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="text-xs text-gray-600 mb-1">To:</div>
                                                    <div class="bg-green-50 border border-green-200 text-green-900 px-2 py-1 rounded text-sm">
                                                        {{ formatDisplayValue(field, change.new) }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-else class="text-gray-500 text-sm italic">
                                        No specific field changes recorded
                                    </div>
                                </div>
                            </div>
                        </div>
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
                <div v-else class="text-center py-16">
                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-blue-100 mb-4">
                        <i class="fas fa-history text-2xl text-blue-500"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No Activity Found</h3>
                    <p class="text-gray-500 max-w-sm mx-auto">
                        This employee record has no recorded changes yet. Once modifications are made to their information,
                        all changes will be tracked and displayed here with full details.
                    </p>
                    <div class="mt-6 p-4 bg-blue-50 rounded-lg max-w-md mx-auto">
                        <p class="text-sm text-blue-700">
                            <i class="fas fa-info-circle mr-2"></i>
                            The audit trail will automatically capture all future updates including field changes,
                            timestamps, and the user who made each modification.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { router } from '@inertiajs/vue3'

const props = defineProps({
    employee: Object,
    auditTrails: Object,
    lookupData: Object
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

const getActionDisplayName = (action) => {
    switch (action) {
        case 'created':
            return 'Record Created'
        case 'updated':
            return 'Record Updated'
        case 'deleted':
            return 'Record Deleted'
        default:
            return 'System Action'
    }
}

const getFieldDisplayName = (fieldName) => {
    const fieldMappings = {
        'first_name': 'First Name',
        'last_name': 'Last Name',
        'middle_name': 'Middle Name',
        'preferred_name': 'Preferred Name',
        'employee_id': 'Employee ID',
        'badge_number': 'Badge Number',
        'biometric_id': 'Biometric ID',
        'updated_at': 'Last Updated',
        'email': 'Email Address',
        'phone': 'Phone Number',
        'mobile_phone': 'Mobile Phone',
        'hire_date': 'Hire Date',
        'birth_date': 'Birth Date',
        'gender': 'Gender',
        'marital_status': 'Marital Status',
        'nationality': 'Nationality',
        'religion': 'Religion',
        'department_id': 'Department',
        'position_id': 'Position',
        'job_grade_id': 'Job Grade',
        'employment_status_id': 'Employment Status',
        'work_schedule_id': 'Work Schedule',
        'branch_id': 'Branch',
        'cost_center_id': 'Cost Center',
        'company_id': 'Company',
        'supervisor_id': 'Supervisor',
        'immediate_supervisor_id': 'Immediate Supervisor',
        'is_active': 'Active Status',
        'basic_salary': 'Basic Salary',
        'allowances': 'Allowances',
        'probation_end_date': 'Probation End Date',
        'regularization_date': 'Regularization Date',
        'contract_start_date': 'Contract Start Date',
        'contract_end_date': 'Contract End Date',
        'address': 'Address',
        'emergency_contacts': 'Emergency Contacts',
        'education_background': 'Education Background',
        'work_experience': 'Work Experience',
        'certifications': 'Certifications',
        'skills': 'Skills',
        'tin_number': 'TIN Number',
        'sss_number': 'SSS Number',
        'philhealth_number': 'PhilHealth Number',
        'pagibig_number': 'Pag-IBIG Number'
    };

    return fieldMappings[fieldName] || fieldName
        .replace(/_/g, ' ')
        .replace(/\b\w/g, l => l.toUpperCase())
        .replace(/Id$/, 'ID');
}

const formatDisplayValue = (fieldName, value) => {
    if (value === null || value === undefined || value === '') {
        return 'Not specified';
    }


    // Handle boolean values
    if (typeof value === 'boolean') {
        return value ? 'Yes' : 'No';
    }

    // Handle specific field formatting
    switch (fieldName) {
        case 'is_active':
            return value === true || value === 1 || value === '1' ? 'Active' : 'Inactive';

        case 'gender':
            return value === 'M' ? 'Male' : value === 'F' ? 'Female' : value;

        case 'basic_salary':
        case 'allowances':
            return typeof value === 'number' ?
                new Intl.NumberFormat('en-PH', {
                    style: 'currency',
                    currency: 'PHP'
                }).format(value) : value;

        case 'hire_date':
        case 'birth_date':
        case 'probation_end_date':
        case 'regularization_date':
        case 'contract_start_date':
        case 'contract_end_date':
            return value ? new Date(value).toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            }) : 'Not specified';

        case 'employee_id':
            return value || 'Not assigned';
        case 'badge_number':
            return value || 'Not assigned';
        case 'biometric_id':
            return value || 'Not assigned';
        case 'updated_at':
            return value ? new Date(value).toLocaleString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            }) : 'Not specified';
        case 'department_id':
            if (!value) return 'No department assigned';
            const deptName = props.lookupData?.departments?.[value];
            return deptName ? deptName : `Department ID: ${value}`;
        case 'position_id':
            if (!value) return 'No position assigned';
            const posName = props.lookupData?.positions?.[value];
            return posName ? posName : `Position (ID: ${value})`;
        case 'job_grade_id':
            if (!value) return 'No job grade assigned';
            const jobGradeName = props.lookupData?.jobGrades?.[value];
            return jobGradeName ? jobGradeName : `Job Grade (ID: ${value})`;
        case 'employment_status_id':
            if (!value) return 'No employment status assigned';
            const empStatusName = props.lookupData?.employmentStatuses?.[value];
            return empStatusName ? empStatusName : `Employment Status (ID: ${value})`;
        case 'work_schedule_id':
            if (!value) return 'No work schedule assigned';
            const schedName = props.lookupData?.workSchedules?.[value];
            return schedName ? schedName : `Work Schedule (ID: ${value})`;
        case 'branch_id':
            if (!value) return 'No branch assigned';
            const branchName = props.lookupData?.branches?.[value];
            return branchName ? branchName : `Branch (ID: ${value})`;
        case 'cost_center_id':
            if (!value) return 'No cost center assigned';
            const costCenterName = props.lookupData?.costCenters?.[value];
            return costCenterName ? costCenterName : `Cost Center (ID: ${value})`;
        case 'company_id':
            if (!value) return 'No company assigned';
            const companyName = props.lookupData?.companies?.[value];
            return companyName ? companyName : `Company (ID: ${value})`;
        case 'supervisor_id':
        case 'immediate_supervisor_id':
            if (!value) return 'No supervisor assigned';
            const supervisorName = props.lookupData?.employees?.[value];
            return supervisorName ? supervisorName : `Supervisor (ID: ${value})`;

        default:
            // Handle arrays and objects
            if (Array.isArray(value)) {
                return value.length > 0 ? `${value.length} items` : 'Empty';
            }

            if (typeof value === 'object') {
                try {
                    return JSON.stringify(value, null, 2);
                } catch (e) {
                    return 'Complex data';
                }
            }

            return String(value);
    }
}

const getActionSummary = (trail) => {
    if (trail.description && trail.description !== 'Record modified') {
        return trail.description;
    }

    // Generate a meaningful summary based on the action and changes
    const changedFields = trail.changed_fields;
    if (!changedFields || Object.keys(changedFields).length === 0) {
        switch (trail.action) {
            case 'created':
                return 'Employee record was created in the system';
            case 'updated':
                return 'Employee record was updated';
            case 'deleted':
                return 'Employee record was deleted from the system';
            default:
                return 'System action performed on employee record';
        }
    }

    const fieldCount = Object.keys(changedFields).length;
    const fieldNames = Object.keys(changedFields).map(field => getFieldDisplayName(field));

    if (fieldCount === 1) {
        return `Updated ${fieldNames[0]}`;
    } else if (fieldCount <= 3) {
        return `Updated ${fieldNames.join(', ')}`;
    } else {
        return `Updated ${fieldCount} fields: ${fieldNames.slice(0, 2).join(', ')} and ${fieldCount - 2} more`;
    }
}

// Navigation functions
const navigateToHome = () => {
    router.visit('/dashboard')
}

const navigateToEmployees = () => {
    router.visit('/employees')
}

const navigateToEmployee = () => {
    router.visit(`/spa/employees/${props.employee.id}`)
}

const navigateToSystemAudit = () => {
    router.visit('/audit-trails')
}
</script>