@extends('layouts.dashboard')

@section('title', 'Create Company Event')

@section('content')
<div class="min-h-screen bg-gray-50/30">
    <!-- Enhanced Header -->
    <div class="bg-white border-b border-gray-200 mb-8">
        <div class="px-6 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Create Company Event</h1>
                    <p class="text-gray-600 mt-1">Add a new event, meeting, or activity to the company calendar</p>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('company-events.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-lg shadow-sm transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Events
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-6 pb-12">
        @if($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                <div class="flex">
                    <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="ml-3">
                        <h3 class="text-red-800 font-medium">Please fix the following errors:</h3>
                        <ul class="mt-2 text-red-700">
                            @foreach($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('company-events.store') }}" method="POST" class="space-y-8">
            @csrf

            <!-- Basic Information -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Basic Information</h2>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Title -->
                    <div class="md:col-span-2">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Event Title *</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-violet-500 focus:border-violet-500">
                    </div>

                    <!-- Event Type -->
                    <div>
                        <label for="event_type" class="block text-sm font-medium text-gray-700 mb-2">Event Type *</label>
                        <select name="event_type" id="event_type" required onchange="updateEventColor()"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-violet-500 focus:border-violet-500">
                            <option value="">Select Event Type</option>
                            <option value="company_meeting" {{ old('event_type') == 'company_meeting' ? 'selected' : '' }}>Company Meeting</option>
                            <option value="training" {{ old('event_type') == 'training' ? 'selected' : '' }}>Training</option>
                            <option value="holiday" {{ old('event_type') == 'holiday' ? 'selected' : '' }}>Holiday</option>
                            <option value="birthday" {{ old('event_type') == 'birthday' ? 'selected' : '' }}>Birthday</option>
                            <option value="work_anniversary" {{ old('event_type') == 'work_anniversary' ? 'selected' : '' }}>Work Anniversary</option>
                            <option value="team_building" {{ old('event_type') == 'team_building' ? 'selected' : '' }}>Team Building</option>
                            <option value="performance_review" {{ old('event_type') == 'performance_review' ? 'selected' : '' }}>Performance Review</option>
                            <option value="compliance_training" {{ old('event_type') == 'compliance_training' ? 'selected' : '' }}>Compliance Training</option>
                            <option value="benefits_enrollment" {{ old('event_type') == 'benefits_enrollment' ? 'selected' : '' }}>Benefits Enrollment</option>
                            <option value="social_event" {{ old('event_type') == 'social_event' ? 'selected' : '' }}>Social Event</option>
                            <option value="conference" {{ old('event_type') == 'conference' ? 'selected' : '' }}>Conference</option>
                            <option value="deadline" {{ old('event_type') == 'deadline' ? 'selected' : '' }}>Deadline</option>
                            <option value="other" {{ old('event_type') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>

                    <!-- Priority -->
                    <div>
                        <label for="priority" class="block text-sm font-medium text-gray-700 mb-2">Priority *</label>
                        <select name="priority" id="priority" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-violet-500 focus:border-violet-500">
                            <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low</option>
                            <option value="medium" {{ old('priority', 'medium') == 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
                            <option value="critical" {{ old('priority') == 'critical' ? 'selected' : '' }}>Critical</option>
                        </select>
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <textarea name="description" id="description" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-violet-500 focus:border-violet-500"
                                  placeholder="Brief description of the event...">{{ old('description') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Date & Time -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Date & Time</h2>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Event Date -->
                    <div>
                        <label for="event_date" class="block text-sm font-medium text-gray-700 mb-2">Event Date *</label>
                        <input type="date" name="event_date" id="event_date" value="{{ old('event_date') }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-violet-500 focus:border-violet-500">
                    </div>

                    <!-- All Day -->
                    <div class="flex items-center">
                        <label class="flex items-center">
                            <input type="checkbox" name="is_all_day" id="is_all_day" value="1" {{ old('is_all_day') ? 'checked' : '' }}
                                   onchange="toggleTimeFields()" class="rounded border-gray-300 text-violet-600 focus:ring-violet-500">
                            <span class="ml-2 text-sm text-gray-700">All Day Event</span>
                        </label>
                    </div>

                    <!-- Start Time -->
                    <div id="start_time_field">
                        <label for="start_time" class="block text-sm font-medium text-gray-700 mb-2">Start Time</label>
                        <input type="time" name="start_time" id="start_time" value="{{ old('start_time') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-violet-500 focus:border-violet-500">
                    </div>

                    <!-- End Time -->
                    <div id="end_time_field">
                        <label for="end_time" class="block text-sm font-medium text-gray-700 mb-2">End Time</label>
                        <input type="time" name="end_time" id="end_time" value="{{ old('end_time') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-violet-500 focus:border-violet-500">
                    </div>

                    <!-- Location -->
                    <div class="md:col-span-2">
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-2">Location</label>
                        <input type="text" name="location" id="location" value="{{ old('location') }}"
                               placeholder="Conference Room A, Virtual Meeting, etc."
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-violet-500 focus:border-violet-500">
                    </div>
                </div>
            </div>

            <!-- Targeting & Settings -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Event Settings</h2>
                </div>
                <div class="p-6 space-y-6">
                    <!-- Company Wide -->
                    <div class="flex items-center">
                        <label class="flex items-center">
                            <input type="checkbox" name="is_company_wide" id="is_company_wide" value="1" {{ old('is_company_wide', true) ? 'checked' : '' }}
                                   onchange="toggleTargeting()" class="rounded border-gray-300 text-violet-600 focus:ring-violet-500">
                            <span class="ml-2 text-sm text-gray-700">Company-wide Event</span>
                        </label>
                    </div>

                    <!-- RSVP Settings -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="flex items-center">
                            <label class="flex items-center">
                                <input type="checkbox" name="requires_rsvp" id="requires_rsvp" value="1" {{ old('requires_rsvp') ? 'checked' : '' }}
                                       onchange="toggleMaxAttendees()" class="rounded border-gray-300 text-violet-600 focus:ring-violet-500">
                                <span class="ml-2 text-sm text-gray-700">Requires RSVP</span>
                            </label>
                        </div>

                        <div id="max_attendees_field" style="display: none;">
                            <label for="max_attendees" class="block text-sm font-medium text-gray-700 mb-2">Max Attendees</label>
                            <input type="number" name="max_attendees" id="max_attendees" value="{{ old('max_attendees') }}" min="1"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-violet-500 focus:border-violet-500">
                        </div>
                    </div>

                    <!-- Related Employee (for birthdays/anniversaries) -->
                    <div id="related_employee_field" style="display: none;">
                        <label for="related_employee_id" class="block text-sm font-medium text-gray-700 mb-2">Related Employee</label>
                        <select name="related_employee_id" id="related_employee_id"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-violet-500 focus:border-violet-500">
                            <option value="">Select Employee</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}" {{ old('related_employee_id') == $employee->id ? 'selected' : '' }}>
                                    {{ $employee->first_name }} {{ $employee->last_name }} ({{ $employee->employee_id }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Color -->
                    <div>
                        <label for="color" class="block text-sm font-medium text-gray-700 mb-2">Event Color</label>
                        <input type="color" name="color" id="color" value="{{ old('color', '#3B82F6') }}"
                               class="w-20 h-10 border border-gray-300 rounded-lg focus:ring-violet-500 focus:border-violet-500">
                    </div>

                    <!-- Meeting Link -->
                    <div>
                        <label for="meeting_link" class="block text-sm font-medium text-gray-700 mb-2">Meeting Link</label>
                        <input type="url" name="meeting_link" id="meeting_link" value="{{ old('meeting_link') }}"
                               placeholder="https://meet.google.com/xyz-abc-def"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-violet-500 focus:border-violet-500">
                    </div>

                    <!-- Notes -->
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Additional Notes</label>
                        <textarea name="notes" id="notes" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-violet-500 focus:border-violet-500"
                                  placeholder="Any additional information or instructions...">{{ old('notes') }}</textarea>
                    </div>

                    <!-- Reminders -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="flex items-center">
                            <label class="flex items-center">
                                <input type="checkbox" name="send_reminders" id="send_reminders" value="1" {{ old('send_reminders', true) ? 'checked' : '' }}
                                       onchange="toggleReminderDays()" class="rounded border-gray-300 text-violet-600 focus:ring-violet-500">
                                <span class="ml-2 text-sm text-gray-700">Send Reminders</span>
                            </label>
                        </div>

                        <div id="reminder_days_field">
                            <label for="reminder_days_before" class="block text-sm font-medium text-gray-700 mb-2">Days Before</label>
                            <input type="number" name="reminder_days_before" id="reminder_days_before" value="{{ old('reminder_days_before', 1) }}" min="0" max="30"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-violet-500 focus:border-violet-500">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('company-events.index') }}"
                   class="px-6 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors duration-200">
                    Cancel
                </a>
                <button type="submit"
                        class="px-6 py-2 bg-violet-600 hover:bg-violet-700 text-white font-medium rounded-lg shadow-sm transition-colors duration-200">
                    Create Event
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function toggleTimeFields() {
    const isAllDay = document.getElementById('is_all_day').checked;
    const startField = document.getElementById('start_time_field');
    const endField = document.getElementById('end_time_field');

    if (isAllDay) {
        startField.style.display = 'none';
        endField.style.display = 'none';
        document.getElementById('start_time').required = false;
        document.getElementById('end_time').required = false;
    } else {
        startField.style.display = 'block';
        endField.style.display = 'block';
    }
}

function toggleMaxAttendees() {
    const requiresRsvp = document.getElementById('requires_rsvp').checked;
    const maxAttendeesField = document.getElementById('max_attendees_field');

    if (requiresRsvp) {
        maxAttendeesField.style.display = 'block';
    } else {
        maxAttendeesField.style.display = 'none';
    }
}

function toggleReminderDays() {
    const sendReminders = document.getElementById('send_reminders').checked;
    const reminderDaysField = document.getElementById('reminder_days_field');

    if (sendReminders) {
        reminderDaysField.style.display = 'block';
    } else {
        reminderDaysField.style.display = 'none';
    }
}

function updateEventColor() {
    const eventType = document.getElementById('event_type').value;
    const colorField = document.getElementById('color');
    const relatedEmployeeField = document.getElementById('related_employee_field');

    const colors = {
        'company_meeting': '#3B82F6',
        'training': '#10B981',
        'holiday': '#8B5CF6',
        'birthday': '#EC4899',
        'work_anniversary': '#059669',
        'team_building': '#06B6D4',
        'performance_review': '#8B5CF6',
        'compliance_training': '#F59E0B',
        'benefits_enrollment': '#10B981',
        'social_event': '#F59E0B',
        'conference': '#6366F1',
        'deadline': '#DC2626',
        'other': '#6B7280'
    };

    if (colors[eventType]) {
        colorField.value = colors[eventType];
    }

    // Show related employee field for birthdays and anniversaries
    if (eventType === 'birthday' || eventType === 'work_anniversary') {
        relatedEmployeeField.style.display = 'block';
    } else {
        relatedEmployeeField.style.display = 'none';
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    toggleTimeFields();
    toggleMaxAttendees();
    toggleReminderDays();
    updateEventColor();
});
</script>
@endsection