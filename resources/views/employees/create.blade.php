@extends('layouts.dashboard')

@section('title', 'Add Employee')

@section('content')
<div class="min-h-screen bg-gray-50/30">
    <!-- Enhanced Header with Breadcrumb -->
    <div class="bg-white border-b border-gray-200 mb-8">
        <div class="px-6 py-6">
            <div class="flex items-center space-x-4 mb-4">
                <a href="{{ route('employees.index') }}"
                   class="inline-flex items-center justify-center w-10 h-10 rounded-lg border border-gray-200 bg-white hover:bg-gray-50 transition-colors group">
                    <svg class="w-5 h-5 text-gray-500 group-hover:text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div class="flex-1">
                    <nav class="flex items-center space-x-2 text-sm text-gray-500 mb-2">
                        <a href="{{ route('dashboard') }}" class="hover:text-gray-700">Dashboard</a>
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <a href="{{ route('employees.index') }}" class="hover:text-gray-700">Employees</a>
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-gray-900 font-medium">Add Employee</span>
                    </nav>
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Add New Employee</h1>
                            <p class="text-gray-600 mt-1">Create a comprehensive employee record with all required information</p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                                Required fields marked with *
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Container with Enhanced Design -->
    <div class="max-w-7xl mx-auto px-6 pb-12">
        <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf

            <!-- Form Progress Indicator -->
            <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-semibold text-gray-900">Form Progress</h3>
                    <span class="text-xs text-gray-500">Complete all required sections</span>
                </div>
                <div class="flex space-x-3">
                    <div class="flex-1 bg-gray-200 rounded-full h-2">
                        <div class="bg-emerald-500 h-2 rounded-full w-0 transition-all duration-300" id="progress-bar"></div>
                    </div>
                    <span class="text-xs text-gray-500 font-medium">0%</span>
                </div>
            </div>

            <!-- Personal Information Section -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="border-b border-gray-200 bg-gray-50/50 px-6 py-4">
                    <div class="flex items-center space-x-3">
                        <div class="flex items-center justify-center w-8 h-8 bg-emerald-100 rounded-lg">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Personal Information</h2>
                            <p class="text-sm text-gray-500">Basic personal details and identification</p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-900">
                                First Name <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="text" name="first_name" required
                                       class="w-full h-10 px-3 text-sm border border-gray-300 rounded-lg bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                       placeholder="Enter first name"
                                       value="{{ old('first_name') }}">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                            </div>
                            @error('first_name')
                                <p class="text-xs text-red-600 flex items-center mt-1">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-900">Middle Name</label>
                            <input type="text" name="middle_name"
                                   class="w-full h-10 px-3 text-sm border border-gray-300 rounded-lg bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                   placeholder="Enter middle name (optional)"
                                   value="{{ old('middle_name') }}">
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-900">
                                Last Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="last_name" required
                                   class="w-full h-10 px-3 text-sm border border-gray-300 rounded-lg bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                   placeholder="Enter last name"
                                   value="{{ old('last_name') }}">
                            @error('last_name')
                                <p class="text-xs text-red-600 flex items-center mt-1">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-900">
                                Birth Date <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="date" name="birth_date" required
                                       class="w-full h-10 px-3 text-sm border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                       value="{{ old('birth_date') }}">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-900">
                                Gender <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <select name="gender" required
                                        class="w-full h-10 px-3 text-sm border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors appearance-none">
                                    <option value="">Select Gender</option>
                                    <option value="Male" {{ old('gender', 'Male') === 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender') === 'Female' ? 'selected' : '' }}>Female</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-900">
                                Civil Status <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <select name="civil_status" required
                                        class="w-full h-10 px-3 text-sm border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors appearance-none">
                                    <option value="">Select Civil Status</option>
                                    <option value="Single" {{ old('civil_status', 'Single') === 'Single' ? 'selected' : '' }}>Single</option>
                                    <option value="Married" {{ old('civil_status') === 'Married' ? 'selected' : '' }}>Married</option>
                                    <option value="Divorced" {{ old('civil_status') === 'Divorced' ? 'selected' : '' }}>Divorced</option>
                                    <option value="Widowed" {{ old('civil_status') === 'Widowed' ? 'selected' : '' }}>Widowed</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-900">Suffix</label>
                            <input type="text" name="suffix"
                                   class="w-full h-10 px-3 text-sm border border-gray-300 rounded-lg bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                   placeholder="Jr., Sr., III, etc."
                                   value="{{ old('suffix') }}">
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-900">Maiden Name</label>
                            <input type="text" name="maiden_name"
                                   class="w-full h-10 px-3 text-sm border border-gray-300 rounded-lg bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                   placeholder="Enter maiden name"
                                   value="{{ old('maiden_name') }}">
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-900">Nickname</label>
                            <input type="text" name="nickname"
                                   class="w-full h-10 px-3 text-sm border border-gray-300 rounded-lg bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                   placeholder="Enter nickname"
                                   value="{{ old('nickname') }}">
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-900">Birth Place</label>
                            <input type="text" name="birth_place"
                                   class="w-full h-10 px-3 text-sm border border-gray-300 rounded-lg bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                   placeholder="Enter birth place"
                                   value="{{ old('birth_place') }}">
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-900">Nationality</label>
                            <input type="text" name="nationality"
                                   class="w-full h-10 px-3 text-sm border border-gray-300 rounded-lg bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                   placeholder="Enter nationality"
                                   value="{{ old('nationality', 'Filipino') }}">
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-900">Religion</label>
                            <input type="text" name="religion"
                                   class="w-full h-10 px-3 text-sm border border-gray-300 rounded-lg bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                   placeholder="Enter religion"
                                   value="{{ old('religion') }}">
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-900">Blood Type</label>
                            <div class="relative">
                                <select name="blood_type"
                                        class="w-full h-10 px-3 text-sm border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors appearance-none">
                                    <option value="">Select Blood Type</option>
                                    <option value="A+" {{ old('blood_type') === 'A+' ? 'selected' : '' }}>A+</option>
                                    <option value="A-" {{ old('blood_type') === 'A-' ? 'selected' : '' }}>A-</option>
                                    <option value="B+" {{ old('blood_type') === 'B+' ? 'selected' : '' }}>B+</option>
                                    <option value="B-" {{ old('blood_type') === 'B-' ? 'selected' : '' }}>B-</option>
                                    <option value="AB+" {{ old('blood_type') === 'AB+' ? 'selected' : '' }}>AB+</option>
                                    <option value="AB-" {{ old('blood_type') === 'AB-' ? 'selected' : '' }}>AB-</option>
                                    <option value="O+" {{ old('blood_type') === 'O+' ? 'selected' : '' }}>O+</option>
                                    <option value="O-" {{ old('blood_type') === 'O-' ? 'selected' : '' }}>O-</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-900">Height (cm)</label>
                            <div class="relative">
                                <input type="number" name="height" step="0.01"
                                       class="w-full h-10 px-3 pr-8 text-sm border border-gray-300 rounded-lg bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                       placeholder="0.00"
                                       value="{{ old('height') }}">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <span class="text-gray-400 text-sm">cm</span>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-900">Weight (kg)</label>
                            <div class="relative">
                                <input type="number" name="weight" step="0.01"
                                       class="w-full h-10 px-3 pr-8 text-sm border border-gray-300 rounded-lg bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                       placeholder="0.00"
                                       value="{{ old('weight') }}">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <span class="text-gray-400 text-sm">kg</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Employment Information Section -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="border-b border-gray-200 bg-gray-50/50 px-6 py-4">
                    <div class="flex items-center space-x-3">
                        <div class="flex items-center justify-center w-8 h-8 bg-blue-100 rounded-lg">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6.294a23.946 23.946 0 01-4 2.33M16 6H8m0 0V4a2 2 0 012-2h4a2 2 0 012 2v2M8 6v10a2 2 0 002 2h4a2 2 0 002-2V6"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Employment Information</h2>
                            <p class="text-sm text-gray-500">Job details, department, and work arrangements</p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-900">
                                Employee ID <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="text" name="employee_id" required
                                       class="w-full h-10 px-3 text-sm border border-gray-300 rounded-lg bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                       placeholder="Enter employee ID"
                                       value="{{ old('employee_id', 'EMP001') }}">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V4a2 2 0 012-2h2a2 2 0 012 2v2m-4 0a2 2 0 002 2h2a2 2 0 002-2m-4 0a2 2 0 00-2-2h-2a2 2 0 00-2 2"></path>
                                    </svg>
                                </div>
                            </div>
                            @error('employee_id')
                                <p class="text-xs text-red-600 flex items-center mt-1">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-900">Badge Number</label>
                            <div class="relative">
                                <input type="text" name="badge_number"
                                       class="w-full h-10 px-3 text-sm border border-gray-300 rounded-lg bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                       placeholder="Enter badge number"
                                       value="{{ old('badge_number') }}">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-900">Biometric ID</label>
                            <div class="relative">
                                <input type="text" name="biometric_id"
                                       class="w-full h-10 px-3 text-sm border border-gray-300 rounded-lg bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                       placeholder="Enter biometric ID"
                                       value="{{ old('biometric_id') }}">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-900">
                                Department <span class="text-red-500">*</span>
                            </label>
                            <div class="flex space-x-2">
                                <div class="relative flex-1">
                                    <select name="department_id" required
                                            class="w-full h-10 px-3 text-sm border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors appearance-none">
                                        <option value="">Select Department</option>
                                        @foreach($departments as $department)
                                            <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                                {{ $department->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                                <button type="button" onclick="openQuickAddModal('department')"
                                        class="inline-flex items-center justify-center w-10 h-10 border border-gray-300 rounded-lg bg-white text-gray-500 hover:bg-gray-50 hover:text-emerald-600 transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-900">
                                Position <span class="text-red-500">*</span>
                            </label>
                            <div class="flex space-x-2">
                                <div class="relative flex-1">
                                    <select name="position_id" required
                                            class="w-full h-10 px-3 text-sm border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors appearance-none">
                                        <option value="">Select Position</option>
                                        @foreach($positions as $position)
                                            <option value="{{ $position->id }}" {{ old('position_id') == $position->id ? 'selected' : '' }}>
                                                {{ $position->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                                <button type="button" onclick="openQuickAddModal('position')"
                                        class="inline-flex items-center justify-center w-10 h-10 border border-gray-300 rounded-lg bg-white text-gray-500 hover:bg-gray-50 hover:text-emerald-600 transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-900">
                                Job Grade <span class="text-red-500">*</span>
                            </label>
                            <div class="flex space-x-2">
                                <div class="relative flex-1">
                                    <select name="job_grade_id" required
                                            class="w-full h-10 px-3 text-sm border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors appearance-none">
                                        <option value="">Select Job Grade</option>
                                        @foreach($jobGrades as $grade)
                                            <option value="{{ $grade->id }}" {{ old('job_grade_id') == $grade->id ? 'selected' : '' }}>
                                                {{ $grade->name }} (₱{{ number_format($grade->min_salary) }} - ₱{{ number_format($grade->max_salary) }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                                <button type="button" onclick="openQuickAddModal('jobgrade')"
                                        class="inline-flex items-center justify-center w-10 h-10 border border-gray-300 rounded-lg bg-white text-gray-500 hover:bg-gray-50 hover:text-emerald-600 transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-900">
                                Branch/Office <span class="text-red-500">*</span>
                            </label>
                            <div class="flex space-x-2">
                                <div class="relative flex-1">
                                    <select name="branch_id" required
                                            class="w-full h-10 px-3 text-sm border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors appearance-none">
                                        <option value="">Select Branch</option>
                                        @foreach($branches as $branch)
                                            <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                                {{ $branch->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                                <button type="button" onclick="openQuickAddModal('branch')"
                                        class="inline-flex items-center justify-center w-10 h-10 border border-gray-300 rounded-lg bg-white text-gray-500 hover:bg-gray-50 hover:text-emerald-600 transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-900">
                                Employment Status <span class="text-red-500">*</span>
                            </label>
                            <div class="flex items-center space-x-2">
                                <div class="relative flex-1">
                                    <select name="employment_status" required
                                            class="w-full h-10 px-3 text-sm border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors appearance-none">
                                        <option value="">Select Status</option>
                                        @foreach($employmentStatuses as $status)
                                            <option value="{{ $status->code }}" {{ old('employment_status', 'PROB') === $status->code ? 'selected' : '' }}>
                                                {{ $status->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                                <button type="button" onclick="openQuickAddModal('employmentStatus')"
                                        class="inline-flex items-center justify-center w-10 h-10 border border-gray-300 rounded-lg bg-white text-gray-500 hover:bg-gray-50 hover:text-emerald-600 transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-900">
                                Hire Date <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="date" name="hire_date" required
                                       class="w-full h-10 px-3 text-sm border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                       value="{{ old('hire_date', '2024-01-15') }}">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-900">
                                Basic Salary <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="text" name="basic_salary" required
                                       class="w-full h-10 px-3 pl-8 text-sm border border-gray-300 rounded-lg bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors salary-input"
                                       placeholder="0.00"
                                       data-mask="currency"
                                       value="{{ old('basic_salary') }}">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <span class="text-gray-400 text-sm">₱</span>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-900">Work Schedule</label>
                            <div class="flex space-x-3">
                                <div class="flex-1 relative">
                                    <select name="work_schedule_id"
                                            class="w-full h-10 px-3 text-sm border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors appearance-none">
                                        <option value="">Select Schedule (Optional)</option>
                                        @foreach($workSchedules as $schedule)
                                            <option value="{{ $schedule->id }}" {{ old('work_schedule_id') == $schedule->id ? 'selected' : '' }}>
                                                {{ $schedule->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                                <button type="button" onclick="openQuickAddModal('workSchedule')"
                                        class="inline-flex items-center justify-center w-10 h-10 border border-gray-300 rounded-lg bg-white text-gray-500 hover:bg-gray-50 hover:text-emerald-600 transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-900">Original Hire Date</label>
                            <div class="relative">
                                <input type="date" name="original_hire_date"
                                       class="w-full h-10 px-3 text-sm border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                       value="{{ old('original_hire_date') }}">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-900">Probation End Date</label>
                            <div class="relative">
                                <input type="date" name="probation_end_date"
                                       class="w-full h-10 px-3 text-sm border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                       value="{{ old('probation_end_date') }}">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-900">Regularization Date</label>
                            <div class="relative">
                                <input type="date" name="regularization_date"
                                       class="w-full h-10 px-3 text-sm border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                       value="{{ old('regularization_date') }}">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-900">Last Promotion Date</label>
                            <div class="relative">
                                <input type="date" name="last_promotion_date"
                                       class="w-full h-10 px-3 text-sm border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                       value="{{ old('last_promotion_date') }}">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-900">Resignation Date</label>
                            <div class="relative">
                                <input type="date" name="resignation_date"
                                       class="w-full h-10 px-3 text-sm border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                       value="{{ old('resignation_date') }}">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-900">Termination Date</label>
                            <div class="relative">
                                <input type="date" name="termination_date"
                                       class="w-full h-10 px-3 text-sm border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                       value="{{ old('termination_date') }}">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-900">Retirement Date</label>
                            <div class="relative">
                                <input type="date" name="retirement_date"
                                       class="w-full h-10 px-3 text-sm border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                       value="{{ old('retirement_date') }}">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Employment Type -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-900">Employment Type</label>
                            <div class="relative">
                                <select name="employment_type"
                                        class="w-full h-10 px-3 text-sm border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors appearance-none">
                                    <option value="">Select Employment Type</option>
                                    <option value="Full-time" {{ old('employment_type') === 'Full-time' ? 'selected' : '' }}>Full-time</option>
                                    <option value="Part-time" {{ old('employment_type') === 'Part-time' ? 'selected' : '' }}>Part-time</option>
                                    <option value="Contractual" {{ old('employment_type') === 'Contractual' ? 'selected' : '' }}>Contractual</option>
                                    <option value="Project-based" {{ old('employment_type') === 'Project-based' ? 'selected' : '' }}>Project-based</option>
                                    <option value="Intern" {{ old('employment_type') === 'Intern' ? 'selected' : '' }}>Intern</option>
                                    <option value="Consultant" {{ old('employment_type') === 'Consultant' ? 'selected' : '' }}>Consultant</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Pay Frequency -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-900">Pay Frequency</label>
                            <div class="relative">
                                <select name="pay_frequency"
                                        class="w-full h-10 px-3 text-sm border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors appearance-none">
                                    <option value="">Select Pay Frequency</option>
                                    <option value="Monthly" {{ old('pay_frequency') === 'Monthly' ? 'selected' : '' }}>Monthly</option>
                                    <option value="Semi-monthly" {{ old('pay_frequency') === 'Semi-monthly' ? 'selected' : '' }}>Semi-monthly</option>
                                    <option value="Bi-weekly" {{ old('pay_frequency') === 'Bi-weekly' ? 'selected' : '' }}>Bi-weekly</option>
                                    <option value="Weekly" {{ old('pay_frequency') === 'Weekly' ? 'selected' : '' }}>Weekly</option>
                                    <option value="Daily" {{ old('pay_frequency') === 'Daily' ? 'selected' : '' }}>Daily</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Cost Center -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-900">Cost Center</label>
                            <div class="flex items-center space-x-2">
                                <div class="relative flex-1">
                                    <select name="cost_center_id"
                                            class="w-full h-10 px-3 text-sm border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors appearance-none">
                                        <option value="">Select Cost Center</option>
                                        @foreach($costCenters as $center)
                                            <option value="{{ $center->id }}" {{ old('cost_center_id') == $center->id ? 'selected' : '' }}>
                                                {{ $center->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                                <button type="button" onclick="openQuickAddModal('costCenter')"
                                        class="inline-flex items-center justify-center w-10 h-10 border border-gray-300 rounded-lg bg-white text-gray-500 hover:bg-gray-50 hover:text-emerald-600 transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Immediate Supervisor -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-900">Immediate Supervisor</label>
                            <div class="relative">
                                <input type="text" name="immediate_supervisor_id"
                                       class="w-full h-10 px-3 text-sm border border-gray-300 rounded-lg bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                       placeholder="Enter supervisor ID/name"
                                       value="{{ old('immediate_supervisor_id') }}">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Is Exempt (Checkbox) -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-900">Exempt Status</label>
                            <div class="flex items-center space-x-3">
                                <div class="relative flex items-start">
                                    <div class="flex items-center h-5">
                                        <input type="checkbox" name="is_exempt" value="1"
                                               class="h-4 w-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500 focus:ring-2"
                                               {{ old('is_exempt') ? 'checked' : '' }}>
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label class="text-gray-700">Exempt from overtime</label>
                                        <p class="text-gray-500 text-xs">Check if employee is exempt from overtime pay regulations</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Information Section -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="border-b border-gray-200 bg-gray-50/50 px-6 py-4">
                    <div class="flex items-center space-x-3">
                        <div class="flex items-center justify-center w-8 h-8 bg-purple-100 rounded-lg">
                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Contact Information</h2>
                            <p class="text-sm text-gray-500">Communication details and addresses</p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-900">Contact Numbers</label>
                            <div class="relative">
                                <textarea name="contact_numbers" rows="3"
                                          class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors resize-vertical"
                                          placeholder='["Mobile: +63-xxx-xxxx", "Landline: xxx-xxxx"]'>{{ old('contact_numbers') }}</textarea>
                                <div class="absolute top-3 right-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                                Enter as JSON array format
                            </p>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-900">Email Addresses</label>
                            <div class="relative">
                                <textarea name="email_addresses" rows="3"
                                          class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors resize-vertical"
                                          placeholder='["personal@email.com", "work@email.com"]'>{{ old('email_addresses') }}</textarea>
                                <div class="absolute top-3 right-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                                Enter as JSON array format
                            </p>
                        </div>

                        <div class="md:col-span-2 space-y-2">
                            <label class="block text-sm font-medium text-gray-900">Address</label>
                            <div class="relative">
                                <textarea name="addresses" rows="4"
                                          class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors resize-vertical"
                                          placeholder='[{"type": "Home", "address": "Full Address", "city": "City", "province": "Province"}]'>{{ old('addresses') }}</textarea>
                                <div class="absolute top-3 right-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                                Enter as JSON array format
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Government IDs Section -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="border-b border-gray-200 bg-gray-50/50 px-6 py-4">
                    <div class="flex items-center space-x-3">
                        <div class="flex items-center justify-center w-8 h-8 bg-amber-100 rounded-lg">
                            <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Government IDs</h2>
                            <p class="text-sm text-gray-500">Philippine government identification numbers</p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-900">SSS Number</label>
                            <div class="relative">
                                <input type="text" name="sss_number" id="sss_number"
                                       class="w-full h-10 px-3 text-sm border border-gray-300 rounded-lg bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                       placeholder="XX-XXXXXXX-X"
                                       value="{{ old('sss_number') }}"
                                       maxlength="12"
                                       oninput="maskSSS(this)">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V4a2 2 0 012-2h2a2 2 0 012 2v2m-4 0a2 2 0 002 2h2a2 2 0 002-2m-4 0a2 2 0 00-2-2h-2a2 2 0 00-2 2"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-900">TIN</label>
                            <div class="relative">
                                <input type="text" name="tin" id="tin"
                                       class="w-full h-10 px-3 text-sm border border-gray-300 rounded-lg bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                       placeholder="XXX-XXX-XXX-XXX"
                                       value="{{ old('tin') }}"
                                       maxlength="15"
                                       oninput="maskTIN(this)">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V4a2 2 0 012-2h2a2 2 0 012 2v2m-4 0a2 2 0 002 2h2a2 2 0 002-2m-4 0a2 2 0 00-2-2h-2a2 2 0 00-2 2"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-900">PhilHealth Number</label>
                            <div class="relative">
                                <input type="text" name="philhealth_number" id="philhealth_number"
                                       class="w-full h-10 px-3 text-sm border border-gray-300 rounded-lg bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                       placeholder="XX-XXXXXXXXX-X"
                                       value="{{ old('philhealth_number') }}"
                                       maxlength="14"
                                       oninput="maskPhilHealth(this)">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-900">Pag-IBIG Number</label>
                            <div class="relative">
                                <input type="text" name="pagibig_number" id="pagibig_number"
                                       class="w-full h-10 px-3 text-sm border border-gray-300 rounded-lg bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                       placeholder="XXXX-XXXX-XXXX"
                                       value="{{ old('pagibig_number') }}"
                                       maxlength="14"
                                       oninput="maskPagIBIG(this)">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Salary & Compensation Section -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="border-b border-gray-200 bg-gray-50/50 px-6 py-4">
                    <div class="flex items-center space-x-3">
                        <div class="flex items-center justify-center w-8 h-8 bg-green-100 rounded-lg">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Salary & Compensation</h2>
                            <p class="text-sm text-gray-500">Additional compensation and tax information</p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-900">Daily Rate</label>
                            <div class="relative">
                                <input type="number" name="daily_rate" step="0.01"
                                       class="w-full h-10 px-3 pl-8 text-sm border border-gray-300 rounded-lg bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                       placeholder="0.00"
                                       value="{{ old('daily_rate') }}">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <span class="text-gray-400 text-sm">₱</span>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-900">Hourly Rate</label>
                            <div class="relative">
                                <input type="number" name="hourly_rate" step="0.01"
                                       class="w-full h-10 px-3 pl-8 text-sm border border-gray-300 rounded-lg bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                       placeholder="0.00"
                                       value="{{ old('hourly_rate') }}">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <span class="text-gray-400 text-sm">₱</span>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-900">Tax Status</label>
                            <div class="relative">
                                <select name="tax_status"
                                        class="w-full h-10 px-3 text-sm border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors appearance-none">
                                    <option value="">Select Tax Status</option>
                                    <option value="S" {{ old('tax_status') === 'S' ? 'selected' : '' }}>S - Single</option>
                                    <option value="ME" {{ old('tax_status') === 'ME' ? 'selected' : '' }}>ME - Married</option>
                                    <option value="S1" {{ old('tax_status') === 'S1' ? 'selected' : '' }}>S1 - Single with 1 dependent</option>
                                    <option value="ME1" {{ old('tax_status') === 'ME1' ? 'selected' : '' }}>ME1 - Married with 1 dependent</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-900">Tax Shield</label>
                            <div class="relative">
                                <input type="number" name="tax_shield" step="0.01"
                                       class="w-full h-10 px-3 pl-8 text-sm border border-gray-300 rounded-lg bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                       placeholder="0.00"
                                       value="{{ old('tax_shield') }}">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <span class="text-gray-400 text-sm">₱</span>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <label class="block text-sm font-medium text-gray-900">Allowances</label>
                                <button type="button" onclick="addAllowance()" class="inline-flex items-center px-3 py-1 text-xs font-medium text-emerald-700 bg-emerald-100 border border-emerald-300 rounded-md hover:bg-emerald-200 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Add Allowance
                                </button>
                            </div>
                            <div id="allowancesContainer" class="space-y-3">
                                <div class="flex items-center space-x-3 allowance-row bg-gray-50 p-3 rounded-lg">
                                    <div class="flex-1">
                                        <input type="text" name="allowances[0][type]"
                                               class="w-full h-9 px-3 text-sm border border-gray-300 rounded-md bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                               placeholder="e.g., Transportation, Meal, Housing">
                                    </div>
                                    <div class="flex-1 relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 text-sm">₱</span>
                                        </div>
                                        <input type="number" name="allowances[0][amount]" step="0.01" min="0"
                                               class="w-full h-9 pl-8 pr-3 text-sm border border-gray-300 rounded-md bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                               placeholder="0.00">
                                    </div>
                                    <button type="button" onclick="removeAllowance(this)" class="flex-shrink-0 p-2 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-md transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <div class="flex items-center space-x-2">
                                <input type="hidden" name="is_minimum_wage" value="0">
                                <input type="checkbox" name="is_minimum_wage" value="1" {{ old('is_minimum_wage') ? 'checked' : '' }}
                                       class="w-4 h-4 text-emerald-600 bg-white border-gray-300 rounded focus:ring-emerald-500 focus:ring-2">
                                <label class="text-sm font-medium text-gray-900">Is Minimum Wage</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Work Arrangements & Leave Section -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="border-b border-gray-200 bg-gray-50/50 px-6 py-4">
                    <div class="flex items-center space-x-3">
                        <div class="flex items-center justify-center w-8 h-8 bg-indigo-100 rounded-lg">
                            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Work Arrangements & Leave</h2>
                            <p class="text-sm text-gray-500">Work setup and leave balances</p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div class="space-y-2">
                            <div class="flex items-center space-x-2">
                                <input type="hidden" name="is_flexible_time" value="0">
                                <input type="checkbox" name="is_flexible_time" value="1" {{ old('is_flexible_time') ? 'checked' : '' }}
                                       class="w-4 h-4 text-emerald-600 bg-white border-gray-300 rounded focus:ring-emerald-500 focus:ring-2">
                                <label class="text-sm font-medium text-gray-900">Flexible Time</label>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <div class="flex items-center space-x-2">
                                <input type="hidden" name="is_field_work" value="0">
                                <input type="checkbox" name="is_field_work" value="1" {{ old('is_field_work') ? 'checked' : '' }}
                                       class="w-4 h-4 text-emerald-600 bg-white border-gray-300 rounded focus:ring-emerald-500 focus:ring-2">
                                <label class="text-sm font-medium text-gray-900">Field Work</label>
                            </div>
                        </div>


                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-900">Vacation Leave Balance</label>
                            <div class="relative">
                                <input type="number" name="vacation_leave_balance" step="0.01"
                                       class="w-full h-10 px-3 pr-12 text-sm border border-gray-300 rounded-lg bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                       placeholder="0.00"
                                       value="{{ old('vacation_leave_balance', '15.00') }}">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <span class="text-gray-400 text-sm">days</span>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-900">Sick Leave Balance</label>
                            <div class="relative">
                                <input type="number" name="sick_leave_balance" step="0.01"
                                       class="w-full h-10 px-3 pr-12 text-sm border border-gray-300 rounded-lg bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                       placeholder="0.00"
                                       value="{{ old('sick_leave_balance', '15.00') }}">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <span class="text-gray-400 text-sm">days</span>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-900">Emergency Leave Balance</label>
                            <div class="relative">
                                <input type="number" name="emergency_leave_balance" step="0.01"
                                       class="w-full h-10 px-3 pr-12 text-sm border border-gray-300 rounded-lg bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                       placeholder="0.00"
                                       value="{{ old('emergency_leave_balance', '3.00') }}">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <span class="text-gray-400 text-sm">days</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Documents & IDs Section -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="border-b border-gray-200 bg-gray-50/50 px-6 py-4">
                    <div class="flex items-center space-x-3">
                        <div class="flex items-center justify-center w-8 h-8 bg-red-100 rounded-lg">
                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Documents & IDs</h2>
                            <p class="text-sm text-gray-500">Additional identification and documents</p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-900">Passport Number</label>
                            <input type="text" name="passport_number"
                                   class="w-full h-10 px-3 text-sm border border-gray-300 rounded-lg bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                   placeholder="Enter passport number"
                                   value="{{ old('passport_number') }}">
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-900">Passport Expiry</label>
                            <div class="relative">
                                <input type="date" name="passport_expiry"
                                       class="w-full h-10 px-3 text-sm border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                       value="{{ old('passport_expiry') }}">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-900">Driver's License</label>
                            <input type="text" name="drivers_license"
                                   class="w-full h-10 px-3 text-sm border border-gray-300 rounded-lg bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                   placeholder="Enter driver's license number"
                                   value="{{ old('drivers_license') }}">
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-900">License Expiry</label>
                            <div class="relative">
                                <input type="date" name="license_expiry"
                                       class="w-full h-10 px-3 text-sm border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                       value="{{ old('license_expiry') }}">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-900">Voter's ID</label>
                            <input type="text" name="voters_id"
                                   class="w-full h-10 px-3 text-sm border border-gray-300 rounded-lg bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                   placeholder="Enter voter's ID number"
                                   value="{{ old('voters_id') }}">
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-900">Employee Photo</label>
                            <div class="flex items-start space-x-6">
                                <!-- Photo Preview Area -->
                                <div class="flex-shrink-0">
                                    <div class="relative group">
                                        <div id="photoPreview" class="w-32 h-32 rounded-xl overflow-hidden border-2 border-gray-200 shadow-sm hidden">
                                            <img id="photoImage" src="" alt="Employee Photo" class="w-full h-full object-cover">
                                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all duration-200 flex items-center justify-center">
                                                <button type="button" onclick="removePhoto()" class="opacity-0 group-hover:opacity-100 transition-opacity duration-200 bg-red-500 hover:bg-red-600 text-white rounded-full p-2 shadow-lg">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                        <div id="photoPlaceholder" class="w-32 h-32 border-2 border-dashed border-gray-300 rounded-xl flex flex-col items-center justify-center bg-gradient-to-br from-gray-50 to-gray-100 hover:from-emerald-50 hover:to-emerald-100 hover:border-emerald-300 transition-all duration-200 cursor-pointer" onclick="document.getElementById('photoInput').click()">
                                            <div class="text-center">
                                                <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                </svg>
                                                <p class="text-xs text-gray-500 font-medium">Add Photo</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Upload Area -->
                                <div class="flex-1 space-y-4">
                                    <div class="border-2 border-dashed border-gray-300 rounded-xl px-6 py-8 text-center hover:border-emerald-400 hover:bg-emerald-50/30 transition-all duration-200" id="photoDropZone">
                                        <div class="mx-auto">
                                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <p class="text-lg font-medium text-gray-900 mb-1">Upload employee photo</p>
                                            <p class="text-sm text-gray-500 mb-4">Drag and drop your image here, or click to browse</p>

                                            <input type="file" name="photo" id="photoInput" accept="image/*" class="hidden" onchange="handlePhotoPreview(this)">

                                            <button type="button" onclick="document.getElementById('photoInput').click()" class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 shadow-sm">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                                </svg>
                                                Choose File
                                            </button>
                                        </div>
                                    </div>

                                    <!-- File Info -->
                                    <div class="text-xs text-gray-500 space-y-1">
                                        <div class="flex items-center space-x-4">
                                            <span class="flex items-center">
                                                <svg class="w-3 h-3 mr-1 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                </svg>
                                                JPG, PNG, GIF
                                            </span>
                                            <span class="flex items-center">
                                                <svg class="w-3 h-3 mr-1 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                </svg>
                                                Max 5MB
                                            </span>
                                            <span class="flex items-center">
                                                <svg class="w-3 h-3 mr-1 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                </svg>
                                                Square 400x400px recommended
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="md:col-span-3 space-y-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <label class="block text-sm font-medium text-gray-900">Employee Documents</label>
                                    <p class="text-xs text-gray-500 mt-1">Upload important documents like resume, certificates, contracts, etc.</p>
                                </div>
                                <button type="button" onclick="addDocumentUpload()" class="inline-flex items-center px-4 py-2 text-sm font-medium text-emerald-700 bg-emerald-100 border border-emerald-300 rounded-lg hover:bg-emerald-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Add Document
                                </button>
                            </div>

                            <!-- Document Upload Container -->
                            <div id="documentsContainer" class="space-y-4">
                                <!-- Initial Document Upload Row -->
                                <div class="document-upload-row bg-gradient-to-r from-gray-50 to-gray-100 border border-gray-200 rounded-xl p-6">
                                    <div class="space-y-4">
                                        <!-- Document Type and File Upload Row -->
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-xs font-medium text-gray-700 mb-2">Document Type</label>
                                                <select name="documents[0][type]" class="w-full h-10 px-3 text-sm border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                                    <option value="">Select document type</option>
                                                    <option value="resume">Resume/CV</option>
                                                    <option value="diploma">Diploma/Certificate</option>
                                                    <option value="transcript">Transcript of Records</option>
                                                    <option value="nbi_clearance">NBI Clearance</option>
                                                    <option value="police_clearance">Police Clearance</option>
                                                    <option value="medical_certificate">Medical Certificate</option>
                                                    <option value="employment_contract">Employment Contract</option>
                                                    <option value="job_offer">Job Offer Letter</option>
                                                    <option value="reference_letter">Reference Letter</option>
                                                    <option value="birth_certificate">Birth Certificate</option>
                                                    <option value="marriage_certificate">Marriage Certificate</option>
                                                    <option value="tor">Transcript of Records</option>
                                                    <option value="license">Professional License</option>
                                                    <option value="training_certificate">Training Certificate</option>
                                                    <option value="other">Other</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-xs font-medium text-gray-700 mb-2">Custom Type (if Other)</label>
                                                <input type="text" name="documents[0][custom_type]"
                                                       class="w-full h-10 px-3 text-sm border border-gray-300 rounded-lg bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                                       placeholder="Specify document type">
                                            </div>
                                        </div>

                                        <!-- File Upload Area -->
                                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-emerald-400 hover:bg-emerald-50/30 transition-all duration-200 document-drop-zone" data-index="0">
                                            <div class="document-upload-content">
                                                <svg class="w-10 h-10 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                                <p class="text-sm font-medium text-gray-900 mb-1">Upload Document</p>
                                                <p class="text-xs text-gray-500 mb-3">Drag and drop your file here, or click to browse</p>

                                                <input type="file" name="documents[0][file]" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.gif" class="hidden document-file-input" onchange="handleDocumentUpload(this, 0)">

                                                <button type="button" onclick="this.previousElementSibling.click()" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 shadow-sm">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                                    </svg>
                                                    Choose File
                                                </button>
                                            </div>

                                            <!-- File Info Display (Hidden by default) -->
                                            <div class="document-file-info hidden">
                                                <div class="flex items-center justify-center space-x-3">
                                                    <div class="file-icon">
                                                        <svg class="w-8 h-8 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                        </svg>
                                                    </div>
                                                    <div class="flex-1 text-left">
                                                        <p class="text-sm font-medium text-gray-900 file-name"></p>
                                                        <p class="text-xs text-gray-500 file-size"></p>
                                                    </div>
                                                    <button type="button" onclick="removeDocumentFile(this, 0)" class="text-red-500 hover:text-red-700 transition-colors">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Remove Document Button -->
                                        <div class="flex justify-end">
                                            <button type="button" onclick="removeDocumentUpload(this)" class="inline-flex items-center px-3 py-1 text-xs text-red-600 hover:text-red-800 hover:bg-red-50 rounded-md transition-colors">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                                Remove Document
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- File Format Info -->
                            <div class="text-xs text-gray-500 bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <div class="flex items-start space-x-2">
                                    <svg class="w-4 h-4 text-blue-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                    </svg>
                                    <div>
                                        <p class="font-medium text-blue-800 mb-1">Supported file formats:</p>
                                        <div class="space-y-1">
                                            <div class="flex flex-wrap gap-x-4 gap-y-1">
                                                <span class="flex items-center">
                                                    <svg class="w-3 h-3 mr-1 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    Documents: PDF, DOC, DOCX
                                                </span>
                                                <span class="flex items-center">
                                                    <svg class="w-3 h-3 mr-1 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    Images: JPG, PNG, GIF
                                                </span>
                                                <span class="flex items-center">
                                                    <svg class="w-3 h-3 mr-1 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    Max size: 10MB per file
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Health & Emergency Section -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="border-b border-gray-200 bg-gray-50/50 px-6 py-4">
                    <div class="flex items-center space-x-3">
                        <div class="flex items-center justify-center w-8 h-8 bg-pink-100 rounded-lg">
                            <svg class="w-4 h-4 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Health & Emergency</h2>
                            <p class="text-sm text-gray-500">Medical information and emergency contacts</p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <label class="block text-sm font-medium text-gray-900">Emergency Contacts</label>
                                <button type="button" onclick="addEmergencyContact()" class="inline-flex items-center px-3 py-1 text-xs font-medium text-emerald-700 bg-emerald-100 border border-emerald-300 rounded-md hover:bg-emerald-200 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Add Contact
                                </button>
                            </div>
                            <div id="emergencyContactsContainer" class="space-y-4">
                                <div class="emergency-contact-row bg-gray-50 p-4 rounded-lg border border-gray-200">
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                        <div>
                                            <label class="block text-xs font-medium text-gray-700 mb-1">Full Name</label>
                                            <input type="text" name="emergency_contacts[0][name]"
                                                   class="w-full h-9 px-3 text-sm border border-gray-300 rounded-md bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                                   placeholder="e.g., Jane Doe">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-700 mb-1">Relationship</label>
                                            <input type="text" name="emergency_contacts[0][relationship]"
                                                   class="w-full h-9 px-3 text-sm border border-gray-300 rounded-md bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                                   placeholder="e.g., Spouse, Parent, Sibling">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-700 mb-1">Phone Number</label>
                                            <input type="tel" name="emergency_contacts[0][phone]"
                                                   class="w-full h-9 px-3 text-sm border border-gray-300 rounded-md bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 phone-input"
                                                   placeholder="e.g., +63 917 123 4567"
                                                   data-mask="phone"
                                                   pattern="^(\+63|63|0)[0-9]{10}$">
                                        </div>
                                    </div>
                                    <div class="flex justify-end mt-3">
                                        <button type="button" onclick="removeEmergencyContact(this)" class="inline-flex items-center px-2 py-1 text-xs text-red-600 hover:text-red-800 hover:bg-red-50 rounded transition-colors">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Remove
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-900">Medical Conditions</label>
                                <textarea name="medical_conditions" rows="2"
                                          class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors resize-vertical"
                                          placeholder="Enter medical conditions">{{ old('medical_conditions') }}</textarea>
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-900">Allergies</label>
                                <textarea name="allergies" rows="2"
                                          class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors resize-vertical"
                                          placeholder="Enter allergies">{{ old('allergies') }}</textarea>
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-900">Medications</label>
                                <textarea name="medications" rows="2"
                                          class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors resize-vertical"
                                          placeholder="Enter current medications">{{ old('medications') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Information Section -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="border-b border-gray-200 bg-gray-50/50 px-6 py-4">
                    <div class="flex items-center space-x-3">
                        <div class="flex items-center justify-center w-8 h-8 bg-gray-100 rounded-lg">
                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Additional Information</h2>
                            <p class="text-sm text-gray-500">Remarks</p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-900">Remarks</label>
                            <textarea name="remarks" rows="4"
                                      class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors resize-vertical"
                                      placeholder="Enter any additional remarks or notes">{{ old('remarks') }}</textarea>
                        </div>

                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <label class="block text-sm font-medium text-gray-900">Custom Fields</label>
                                <button type="button" onclick="addCustomField()" class="inline-flex items-center px-3 py-1 text-xs font-medium text-emerald-700 bg-emerald-100 border border-emerald-300 rounded-md hover:bg-emerald-200 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Add Field
                                </button>
                            </div>
                            <div id="customFieldsContainer" class="space-y-3">
                                <div class="flex items-center space-x-3 custom-field-row bg-gray-50 p-3 rounded-lg">
                                    <div class="flex-1">
                                        <input type="text" name="custom_fields_keys[]"
                                               class="w-full h-9 px-3 text-sm border border-gray-300 rounded-md bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                               placeholder="Field name (e.g., employee_number, skills)">
                                    </div>
                                    <div class="flex-1">
                                        <input type="text" name="custom_fields_values[]"
                                               class="w-full h-9 px-3 text-sm border border-gray-300 rounded-md bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                               placeholder="Field value">
                                    </div>
                                    <button type="button" onclick="removeCustomField(this)" class="flex-shrink-0 p-2 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-md transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <!-- Hidden Fields -->
        <input type="hidden" name="company_id" value="1">
        <input type="hidden" name="is_active" value="1">

            <!-- Submit Buttons Section -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
                    <div class="text-sm text-gray-600">
                        <p class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Please review all information before submitting
                        </p>
                    </div>
                    <div class="flex space-x-4">
                        <a href="{{ route('employees.index') }}"
                           class="inline-flex items-center px-6 py-2.5 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Cancel
                        </a>
                        <button type="submit"
                                class="inline-flex items-center px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Create Employee
                        </button>
                    </div>
                </div>
            </div>
    </form>
</div>

<!-- Quick Add Modal -->
<div id="quickAddModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-10 mx-auto p-6 border max-w-4xl shadow-lg rounded-md bg-white max-h-[90vh] overflow-y-auto">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900" id="modalTitle">Add New Item</h3>
                <button type="button" onclick="closeQuickAddModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form id="quickAddForm" class="space-y-4">
                <div id="modalFields">
                    <!-- Dynamic fields will be inserted here -->
                </div>

                <div class="flex justify-end space-x-3 pt-4 border-t">
                    <button type="button" onclick="closeQuickAddModal()"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-emerald-600 border border-transparent rounded-md hover:bg-emerald-700">
                        Add Item
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const requiredFields = document.querySelectorAll('input[required], select[required]');
    const progressBar = document.getElementById('progress-bar');
    const progressText = progressBar.parentElement.nextElementSibling;

    function updateProgress() {
        let filledFields = 0;

        requiredFields.forEach(field => {
            if (field.value.trim() !== '') {
                filledFields++;
            }
        });

        const percentage = Math.round((filledFields / requiredFields.length) * 100);
        progressBar.style.width = percentage + '%';
        progressText.textContent = percentage + '%';

        // Update progress bar color based on completion
        if (percentage < 30) {
            progressBar.className = 'bg-red-500 h-2 rounded-full transition-all duration-300';
        } else if (percentage < 70) {
            progressBar.className = 'bg-yellow-500 h-2 rounded-full transition-all duration-300';
        } else {
            progressBar.className = 'bg-emerald-500 h-2 rounded-full transition-all duration-300';
        }
    }

    // Add event listeners to all required fields
    requiredFields.forEach(field => {
        field.addEventListener('input', updateProgress);
        field.addEventListener('change', updateProgress);
    });

    // Initial progress calculation
    updateProgress();
});

// Input mask functions for government IDs
function maskSSS(input) {
    let value = input.value.replace(/\D/g, ''); // Remove non-digits
    if (value.length >= 2) value = value.substring(0,2) + '-' + value.substring(2);
    if (value.length >= 10) value = value.substring(0,10) + '-' + value.substring(10);
    input.value = value.substring(0, 12); // Max length XX-XXXXXXX-X
}

function maskTIN(input) {
    let value = input.value.replace(/\D/g, ''); // Remove non-digits
    if (value.length >= 3) value = value.substring(0,3) + '-' + value.substring(3);
    if (value.length >= 7) value = value.substring(0,7) + '-' + value.substring(7);
    if (value.length >= 11) value = value.substring(0,11) + '-' + value.substring(11);
    input.value = value.substring(0, 15); // Max length XXX-XXX-XXX-XXX
}

function maskPhilHealth(input) {
    let value = input.value.replace(/\D/g, ''); // Remove non-digits
    if (value.length >= 2) value = value.substring(0,2) + '-' + value.substring(2);
    if (value.length >= 12) value = value.substring(0,12) + '-' + value.substring(12);
    input.value = value.substring(0, 14); // Max length XX-XXXXXXXXX-X
}

function maskPagIBIG(input) {
    let value = input.value.replace(/\D/g, ''); // Remove non-digits
    if (value.length >= 4) value = value.substring(0,4) + '-' + value.substring(4);
    if (value.length >= 9) value = value.substring(0,9) + '-' + value.substring(9);
    input.value = value.substring(0, 14); // Max length XXXX-XXXX-XXXX
}

// Enhanced Photo Upload Functions
function handlePhotoPreview(input) {
    const preview = document.getElementById('photoPreview');
    const image = document.getElementById('photoImage');
    const placeholder = document.getElementById('photoPlaceholder');
    const dropZone = document.getElementById('photoDropZone');

    if (input.files && input.files[0]) {
        const file = input.files[0];

        // Check file size (5MB = 5 * 1024 * 1024 bytes)
        if (file.size > 5 * 1024 * 1024) {
            showNotification('File size must be less than 5MB', 'error');
            input.value = '';
            return;
        }

        // Check file type
        if (!file.type.startsWith('image/')) {
            showNotification('Please select a valid image file (JPG, PNG, GIF)', 'error');
            input.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            image.src = e.target.result;
            preview.classList.remove('hidden');
            placeholder.classList.add('hidden');

            // Update drop zone appearance
            dropZone.classList.add('border-emerald-400', 'bg-emerald-50/30');
            dropZone.innerHTML = `
                <div class="text-center">
                    <svg class="w-8 h-8 text-emerald-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <p class="text-sm font-medium text-emerald-700 mb-1">Photo uploaded successfully!</p>
                    <p class="text-xs text-emerald-600">Click to change or remove the current photo</p>
                    <button type="button" onclick="document.getElementById('photoInput').click()" class="mt-2 inline-flex items-center px-3 py-1 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-medium rounded-md transition-colors duration-200">
                        Change Photo
                    </button>
                </div>
            `;

            showNotification('Photo uploaded successfully!', 'success');
        };
        reader.readAsDataURL(file);
    } else {
        resetPhotoUpload();
    }
}

function removePhoto() {
    const input = document.getElementById('photoInput');
    input.value = '';
    resetPhotoUpload();
    showNotification('Photo removed', 'info');
}

function resetPhotoUpload() {
    const preview = document.getElementById('photoPreview');
    const image = document.getElementById('photoImage');
    const placeholder = document.getElementById('photoPlaceholder');
    const dropZone = document.getElementById('photoDropZone');

    preview.classList.add('hidden');
    placeholder.classList.remove('hidden');
    image.src = '';

    // Reset drop zone appearance
    dropZone.classList.remove('border-emerald-400', 'bg-emerald-50/30');
    dropZone.innerHTML = `
        <div class="mx-auto">
            <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <p class="text-lg font-medium text-gray-900 mb-1">Upload employee photo</p>
            <p class="text-sm text-gray-500 mb-4">Drag and drop your image here, or click to browse</p>

            <input type="file" name="photo" id="photoInput" accept="image/*" class="hidden" onchange="handlePhotoPreview(this)">

            <button type="button" onclick="document.getElementById('photoInput').click()" class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                </svg>
                Choose File
            </button>
        </div>
    `;
}

// Drag and Drop functionality
document.addEventListener('DOMContentLoaded', function() {
    const dropZone = document.getElementById('photoDropZone');

    if (dropZone) {
        // Prevent default drag behaviors
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
            document.body.addEventListener(eventName, preventDefaults, false);
        });

        // Highlight drop area when item is dragged over it
        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, unhighlight, false);
        });

        // Handle dropped files
        dropZone.addEventListener('drop', handleDrop, false);

        // Handle click to open file dialog
        dropZone.addEventListener('click', function() {
            document.getElementById('photoInput').click();
        });
    }

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    function highlight(e) {
        dropZone.classList.add('border-emerald-400', 'bg-emerald-50/50');
    }

    function unhighlight(e) {
        dropZone.classList.remove('border-emerald-400', 'bg-emerald-50/50');
    }

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;

        if (files.length > 0) {
            const input = document.getElementById('photoInput');
            input.files = files;
            handlePhotoPreview(input);
        }
    }
});

// Quick Add Modal Functions
function openQuickAddModal(type) {
    const modal = document.getElementById('quickAddModal');
    const modalTitle = document.getElementById('modalTitle');
    const modalFields = document.getElementById('modalFields');

    // Set title and fields based on type
    // Get dropdown data for dependent fields
    function getDepartments() {
        return Array.from(document.querySelectorAll('select[name="department_id"] option')).slice(1).map(opt => `<option value="${opt.value}">${opt.textContent}</option>`).join('');
    }
    function getJobGrades() {
        return Array.from(document.querySelectorAll('select[name="job_grade_id"] option')).slice(1).map(opt => `<option value="${opt.value}">${opt.textContent}</option>`).join('');
    }
    function getBranches() {
        return Array.from(document.querySelectorAll('select[name="branch_id"] option')).slice(1).map(opt => `<option value="${opt.value}">${opt.textContent}</option>`).join('');
    }

    const configs = {
        department: {
            title: 'Add New Department',
            fields: `
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Department Code <span class="text-red-500">*</span></label>
                        <input type="text" name="code" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="e.g., HR, IT">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Level</label>
                        <input type="number" name="level" value="1" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="1">
                    </div>
                </div>
                <input type="hidden" name="company_id" value="1">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Department Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="e.g., Human Resources">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="Department description"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Budget Amount</label>
                        <input type="number" name="budget_amount" step="0.01" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="0.00">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Max Headcount</label>
                        <input type="number" name="max_headcount" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="10">
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" checked class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500">
                    <label class="text-sm font-medium text-gray-700">Active Department</label>
                </div>
            `
        },
        position: {
            title: 'Add New Position',
            fields: `
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Position Code <span class="text-red-500">*</span></label>
                        <input type="text" name="code" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="e.g., DEV001">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Type <span class="text-red-500">*</span></label>
                        <select name="type" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500">
                            <option value="">Select Type</option>
                            <option value="Regular">Regular</option>
                            <option value="Contractual">Contractual</option>
                            <option value="Consultant">Consultant</option>
                            <option value="Intern">Intern</option>
                        </select>
                    </div>
                </div>
                <input type="hidden" name="company_id" value="1">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Position Title <span class="text-red-500">*</span></label>
                    <input type="text" name="title" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="e.g., Software Developer">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Department <span class="text-red-500">*</span></label>
                        <select name="department_id" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500">
                            <option value="">Select Department</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Job Grade <span class="text-red-500">*</span></label>
                        <select name="job_grade_id" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500">
                            <option value="">Select Job Grade</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Level <span class="text-red-500">*</span></label>
                    <select name="level" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        <option value="">Select Level</option>
                        <option value="Executive">Executive</option>
                        <option value="Managerial">Managerial</option>
                        <option value="Supervisory">Supervisory</option>
                        <option value="Rank and File">Rank and File</option>
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Authorized Headcount <span class="text-red-500">*</span></label>
                        <input type="number" name="authorized_headcount" required min="1" value="1" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Current Headcount</label>
                        <input type="number" name="current_headcount" min="0" value="0" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Min Salary</label>
                        <input type="number" name="min_salary" step="0.01" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="0.00">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Max Salary</label>
                        <input type="number" name="max_salary" step="0.01" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="0.00">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="Position description"></textarea>
                </div>
                <div class="grid grid-cols-3 gap-3">
                    <div class="flex items-center space-x-2">
                        <input type="hidden" name="is_exempt" value="0">
                        <input type="checkbox" name="is_exempt" value="1" class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500">
                        <label class="text-sm text-gray-700">Exempt</label>
                    </div>
                    <div class="flex items-center space-x-2">
                        <input type="hidden" name="is_confidential" value="0">
                        <input type="checkbox" name="is_confidential" value="1" class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500">
                        <label class="text-sm text-gray-700">Confidential</label>
                    </div>
                    <div class="flex items-center space-x-2">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" checked class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500">
                        <label class="text-sm text-gray-700">Active</label>
                    </div>
                </div>
            `
        },
        jobgrade: {
            title: 'Add New Job Grade',
            fields: `
                <input type="hidden" name="company_id" value="1">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Grade Code <span class="text-red-500">*</span></label>
                    <input type="text" name="code" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="e.g., SG-34">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Grade Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="e.g., Salary Grade 34">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Level <span class="text-red-500">*</span></label>
                    <input type="number" name="level" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="34">
                </div>
                <div class="grid grid-cols-3 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Min Salary <span class="text-red-500">*</span></label>
                        <input type="number" name="min_salary" required step="0.01" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="130000">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Mid Salary</label>
                        <input type="number" name="mid_salary" step="0.01" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="146250">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Max Salary <span class="text-red-500">*</span></label>
                        <input type="number" name="max_salary" required step="0.01" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="162500">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="Grade description (optional)"></textarea>
                </div>
            `
        },
        branch: {
            title: 'Add New Branch',
            fields: `
                <input type="hidden" name="company_id" value="1">
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Branch Code <span class="text-red-500">*</span></label>
                        <input type="text" name="code" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="e.g., MNL001">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Type <span class="text-red-500">*</span></label>
                        <select name="type" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500">
                            <option value="">Select Type</option>
                            <option value="Head Office">Head Office</option>
                            <option value="Branch">Branch</option>
                            <option value="Warehouse">Warehouse</option>
                            <option value="Plant">Plant</option>
                            <option value="Sales Office">Sales Office</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Branch Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="e.g., Manila Main Office">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Address <span class="text-red-500">*</span></label>
                    <textarea name="address" required rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="Full street address"></textarea>
                </div>
                <div class="grid grid-cols-3 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">City <span class="text-red-500">*</span></label>
                        <input type="text" name="city" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="City">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Province <span class="text-red-500">*</span></label>
                        <input type="text" name="province" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="Province">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Region <span class="text-red-500">*</span></label>
                        <input type="text" name="region" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="Region">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Postal Code</label>
                        <input type="text" name="postal_code" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="1234">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                        <input type="text" name="country" value="Philippines" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Contact Numbers</label>
                        <input type="text" name="contact_numbers" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="09123456789">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email Addresses</label>
                        <input type="email" name="email_addresses" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="branch@company.com">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Operation Start Time</label>
                        <input type="time" name="operation_start_time" value="08:00" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Operation End Time</label>
                        <input type="time" name="operation_end_time" value="17:00" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">BIR RDO Code</label>
                    <input type="text" name="bir_rdo_code" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="RDO Code">
                </div>
                <div class="flex items-center space-x-2">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" checked class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500">
                    <label class="text-sm font-medium text-gray-700">Active Branch</label>
                </div>
            `
        },
        workSchedule: {
            title: 'Add New Work Schedule',
            fields: `
                <input type="hidden" name="company_id" value="1">
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Schedule Code <span class="text-red-500">*</span></label>
                        <input type="text" name="code" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="e.g., REG001">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Type <span class="text-red-500">*</span></label>
                        <select name="type" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500">
                            <option value="">Select Type</option>
                            <option value="Fixed">Fixed</option>
                            <option value="Flexible">Flexible</option>
                            <option value="Shift">Shift</option>
                            <option value="Compressed">Compressed</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Schedule Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="e.g., Regular Schedule">
                </div>
                <div class="grid grid-cols-3 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Hours per Day <span class="text-red-500">*</span></label>
                        <input type="number" name="hours_per_day" required min="1" max="24" step="0.5" value="8" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Days per Week <span class="text-red-500">*</span></label>
                        <input type="number" name="days_per_week" required min="1" max="7" value="5" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Hours per Week</label>
                        <input type="number" name="hours_per_week" step="0.5" value="40" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Start Time</label>
                        <input type="time" name="start_time" value="08:00" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">End Time</label>
                        <input type="time" name="end_time" value="17:00" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Break Duration (minutes)</label>
                        <input type="number" name="break_duration" value="60" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Grace Period (minutes)</label>
                        <input type="number" name="grace_period" value="15" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="Schedule description"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div class="flex items-center space-x-2">
                        <input type="hidden" name="is_flexible" value="0">
                        <input type="checkbox" name="is_flexible" value="1" class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500">
                        <label class="text-sm text-gray-700">Flexible Time</label>
                    </div>
                    <div class="flex items-center space-x-2">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" checked class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500">
                        <label class="text-sm text-gray-700">Active</label>
                    </div>
                </div>
            `
        },
        costCenter: {
            title: 'Add New Cost Center',
            fields: `
                <input type="hidden" name="company_id" value="1">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Cost Center Code <span class="text-red-500">*</span></label>
                    <input type="text" name="code" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="e.g., CC001">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Cost Center Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="e.g., Operations">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="Cost center description (optional)"></textarea>
                </div>
            `
        },
        employmentStatus: {
            title: 'Add New Employment Status',
            fields: `
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status Code <span class="text-red-500">*</span></label>
                    <input type="text" name="code" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="e.g., TEMP">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="e.g., Temporary">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Color <span class="text-red-500">*</span></label>
                    <input type="color" name="color" value="#6B7280" class="w-full h-10 border border-gray-300 rounded-md cursor-pointer">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="Status description (optional)"></textarea>
                </div>
                <div class="flex items-center space-x-4">
                    <label class="flex items-center">
                        <input type="checkbox" name="requires_probation" value="1" class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500">
                        <span class="ml-2 text-sm">Requires Probation</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="eligible_for_benefits" value="1" checked class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500">
                        <span class="ml-2 text-sm">Eligible for Benefits</span>
                    </label>
                </div>
            `
        }
    };

    const config = configs[type];
    modalTitle.textContent = config.title;
    modalFields.innerHTML = config.fields;

    // Populate dependent dropdowns for Position modal
    if (type === 'position') {
        const deptSelect = modalFields.querySelector('select[name="department_id"]');
        const gradeSelect = modalFields.querySelector('select[name="job_grade_id"]');

        // Populate departments
        const mainDeptSelect = document.querySelector('select[name="department_id"]');
        if (mainDeptSelect && deptSelect) {
            Array.from(mainDeptSelect.options).slice(1).forEach(option => {
                const newOption = document.createElement('option');
                newOption.value = option.value;
                newOption.textContent = option.textContent;
                deptSelect.appendChild(newOption);
            });
        }

        // Populate job grades
        const mainGradeSelect = document.querySelector('select[name="job_grade_id"]');
        if (mainGradeSelect && gradeSelect) {
            Array.from(mainGradeSelect.options).slice(1).forEach(option => {
                const newOption = document.createElement('option');
                newOption.value = option.value;
                newOption.textContent = option.textContent;
                gradeSelect.appendChild(newOption);
            });
        }
    }

    // Store the type for form submission
    document.getElementById('quickAddForm').dataset.type = type;

    // Show modal
    modal.classList.remove('hidden');
}

function closeQuickAddModal() {
    const modal = document.getElementById('quickAddModal');
    modal.classList.add('hidden');

    // Reset form
    document.getElementById('quickAddForm').reset();
}

// Handle form submission
document.getElementById('quickAddForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const type = this.dataset.type;

    // Add CSRF token
    formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

    // Determine endpoint
    const endpoints = {
        department: '/departments',
        position: '/positions',
        jobgrade: '/job-grades',
        branch: '/company-branches',
        workSchedule: '/work-schedules',
        costCenter: '/cost-centers',
        employmentStatus: '/employment-statuses'
    };

    fetch(endpoints[type], {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            if (response.status === 401) {
                // Handle authentication error
                showNotification('Your session has expired. Please log in again.', 'error');
                setTimeout(() => {
                    window.location.href = '/login';
                }, 2000);
                throw new Error('Authentication required');
            }
            if (response.status === 419) {
                // Handle CSRF token mismatch
                showNotification('Security token expired. Please refresh the page and try again.', 'error');
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
                throw new Error('CSRF token mismatch');
            }
            if (response.status === 422) {
                // Handle validation errors
                return response.json().then(data => {
                    if (data.errors) {
                        const errorMsg = Object.values(data.errors).flat().join(', ');
                        throw new Error(errorMsg);
                    }
                    throw new Error(data.message || 'Validation failed');
                });
            }
            // Check if response is JSON or HTML
            const contentType = response.headers.get('content-type');
            if (contentType && contentType.includes('application/json')) {
                return response.json().then(data => {
                    const errorMsg = data.message || data.errors ? Object.values(data.errors).flat().join(', ') : 'Error adding item';
                    throw new Error(errorMsg);
                });
            } else {
                // Server returned HTML error page instead of JSON
                return response.text().then(text => {
                    console.error('Server returned HTML instead of JSON:', text);
                    throw new Error('Server error occurred. Please try again or contact support.');
                });
            }
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Add new option to select
            const selectName = type === 'jobgrade' ? 'job_grade_id' :
                              type === 'branch' ? 'branch_id' :
                              type === 'workSchedule' ? 'work_schedule_id' :
                              type === 'costCenter' ? 'cost_center_id' :
                              type === 'employmentStatus' ? 'employment_status' :
                              type + '_id';
            const select = document.querySelector(`select[name="${selectName}"]`);

            const option = document.createElement('option');
            option.value = data.item.id;
            option.selected = true;

            if (type === 'jobgrade') {
                option.textContent = `${data.item.name} (₱${Number(data.item.min_salary).toLocaleString()} - ₱${Number(data.item.max_salary).toLocaleString()})`;
            } else if (type === 'employmentStatus') {
                option.value = data.item.code;
                option.textContent = data.item.name;
            } else {
                option.textContent = data.item.name || data.item.title;
            }

            select.appendChild(option);

            // Close modal
            closeQuickAddModal();

            // Show success message
            showNotification('Item added successfully!', 'success');
        } else {
            console.error('Server response:', data);
            const errorMsg = data.message || data.errors ? Object.values(data.errors).flat().join(', ') : 'Error adding item';
            showNotification(errorMsg, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification(`Error: ${error.message}`, 'error');
    });
});

function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 p-4 rounded-md text-white z-50 ${type === 'success' ? 'bg-green-500' : 'bg-red-500'}`;
    notification.textContent = message;

    document.body.appendChild(notification);

    setTimeout(() => {
        notification.remove();
    }, 3000);
}

// Allowances Functions
function addAllowance() {
    const container = document.getElementById('allowancesContainer');
    const index = container.children.length;
    const newRow = document.createElement('div');
    newRow.className = 'flex items-center space-x-3 allowance-row bg-gray-50 p-3 rounded-lg';
    newRow.innerHTML = `
        <div class="flex-1">
            <input type="text" name="allowances[${index}][type]"
                   class="w-full h-9 px-3 text-sm border border-gray-300 rounded-md bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                   placeholder="e.g., Transportation, Meal, Housing">
        </div>
        <div class="flex-1 relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <span class="text-gray-500 text-sm">₱</span>
            </div>
            <input type="number" name="allowances[${index}][amount]" step="0.01" min="0"
                   class="w-full h-9 pl-8 pr-3 text-sm border border-gray-300 rounded-md bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                   placeholder="0.00">
        </div>
        <button type="button" onclick="removeAllowance(this)" class="flex-shrink-0 p-2 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-md transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
            </svg>
        </button>
    `;
    container.appendChild(newRow);
}

function removeAllowance(button) {
    const container = document.getElementById('allowancesContainer');
    if (container.children.length > 1) {
        button.closest('.allowance-row').remove();
        updateAllowanceIndices();
    }
}

function updateAllowanceIndices() {
    const container = document.getElementById('allowancesContainer');
    Array.from(container.children).forEach((row, index) => {
        const inputs = row.querySelectorAll('input');
        inputs.forEach(input => {
            const name = input.getAttribute('name');
            if (name && name.includes('allowances[')) {
                const newName = name.replace(/allowances\[\d+\]/, `allowances[${index}]`);
                input.setAttribute('name', newName);
            }
        });
    });
}

// Enhanced Document Upload Functions
function addDocumentUpload() {
    const container = document.getElementById('documentsContainer');
    const index = container.children.length;
    const newRow = document.createElement('div');
    newRow.className = 'document-upload-row bg-gradient-to-r from-gray-50 to-gray-100 border border-gray-200 rounded-xl p-6';
    newRow.innerHTML = `
        <div class="space-y-4">
            <!-- Document Type and File Upload Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-2">Document Type</label>
                    <select name="documents[${index}][type]" class="w-full h-10 px-3 text-sm border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="">Select document type</option>
                        <option value="resume">Resume/CV</option>
                        <option value="diploma">Diploma/Certificate</option>
                        <option value="transcript">Transcript of Records</option>
                        <option value="nbi_clearance">NBI Clearance</option>
                        <option value="police_clearance">Police Clearance</option>
                        <option value="medical_certificate">Medical Certificate</option>
                        <option value="employment_contract">Employment Contract</option>
                        <option value="job_offer">Job Offer Letter</option>
                        <option value="reference_letter">Reference Letter</option>
                        <option value="birth_certificate">Birth Certificate</option>
                        <option value="marriage_certificate">Marriage Certificate</option>
                        <option value="tor">Transcript of Records</option>
                        <option value="license">Professional License</option>
                        <option value="training_certificate">Training Certificate</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-2">Custom Type (if Other)</label>
                    <input type="text" name="documents[${index}][custom_type]"
                           class="w-full h-10 px-3 text-sm border border-gray-300 rounded-lg bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                           placeholder="Specify document type">
                </div>
            </div>

            <!-- File Upload Area -->
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-emerald-400 hover:bg-emerald-50/30 transition-all duration-200 document-drop-zone" data-index="${index}">
                <div class="document-upload-content">
                    <svg class="w-10 h-10 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p class="text-sm font-medium text-gray-900 mb-1">Upload Document</p>
                    <p class="text-xs text-gray-500 mb-3">Drag and drop your file here, or click to browse</p>

                    <input type="file" name="documents[${index}][file]" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.gif" class="hidden document-file-input" onchange="handleDocumentUpload(this, ${index})">

                    <button type="button" onclick="this.previousElementSibling.click()" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 shadow-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        Choose File
                    </button>
                </div>

                <!-- File Info Display (Hidden by default) -->
                <div class="document-file-info hidden">
                    <div class="flex items-center justify-center space-x-3">
                        <div class="file-icon">
                            <svg class="w-8 h-8 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div class="flex-1 text-left">
                            <p class="text-sm font-medium text-gray-900 file-name"></p>
                            <p class="text-xs text-gray-500 file-size"></p>
                        </div>
                        <button type="button" onclick="removeDocumentFile(this, ${index})" class="text-red-500 hover:text-red-700 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Remove Document Button -->
            <div class="flex justify-end">
                <button type="button" onclick="removeDocumentUpload(this)" class="inline-flex items-center px-3 py-1 text-xs text-red-600 hover:text-red-800 hover:bg-red-50 rounded-md transition-colors">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Remove Document
                </button>
            </div>
        </div>
    `;
    container.appendChild(newRow);

    // Setup drag and drop for the new upload zone
    setupDocumentDropZone(newRow.querySelector('.document-drop-zone'), index);
}

function removeDocumentUpload(button) {
    const container = document.getElementById('documentsContainer');
    if (container.children.length > 1) {
        button.closest('.document-upload-row').remove();
        updateDocumentIndices();
    }
}

function handleDocumentUpload(input, index) {
    const file = input.files[0];
    if (!file) return;

    // Check file size (10MB limit)
    if (file.size > 10 * 1024 * 1024) {
        showNotification('File size must be less than 10MB', 'error');
        input.value = '';
        return;
    }

    // Check file type
    const allowedTypes = ['.pdf', '.doc', '.docx', '.jpg', '.jpeg', '.png', '.gif'];
    const fileExtension = '.' + file.name.split('.').pop().toLowerCase();
    if (!allowedTypes.includes(fileExtension)) {
        showNotification('Please select a valid file type (PDF, DOC, DOCX, JPG, PNG, GIF)', 'error');
        input.value = '';
        return;
    }

    // Update UI to show uploaded file
    const dropZone = input.closest('.document-drop-zone');
    const uploadContent = dropZone.querySelector('.document-upload-content');
    const fileInfo = dropZone.querySelector('.document-file-info');

    // Set file icon based on type
    const fileIcon = fileInfo.querySelector('.file-icon svg');
    if (fileExtension === '.pdf') {
        fileIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>`;
        fileIcon.className = 'w-8 h-8 text-red-500';
    } else if (['.doc', '.docx'].includes(fileExtension)) {
        fileIcon.className = 'w-8 h-8 text-blue-500';
    } else {
        fileIcon.className = 'w-8 h-8 text-emerald-500';
    }

    // Update file info
    fileInfo.querySelector('.file-name').textContent = file.name;
    fileInfo.querySelector('.file-size').textContent = formatFileSize(file.size);

    // Show file info, hide upload content
    uploadContent.classList.add('hidden');
    fileInfo.classList.remove('hidden');

    // Update drop zone appearance
    dropZone.classList.add('border-emerald-400', 'bg-emerald-50/30');

    showNotification(`Document "${file.name}" uploaded successfully!`, 'success');
}

function removeDocumentFile(button, index) {
    const dropZone = button.closest('.document-drop-zone');
    const uploadContent = dropZone.querySelector('.document-upload-content');
    const fileInfo = dropZone.querySelector('.document-file-info');
    const fileInput = dropZone.querySelector('.document-file-input');

    // Clear file input
    fileInput.value = '';

    // Reset UI
    uploadContent.classList.remove('hidden');
    fileInfo.classList.add('hidden');
    dropZone.classList.remove('border-emerald-400', 'bg-emerald-50/30');

    showNotification('Document removed', 'info');
}

function setupDocumentDropZone(dropZone, index) {
    if (!dropZone) return;

    // Prevent default drag behaviors
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, preventDefaults, false);
    });

    // Highlight drop area when item is dragged over it
    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, () => {
            dropZone.classList.add('border-emerald-400', 'bg-emerald-50/50');
        }, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, () => {
            dropZone.classList.remove('border-emerald-400', 'bg-emerald-50/50');
        }, false);
    });

    // Handle dropped files
    dropZone.addEventListener('drop', function(e) {
        const dt = e.dataTransfer;
        const files = dt.files;

        if (files.length > 0) {
            const input = dropZone.querySelector('.document-file-input');
            input.files = files;
            handleDocumentUpload(input, index);
        }
    }, false);

    // Handle click to open file dialog
    dropZone.addEventListener('click', function(e) {
        if (e.target.closest('button')) return; // Don't trigger on button clicks
        dropZone.querySelector('.document-file-input').click();
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
}

function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

function updateDocumentIndices() {
    const container = document.getElementById('documentsContainer');
    Array.from(container.children).forEach((row, index) => {
        // Update all form field names and data attributes
        const inputs = row.querySelectorAll('input, select');
        inputs.forEach(input => {
            const name = input.getAttribute('name');
            if (name && name.includes('documents[')) {
                const newName = name.replace(/documents\[\d+\]/, `documents[${index}]`);
                input.setAttribute('name', newName);
            }
        });

        // Update drop zone data-index
        const dropZone = row.querySelector('.document-drop-zone');
        if (dropZone) {
            dropZone.setAttribute('data-index', index);
        }

        // Update onclick handlers
        const removeButton = row.querySelector('button[onclick*="removeDocumentFile"]');
        if (removeButton) {
            removeButton.setAttribute('onclick', `removeDocumentFile(this, ${index})`);
        }

        const uploadInput = row.querySelector('.document-file-input');
        if (uploadInput) {
            uploadInput.setAttribute('onchange', `handleDocumentUpload(this, ${index})`);
        }
    });
}

// Initialize document drop zones on page load
document.addEventListener('DOMContentLoaded', function() {
    const initialDropZone = document.querySelector('.document-drop-zone[data-index="0"]');
    if (initialDropZone) {
        setupDocumentDropZone(initialDropZone, 0);
    }
});

// Emergency Contacts Functions
function addEmergencyContact() {
    const container = document.getElementById('emergencyContactsContainer');
    const index = container.children.length;
    const newRow = document.createElement('div');
    newRow.className = 'emergency-contact-row bg-gray-50 p-4 rounded-lg border border-gray-200';
    newRow.innerHTML = `
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Full Name</label>
                <input type="text" name="emergency_contacts[${index}][name]"
                       class="w-full h-9 px-3 text-sm border border-gray-300 rounded-md bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                       placeholder="e.g., Jane Doe">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Relationship</label>
                <input type="text" name="emergency_contacts[${index}][relationship]"
                       class="w-full h-9 px-3 text-sm border border-gray-300 rounded-md bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                       placeholder="e.g., Spouse, Parent, Sibling">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Phone Number</label>
                <input type="text" name="emergency_contacts[${index}][phone]"
                       class="w-full h-9 px-3 text-sm border border-gray-300 rounded-md bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                       placeholder="e.g., +63 917 123 4567">
            </div>
        </div>
        <div class="flex justify-end mt-3">
            <button type="button" onclick="removeEmergencyContact(this)" class="inline-flex items-center px-2 py-1 text-xs text-red-600 hover:text-red-800 hover:bg-red-50 rounded transition-colors">
                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
                Remove
            </button>
        </div>
    `;
    container.appendChild(newRow);
}

function removeEmergencyContact(button) {
    const container = document.getElementById('emergencyContactsContainer');
    if (container.children.length > 1) {
        button.closest('.emergency-contact-row').remove();
        updateEmergencyContactIndices();
    }
}

function updateEmergencyContactIndices() {
    const container = document.getElementById('emergencyContactsContainer');
    Array.from(container.children).forEach((row, index) => {
        const inputs = row.querySelectorAll('input');
        inputs.forEach(input => {
            const name = input.getAttribute('name');
            if (name && name.includes('emergency_contacts[')) {
                const newName = name.replace(/emergency_contacts\[\d+\]/, `emergency_contacts[${index}]`);
                input.setAttribute('name', newName);
            }
        });
    });
}

// Custom Fields Functions
function addCustomField() {
    const container = document.getElementById('customFieldsContainer');
    const newRow = document.createElement('div');
    newRow.className = 'flex items-center space-x-3 custom-field-row bg-gray-50 p-3 rounded-lg';
    newRow.innerHTML = `
        <div class="flex-1">
            <input type="text" name="custom_fields_keys[]"
                   class="w-full h-9 px-3 text-sm border border-gray-300 rounded-md bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                   placeholder="Field name (e.g., employee_number, skills)">
        </div>
        <div class="flex-1">
            <input type="text" name="custom_fields_values[]"
                   class="w-full h-9 px-3 text-sm border border-gray-300 rounded-md bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                   placeholder="Field value">
        </div>
        <button type="button" onclick="removeCustomField(this)" class="flex-shrink-0 p-2 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-md transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
            </svg>
        </button>
    `;
    container.appendChild(newRow);
}

function removeCustomField(button) {
    const container = document.getElementById('customFieldsContainer');
    if (container.children.length > 1) {
        button.closest('.custom-field-row').remove();
    }
}

// Close modal when clicking outside
document.getElementById('quickAddModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeQuickAddModal();
    }
});

// Input Masking Functions
function formatCurrency(value) {
    // Remove all non-numeric characters except dots
    const numValue = value.replace(/[^0-9.]/g, '');

    // Ensure only one decimal point
    const parts = numValue.split('.');
    if (parts.length > 2) {
        return parts[0] + '.' + parts.slice(1).join('');
    }

    // Limit to 2 decimal places
    if (parts[1] && parts[1].length > 2) {
        return parts[0] + '.' + parts[1].substring(0, 2);
    }

    return numValue;
}

function formatPhoneNumber(value) {
    // Remove all non-numeric characters except +
    let cleaned = value.replace(/[^0-9+]/g, '');

    // Handle Philippine phone numbers
    if (cleaned.startsWith('+63')) {
        // +63 XXXX XXX XXXX format
        cleaned = cleaned.replace(/(\+63)(\d{4})(\d{3})(\d{4})/, '$1 $2 $3 $4');
    } else if (cleaned.startsWith('63')) {
        // 63 XXXX XXX XXXX format
        cleaned = cleaned.replace(/^(63)(\d{4})(\d{3})(\d{4})/, '+$1 $2 $3 $4');
    } else if (cleaned.startsWith('0')) {
        // 0XXX XXX XXXX format
        cleaned = cleaned.replace(/^(0)(\d{3})(\d{3})(\d{4})/, '$1$2 $3 $4');
    }

    return cleaned;
}

// Apply input masking
document.addEventListener('DOMContentLoaded', function() {
    // Currency input masking
    document.querySelectorAll('.salary-input, input[data-mask="currency"]').forEach(input => {
        input.addEventListener('input', function(e) {
            const cursorPos = e.target.selectionStart;
            const oldValue = e.target.value;
            const newValue = formatCurrency(oldValue);

            if (newValue !== oldValue) {
                e.target.value = newValue;
                // Restore cursor position
                const diff = newValue.length - oldValue.length;
                e.target.setSelectionRange(cursorPos + diff, cursorPos + diff);
            }
        });

        // Prevent non-numeric input
        input.addEventListener('keypress', function(e) {
            const char = String.fromCharCode(e.which);
            if (!/[0-9.]/.test(char) && e.which !== 8 && e.which !== 0) {
                e.preventDefault();
            }
        });
    });

    // Phone number input masking
    document.querySelectorAll('.phone-input, input[data-mask="phone"]').forEach(input => {
        input.addEventListener('input', function(e) {
            const cursorPos = e.target.selectionStart;
            const oldValue = e.target.value;
            const newValue = formatPhoneNumber(oldValue);

            if (newValue !== oldValue) {
                e.target.value = newValue;
                // Restore cursor position
                const diff = newValue.length - oldValue.length;
                e.target.setSelectionRange(cursorPos + diff, cursorPos + diff);
            }
        });

        // Prevent invalid characters
        input.addEventListener('keypress', function(e) {
            const char = String.fromCharCode(e.which);
            if (!/[0-9+\s]/.test(char) && e.which !== 8 && e.which !== 0) {
                e.preventDefault();
            }
        });
    });

    // Apply masks to dynamically created elements
    document.addEventListener('input', function(e) {
        if (e.target.matches('.phone-input, input[data-mask="phone"]')) {
            const cursorPos = e.target.selectionStart;
            const oldValue = e.target.value;
            const newValue = formatPhoneNumber(oldValue);

            if (newValue !== oldValue) {
                e.target.value = newValue;
                const diff = newValue.length - oldValue.length;
                e.target.setSelectionRange(cursorPos + diff, cursorPos + diff);
            }
        }
    });
});
</script>
@endsection