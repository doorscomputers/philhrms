@extends('layouts.dashboard')

@section('title', 'Company Events')

@section('content')
<div class="min-h-screen bg-gray-50/30">
    <!-- Enhanced Header -->
    <div class="bg-white border-b border-gray-200 mb-8">
        <div class="px-6 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Company Events</h1>
                    <p class="text-gray-600 mt-1">Manage company events, meetings, and activities throughout the year</p>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('company-events.create') }}" class="inline-flex items-center px-4 py-2 bg-violet-600 hover:bg-violet-700 text-white font-semibold rounded-lg shadow-sm transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add New Event
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 pb-12">
        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
                <div class="flex">
                    <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="ml-3">
                        <p class="text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Events Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
            @forelse($events as $event)
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-all duration-200 overflow-hidden">
                    <!-- Event Header -->
                    <div class="border-b border-gray-100 px-6 py-4" style="background-color: {{ $event->color }}20; border-left: 4px solid {{ $event->color }};">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="flex items-center justify-center w-10 h-10 rounded-lg" style="background-color: {{ $event->color }}20; color: {{ $event->color }};">
                                    <i class="{{ $event->type_icon }} text-sm"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-lg font-semibold text-gray-900 truncate">{{ $event->title }}</h3>
                                    <p class="text-sm text-gray-600">{{ $event->type_name }}</p>
                                </div>
                            </div>
                            <div class="flex flex-col items-end">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $event->priority_color }}">
                                    {{ strtoupper($event->priority) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Event Body -->
                    <div class="p-6">
                        <!-- Date & Time -->
                        <div class="mb-4 space-y-2">
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span class="font-medium">{{ $event->formatted_date }}</span>
                                @if($event->days_until >= 0)
                                    <span class="ml-2 text-xs {{ $event->days_until <= 7 ? 'text-orange-600' : 'text-gray-500' }}">
                                        ({{ $event->days_until == 0 ? 'Today' : ($event->days_until == 1 ? 'Tomorrow' : $event->days_until . ' days') }})
                                    </span>
                                @endif
                            </div>
                            @if($event->formatted_time)
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>{{ $event->formatted_time }}</span>
                                </div>
                            @endif
                            @if($event->location)
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span>{{ $event->location }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- Description -->
                        @if($event->description)
                            <div class="mb-4">
                                <p class="text-sm text-gray-700 line-clamp-3">{{ $event->description }}</p>
                            </div>
                        @endif

                        <!-- Additional Info -->
                        <div class="mb-4 flex flex-wrap gap-2">
                            @if($event->is_company_wide)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-blue-100 text-blue-800">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"></path>
                                    </svg>
                                    Company-wide
                                </span>
                            @endif
                            @if($event->requires_rsvp)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-yellow-100 text-yellow-800">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                    </svg>
                                    RSVP Required
                                </span>
                            @endif
                            @if($event->is_recurring)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-purple-100 text-purple-800">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"></path>
                                    </svg>
                                    Recurring
                                </span>
                            @endif
                        </div>

                        <!-- Related Employee -->
                        @if($event->relatedEmployee)
                            <div class="mb-4 p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-gray-300 flex items-center justify-center text-xs font-medium text-gray-700">
                                        {{ substr($event->relatedEmployee->first_name, 0, 1) }}{{ substr($event->relatedEmployee->last_name, 0, 1) }}
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">{{ $event->relatedEmployee->first_name }} {{ $event->relatedEmployee->last_name }}</p>
                                        <p class="text-xs text-gray-500">{{ $event->relatedEmployee->employee_id }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Action Buttons -->
                        <div class="flex space-x-3">
                            <a href="{{ route('company-events.show', $event) }}" class="flex-1 inline-flex items-center justify-center px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                View
                            </a>
                            <a href="{{ route('company-events.edit', $event) }}" class="inline-flex items-center justify-center px-3 py-2 text-violet-600 hover:text-violet-800 text-sm font-medium transition-colors duration-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>
                            <form action="{{ route('company-events.destroy', $event) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this event?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center justify-center px-3 py-2 text-red-600 hover:text-red-800 text-sm font-medium transition-colors duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="text-center py-12">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No events found</h3>
                        <p class="text-gray-500 mb-6">Start by creating your first company event.</p>
                        <a href="{{ route('company-events.create') }}" class="inline-flex items-center px-4 py-2 bg-violet-600 hover:bg-violet-700 text-white font-semibold rounded-lg shadow-sm transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Add New Event
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($events->hasPages())
            <div class="mt-8">
                {{ $events->links() }}
            </div>
        @endif
    </div>
</div>

<style>
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection