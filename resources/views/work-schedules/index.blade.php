@extends('layouts.dashboard')

@section('title', 'Work Schedules')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Work Schedule Management</h1>
            <p class="text-gray-600">Manage employee work schedules</p>
        </div>
        <a href="{{ route('work-schedules.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg font-medium">
            Add Schedule
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-sm">
        @forelse($workSchedules as $schedule)
            <div class="px-6 py-4 border-b border-gray-100">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-medium">{{ $schedule->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $schedule->code }} • {{ $schedule->type }}</p>
                        <p class="text-sm text-gray-400">{{ $schedule->hours_per_day }} hours/day</p>
                    </div>
                    <span class="px-2 py-1 text-xs rounded-full {{ $schedule->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ $schedule->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
            </div>
        @empty
            <div class="px-6 py-12 text-center">
                <h3 class="text-sm font-medium text-gray-900">No work schedules</h3>
                <p class="mt-1 text-sm text-gray-500">Create your first work schedule to get started.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection