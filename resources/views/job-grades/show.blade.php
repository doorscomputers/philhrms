@extends('layouts.dashboard')

@section('title', $jobGrade->name)

@section('content')
<div class="min-h-screen bg-gray-50/30">
    <!-- Header -->
    <div class="bg-white border-b border-gray-200 mb-8">
        <div class="px-6 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('job-grades.index') }}"
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
                            <a href="{{ route('job-grades.index') }}" class="hover:text-gray-700">Job Grades</a>
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-900 font-medium">{{ $jobGrade->name }}</span>
                        </nav>
                        <h1 class="text-3xl font-bold text-gray-900">{{ $jobGrade->name }}</h1>
                        <p class="text-gray-600 mt-1">{{ $jobGrade->code }} • Level {{ $jobGrade->level }}</p>
                    </div>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('job-grades.edit', $jobGrade) }}"
                       class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-lg font-medium transition-colors flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        <span>Edit Job Grade</span>
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
                            <label class="block text-sm font-medium text-gray-500 mb-1">Job Grade Code</label>
                            <p class="text-gray-900 font-medium">{{ $jobGrade->code }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Grade Level</label>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                Level {{ $jobGrade->level }}
                            </span>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Company</label>
                            <p class="text-gray-900">{{ $jobGrade->company->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Status</label>
                            @if($jobGrade->is_active)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    Active
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                    Inactive
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Salary Information -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Salary Information</h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-green-600">₱{{ number_format($jobGrade->min_salary, 2) }}</div>
                            <div class="text-sm text-gray-500 mt-1">Minimum Salary</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-blue-600">₱{{ number_format($jobGrade->mid_salary ?? (($jobGrade->min_salary + $jobGrade->max_salary) / 2), 2) }}</div>
                            <div class="text-sm text-gray-500 mt-1">Mid Salary</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-purple-600">₱{{ number_format($jobGrade->max_salary, 2) }}</div>
                            <div class="text-sm text-gray-500 mt-1">Maximum Salary</div>
                        </div>
                    </div>

                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Salary Range</label>
                                <p class="text-gray-900">₱{{ number_format($jobGrade->max_salary - $jobGrade->min_salary, 2) }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Range Percentage</label>
                                <p class="text-gray-900">{{ number_format((($jobGrade->max_salary - $jobGrade->min_salary) / $jobGrade->min_salary) * 100, 1) }}%</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                @if($jobGrade->description)
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Description</h3>
                    <div class="prose prose-sm max-w-none text-gray-900">
                        {!! nl2br(e($jobGrade->description)) !!}
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-8">
                <!-- Statistics -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Statistics</h3>

                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">Total Positions</span>
                            <span class="text-2xl font-bold text-blue-600">{{ $jobGrade->positions->count() }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">Total Employees</span>
                            <span class="text-2xl font-bold text-green-600">{{ $jobGrade->employees->count() }}</span>
                        </div>
                    </div>
                </div>

                <!-- Positions -->
                @if($jobGrade->positions->count() > 0)
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Positions in this Grade</h3>

                    <div class="space-y-3">
                        @foreach($jobGrade->positions->take(5) as $position)
                        <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-b-0">
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $position->title }}</p>
                                <p class="text-xs text-gray-500">{{ $position->code }} • {{ $position->department->name ?? 'N/A' }}</p>
                            </div>
                            <div class="text-right">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $position->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $position->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </div>
                        @endforeach

                        @if($jobGrade->positions->count() > 5)
                        <div class="text-center pt-2">
                            <p class="text-sm text-gray-500">
                                and {{ $jobGrade->positions->count() - 5 }} more positions
                            </p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Timestamps -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Information</h3>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Created</label>
                            <p class="text-gray-900">{{ $jobGrade->created_at->format('F j, Y g:i A') }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Last Updated</label>
                            <p class="text-gray-900">{{ $jobGrade->updated_at->format('F j, Y g:i A') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection