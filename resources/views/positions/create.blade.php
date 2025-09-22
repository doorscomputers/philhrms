@extends('layouts.dashboard')

@section('title', 'Add Position')

@section('content')
<div class="min-h-screen bg-gray-50/30">
    <!-- Enhanced Header with Breadcrumb -->
    <div class="bg-white border-b border-gray-200 mb-8">
        <div class="px-6 py-6">
            <div class="flex items-center space-x-4 mb-4">
                <a href="{{ route('positions.index') }}"
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
                        <a href="{{ route('positions.index') }}" class="hover:text-gray-700">Positions</a>
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-gray-900 font-medium">Add Position</span>
                    </nav>
                    <h1 class="text-3xl font-bold text-gray-900">Add New Position</h1>
                    <p class="text-gray-600 mt-1">Create a new position for your organization</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Container -->
    <div class="max-w-6xl mx-auto px-6 pb-12">
        <form action="{{ route('positions.store') }}" method="POST" class="space-y-8">
            @csrf

            <!-- Basic Information Section -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="border-b border-gray-200 bg-gray-50/50 px-6 py-4">
                    <div class="flex items-center space-x-3">
                        <div class="flex items-center justify-center w-8 h-8 bg-blue-100 rounded-lg">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2h8z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Basic Information</h2>
                            <p class="text-sm text-gray-500">Position details and identification</p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-900">
                                Position Code <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="code" required
                                   class="w-full h-10 px-3 text-sm border border-gray-300 rounded-lg bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                   placeholder="e.g., DEV01, MGR02"
                                   value="{{ old('code') }}">
                            @error('code')
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
                                Position Title <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="title" required
                                   class="w-full h-10 px-3 text-sm border border-gray-300 rounded-lg bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                   placeholder="e.g., Software Developer"
                                   value="{{ old('title') }}">
                            @error('title')
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
                                Department <span class="text-red-500">*</span>
                            </label>
                            <select name="department_id" required
                                    class="w-full h-10 px-3 text-sm border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors appearance-none">
                                <option value="">Select Department</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('department_id')
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
                                Job Grade <span class="text-red-500">*</span>
                            </label>
                            <select name="job_grade_id" required
                                    class="w-full h-10 px-3 text-sm border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors appearance-none">
                                <option value="">Select Job Grade</option>
                                @foreach($jobGrades as $jobGrade)
                                    <option value="{{ $jobGrade->id }}" {{ old('job_grade_id') == $jobGrade->id ? 'selected' : '' }}>
                                        {{ $jobGrade->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('job_grade_id')
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
                                Position Type <span class="text-red-500">*</span>
                            </label>
                            <select name="type" required
                                    class="w-full h-10 px-3 text-sm border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors appearance-none">
                                <option value="">Select Type</option>
                                <option value="Regular" {{ old('type') == 'Regular' ? 'selected' : '' }}>Regular</option>
                                <option value="Contractual" {{ old('type') == 'Contractual' ? 'selected' : '' }}>Contractual</option>
                                <option value="Consultant" {{ old('type') == 'Consultant' ? 'selected' : '' }}>Consultant</option>
                                <option value="Intern" {{ old('type') == 'Intern' ? 'selected' : '' }}>Intern</option>
                            </select>
                            @error('type')
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
                                Position Level <span class="text-red-500">*</span>
                            </label>
                            <select name="level" required
                                    class="w-full h-10 px-3 text-sm border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors appearance-none">
                                <option value="">Select Level</option>
                                <option value="Executive" {{ old('level') == 'Executive' ? 'selected' : '' }}>Executive</option>
                                <option value="Managerial" {{ old('level') == 'Managerial' ? 'selected' : '' }}>Managerial</option>
                                <option value="Supervisory" {{ old('level') == 'Supervisory' ? 'selected' : '' }}>Supervisory</option>
                                <option value="Rank and File" {{ old('level') == 'Rank and File' ? 'selected' : '' }}>Rank and File</option>
                            </select>
                            @error('level')
                                <p class="text-xs text-red-600 flex items-center mt-1">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="md:col-span-2 space-y-2">
                            <label class="block text-sm font-medium text-gray-900">Description</label>
                            <textarea name="description" rows="3"
                                      class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors resize-vertical"
                                      placeholder="Position description (optional)">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Organization Structure Section -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="border-b border-gray-200 bg-gray-50/50 px-6 py-4">
                    <div class="flex items-center space-x-3">
                        <div class="flex items-center justify-center w-8 h-8 bg-purple-100 rounded-lg">
                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16l2.879-2.879m0 0a3 3 0 104.243-4.242 3 3 0 00-4.243 4.242zM21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Organization Structure</h2>
                            <p class="text-sm text-gray-500">Reporting relationships and hierarchy</p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-900">Reports To</label>
                            <select name="reports_to_id"
                                    class="w-full h-10 px-3 text-sm border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors appearance-none">
                                <option value="">No Supervisor Position</option>
                                @foreach($supervisorPositions as $supervisor)
                                    <option value="{{ $supervisor->id }}" {{ old('reports_to_id') == $supervisor->id ? 'selected' : '' }}>
                                        {{ $supervisor->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-900">
                                Authorized Headcount <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="authorized_headcount" required min="1"
                                   class="w-full h-10 px-3 text-sm border border-gray-300 rounded-lg bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                   placeholder="1"
                                   value="{{ old('authorized_headcount', 1) }}">
                            @error('authorized_headcount')
                                <p class="text-xs text-red-600 flex items-center mt-1">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-900">Current Headcount</label>
                            <input type="number" name="current_headcount" min="0"
                                   class="w-full h-10 px-3 text-sm border border-gray-300 rounded-lg bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                   placeholder="0"
                                   value="{{ old('current_headcount', 0) }}">
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-900">Vacant Positions</label>
                            <input type="number" name="vacant_positions" min="0"
                                   class="w-full h-10 px-3 text-sm border border-gray-300 rounded-lg bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                   placeholder="0"
                                   value="{{ old('vacant_positions', 0) }}">
                        </div>

                        <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="flex items-center space-x-3">
                                <input type="checkbox" name="is_exempt" value="1" {{ old('is_exempt') ? 'checked' : '' }}
                                       class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500">
                                <label class="text-sm font-medium text-gray-700">Is Exempt</label>
                            </div>
                            <div class="flex items-center space-x-3">
                                <input type="checkbox" name="is_confidential" value="1" {{ old('is_confidential') ? 'checked' : '' }}
                                       class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500">
                                <label class="text-sm font-medium text-gray-700">Is Confidential</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Salary Range Section -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="border-b border-gray-200 bg-gray-50/50 px-6 py-4">
                    <div class="flex items-center space-x-3">
                        <div class="flex items-center justify-center w-8 h-8 bg-green-100 rounded-lg">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Salary Range</h2>
                            <p class="text-sm text-gray-500">Compensation range for this position</p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-900">Minimum Salary</label>
                            <div class="relative">
                                <input type="number" name="min_salary" step="0.01" min="0"
                                       class="w-full h-10 px-3 pl-8 text-sm border border-gray-300 rounded-lg bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                       placeholder="0.00"
                                       value="{{ old('min_salary') }}">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <span class="text-gray-400 text-sm">₱</span>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-900">Maximum Salary</label>
                            <div class="relative">
                                <input type="number" name="max_salary" step="0.01" min="0"
                                       class="w-full h-10 px-3 pl-8 text-sm border border-gray-300 rounded-lg bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                       placeholder="0.00"
                                       value="{{ old('max_salary') }}">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <span class="text-gray-400 text-sm">₱</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Job Details Section -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="border-b border-gray-200 bg-gray-50/50 px-6 py-4">
                    <div class="flex items-center space-x-3">
                        <div class="flex items-center justify-center w-8 h-8 bg-orange-100 rounded-lg">
                            <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Job Details</h2>
                            <p class="text-sm text-gray-500">Responsibilities and qualifications</p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <div class="space-y-6">
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-900">Responsibilities</label>
                            <textarea name="responsibilities" rows="4"
                                      class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors resize-vertical"
                                      placeholder="Key responsibilities and duties...">{{ old('responsibilities') }}</textarea>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-900">Qualifications</label>
                            <textarea name="qualifications" rows="4"
                                      class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors resize-vertical"
                                      placeholder="Required qualifications, skills, and experience...">{{ old('qualifications') }}</textarea>
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
                        <a href="{{ route('positions.index') }}"
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
                            Create Position
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection