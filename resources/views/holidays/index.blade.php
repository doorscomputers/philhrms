@extends('layouts.dashboard')

@section('title', 'Holidays')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Holiday Management</h1>
            <p class="text-gray-600">Manage company holidays and special dates</p>
        </div>
        <a href="{{ route('holidays.create') }}"
           class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
            Add Holiday
        </a>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <form method="GET" action="{{ route('holidays.index') }}" class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-64">
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Search holidays..."
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-emerald-500 focus:border-emerald-500">
            </div>
            <div>
                <select name="type" class="px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-emerald-500 focus:border-emerald-500">
                    <option value="">All Types</option>
                    <option value="Regular" {{ request('type') == 'Regular' ? 'selected' : '' }}>Regular</option>
                    <option value="Special Non-Working" {{ request('type') == 'Special Non-Working' ? 'selected' : '' }}>Special Non-Working</option>
                    <option value="Special Working" {{ request('type') == 'Special Working' ? 'selected' : '' }}>Special Working</option>
                </select>
            </div>
            <div>
                <select name="scope" class="px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-emerald-500 focus:border-emerald-500">
                    <option value="">All Scopes</option>
                    <option value="National" {{ request('scope') == 'National' ? 'selected' : '' }}>National</option>
                    <option value="Regional" {{ request('scope') == 'Regional' ? 'selected' : '' }}>Regional</option>
                    <option value="Local" {{ request('scope') == 'Local' ? 'selected' : '' }}>Local</option>
                    <option value="Company" {{ request('scope') == 'Company' ? 'selected' : '' }}>Company</option>
                </select>
            </div>
            <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md transition-colors">
                Filter
            </button>
            @if(request()->anyFilled(['search', 'type', 'scope']))
                <a href="{{ route('holidays.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-md transition-colors">
                    Clear
                </a>
            @endif
        </form>
    </div>

    <!-- Holidays List -->
    <div class="bg-white rounded-lg shadow-sm">
        @forelse($holidays as $holiday)
            <div class="px-6 py-4 border-b border-gray-100 hover:bg-gray-50">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <h3 class="text-lg font-medium text-gray-900">{{ $holiday->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $holiday->date->format('F j, Y') }} • {{ $holiday->type }} • {{ $holiday->scope }}</p>
                        @if($holiday->company)
                            <p class="text-sm text-gray-400">{{ $holiday->company->name }}</p>
                        @endif
                        @if($holiday->description)
                            <p class="text-sm text-gray-600 mt-1">{{ Str::limit($holiday->description, 100) }}</p>
                        @endif
                    </div>

                    <div class="flex items-center space-x-4">
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-900">{{ $holiday->pay_multiplier }}x pay</p>
                            @if($holiday->is_recurring)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    Recurring
                                </span>
                            @endif
                        </div>

                        <div class="flex space-x-2">
                            <a href="{{ route('holidays.show', $holiday) }}" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </a>
                            <a href="{{ route('holidays.edit', $holiday) }}" class="text-gray-400 hover:text-emerald-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>
                            <form action="{{ route('holidays.destroy', $holiday) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this holiday?')">
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
                <h3 class="text-sm font-medium text-gray-900">No holidays</h3>
                <p class="mt-1 text-sm text-gray-500">Create your first holiday to get started.</p>
                <div class="mt-6">
                    <a href="{{ route('holidays.create') }}"
                       class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-emerald-600 hover:bg-emerald-700">
                        Add Holiday
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    @if($holidays->hasPages())
        <div class="mt-6">
            {{ $holidays->withQueryString()->links() }}
        </div>
    @endif
</div>
@endsection