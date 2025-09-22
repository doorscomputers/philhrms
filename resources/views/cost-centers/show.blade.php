@extends('layouts.dashboard')

@section('title', $costCenter->name)

@section('content')
<div class="min-h-screen bg-gray-50/30">
    <!-- Header -->
    <div class="bg-white border-b border-gray-200 mb-8">
        <div class="px-6 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('cost-centers.index') }}"
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
                            <a href="{{ route('cost-centers.index') }}" class="hover:text-gray-700">Cost Centers</a>
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-900 font-medium">{{ $costCenter->name }}</span>
                        </nav>
                        <h1 class="text-3xl font-bold text-gray-900">{{ $costCenter->name }}</h1>
                        <p class="text-gray-600 mt-1">{{ $costCenter->code }} • {{ $costCenter->type ?? 'N/A' }} • {{ $costCenter->location ?? 'N/A' }}</p>
                    </div>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('cost-centers.edit', $costCenter) }}"
                       class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-lg font-medium transition-colors flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        <span>Edit Cost Center</span>
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
                            <label class="block text-sm font-medium text-gray-500 mb-1">Cost Center Code</label>
                            <p class="text-gray-900 font-medium">{{ $costCenter->code }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Type</label>
                            @if($costCenter->type)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $costCenter->type === 'Revenue' ? 'bg-green-100 text-green-800' :
                                       ($costCenter->type === 'Cost' ? 'bg-red-100 text-red-800' :
                                       ($costCenter->type === 'Profit' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800')) }}">
                                    {{ $costCenter->type }}
                                </span>
                            @else
                                <p class="text-gray-500">N/A</p>
                            @endif
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Manager</label>
                            <p class="text-gray-900">{{ $costCenter->manager ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Location</label>
                            <p class="text-gray-900">{{ $costCenter->location ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Primary Department</label>
                            <p class="text-gray-900">{{ $costCenter->department ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Company</label>
                            <p class="text-gray-900">{{ $costCenter->company->name ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Budget Information -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Budget Information</h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-blue-600">
                                ₱{{ number_format($costCenter->budget_amount ?? 0, 2) }}
                            </div>
                            <div class="text-sm text-gray-500 mt-1">Budget Amount</div>
                        </div>
                        <div class="text-center">
                            <div class="text-lg font-semibold text-green-600">
                                {{ $costCenter->budget_period ?? 'N/A' }}
                            </div>
                            <div class="text-sm text-gray-500 mt-1">Budget Period</div>
                        </div>
                        <div class="text-center">
                            <div class="text-lg font-semibold text-purple-600">
                                {{ $costCenter->budget_start_date ? $costCenter->budget_start_date->format('M j, Y') : 'N/A' }}
                            </div>
                            <div class="text-sm text-gray-500 mt-1">Start Date</div>
                        </div>
                    </div>

                    @if($costCenter->budget_amount)
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Monthly Budget</label>
                                <p class="text-gray-900">
                                    @if($costCenter->budget_period === 'Monthly')
                                        ₱{{ number_format($costCenter->budget_amount, 2) }}
                                    @elseif($costCenter->budget_period === 'Quarterly')
                                        ₱{{ number_format($costCenter->budget_amount / 3, 2) }}
                                    @elseif($costCenter->budget_period === 'Annually')
                                        ₱{{ number_format($costCenter->budget_amount / 12, 2) }}
                                    @else
                                        N/A
                                    @endif
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Annual Budget</label>
                                <p class="text-gray-900">
                                    @if($costCenter->budget_period === 'Monthly')
                                        ₱{{ number_format($costCenter->budget_amount * 12, 2) }}
                                    @elseif($costCenter->budget_period === 'Quarterly')
                                        ₱{{ number_format($costCenter->budget_amount * 4, 2) }}
                                    @elseif($costCenter->budget_period === 'Annually')
                                        ₱{{ number_format($costCenter->budget_amount, 2) }}
                                    @else
                                        N/A
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Description -->
                @if($costCenter->description)
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Description</h3>
                    <div class="prose prose-sm max-w-none text-gray-900">
                        {!! nl2br(e($costCenter->description)) !!}
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-8">
                <!-- Status & Statistics -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Status & Statistics</h3>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-2">Status</label>
                            @if($costCenter->is_active)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    Active
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                    Inactive
                                </span>
                            @endif
                        </div>

                        <div class="border-t border-gray-200 pt-4 space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500">Total Departments</span>
                                <span class="text-2xl font-bold text-blue-600">{{ $costCenter->departments->count() }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500">Total Employees</span>
                                <span class="text-2xl font-bold text-green-600">{{ $costCenter->employees->count() }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Associated Departments -->
                @if($costCenter->departments->count() > 0)
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Associated Departments</h3>

                    <div class="space-y-3">
                        @foreach($costCenter->departments->take(5) as $department)
                        <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-b-0">
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $department->name }}</p>
                                <p class="text-xs text-gray-500">{{ $department->code ?? 'N/A' }}</p>
                            </div>
                            <div class="text-right">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $department->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $department->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </div>
                        @endforeach

                        @if($costCenter->departments->count() > 5)
                        <div class="text-center pt-2">
                            <p class="text-sm text-gray-500">
                                and {{ $costCenter->departments->count() - 5 }} more departments
                            </p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Associated Employees -->
                @if($costCenter->employees->count() > 0)
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Associated Employees</h3>

                    <div class="space-y-3">
                        @foreach($costCenter->employees->take(5) as $employee)
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

                        @if($costCenter->employees->count() > 5)
                        <div class="text-center pt-2">
                            <p class="text-sm text-gray-500">
                                and {{ $costCenter->employees->count() - 5 }} more employees
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
                            <p class="text-gray-900">{{ $costCenter->created_at->format('F j, Y g:i A') }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Last Updated</label>
                            <p class="text-gray-900">{{ $costCenter->updated_at->format('F j, Y g:i A') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection