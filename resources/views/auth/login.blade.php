@extends('layouts.app')

@section('content')
<div class="min-h-screen flex">
    <!-- Left Side - Login Form -->
    <div class="flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 lg:flex-none lg:px-20 xl:px-24 bg-gradient-to-br from-gray-50 to-white">
        <div class="mx-auto w-full max-w-sm lg:w-96">
            <!-- Header Section -->
            <div class="text-center lg:text-left">
                <div class="mx-auto lg:mx-0 h-16 w-16 bg-gradient-to-r from-emerald-500 to-teal-600 rounded-3xl shadow-xl flex items-center justify-center transform hover:scale-110 hover:rotate-3 transition-all duration-500">
                    <svg class="h-10 w-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <h1 class="mt-6 text-3xl font-bold text-gray-900">
                    Welcome to PH-HRMS
                </h1>
                <p class="mt-2 text-sm text-gray-600">
                    Sign in to your Human Resources Management System
                </p>
            </div>

            <!-- Login Form -->
            <div class="mt-8">
                <form class="space-y-6" method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="space-y-5">
                        <!-- Username Field -->
                        <div>
                            <label for="username" class="block text-sm font-semibold text-gray-700 mb-1">
                                Username
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <input id="username"
                                       name="username"
                                       type="text"
                                       required
                                       value="{{ old('username') }}"
                                       class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl shadow-sm placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-300 @error('username') border-red-300 focus:ring-red-500 @enderror"
                                       placeholder="Enter your username">
                            </div>
                            @error('username')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Password Field -->
                        <div>
                            <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">
                                Password
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                </div>
                                <input id="password"
                                       name="password"
                                       type="password"
                                       required
                                       class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl shadow-sm placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-300 @error('password') border-red-300 focus:ring-red-500 @enderror"
                                       placeholder="Enter your password">
                            </div>
                            @error('password')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember"
                                   name="remember"
                                   type="checkbox"
                                   class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded">
                            <label for="remember" class="ml-2 block text-sm text-gray-700">
                                Remember me
                            </label>
                        </div>

                        <div class="text-sm">
                            <a href="#" class="font-semibold text-emerald-600 hover:text-emerald-500 transition-colors duration-200">
                                Forgot your password?
                            </a>
                        </div>
                    </div>

                    <!-- Sign In Button -->
                    <div>
                        <button type="submit"
                                class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-semibold rounded-xl text-white bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 shadow-lg hover:shadow-xl transform hover:scale-[1.03] transition-all duration-300">
                            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-emerald-200 group-hover:text-emerald-100 transition-colors duration-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                </svg>
                            </span>
                            Sign in to your account
                        </button>
                    </div>
                </form>

                <!-- Security Notice -->
                <div class="mt-6">
                    <div class="text-center">
                        <p class="text-xs text-gray-500">
                            🔒 Your connection is secure and encrypted
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Side - Branded Content -->
    <div class="hidden lg:block relative w-0 flex-1">
        <div class="absolute inset-0 bg-gradient-to-br from-emerald-600 via-teal-700 to-cyan-800">
            <!-- Overlay -->
            <div class="absolute inset-0 bg-black bg-opacity-10"></div>

            <!-- Enhanced Floating Background Elements with Different Animations -->
            <div class="absolute top-16 left-16 w-36 h-36 bg-white bg-opacity-10 rounded-full blur-2xl animate-bounce"></div>
            <div class="absolute top-32 right-24 w-20 h-20 bg-emerald-300 bg-opacity-20 rounded-full blur-xl animate-ping"></div>
            <div class="absolute bottom-32 left-24 w-48 h-48 bg-teal-300 bg-opacity-15 rounded-full blur-3xl animate-pulse delay-1000"></div>
            <div class="absolute bottom-16 right-16 w-32 h-32 bg-cyan-300 bg-opacity-20 rounded-full blur-xl animate-bounce delay-300"></div>
            <div class="absolute top-1/2 left-1/4 w-16 h-16 bg-white bg-opacity-15 rounded-full blur-lg animate-ping delay-700"></div>
            <div class="absolute top-1/3 right-1/3 w-24 h-24 bg-emerald-400 bg-opacity-10 rounded-full blur-2xl animate-pulse delay-1500"></div>

            <!-- Content -->
            <div class="relative z-10 h-full flex flex-col justify-center px-12">
                <div class="max-w-md">
                    <!-- Large HR Icon with Enhanced Animation -->
                    <div class="mb-8">
                        <div class="h-20 w-20 bg-white bg-opacity-25 backdrop-blur-md rounded-3xl flex items-center justify-center transform hover:scale-110 hover:rotate-6 transition-all duration-500 shadow-2xl">
                            <svg class="h-12 w-12 text-white animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Main Heading -->
                    <h2 class="text-4xl font-bold text-white leading-tight mb-6">
                        Streamline Your
                        <span class="block bg-gradient-to-r from-emerald-200 to-cyan-200 bg-clip-text text-transparent">
                            HR Operations
                        </span>
                    </h2>

                    <!-- Description -->
                    <p class="text-lg text-emerald-100 mb-8 leading-relaxed">
                        Manage employees, track performance, handle payroll, and streamline HR processes all in one comprehensive platform.
                    </p>

                    <!-- Feature List with Staggered Animations -->
                    <div class="space-y-4">
                        <div class="flex items-center transform hover:translate-x-2 transition-transform duration-300">
                            <div class="flex-shrink-0">
                                <div class="h-8 w-8 bg-emerald-400 bg-opacity-30 rounded-full flex items-center justify-center animate-pulse">
                                    <svg class="h-4 w-4 text-emerald-200" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-emerald-100 font-medium">Employee Management & Analytics</p>
                            </div>
                        </div>

                        <div class="flex items-center transform hover:translate-x-2 transition-transform duration-300 delay-100">
                            <div class="flex-shrink-0">
                                <div class="h-8 w-8 bg-emerald-400 bg-opacity-30 rounded-full flex items-center justify-center animate-pulse delay-200">
                                    <svg class="h-4 w-4 text-emerald-200" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-emerald-100 font-medium">Automated Payroll & Benefits</p>
                            </div>
                        </div>

                        <div class="flex items-center transform hover:translate-x-2 transition-transform duration-300 delay-200">
                            <div class="flex-shrink-0">
                                <div class="h-8 w-8 bg-emerald-400 bg-opacity-30 rounded-full flex items-center justify-center animate-pulse delay-500">
                                    <svg class="h-4 w-4 text-emerald-200" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-emerald-100 font-medium">Performance Tracking & Reviews</p>
                            </div>
                        </div>

                        <div class="flex items-center transform hover:translate-x-2 transition-transform duration-300 delay-300">
                            <div class="flex-shrink-0">
                                <div class="h-8 w-8 bg-emerald-400 bg-opacity-30 rounded-full flex items-center justify-center animate-pulse delay-700">
                                    <svg class="h-4 w-4 text-emerald-200" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-emerald-100 font-medium">Compliance & Reporting Tools</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection