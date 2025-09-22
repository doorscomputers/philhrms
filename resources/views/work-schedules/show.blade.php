@extends('layouts.dashboard')

@section('title', $workSchedule->name)

@section('content')
<div class="min-h-screen bg-gray-50/30">
    <!-- Header -->
    <div class="bg-white border-b border-gray-200 mb-8">
        <div class="px-6 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('work-schedules.index') }}"
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
                            <a href="{{ route('work-schedules.index') }}" class="hover:text-gray-700">Work Schedules</a>
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-900 font-medium">{{ $workSchedule->name }}</span>
                        </nav>
                        <h1 class="text-3xl font-bold text-gray-900">{{ $workSchedule->name }}</h1>
                        <p class="text-gray-600 mt-1">{{ $workSchedule->code }} • {{ $workSchedule->type }} • {{ $workSchedule->hours_per_day }}h/day</p>
                    </div>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('work-schedules.edit', $workSchedule) }}"
                       class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-lg font-medium transition-colors flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        <span>Edit Schedule</span>
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
                            <label class="block text-sm font-medium text-gray-500 mb-1">Schedule Code</label>
                            <p class="text-gray-900 font-medium">{{ $workSchedule->code }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Schedule Type</label>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $workSchedule->type }}
                            </span>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Hours Per Day</label>
                            <p class="text-gray-900">{{ $workSchedule->hours_per_day }} hours</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Days Per Week</label>
                            <p class="text-gray-900">{{ $workSchedule->days_per_week ?? 'N/A' }} days</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Break Duration</label>
                            <p class="text-gray-900">{{ $workSchedule->break_duration ?? 'N/A' }} minutes</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Company</label>
                            <p class="text-gray-900">{{ $workSchedule->company->name ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Weekly Schedule -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Weekly Schedule</h3>

                    <div class="space-y-3">
                        @php
                            $scheduleDetails = $workSchedule->schedule_details ?? [];
                            $daysOfWeek = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
                        @endphp

                        @foreach($daysOfWeek as $day)
                            @php
                                $daySchedule = $scheduleDetails[$day] ?? ['is_working_day' => false, 'start' => '08:00', 'end' => '17:00'];
                                $isWorkingDay = $daySchedule['is_working_day'] ?? false;
                            @endphp
                            <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                                <div class="flex items-center space-x-4">
                                    <div class="w-20">
                                        <span class="text-sm font-medium text-gray-900 capitalize">{{ $day }}</span>
                                    </div>
                                    <div>
                                        @if($isWorkingDay)
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Working Day
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                Rest Day
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex items-center space-x-4">
                                    @if($isWorkingDay)
                                        <div class="text-sm text-gray-900">
                                            {{ date('g:i A', strtotime($daySchedule['start'] ?? '08:00')) }} -
                                            {{ date('g:i A', strtotime($daySchedule['end'] ?? '17:00')) }}
                                        </div>
                                        @php
                                            $start = strtotime($daySchedule['start'] ?? '08:00');
                                            $end = strtotime($daySchedule['end'] ?? '17:00');
                                            $totalHours = round(($end - $start) / 3600, 1);
                                        @endphp
                                        <div class="text-xs text-gray-500">
                                            {{ $totalHours }}h
                                        </div>
                                    @else
                                        <div class="text-sm text-gray-500">
                                            No working hours
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Description -->
                @if($workSchedule->description)
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Description</h3>
                    <div class="prose prose-sm max-w-none text-gray-900">
                        {!! nl2br(e($workSchedule->description)) !!}
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
                            @if($workSchedule->is_active)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    Active
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                    Inactive
                                </span>
                            @endif
                        </div>

                        <div class="border-t border-gray-200 pt-4">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500">Assigned Employees</span>
                                <span class="text-2xl font-bold text-blue-600">{{ $workSchedule->employees->count() }}</span>
                            </div>
                        </div>

                        @php
                            $workingDays = collect($scheduleDetails)->filter(function($day) {
                                return $day['is_working_day'] ?? false;
                            })->count();
                            $totalWeeklyHours = $workingDays * $workSchedule->hours_per_day;
                        @endphp

                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">Working Days/Week</span>
                            <span class="text-lg font-semibold text-green-600">{{ $workingDays }}</span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">Total Weekly Hours</span>
                            <span class="text-lg font-semibold text-purple-600">{{ $totalWeeklyHours }}h</span>
                        </div>
                    </div>
                </div>

                <!-- Assigned Employees -->
                @if($workSchedule->employees->count() > 0)
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Assigned Employees</h3>

                    <div class="space-y-3">
                        @foreach($workSchedule->employees->take(5) as $employee)
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

                        @if($workSchedule->employees->count() > 5)
                        <div class="text-center pt-2">
                            <p class="text-sm text-gray-500">
                                and {{ $workSchedule->employees->count() - 5 }} more employees
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
                            <p class="text-gray-900">{{ $workSchedule->created_at->format('F j, Y g:i A') }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Last Updated</label>
                            <p class="text-gray-900">{{ $workSchedule->updated_at->format('F j, Y g:i A') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection