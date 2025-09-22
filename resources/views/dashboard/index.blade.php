@extends('layouts.dashboard')

@section('title', 'Admin Dashboard')
@section('page-title', 'Admin Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Welcome Section with User Profile -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <img class="h-16 w-16 rounded-full object-cover border-4 border-blue-100"
                         src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&color=3B82F6&background=EBF4FF"
                         alt="{{ auth()->user()->name }}">
                    <div class="absolute -top-1 -right-1 h-5 w-5 bg-green-400 border-2 border-white rounded-full"></div>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">
                        Welcome Back, {{ auth()->user()->name }}!
                    </h2>
                    <p class="text-gray-600">
                        You have <span class="font-semibold text-blue-600">21 Pending Approvals</span> &
                        <span class="font-semibold text-orange-600">14 Leave Requests</span>
                    </p>
                </div>
            </div>
            <div class="flex space-x-3">
                <a href="/spa/employees" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                    Employee Management
                </a>
                <a href="/spa/employees/create" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add Employee
                </a>
                <button class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0V6a2 2 0 012-2h4a2 2 0 012 2v1m-6 0h8m-8 0H6a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V9a2 2 0 00-2-2h-2m-8 0V7"></path>
                    </svg>
                    Reports
                </button>
            </div>
        </div>
    </div>

    <!-- Statistics Cards Row 1 -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Attendance Overview -->
        <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-orange-500">
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center space-x-2">
                        <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-sm font-medium text-gray-600">Attendance Overview</h3>
                    </div>
                    <div class="mt-2">
                        <div class="text-2xl font-bold text-gray-900">120/154</div>
                        <div class="text-sm text-green-600 font-medium">▲ +2.1%</div>
                    </div>
                </div>
                <div class="text-right">
                    <button class="text-blue-600 hover:text-blue-700 text-sm font-medium">View Details</button>
                </div>
            </div>
        </div>

        <!-- Infrastructure Projects -->
        <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center space-x-2">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <h3 class="text-sm font-medium text-gray-600">Infrastructure Projects</h3>
                    </div>
                    <div class="mt-2">
                        <div class="text-2xl font-bold text-gray-900">12/18</div>
                        <div class="text-sm text-green-600 font-medium">▲ +8.2%</div>
                    </div>
                </div>
                <div class="text-right">
                    <button class="text-blue-600 hover:text-blue-700 text-sm font-medium">View Projects</button>
                </div>
            </div>
        </div>

        <!-- Citizen Requests -->
        <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-blue-400">
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center space-x-2">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                        </div>
                        <h3 class="text-sm font-medium text-gray-600">Citizen Requests</h3>
                    </div>
                    <div class="mt-2">
                        <div class="text-2xl font-bold text-gray-900">156</div>
                        <div class="text-sm text-green-600 font-medium">▲ +15.4%</div>
                    </div>
                </div>
                <div class="text-right">
                    <button class="text-blue-600 hover:text-blue-700 text-sm font-medium">View Requests</button>
                </div>
            </div>
        </div>

        <!-- Permits Issued -->
        <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-pink-500">
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center space-x-2">
                        <div class="w-10 h-10 bg-pink-100 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-sm font-medium text-gray-600">Permits Issued</h3>
                    </div>
                    <div class="mt-2">
                        <div class="text-2xl font-bold text-gray-900">89</div>
                        <div class="text-sm text-green-600 font-medium">▲ +22.1%</div>
                    </div>
                </div>
                <div class="text-right">
                    <button class="text-blue-600 hover:text-blue-700 text-sm font-medium">View Permits</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards Row 2 -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Budget Utilization -->
        <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center space-x-2">
                        <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-sm font-medium text-gray-600">Budget Utilization</h3>
                    </div>
                    <div class="mt-2">
                        <div class="text-2xl font-bold text-gray-900">₱2.4M/₱3.2M</div>
                        <div class="text-sm text-green-600 font-medium">▲ 75% utilized</div>
                    </div>
                </div>
                <div class="text-right">
                    <button class="text-blue-600 hover:text-blue-700 text-sm font-medium">View Budget</button>
                </div>
            </div>
        </div>

        <!-- Public Services -->
        <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-red-500">
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center space-x-2">
                        <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <h3 class="text-sm font-medium text-gray-600">Public Services</h3>
                    </div>
                    <div class="mt-2">
                        <div class="text-2xl font-bold text-gray-900">245</div>
                        <div class="text-sm text-green-600 font-medium">▲ +12.3%</div>
                    </div>
                </div>
                <div class="text-right">
                    <button class="text-blue-600 hover:text-blue-700 text-sm font-medium">View Services</button>
                </div>
            </div>
        </div>

        <!-- Document Requests -->
        <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center space-x-2">
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-sm font-medium text-gray-600">Document Requests</h3>
                    </div>
                    <div class="mt-2">
                        <div class="text-2xl font-bold text-gray-900">156</div>
                        <div class="text-sm text-green-600 font-medium">▲ +18.5%</div>
                    </div>
                </div>
                <div class="text-right">
                    <button class="text-blue-600 hover:text-blue-700 text-sm font-medium">View Documents</button>
                </div>
            </div>
        </div>

        <!-- New Hire -->
        <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-gray-500">
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center space-x-2">
                        <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                        </div>
                        <h3 class="text-sm font-medium text-gray-600">New Hire This month</h3>
                    </div>
                    <div class="mt-2">
                        <div class="text-2xl font-bold text-gray-900">45/48</div>
                        <div class="text-sm text-red-600 font-medium">▼ -11.2%</div>
                    </div>
                </div>
                <div class="text-right">
                    <button class="text-blue-600 hover:text-blue-700 text-sm font-medium">View Candidates</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column (2/3 width) -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Employee Status & Attendance Overview -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Employee Status -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Employee Status</h3>
                        <span class="text-sm text-gray-500">This Week</span>
                    </div>

                    <div class="mb-4">
                        <div class="text-sm text-gray-600 mb-2">Total Employee</div>
                        <div class="text-3xl font-bold text-gray-900">154</div>
                    </div>

                    <!-- Status Bars -->
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center space-x-2">
                                <div class="w-3 h-3 bg-orange-500 rounded-full"></div>
                                <span class="text-sm font-medium">Fulltime (48%)</span>
                            </div>
                            <span class="text-lg font-bold">112</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <div class="flex items-center space-x-2">
                                <div class="w-3 h-3 bg-teal-600 rounded-full"></div>
                                <span class="text-sm font-medium">Contract (20%)</span>
                            </div>
                            <span class="text-lg font-bold">21</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <div class="flex items-center space-x-2">
                                <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                                <span class="text-sm font-medium">Probation (22%)</span>
                            </div>
                            <span class="text-lg font-bold">12</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <div class="flex items-center space-x-2">
                                <div class="w-3 h-3 bg-pink-500 rounded-full"></div>
                                <span class="text-sm font-medium">WFH (20%)</span>
                            </div>
                            <span class="text-lg font-bold">04</span>
                        </div>
                    </div>

                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-sm text-gray-600">Top Performer</div>
                                <div class="flex items-center space-x-2 mt-1">
                                    <img class="w-6 h-6 rounded-full" src="https://ui-avatars.com/api/?name=Daniel+Esbella&color=3B82F6&background=EBF4FF" alt="Daniel Esbella">
                                    <div>
                                        <div class="text-sm font-medium">Daniel Esbella</div>
                                        <div class="text-xs text-gray-500">iOS Developer</div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-sm text-gray-600">Performance</div>
                                <div class="text-lg font-bold text-green-600">99%</div>
                            </div>
                        </div>
                        <a href="/spa/employees" class="block w-full mt-3 text-center text-blue-600 hover:text-blue-700 text-sm font-medium">View All Employees</a>
                    </div>
                </div>

                <!-- Attendance Overview -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Attendance Overview</h3>
                        <span class="text-sm text-gray-500">Today</span>
                    </div>

                    <!-- Donut Chart Placeholder -->
                    <div class="flex items-center justify-center mb-4">
                        <div class="relative w-32 h-32">
                            <div class="w-32 h-32 rounded-full" style="background: conic-gradient(#10B981 0% 59%, #F59E0B 59% 80%, #EF4444 80% 95%, #EC4899 95% 100%);"></div>
                            <div class="absolute inset-4 bg-white rounded-full flex items-center justify-center">
                                <div class="text-center">
                                    <div class="text-xs text-gray-600">Total Attendance</div>
                                    <div class="text-xl font-bold">120</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Status Legend -->
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center space-x-2">
                                <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                <span>Present</span>
                            </div>
                            <span class="font-medium">59%</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <div class="flex items-center space-x-2">
                                <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                                <span>Late</span>
                            </div>
                            <span class="font-medium">21%</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <div class="flex items-center space-x-2">
                                <div class="w-3 h-3 bg-purple-500 rounded-full"></div>
                                <span>Permission</span>
                            </div>
                            <span class="font-medium">2%</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <div class="flex items-center space-x-2">
                                <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                                <span>Absent</span>
                            </div>
                            <span class="font-medium">15</span>
                        </div>
                    </div>

                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Total Absentees</span>
                            <div class="flex -space-x-2">
                                <img class="w-6 h-6 rounded-full border-2 border-white" src="https://ui-avatars.com/api/?name=User1&color=3B82F6&background=EBF4FF" alt="">
                                <img class="w-6 h-6 rounded-full border-2 border-white" src="https://ui-avatars.com/api/?name=User2&color=EF4444&background=FEE2E2" alt="">
                                <img class="w-6 h-6 rounded-full border-2 border-white" src="https://ui-avatars.com/api/?name=User3&color=10B981&background=D1FAE5" alt="">
                                <div class="w-6 h-6 rounded-full border-2 border-white bg-gray-200 flex items-center justify-center text-xs">+3</div>
                            </div>
                        </div>
                        <button class="w-full mt-3 text-center text-blue-600 hover:text-blue-700 text-sm font-medium">View Details</button>
                    </div>
                </div>
            </div>

            <!-- Employees By Department Chart -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Employees By Department</h3>
                    <span class="text-sm text-gray-500">This Week</span>
                </div>

                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">UI/UX</span>
                        <div class="flex-1 mx-4">
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-orange-500 h-2 rounded-full" style="width: 85%"></div>
                            </div>
                        </div>
                        <span class="text-sm font-medium text-gray-900">85%</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">Development</span>
                        <div class="flex-1 mx-4">
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-orange-500 h-2 rounded-full" style="width: 90%"></div>
                            </div>
                        </div>
                        <span class="text-sm font-medium text-gray-900">90%</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">Management</span>
                        <div class="flex-1 mx-4">
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-orange-500 h-2 rounded-full" style="width: 70%"></div>
                            </div>
                        </div>
                        <span class="text-sm font-medium text-gray-900">70%</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">HR</span>
                        <div class="flex-1 mx-4">
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-orange-500 h-2 rounded-full" style="width: 45%"></div>
                            </div>
                        </div>
                        <span class="text-sm font-medium text-gray-900">45%</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">Testing</span>
                        <div class="flex-1 mx-4">
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-orange-500 h-2 rounded-full" style="width: 60%"></div>
                            </div>
                        </div>
                        <span class="text-sm font-medium text-gray-900">60%</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">Marketing</span>
                        <div class="flex-1 mx-4">
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-orange-500 h-2 rounded-full" style="width: 55%"></div>
                            </div>
                        </div>
                        <span class="text-sm font-medium text-gray-900">55%</span>
                    </div>
                </div>

                <div class="mt-4 pt-4 border-t border-gray-200 text-center">
                    <span class="text-sm text-gray-600">• No of Employees increased by </span>
                    <span class="text-sm font-semibold text-green-600">+20%</span>
                    <span class="text-sm text-gray-600"> from last Week</span>
                </div>
            </div>
        </div>

        <!-- Right Column (1/3 width) -->
        <div class="space-y-6">
            <!-- Clock In/Out Section -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Clock-In/Out</h3>
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-600">All Departments</span>
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <img class="w-10 h-10 rounded-full" src="https://ui-avatars.com/api/?name=Daniel+Esbella&color=3B82F6&background=EBF4FF" alt="">
                            <div>
                                <div class="font-medium text-sm">Daniel Esbella</div>
                                <div class="text-xs text-gray-500">UI/UX Designer</div>
                            </div>
                        </div>
                        <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">09:15</span>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <img class="w-10 h-10 rounded-full" src="https://ui-avatars.com/api/?name=Doglas+Martini&color=EF4444&background=FEE2E2" alt="">
                            <div>
                                <div class="font-medium text-sm">Doglas Martini</div>
                                <div class="text-xs text-gray-500">Project Manager</div>
                            </div>
                        </div>
                        <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">09:30</span>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <img class="w-10 h-10 rounded-full" src="https://ui-avatars.com/api/?name=Brian+Villalobos&color=10B981&background=D1FAE5" alt="">
                            <div>
                                <div class="font-medium text-sm">Brian Villalobos</div>
                                <div class="text-xs text-gray-500">PHP Developer</div>
                            </div>
                        </div>
                        <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">09:20</span>
                    </div>

                    <div class="pt-3 border-t border-gray-200 space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">• Clock In</span>
                            <span class="font-medium">10:30 AM</span>
                            <span class="text-gray-600">• Clock Out</span>
                            <span class="font-medium">06:45 AM</span>
                            <span class="text-gray-600">• Production</span>
                            <span class="font-medium">09:21 Hrs</span>
                        </div>

                        <div class="pt-3 border-t border-gray-200">
                            <div class="text-sm font-medium text-gray-900 mb-2">Late</div>
                            <div class="flex items-center justify-between p-2 bg-red-50 rounded-lg">
                                <div class="flex items-center space-x-2">
                                    <img class="w-8 h-8 rounded-full" src="https://ui-avatars.com/api/?name=Anthony+Lewis&color=EF4444&background=FEE2E2" alt="">
                                    <div>
                                        <div class="font-medium text-xs">Anthony Lewis</div>
                                        <div class="text-xs text-gray-500">Marketing Head</div>
                                    </div>
                                </div>
                                <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full">30 Min</span>
                            </div>
                        </div>
                    </div>

                    <button class="w-full mt-4 text-center text-blue-600 hover:text-blue-700 text-sm font-medium">View All Attendance</button>
                </div>
            </div>

            <!-- Todo Section -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Todo</h3>
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-600">Today</span>
                        <button class="w-6 h-6 bg-orange-500 rounded-full flex items-center justify-center text-white">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="space-y-3">
                    <div class="flex items-center space-x-3 p-3 border border-gray-200 rounded-lg">
                        <div class="w-2 h-2 bg-gray-400 rounded-full"></div>
                        <span class="text-sm">Add Holidays</span>
                    </div>
                    <div class="flex items-center space-x-3 p-3 border border-orange-200 bg-orange-50 rounded-lg">
                        <div class="w-2 h-2 bg-orange-500 rounded-full"></div>
                        <span class="text-sm">Add Meeting to Client</span>
                    </div>
                    <div class="flex items-center space-x-3 p-3 border border-gray-200 rounded-lg">
                        <div class="w-2 h-2 bg-gray-400 rounded-full"></div>
                        <span class="text-sm">Chat with Adrian</span>
                    </div>
                    <div class="flex items-center space-x-3 p-3 border border-gray-200 rounded-lg">
                        <div class="w-2 h-2 bg-gray-400 rounded-full"></div>
                        <span class="text-sm">Management Call</span>
                    </div>
                    <div class="flex items-center space-x-3 p-3 border border-gray-200 rounded-lg">
                        <div class="w-2 h-2 bg-gray-400 rounded-full"></div>
                        <span class="text-sm">Add Payroll</span>
                    </div>
                    <div class="flex items-center space-x-3 p-3 border border-gray-200 rounded-lg">
                        <div class="w-2 h-2 bg-gray-400 rounded-full"></div>
                        <span class="text-sm">Add Policy for Increment</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection