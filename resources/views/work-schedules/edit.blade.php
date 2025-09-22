@extends('layouts.dashboard')

@section('title', 'Edit Work Schedule')

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
                            <span class="text-gray-900 font-medium">Edit</span>
                        </nav>
                        <h1 class="text-3xl font-bold text-gray-900">Edit Work Schedule</h1>
                        <p class="text-gray-600 mt-1">Update work schedule information and time periods</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Content -->
    <div class="max-w-4xl mx-auto px-6 pb-12">
        <form action="{{ route('work-schedules.update', $workSchedule) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')

            <!-- Basic Information -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Basic Information</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Schedule Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Schedule Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   id="name"
                                   name="name"
                                   value="{{ old('name', $workSchedule->name) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('name') border-red-500 @enderror"
                                   placeholder="Enter schedule name">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Schedule Code -->
                        <div>
                            <label for="code" class="block text-sm font-medium text-gray-700 mb-2">
                                Schedule Code
                            </label>
                            <input type="text"
                                   id="code"
                                   name="code"
                                   value="{{ old('code', $workSchedule->code) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('code') border-red-500 @enderror"
                                   placeholder="Schedule code">
                            @error('code')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Schedule Type -->
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                                Schedule Type <span class="text-red-500">*</span>
                            </label>
                            <select id="type"
                                    name="type"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('type') border-red-500 @enderror">
                                <option value="">Select Schedule Type</option>
                                <option value="Fixed" {{ old('type', $workSchedule->type) == 'Fixed' ? 'selected' : '' }}>Fixed</option>
                                <option value="Flexible" {{ old('type', $workSchedule->type) == 'Flexible' ? 'selected' : '' }}>Flexible</option>
                                <option value="Shift" {{ old('type', $workSchedule->type) == 'Shift' ? 'selected' : '' }}>Shift</option>
                                <option value="Compressed" {{ old('type', $workSchedule->type) == 'Compressed' ? 'selected' : '' }}>Compressed</option>
                            </select>
                            @error('type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Hours Per Day -->
                        <div>
                            <label for="hours_per_day" class="block text-sm font-medium text-gray-700 mb-2">
                                Hours Per Day <span class="text-red-500">*</span>
                            </label>
                            <input type="number"
                                   id="hours_per_day"
                                   name="hours_per_day"
                                   value="{{ old('hours_per_day', $workSchedule->hours_per_day) }}"
                                   step="0.5"
                                   min="1"
                                   max="24"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('hours_per_day') border-red-500 @enderror"
                                   placeholder="8">
                            @error('hours_per_day')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Days Per Week -->
                        <div>
                            <label for="days_per_week" class="block text-sm font-medium text-gray-700 mb-2">
                                Days Per Week
                            </label>
                            <input type="number"
                                   id="days_per_week"
                                   name="days_per_week"
                                   value="{{ old('days_per_week', $workSchedule->days_per_week) }}"
                                   min="1"
                                   max="7"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('days_per_week') border-red-500 @enderror"
                                   placeholder="5">
                            @error('days_per_week')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Break Duration -->
                        <div>
                            <label for="break_duration" class="block text-sm font-medium text-gray-700 mb-2">
                                Break Duration (minutes)
                            </label>
                            <input type="number"
                                   id="break_duration"
                                   name="break_duration"
                                   value="{{ old('break_duration', $workSchedule->break_duration) }}"
                                   min="0"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('break_duration') border-red-500 @enderror"
                                   placeholder="60">
                            @error('break_duration')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Schedule Details -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Weekly Schedule</h3>
                    <p class="text-sm text-gray-600 mt-1">Define working hours for each day of the week</p>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @php
                            $existingSchedule = $workSchedule->schedule_details ?? [];
                        @endphp

                        @foreach(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day)
                            @php
                                $daySchedule = $existingSchedule[$day] ?? ['is_working_day' => in_array($day, ['monday', 'tuesday', 'wednesday', 'thursday', 'friday']), 'start' => '08:00', 'end' => '17:00'];
                                $isWorkingDay = $daySchedule['is_working_day'] ?? false;
                            @endphp
                        <div class="flex items-center space-x-4 p-4 border border-gray-200 rounded-lg">
                            <div class="w-20">
                                <label class="block text-sm font-medium text-gray-700 capitalize">{{ $day }}</label>
                            </div>
                            <div class="flex items-center space-x-2">
                                <input type="checkbox"
                                       id="{{ $day }}_working"
                                       name="schedule_details[{{ $day }}][is_working_day]"
                                       value="1"
                                       {{ $isWorkingDay ? 'checked' : '' }}
                                       class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded"
                                       onchange="toggleWorkingDay('{{ $day }}')">
                                <label for="{{ $day }}_working" class="text-sm text-gray-700">Working Day</label>
                            </div>
                            <div class="flex items-center space-x-4" id="{{ $day }}_times">
                                <div>
                                    <label class="block text-xs text-gray-500 mb-1">Start Time</label>
                                    <input type="time"
                                           name="schedule_details[{{ $day }}][start]"
                                           value="{{ $daySchedule['start'] ?? '08:00' }}"
                                           class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-500 mb-1">End Time</label>
                                    <input type="time"
                                           name="schedule_details[{{ $day }}][end]"
                                           value="{{ $daySchedule['end'] ?? '17:00' }}"
                                           class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Description</h3>
                </div>
                <div class="p-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Schedule Description
                    </label>
                    <textarea id="description"
                              name="description"
                              rows="4"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('description') border-red-500 @enderror"
                              placeholder="Enter schedule description">{{ old('description', $workSchedule->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Status -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Status</h3>
                </div>
                <div class="p-6">
                    <div class="flex items-center">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox"
                               id="is_active"
                               name="is_active"
                               value="1"
                               {{ old('is_active', $workSchedule->is_active) ? 'checked' : '' }}
                               class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded">
                        <label for="is_active" class="ml-2 block text-sm text-gray-900">
                            Active Schedule
                        </label>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-4">
                <a href="{{ route('work-schedules.index') }}"
                   class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium transition-colors">
                    Cancel
                </a>
                <button type="submit"
                        class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-lg font-medium transition-colors flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>Update Schedule</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function toggleWorkingDay(day) {
    const checkbox = document.getElementById(day + '_working');
    const timesContainer = document.getElementById(day + '_times');

    if (checkbox.checked) {
        timesContainer.style.opacity = '1';
        timesContainer.style.pointerEvents = 'auto';
    } else {
        timesContainer.style.opacity = '0.5';
        timesContainer.style.pointerEvents = 'none';
    }
}

// Initialize the state on page load
document.addEventListener('DOMContentLoaded', function() {
    ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'].forEach(function(day) {
        toggleWorkingDay(day);
    });
});
</script>
@endsection