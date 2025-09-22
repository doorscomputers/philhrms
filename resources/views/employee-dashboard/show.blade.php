@extends('layouts.dashboard')

@section('title', 'Employee Dashboard - ' . $employee->first_name . ' ' . $employee->last_name)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <a href="{{ route('employees.index') }}" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Employee Dashboard</h1>
                <p class="text-gray-600">{{ $employee->first_name }} {{ $employee->last_name }}'s personal dashboard</p>
            </div>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('employees.show', $employee) }}"
               class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-medium transition-colors">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                View Profile
            </a>
            <a href="{{ route('employees.edit', $employee) }}"
               class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit Employee
            </a>
        </div>
    </div>

    <!-- Employee Summary Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
        <div class="flex items-start space-x-6">
            <div class="relative">
                <img class="w-24 h-24 rounded-full object-cover border-4 border-gray-100"
                     src="https://ui-avatars.com/api/?name={{ urlencode($employee->first_name . ' ' . $employee->last_name) }}&color=3B82F6&background=EBF4FF&size=256"
                     alt="{{ $employee->first_name }} {{ $employee->last_name }}">
                @if($employee->is_active)
                    <div class="absolute -top-1 -right-1 h-6 w-6 bg-green-400 border-4 border-white rounded-full"></div>
                @endif
            </div>

            <div class="flex-1">
                <div class="flex items-center space-x-4 mb-2">
                    <h2 class="text-2xl font-bold text-gray-900">
                        {{ $employee->first_name }}
                        @if($employee->middle_name){{ substr($employee->middle_name, 0, 1) }}.@endif
                        {{ $employee->last_name }}
                    </h2>
                    <span class="px-3 py-1 text-sm font-medium rounded-full
                        @if($employee->employment_status === 'Regular') bg-green-100 text-green-800
                        @elseif($employee->employment_status === 'Probationary') bg-yellow-100 text-yellow-800
                        @elseif($employee->employment_status === 'Contractual') bg-blue-100 text-blue-800
                        @else bg-gray-100 text-gray-800 @endif">
                        {{ $employee->employment_status }}
                    </span>
                </div>

                <p class="text-lg text-gray-600 mb-1">{{ $employee->position->title ?? 'N/A' }}</p>
                <p class="text-gray-500 mb-4">{{ $employee->department->name ?? 'N/A' }} • Employee ID: {{ $employee->employee_id }}</p>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                        <div class="text-lg font-semibold text-gray-900">{{ \Carbon\Carbon::parse($employee->hire_date)->diffInYears() }}</div>
                        <div class="text-sm text-gray-600">Years of Service</div>
                    </div>
                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                        <div class="text-lg font-semibold text-green-600">{{ number_format($attendance_summary['attendance_rate'], 1) }}%</div>
                        <div class="text-sm text-gray-600">Attendance Rate</div>
                    </div>
                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                        <div class="text-lg font-semibold text-blue-600">{{ $attendance_summary['hours_worked'] }}h</div>
                        <div class="text-sm text-gray-600">Hours This Month</div>
                    </div>
                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                        <div class="text-lg font-semibold text-purple-600">₱{{ number_format($employee->basic_salary, 2) }}</div>
                        <div class="text-sm text-gray-600">Basic Salary</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dashboard Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Attendance & Performance -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Attendance Summary -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Attendance Summary</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="text-center p-4 bg-green-50 rounded-lg">
                        <div class="text-2xl font-bold text-green-600">{{ $attendance_summary['present_days'] }}</div>
                        <div class="text-sm text-gray-600">Present Days</div>
                    </div>
                    <div class="text-center p-4 bg-red-50 rounded-lg">
                        <div class="text-2xl font-bold text-red-600">{{ $attendance_summary['late_days'] }}</div>
                        <div class="text-sm text-gray-600">Late Days</div>
                    </div>
                    <div class="text-center p-4 bg-blue-50 rounded-lg">
                        <div class="text-2xl font-bold text-blue-600">{{ $attendance_summary['hours_worked'] }}</div>
                        <div class="text-sm text-gray-600">Total Hours</div>
                    </div>
                    <div class="text-center p-4 bg-orange-50 rounded-lg">
                        <div class="text-2xl font-bold text-orange-600">{{ $attendance_summary['overtime_hours'] }}</div>
                        <div class="text-sm text-gray-600">Overtime Hours</div>
                    </div>
                </div>
            </div>

            <!-- Recent Activities -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Recent Activities</h3>
                    <button class="text-emerald-600 hover:text-emerald-700 text-sm font-medium">View All</button>
                </div>
                <div class="space-y-4">
                    @foreach($recent_activities as $activity)
                    <div class="flex items-start space-x-3 p-4 bg-gray-50 rounded-lg">
                        <div class="p-2 bg-white rounded-lg shadow-sm">
                            @if($activity['icon'] === 'clock')
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            @elseif($activity['icon'] === 'calendar')
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            @else
                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            @endif
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-gray-900">{{ $activity['description'] }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $activity['date']->diffForHumans() }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Leave Balances -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Leave Balances</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-green-100 rounded-lg">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-gray-900">Vacation</span>
                        </div>
                        <span class="text-lg font-bold text-green-600">{{ $leave_balances['vacation_leave'] }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-red-100 rounded-lg">
                                <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-gray-900">Sick</span>
                        </div>
                        <span class="text-lg font-bold text-red-600">{{ $leave_balances['sick_leave'] }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-orange-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-orange-100 rounded-lg">
                                <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.966-.833-2.732 0L4.732 15.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-gray-900">Emergency</span>
                        </div>
                        <span class="text-lg font-bold text-orange-600">{{ $leave_balances['emergency_leave'] }}</span>
                    </div>
                </div>
            </div>

            <!-- Upcoming Events -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Upcoming Events</h3>
                <div class="space-y-3">
                    @foreach($upcoming_events as $event)
                    <div class="flex items-center space-x-3 p-3 border border-gray-100 rounded-lg">
                        <div class="p-2
                            @if($event['type'] === 'meeting') bg-blue-100
                            @elseif($event['type'] === 'review') bg-orange-100
                            @else bg-green-100 @endif
                            rounded-lg">
                            @if($event['type'] === 'meeting')
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            @elseif($event['type'] === 'review')
                                <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                </svg>
                            @else
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            @endif
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">{{ $event['title'] }}</p>
                            <p class="text-xs text-gray-500">{{ $event['date']->format('M d') }} • {{ $event['time'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                <div class="space-y-3">
                    <button class="w-full bg-emerald-600 hover:bg-emerald-700 text-white py-2 px-4 rounded-lg text-sm font-medium transition-colors">
                        Request Leave
                    </button>
                    <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg text-sm font-medium transition-colors">
                        Update Information
                    </button>
                    <button class="w-full bg-purple-600 hover:bg-purple-700 text-white py-2 px-4 rounded-lg text-sm font-medium transition-colors">
                        View Payslip
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection