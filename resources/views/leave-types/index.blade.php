@extends('layouts.dashboard')

@section('title', 'Leave Types')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Leave Type Management</h1>
            <p class="text-gray-600">Configure leave types and policies</p>
        </div>
        <a href="{{ route('leave-types.create') }}"
           class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
            Add Leave Type
        </a>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <form method="GET" action="{{ route('leave-types.index') }}" class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-64">
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Search leave types..."
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-emerald-500 focus:border-emerald-500">
            </div>
            <div>
                <select name="category" class="px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-emerald-500 focus:border-emerald-500">
                    <option value="">All Categories</option>
                    <option value="Vacation" {{ request('category') == 'Vacation' ? 'selected' : '' }}>Vacation</option>
                    <option value="Sick" {{ request('category') == 'Sick' ? 'selected' : '' }}>Sick</option>
                    <option value="Emergency" {{ request('category') == 'Emergency' ? 'selected' : '' }}>Emergency</option>
                    <option value="Maternity" {{ request('category') == 'Maternity' ? 'selected' : '' }}>Maternity</option>
                    <option value="Paternity" {{ request('category') == 'Paternity' ? 'selected' : '' }}>Paternity</option>
                    <option value="Special" {{ request('category') == 'Special' ? 'selected' : '' }}>Special</option>
                    <option value="Others" {{ request('category') == 'Others' ? 'selected' : '' }}>Others</option>
                </select>
            </div>
            <div>
                <select name="is_paid" class="px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-emerald-500 focus:border-emerald-500">
                    <option value="">All Types</option>
                    <option value="1" {{ request('is_paid') == '1' ? 'selected' : '' }}>Paid</option>
                    <option value="0" {{ request('is_paid') == '0' ? 'selected' : '' }}>Unpaid</option>
                </select>
            </div>
            <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md transition-colors">
                Filter
            </button>
            @if(request()->anyFilled(['search', 'category', 'is_paid']))
                <a href="{{ route('leave-types.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-md transition-colors">
                    Clear
                </a>
            @endif
        </form>
    </div>

    <!-- Leave Types List -->
    <div class="bg-white rounded-lg shadow-sm">
        @forelse($leaveTypes as $leaveType)
            <div class="px-6 py-4 border-b border-gray-100 hover:bg-gray-50">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class="flex items-center space-x-3">
                            <h3 class="text-lg font-medium text-gray-900">{{ $leaveType->name }}</h3>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $leaveType->category }}
                            </span>
                            @if($leaveType->is_paid)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Paid
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    Unpaid
                                </span>
                            @endif
                            @if(!$leaveType->is_active)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    Inactive
                                </span>
                            @endif
                        </div>
                        <p class="text-sm text-gray-500 mt-1">{{ $leaveType->code }} • {{ $leaveType->annual_entitlement }} days annually • {{ $leaveType->accrual_method }}</p>
                        @if($leaveType->company)
                            <p class="text-sm text-gray-400">{{ $leaveType->company->name }}</p>
                        @endif
                        @if($leaveType->description)
                            <p class="text-sm text-gray-600 mt-1">{{ Str::limit($leaveType->description, 120) }}</p>
                        @endif
                    </div>

                    <div class="flex items-center space-x-4">
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-900">{{ $leaveType->annual_entitlement }} days</p>
                            <p class="text-xs text-gray-500">Annual entitlement</p>
                            @if($leaveType->can_be_carried_over)
                                <p class="text-xs text-green-600">Can carry over</p>
                            @endif
                        </div>

                        <div class="flex space-x-2">
                            <a href="{{ route('leave-types.show', $leaveType) }}" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </a>
                            <a href="{{ route('leave-types.edit', $leaveType) }}" class="text-gray-400 hover:text-emerald-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>
                            <form action="{{ route('leave-types.destroy', $leaveType) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this leave type?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-gray-400 hover:text-red-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="px-6 py-12 text-center">
                <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0h6M6 7v10a2 2 0 002 2h8a2 2 0 002-2V7"></path>
                    </svg>
                </div>
                <h3 class="text-sm font-medium text-gray-900">No leave types</h3>
                <p class="mt-1 text-sm text-gray-500">Create your first leave type to get started.</p>
                <div class="mt-6">
                    <a href="{{ route('leave-types.create') }}"
                       class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-emerald-600 hover:bg-emerald-700">
                        Add Leave Type
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    @if($leaveTypes->hasPages())
        <div class="mt-6">
            {{ $leaveTypes->withQueryString()->links() }}
        </div>
    @endif
</div>
@endsection