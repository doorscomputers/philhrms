<div class="flex flex-col h-full">
    <!-- Logo -->
    <div class="flex items-center justify-center h-16 bg-blue-600 text-white">
        <div class="flex items-center">
            <svg class="h-8 w-8 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
            </svg>
            <span class="text-xl font-bold">PH-HRMS</span>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-4 py-6 overflow-y-auto">
        <div class="space-y-1">
            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}"
               class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('dashboard') ? 'bg-blue-100 text-blue-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <svg class="mr-3 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2V7z"></path>
                </svg>
                Dashboard
            </a>

            <!-- Employee Management -->
            <div class="space-y-1" x-data="{ open: false }">
                <button @click="open = !open" class="group w-full flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                    <svg class="mr-3 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                    Employee Management
                    <svg class="ml-auto h-4 w-4 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="open" x-transition class="ml-8 space-y-1">
                    <a href="/spa/employees" class="group flex items-center px-2 py-2 text-sm text-gray-500 hover:text-gray-900">
                        Employee Records
                    </a>
                    <a href="#" class="group flex items-center px-2 py-2 text-sm text-gray-500 hover:text-gray-900">
                        Personal Information
                    </a>
                    <a href="#" class="group flex items-center px-2 py-2 text-sm text-gray-500 hover:text-gray-900">
                        Employment History
                    </a>

                    <!-- Manage Data Link -->
                    <a href="{{ route('manage-data.index') }}"
                       class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('manage-data.*') ? 'bg-emerald-100 text-emerald-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.79 4 8.5 4s8.5-1.79 8.5-4V7M4 7c0 2.21 3.79 4 8.5 4s8.5-1.79 8.5-4M4 7c0-2.21 3.79-4 8.5-4s8.5 1.79 8.5 4m0 5c0 2.21-3.79 4-8.5 4s-8.5-1.79-8.5-4"></path>
                        </svg>
                        Manage Data
                    </a>

                    <!-- Quick Access Dropdown (Optional) -->
                    <div class="space-y-1" x-data="{ quickAccessOpen: false }">
                        <button @click="quickAccessOpen = !quickAccessOpen" class="group w-full flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-500 hover:bg-gray-50 hover:text-gray-900">
                            <svg class="mr-3 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            Quick Access
                            <svg class="ml-auto h-3 w-3 transition-transform duration-200" :class="{ 'rotate-180': quickAccessOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="quickAccessOpen" x-transition class="ml-6 space-y-1">
                            <a href="{{ route('companies.index') }}" class="group flex items-center px-2 py-1 text-xs text-gray-400 hover:text-gray-600">
                                <svg class="mr-2 h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                Companies
                            </a>
                            <a href="{{ route('branches.index') }}" class="group flex items-center px-2 py-1 text-xs text-gray-400 hover:text-gray-600">
                                <svg class="mr-2 h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Company Branches
                            </a>
                            <a href="{{ route('departments.index') }}" class="group flex items-center px-2 py-1 text-xs text-gray-400 hover:text-gray-600">
                                <svg class="mr-2 h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                Departments
                            </a>
                            <a href="{{ route('positions.index') }}" class="group flex items-center px-2 py-1 text-xs text-gray-400 hover:text-gray-600">
                                <svg class="mr-2 h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V2a2 2 0 00-2-2H8a2 2 0 00-2 2v4M7 7h10a2 2 0 012 2v10a2 2 0 01-2 2H7a2 2 0 01-2-2V9a2 2 0 012-2z"></path>
                                </svg>
                                Positions
                            </a>
                            <a href="{{ route('job-grades.index') }}" class="group flex items-center px-2 py-1 text-xs text-gray-400 hover:text-gray-600">
                                <svg class="mr-2 h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                </svg>
                                Job Grades
                            </a>
                            <a href="{{ route('employment-statuses.index') }}" class="group flex items-center px-2 py-1 text-xs text-gray-400 hover:text-gray-600">
                                <svg class="mr-2 h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Employment Status
                            </a>
                            <a href="{{ route('cost-centers.index') }}" class="group flex items-center px-2 py-1 text-xs text-gray-400 hover:text-gray-600">
                                <svg class="mr-2 h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Cost Centers
                            </a>
                            <a href="{{ route('work-schedules.index') }}" class="group flex items-center px-2 py-1 text-xs text-gray-400 hover:text-gray-600">
                                <svg class="mr-2 h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Work Schedules
                            </a>
                            <a href="{{ route('payroll-groups.index') }}" class="group flex items-center px-2 py-1 text-xs text-gray-400 hover:text-gray-600">
                                <svg class="mr-2 h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                Payroll Groups
                            </a>
                            <a href="{{ route('leave-types.index') }}" class="group flex items-center px-2 py-1 text-xs text-gray-400 hover:text-gray-600">
                                <svg class="mr-2 h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a4 4 0 118 0v4m-8 0h8m-8 0H6a2 2 0 00-2 2v6a2 2 0 002 2h2m8-10h2a2 2 0 012 2v6a2 2 0 01-2 2h-2m0 0H8m8 0v4a4 4 0 11-8 0v-4m8 0V9a2 2 0 00-2-2H8a2 2 0 00-2 2v2"></path>
                                </svg>
                                Leave Types
                            </a>
                            <a href="{{ route('holidays.index') }}" class="group flex items-center px-2 py-1 text-xs text-gray-400 hover:text-gray-600">
                                <svg class="mr-2 h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a4 4 0 118 0v4m-8 0h8m-8 0H6a2 2 0 00-2 2v6a2 2 0 002 2h2m8-10h2a2 2 0 012 2v6a2 2 0 01-2 2h-2m0 0H8m8 0v4a4 4 0 11-8 0v-4m8 0V9a2 2 0 00-2-2H8a2 2 0 00-2 2v2"></path>
                                </svg>
                                Holidays
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Time & Attendance -->
            <div class="space-y-1">
                <button class="group w-full flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                    <svg class="mr-3 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Time & Attendance
                    <svg class="ml-auto h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="ml-8 space-y-1">
                    <a href="#" class="group flex items-center px-2 py-2 text-sm text-gray-500 hover:text-gray-900">
                        Time Logs
                    </a>
                    <a href="#" class="group flex items-center px-2 py-2 text-sm text-gray-500 hover:text-gray-900">
                        Overtime Requests
                    </a>
                    <a href="#" class="group flex items-center px-2 py-2 text-sm text-gray-500 hover:text-gray-900">
                        Work Schedules
                    </a>
                </div>
            </div>

            <!-- Leave Management -->
            <div class="space-y-1">
                <button class="group w-full flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                    <svg class="mr-3 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Leave Management
                    <svg class="ml-auto h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="ml-8 space-y-1">
                    <a href="#" class="group flex items-center px-2 py-2 text-sm text-gray-500 hover:text-gray-900">
                        Leave Applications
                    </a>
                    <a href="#" class="group flex items-center px-2 py-2 text-sm text-gray-500 hover:text-gray-900">
                        Leave Balances
                    </a>
                    <a href="#" class="group flex items-center px-2 py-2 text-sm text-gray-500 hover:text-gray-900">
                        Leave Types
                    </a>
                </div>
            </div>

            <!-- Payroll -->
            <div class="space-y-1">
                <button class="group w-full flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                    <svg class="mr-3 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Payroll
                    <svg class="ml-auto h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="ml-8 space-y-1">
                    <a href="#" class="group flex items-center px-2 py-2 text-sm text-gray-500 hover:text-gray-900">
                        Payroll Runs
                    </a>
                    <a href="#" class="group flex items-center px-2 py-2 text-sm text-gray-500 hover:text-gray-900">
                        Salary Adjustments
                    </a>
                    <a href="#" class="group flex items-center px-2 py-2 text-sm text-gray-500 hover:text-gray-900">
                        Government Reports
                    </a>
                </div>
            </div>

            <!-- Organization -->
            <div class="space-y-1">
                <button class="group w-full flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                    <svg class="mr-3 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    Organization
                    <svg class="ml-auto h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="ml-8 space-y-1">
                    <a href="{{ route('companies.index') }}" class="group flex items-center px-2 py-2 text-sm text-gray-500 hover:text-gray-900">
                        Company Profile
                    </a>
                    <a href="{{ route('branches.index') }}" class="group flex items-center px-2 py-2 text-sm text-gray-500 hover:text-gray-900">
                        Branches/Offices
                    </a>
                    <a href="{{ route('departments.index') }}" class="group flex items-center px-2 py-2 text-sm text-gray-500 hover:text-gray-900">
                        Departments
                    </a>
                    <a href="{{ route('positions.index') }}" class="group flex items-center px-2 py-2 text-sm text-gray-500 hover:text-gray-900">
                        Positions
                    </a>
                    <a href="{{ route('job-grades.index') }}" class="group flex items-center px-2 py-2 text-sm text-gray-500 hover:text-gray-900">
                        Job Grades
                    </a>
                    <a href="{{ route('cost-centers.index') }}" class="group flex items-center px-2 py-2 text-sm text-gray-500 hover:text-gray-900">
                        Cost Centers
                    </a>
                    <a href="{{ route('work-schedules.index') }}" class="group flex items-center px-2 py-2 text-sm text-gray-500 hover:text-gray-900">
                        Work Schedules
                    </a>
                </div>
            </div>

            <!-- Audit Trail -->
            <a href="{{ route('audit-trails.index') }}"
               class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('audit-trails.*') ? 'bg-purple-100 text-purple-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <svg class="mr-3 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
                Audit Trail
            </a>

            <!-- Reports -->
            <a href="#"
               class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                <svg class="mr-3 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Reports
            </a>

            <!-- Settings -->
            <a href="#"
               class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                <svg class="mr-3 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                Settings
            </a>
        </div>
    </nav>
</div>