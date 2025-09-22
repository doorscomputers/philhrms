@extends('layouts.dashboard')

@section('title', 'Employee Profile')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <a href="{{ route('employees.index') }}" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Employee Profile</h1>
                <p class="text-gray-600">View employee information and details</p>
            </div>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('audit-trails.show', ['modelType' => 'App%5CModels%5CEmployee', 'modelId' => $employee->id]) }}"
               class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
                View Audit Trail
            </a>
            <a href="{{ route('employees.edit', $employee) }}"
               class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit Employee
            </a>
        </div>
    </div>

    <!-- Employee Profile Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
        <div class="flex items-start space-x-6">
            <div class="relative">
                @if($employee->photo)
                    <img class="w-24 h-24 rounded-full object-cover border-4 border-gray-100"
                         src="{{ asset('storage/' . $employee->photo) }}"
                         alt="{{ $employee->first_name }} {{ $employee->last_name }}">
                @else
                    <img class="w-24 h-24 rounded-full object-cover border-4 border-gray-100"
                         src="https://ui-avatars.com/api/?name={{ urlencode($employee->first_name . ' ' . $employee->last_name) }}&color=3B82F6&background=EBF4FF&size=256"
                         alt="{{ $employee->first_name }} {{ $employee->last_name }}">
                @endif
                @if($employee->is_active)
                    <div class="absolute -top-1 -right-1 h-6 w-6 bg-green-400 border-4 border-white rounded-full"></div>
                @endif
            </div>

            <div class="flex-1">
                <div class="flex items-center space-x-4 mb-2">
                    <h2 class="text-2xl font-bold text-gray-900">
                        {{ $employee->first_name }}
                        @if($employee->middle_name){{ substr($employee->middle_name, 0, 1) }}.@endif
                        {{ $employee->last_name }}
                        @if($employee->suffix){{ $employee->suffix }}@endif
                    </h2>
                    <span class="px-3 py-1 text-sm font-medium rounded-full
                        @if($employee->employment_status === 'Regular') bg-green-100 text-green-800
                        @elseif($employee->employment_status === 'Probationary') bg-yellow-100 text-yellow-800
                        @elseif($employee->employment_status === 'Contractual') bg-blue-100 text-blue-800
                        @else bg-gray-100 text-gray-800 @endif">
                        {{ $employee->employment_status ?? 'N/A' }}
                    </span>
                </div>

                <p class="text-lg text-gray-600 mb-1">{{ $employee->position->title ?? 'N/A' }}</p>
                <p class="text-gray-500 mb-4">{{ $employee->department->name ?? 'N/A' }} • Employee ID: {{ $employee->employee_id ?? 'N/A' }}</p>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                        <div class="text-lg font-semibold text-gray-900">
                            @if($employee->hire_date)
                                {{ \Carbon\Carbon::parse($employee->hire_date)->diffInYears() }}
                            @else
                                0
                            @endif
                        </div>
                        <div class="text-sm text-gray-600">Years</div>
                    </div>
                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                        <div class="text-lg font-semibold text-green-600">98%</div>
                        <div class="text-sm text-gray-600">Attendance</div>
                    </div>
                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                        <div class="text-lg font-semibold text-blue-600">94%</div>
                        <div class="text-sm text-gray-600">Performance</div>
                    </div>
                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                        <div class="text-lg font-semibold text-purple-600">
                            @if($employee->basic_salary)
                                ₱{{ number_format($employee->basic_salary, 2) }}
                            @else
                                N/A
                            @endif
                        </div>
                        <div class="text-sm text-gray-600">Basic Salary</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Information Tabs -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200" x-data="{ activeTab: 'personal' }">
        <div class="border-b border-gray-200">
            <nav class="flex space-x-8 px-6" aria-label="Tabs">
                <button @click="activeTab = 'personal'"
                        class="py-4 px-1 text-sm font-medium transition-colors border-b-2"
                        :class="activeTab === 'personal' ? 'border-emerald-500 text-emerald-600' : 'border-transparent text-gray-500 hover:text-gray-700'">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Personal Information
                </button>
                <button @click="activeTab = 'employment'"
                        class="py-4 px-1 text-sm font-medium transition-colors border-b-2"
                        :class="activeTab === 'employment' ? 'border-emerald-500 text-emerald-600' : 'border-transparent text-gray-500 hover:text-gray-700'">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V2a2 2 0 00-2-2H8a2 2 0 00-2 2v4M7 7h10a2 2 0 012 2v10a2 2 0 01-2 2H7a2 2 0 01-2-2V9a2 2 0 012-2z"></path>
                    </svg>
                    Employment Details
                </button>
                <button @click="activeTab = 'contact'"
                        class="py-4 px-1 text-sm font-medium transition-colors border-b-2"
                        :class="activeTab === 'contact' ? 'border-emerald-500 text-emerald-600' : 'border-transparent text-gray-500 hover:text-gray-700'">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                    Contact Information
                </button>
                <button @click="activeTab = 'government'"
                        class="py-4 px-1 text-sm font-medium transition-colors border-b-2"
                        :class="activeTab === 'government' ? 'border-emerald-500 text-emerald-600' : 'border-transparent text-gray-500 hover:text-gray-700'">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                    </svg>
                    Government IDs
                </button>
                <button @click="activeTab = 'payroll'"
                        class="py-4 px-1 text-sm font-medium transition-colors border-b-2"
                        :class="activeTab === 'payroll' ? 'border-emerald-500 text-emerald-600' : 'border-transparent text-gray-500 hover:text-gray-700'">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Payroll & Benefits
                </button>
                <button @click="activeTab = 'documents'"
                        class="py-4 px-1 text-sm font-medium transition-colors border-b-2"
                        :class="activeTab === 'documents' ? 'border-emerald-500 text-emerald-600' : 'border-transparent text-gray-500 hover:text-gray-700'">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Documents
                </button>
                <button @click="activeTab = 'audit'"
                        class="py-4 px-1 text-sm font-medium transition-colors border-b-2"
                        :class="activeTab === 'audit' ? 'border-emerald-500 text-emerald-600' : 'border-transparent text-gray-500 hover:text-gray-700'">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    Audit Trail
                </button>
            </nav>
        </div>

        <div class="p-6">
            <!-- Personal Information Tab -->
            <div x-show="activeTab === 'personal'" x-transition>
                <h3 class="text-lg font-medium text-gray-900 mb-6">Personal Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">First Name</label>
                        <p class="text-sm text-gray-900">{{ $employee->first_name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Middle Name</label>
                        <p class="text-sm text-gray-900">{{ $employee->middle_name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Last Name</label>
                        <p class="text-sm text-gray-900">{{ $employee->last_name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Suffix</label>
                        <p class="text-sm text-gray-900">{{ $employee->suffix ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Maiden Name</label>
                        <p class="text-sm text-gray-900">{{ $employee->maiden_name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Nickname</label>
                        <p class="text-sm text-gray-900">{{ $employee->nickname ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Birth Date</label>
                        <p class="text-sm text-gray-900">
                            @if($employee->birth_date)
                                {{ \Carbon\Carbon::parse($employee->birth_date)->format('F d, Y') }}
                            @else
                                N/A
                            @endif
                        </p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Birth Place</label>
                        <p class="text-sm text-gray-900">{{ $employee->birth_place ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Age</label>
                        <p class="text-sm text-gray-900">
                            @if($employee->birth_date)
                                {{ \Carbon\Carbon::parse($employee->birth_date)->age }} years old
                            @else
                                N/A
                            @endif
                        </p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Gender</label>
                        <p class="text-sm text-gray-900">{{ $employee->gender ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Civil Status</label>
                        <p class="text-sm text-gray-900">{{ $employee->civil_status ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Nationality</label>
                        <p class="text-sm text-gray-900">{{ $employee->nationality ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Religion</label>
                        <p class="text-sm text-gray-900">{{ $employee->religion ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Blood Type</label>
                        <p class="text-sm text-gray-900">{{ $employee->blood_type ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Height</label>
                        <p class="text-sm text-gray-900">
                            @if($employee->height)
                                {{ $employee->height }} cm
                            @else
                                N/A
                            @endif
                        </p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Weight</label>
                        <p class="text-sm text-gray-900">
                            @if($employee->weight)
                                {{ $employee->weight }} kg
                            @else
                                N/A
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Employment Details Tab -->
            <div x-show="activeTab === 'employment'" x-transition>
                <h3 class="text-lg font-medium text-gray-900 mb-6">Employment Details</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Employee ID</label>
                        <p class="text-sm text-gray-900">{{ $employee->employee_id ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Badge Number</label>
                        <p class="text-sm text-gray-900">{{ $employee->badge_number ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Biometric ID</label>
                        <p class="text-sm text-gray-900">{{ $employee->biometric_id ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Company</label>
                        <p class="text-sm text-gray-900">{{ $employee->company->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Department</label>
                        <p class="text-sm text-gray-900">{{ $employee->department->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Position</label>
                        <p class="text-sm text-gray-900">{{ $employee->position->title ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Job Grade</label>
                        <p class="text-sm text-gray-900">{{ $employee->jobGrade->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Branch/Office</label>
                        <p class="text-sm text-gray-900">{{ $employee->branch->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Cost Center</label>
                        <p class="text-sm text-gray-900">{{ $employee->costCenter->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Work Schedule</label>
                        <p class="text-sm text-gray-900">{{ $employee->workSchedule->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Hire Date</label>
                        <p class="text-sm text-gray-900">
                            @if($employee->hire_date)
                                {{ \Carbon\Carbon::parse($employee->hire_date)->format('F d, Y') }}
                            @else
                                N/A
                            @endif
                        </p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Original Hire Date</label>
                        <p class="text-sm text-gray-900">
                            @if($employee->original_hire_date)
                                {{ \Carbon\Carbon::parse($employee->original_hire_date)->format('F d, Y') }}
                            @else
                                N/A
                            @endif
                        </p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Employment Status</label>
                        <p class="text-sm text-gray-900">{{ $employee->employment_status ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Employment Type</label>
                        <p class="text-sm text-gray-900">{{ $employee->employment_type ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Status</label>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $employee->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $employee->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Contact Information Tab -->
            <div x-show="activeTab === 'contact'" x-transition>
                <h3 class="text-lg font-medium text-gray-900 mb-6">Contact Information</h3>

                <!-- Contact Numbers -->
                @if($employee->contact_numbers && is_array($employee->contact_numbers) && count($employee->contact_numbers) > 0)
                    <div class="mb-8">
                        <h4 class="text-base font-medium text-gray-900 mb-4">Contact Numbers</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($employee->contact_numbers as $index => $number)
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <p class="text-sm font-medium text-gray-500">Contact {{ $index + 1 }}</p>
                                    <p class="text-sm text-gray-900">{{ $number }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Email Addresses -->
                @if($employee->email_addresses && is_array($employee->email_addresses) && count($employee->email_addresses) > 0)
                    <div class="mb-8">
                        <h4 class="text-base font-medium text-gray-900 mb-4">Email Addresses</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($employee->email_addresses as $index => $email)
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <p class="text-sm font-medium text-gray-500">Email {{ $index + 1 }}</p>
                                    <p class="text-sm text-gray-900">{{ $email }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Addresses -->
                @if($employee->addresses && is_array($employee->addresses) && count($employee->addresses) > 0)
                    <div class="mb-8">
                        <h4 class="text-base font-medium text-gray-900 mb-4">Addresses</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($employee->addresses as $address)
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <p class="text-sm font-medium text-gray-500 mb-1">{{ $address['type'] ?? 'Address' }}</p>
                                    <div class="text-sm text-gray-900">
                                        @if(isset($address['address']) && $address['address'])
                                            <p>{{ $address['address'] }}</p>
                                        @endif
                                        @if(isset($address['city']) && $address['city'])
                                            <p>{{ $address['city'] }}@if(isset($address['province']) && $address['province']), {{ $address['province'] }}@endif</p>
                                        @endif
                                        @if(isset($address['postal_code']) && $address['postal_code'])
                                            <p>{{ $address['postal_code'] }}</p>
                                        @endif
                                        @if(isset($address['country']) && $address['country'])
                                            <p>{{ $address['country'] }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Emergency Contacts -->
                @if($employee->emergency_contacts && is_array($employee->emergency_contacts) && count($employee->emergency_contacts) > 0)
                    <div>
                        <h4 class="text-base font-medium text-gray-900 mb-4">Emergency Contacts</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($employee->emergency_contacts as $contact)
                                <div class="bg-red-50 border border-red-200 p-4 rounded-lg">
                                    <p class="text-sm font-medium text-red-900 mb-1">{{ $contact['name'] ?? 'N/A' }}</p>
                                    <p class="text-sm text-red-700">{{ $contact['relationship'] ?? 'N/A' }}</p>
                                    <p class="text-sm text-red-700">{{ $contact['phone'] ?? 'N/A' }}</p>
                                    @if(isset($contact['address']) && $contact['address'])
                                        <p class="text-xs text-red-600 mt-1">{{ $contact['address'] }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if((!$employee->contact_numbers || !is_array($employee->contact_numbers) || count($employee->contact_numbers) === 0) && (!$employee->email_addresses || !is_array($employee->email_addresses) || count($employee->email_addresses) === 0) && (!$employee->addresses || !is_array($employee->addresses) || count($employee->addresses) === 0) && (!$employee->emergency_contacts || !is_array($employee->emergency_contacts) || count($employee->emergency_contacts) === 0))
                    <div class="text-center py-12">
                        <div class="text-gray-400 text-4xl mb-4">
                            <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No Contact Information</h3>
                        <p class="text-gray-600">No contact information has been provided for this employee.</p>
                    </div>
                @endif
            </div>

            <!-- Government IDs Tab -->
            <div x-show="activeTab === 'government'" x-transition>
                <h3 class="text-lg font-medium text-gray-900 mb-6">Government IDs & Documents</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">SSS Number</label>
                        <p class="text-sm text-gray-900">{{ $employee->sss_number ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">TIN</label>
                        <p class="text-sm text-gray-900">{{ $employee->tin ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">PhilHealth Number</label>
                        <p class="text-sm text-gray-900">{{ $employee->philhealth_number ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Pag-IBIG Number</label>
                        <p class="text-sm text-gray-900">{{ $employee->pagibig_number ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Passport Number</label>
                        <p class="text-sm text-gray-900">{{ $employee->passport_number ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Passport Expiry</label>
                        <p class="text-sm text-gray-900">
                            @if($employee->passport_expiry)
                                {{ \Carbon\Carbon::parse($employee->passport_expiry)->format('F d, Y') }}
                            @else
                                N/A
                            @endif
                        </p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Driver's License</label>
                        <p class="text-sm text-gray-900">{{ $employee->drivers_license ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">License Expiry</label>
                        <p class="text-sm text-gray-900">
                            @if($employee->license_expiry)
                                {{ \Carbon\Carbon::parse($employee->license_expiry)->format('F d, Y') }}
                            @else
                                N/A
                            @endif
                        </p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Voter's ID</label>
                        <p class="text-sm text-gray-900">{{ $employee->voters_id ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <!-- Payroll & Benefits Tab -->
            <div x-show="activeTab === 'payroll'" x-transition>
                <h3 class="text-lg font-medium text-gray-900 mb-6">Payroll & Benefits Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Basic Salary</label>
                        <p class="text-sm text-gray-900">
                            @if($employee->basic_salary)
                                ₱{{ number_format($employee->basic_salary, 2) }}
                            @else
                                N/A
                            @endif
                        </p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Daily Rate</label>
                        <p class="text-sm text-gray-900">
                            @if($employee->daily_rate)
                                ₱{{ number_format($employee->daily_rate, 2) }}
                            @else
                                N/A
                            @endif
                        </p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Hourly Rate</label>
                        <p class="text-sm text-gray-900">
                            @if($employee->hourly_rate)
                                ₱{{ number_format($employee->hourly_rate, 2) }}
                            @else
                                N/A
                            @endif
                        </p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Pay Frequency</label>
                        <p class="text-sm text-gray-900">{{ $employee->pay_frequency ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Tax Status</label>
                        <p class="text-sm text-gray-900">{{ $employee->tax_status ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Tax Shield</label>
                        <p class="text-sm text-gray-900">
                            @if($employee->tax_shield)
                                ₱{{ number_format($employee->tax_shield, 2) }}
                            @else
                                N/A
                            @endif
                        </p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Is Exempt</label>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $employee->is_exempt ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $employee->is_exempt ? 'Yes' : 'No' }}
                        </span>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Is Minimum Wage</label>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $employee->is_minimum_wage ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $employee->is_minimum_wage ? 'Yes' : 'No' }}
                        </span>
                    </div>
                </div>

                <!-- Leave Balances -->
                <div class="mt-8 pt-8 border-t border-gray-200">
                    <h4 class="text-base font-medium text-gray-900 mb-4">Leave Balances</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-green-50 border border-green-200 p-4 rounded-lg text-center">
                            <div class="text-2xl font-bold text-green-600">
                                {{ $employee->vacation_leave_balance ?? 0 }}
                            </div>
                            <div class="text-sm text-green-700">Vacation Leave</div>
                        </div>
                        <div class="bg-blue-50 border border-blue-200 p-4 rounded-lg text-center">
                            <div class="text-2xl font-bold text-blue-600">
                                {{ $employee->sick_leave_balance ?? 0 }}
                            </div>
                            <div class="text-sm text-blue-700">Sick Leave</div>
                        </div>
                        <div class="bg-red-50 border border-red-200 p-4 rounded-lg text-center">
                            <div class="text-2xl font-bold text-red-600">
                                {{ $employee->emergency_leave_balance ?? 0 }}
                            </div>
                            <div class="text-sm text-red-700">Emergency Leave</div>
                        </div>
                    </div>
                </div>

                <!-- Allowances -->
                @if($employee->allowances && is_array($employee->allowances) && count($employee->allowances) > 0)
                    <div class="mt-8 pt-8 border-t border-gray-200">
                        <h4 class="text-base font-medium text-gray-900 mb-4">Allowances</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($employee->allowances as $allowance)
                                <div class="bg-purple-50 border border-purple-200 p-4 rounded-lg">
                                    <p class="text-sm font-medium text-purple-900">{{ $allowance['type'] ?? 'Allowance' }}</p>
                                    <p class="text-lg font-bold text-purple-600">
                                        @if(isset($allowance['amount']))
                                            ₱{{ number_format($allowance['amount'], 2) }}
                                        @else
                                            N/A
                                        @endif
                                    </p>
                                    @if(isset($allowance['frequency']))
                                        <p class="text-xs text-purple-700">{{ $allowance['frequency'] }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Documents Tab -->
            <div x-show="activeTab === 'documents'" x-transition>
                <h3 class="text-lg font-medium text-gray-900 mb-6">Documents</h3>

                @if($employee->documents && is_array($employee->documents) && count($employee->documents) > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($employee->documents as $document)
                            <div class="bg-white border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                <div class="flex items-start space-x-3">
                                    <div class="flex-shrink-0">
                                        <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">
                                            {{ $document['name'] ?? 'Document' }}
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            {{ $document['type'] ?? 'File' }}
                                        </p>
                                        @if(isset($document['description']) && $document['description'])
                                            <p class="text-xs text-gray-400 mt-1">{{ $document['description'] }}</p>
                                        @endif
                                        @if(isset($document['file_path']) && $document['file_path'])
                                            <a href="{{ asset('storage/' . $document['file_path']) }}"
                                               target="_blank"
                                               class="text-xs text-blue-600 hover:text-blue-800 mt-2 inline-block">
                                                View Document
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="text-gray-400 text-4xl mb-4">
                            <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No Documents</h3>
                        <p class="text-gray-600">No documents have been uploaded for this employee.</p>
                    </div>
                @endif
            </div>

            <!-- Audit Trail Tab -->
            <div x-show="activeTab === 'audit'" x-transition>
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-medium text-gray-900">Audit Trail</h3>
                    <a href="{{ route('audit-trails.show', ['modelType' => 'App%5CModels%5CEmployee', 'modelId' => $employee->id]) }}"
                       class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                        View Full Audit Trail →
                    </a>
                </div>

                @php
                    $recentAudits = $employee->auditTrails()->latest()->take(10)->get();
                @endphp

                @if($recentAudits->count() > 0)
                    <div class="flow-root">
                        <ul class="-mb-8">
                            @foreach($recentAudits as $index => $trail)
                                <li>
                                    <div class="relative pb-8">
                                        @if(!$loop->last)
                                            <span class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                        @endif
                                        <div class="relative flex items-start space-x-3">
                                            <div class="relative">
                                                <div class="h-10 w-10 rounded-full flex items-center justify-center ring-8 ring-white
                                                            @if($trail->action === 'created') bg-green-500
                                                            @elseif($trail->action === 'updated') bg-blue-500
                                                            @elseif($trail->action === 'deleted') bg-red-500
                                                            @else bg-gray-500 @endif">
                                                    @if($trail->action === 'created')
                                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                        </svg>
                                                    @elseif($trail->action === 'updated')
                                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                        </svg>
                                                    @elseif($trail->action === 'deleted')
                                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                    @else
                                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <div>
                                                    <div class="text-sm">
                                                        <span class="font-medium text-gray-900">{{ $trail->user_name }}</span>
                                                        <span class="text-gray-600">{{ $trail->description }}</span>
                                                    </div>
                                                    <p class="mt-0.5 text-sm text-gray-500">
                                                        {{ $trail->created_at->format('M j, Y \a\t g:i A') }}
                                                        @if($trail->ip_address)
                                                            • {{ $trail->ip_address }}
                                                        @endif
                                                    </p>
                                                </div>

                                                @if(!empty($trail->changed_fields) && count($trail->changed_fields) <= 3)
                                                    <div class="mt-2 text-sm text-gray-600">
                                                        <span class="text-gray-500">Changed:</span>
                                                        {{ implode(', ', array_keys($trail->changed_fields)) }}
                                                    </div>
                                                @elseif(!empty($trail->changed_fields) && count($trail->changed_fields) > 3)
                                                    <div class="mt-2 text-sm text-gray-600">
                                                        <span class="text-gray-500">Changed:</span>
                                                        {{ implode(', ', array_slice(array_keys($trail->changed_fields), 0, 3)) }}
                                                        <span class="text-gray-400">and {{ count($trail->changed_fields) - 3 }} more</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="text-gray-400 text-4xl mb-4">
                            <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No Audit Trail</h3>
                        <p class="text-gray-600">No activities have been recorded for this employee yet.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection