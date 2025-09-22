@extends('layouts.dashboard')

@section('title', $position->title)

@section('content')
<div class="min-h-screen bg-gray-50/30">
    <!-- Header -->
    <div class="bg-white border-b border-gray-200 mb-8">
        <div class="px-6 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('positions.index') }}"
                       class="inline-flex items-center justify-center w-10 h-10 rounded-lg border border-gray-200 bg-white hover:bg-gray-50 transition-colors group">
                        <svg class="w-5 h-5 text-gray-500 group-hover:text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </a>
                    <div>
                        <nav class="flex items-center space-x-2 text-sm text-gray-500 mb-2">
                            <a href="{{ route('dashboard') }}" class="hover:text-gray-700">Dashboard</a>
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <a href="{{ route('positions.index') }}" class="hover:text-gray-700">Positions</a>
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-900 font-medium">{{ $position->title }}</span>
                        </nav>
                        <h1 class="text-3xl font-bold text-gray-900">{{ $position->title }}</h1>
                        <p class="text-gray-600 mt-1">{{ $position->code }} • {{ $position->type }} • {{ $position->level }}</p>
                    </div>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('positions.edit', $position) }}"
                       class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-lg font-medium transition-colors flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        <span>Edit Position</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 pb-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Basic Information -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Basic Information</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Position Code</label>
                            <p class="text-gray-900 font-medium">{{ $position->code }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Department</label>
                            <p class="text-gray-900">{{ $position->department->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Job Grade</label>
                            <p class="text-gray-900">{{ $position->jobGrade->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Reports To</label>
                            <p class="text-gray-900">{{ $position->reportsTo->title ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Type</label>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $position->type }}
                            </span>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Level</label>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                {{ $position->level }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Description & Responsibilities -->
                @if($position->description || $position->responsibilities || $position->qualifications)
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Position Details</h3>

                    @if($position->description)
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-500 mb-3">Description</label>
                        <div class="prose prose-sm max-w-none text-gray-900">
                            {!! nl2br(e($position->description)) !!}
                        </div>
                    </div>
                    @endif

                    @if($position->responsibilities)
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-500 mb-3">Responsibilities</label>
                        <div class="prose prose-sm max-w-none text-gray-900">
                            {!! nl2br(e($position->responsibilities)) !!}
                        </div>
                    </div>
                    @endif

                    @if($position->qualifications)
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-3">Qualifications</label>
                        <div class="prose prose-sm max-w-none text-gray-900">
                            {!! nl2br(e($position->qualifications)) !!}
                        </div>
                    </div>
                    @endif
                </div>
                @endif

                <!-- Headcount Information -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Headcount Information</h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-blue-600">{{ $position->authorized_headcount }}</div>
                            <div class="text-sm text-gray-500 mt-1">Authorized</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-green-600">{{ $position->current_headcount }}</div>
                            <div class="text-sm text-gray-500 mt-1">Current</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-orange-600">{{ $position->vacant_positions }}</div>
                            <div class="text-sm text-gray-500 mt-1">Vacant</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-8">
                <!-- Status & Info -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Status & Information</h3>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-2">Status</label>
                            @if($position->is_active)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    Active
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                    Inactive
                                </span>
                            @endif
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Exempt Position</label>
                            <p class="text-gray-900">{{ $position->is_exempt ? 'Yes' : 'No' }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Confidential Position</label>
                            <p class="text-gray-900">{{ $position->is_confidential ? 'Yes' : 'No' }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Created</label>
                            <p class="text-gray-900">{{ $position->created_at->format('F j, Y') }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Last Updated</label>
                            <p class="text-gray-900">{{ $position->updated_at->format('F j, Y') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Salary Range -->
                @if($position->min_salary || $position->max_salary)
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Salary Range</h3>

                    <div class="space-y-4">
                        @if($position->min_salary)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Minimum Salary</label>
                            <p class="text-gray-900">₱{{ number_format($position->min_salary, 2) }}</p>
                        </div>
                        @endif

                        @if($position->max_salary)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Maximum Salary</label>
                            <p class="text-gray-900">₱{{ number_format($position->max_salary, 2) }}</p>
                        </div>
                        @endif

                        @if($position->min_salary && $position->max_salary)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Range</label>
                            <p class="text-gray-900">₱{{ number_format($position->max_salary - $position->min_salary, 2) }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Current Employees -->
                @if($position->employees->count() > 0)
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Current Employees</h3>

                    <div class="space-y-3">
                        @foreach($position->employees->take(5) as $employee)
                        <div class="flex items-center space-x-3 py-2">
                            <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                                <span class="text-xs font-medium text-gray-600">
                                    {{ substr($employee->first_name, 0, 1) }}{{ substr($employee->last_name, 0, 1) }}
                                </span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">
                                    {{ $employee->first_name }} {{ $employee->last_name }}
                                </p>
                                <p class="text-xs text-gray-500">{{ $employee->employee_id }}</p>
                            </div>
                        </div>
                        @endforeach

                        @if($position->employees->count() > 5)
                        <div class="text-center pt-2">
                            <p class="text-sm text-gray-500">
                                and {{ $position->employees->count() - 5 }} more employees
                            </p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection