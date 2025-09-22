@extends('layouts.dashboard')

@section('title', 'Edit Company')

@section('content')
<div class="min-h-screen bg-gray-50/30">
    <!-- Enhanced Header with Breadcrumb -->
    <div class="bg-white border-b border-gray-200 mb-8">
        <div class="px-6 py-6">
            <div class="flex items-center space-x-4 mb-4">
                <a href="{{ route('companies.show', $company) }}"
                   class="inline-flex items-center justify-center w-10 h-10 rounded-lg border border-gray-200 bg-white hover:bg-gray-50 transition-colors group">
                    <svg class="w-5 h-5 text-gray-500 group-hover:text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div class="flex-1">
                    <nav class="flex items-center space-x-2 text-sm text-gray-500 mb-2">
                        <a href="{{ route('dashboard') }}" class="hover:text-gray-700">Dashboard</a>
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <a href="{{ route('companies.index') }}" class="hover:text-gray-700">Companies</a>
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <a href="{{ route('companies.show', $company) }}" class="hover:text-gray-700">{{ $company->name }}</a>
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-gray-900 font-medium">Edit</span>
                    </nav>
                    <h1 class="text-3xl font-bold text-gray-900">Edit {{ $company->name }}</h1>
                    <p class="text-gray-600 mt-1">Update company information</p>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-6xl mx-auto px-6 pb-12">

        <!-- Form -->
        <form action="{{ route('companies.update', $company) }}" method="POST" class="space-y-8">
                @csrf
                @method('PUT')

                <!-- Basic Information -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Basic Information</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="code" class="block text-sm font-medium text-gray-700 mb-2">Company Code *</label>
                            <input type="text" name="code" id="code" value="{{ old('code', $company->code) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('code') border-red-500 @enderror"
                                   placeholder="COMP001" maxlength="20" required>
                            @error('code')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Company Name *</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $company->name) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('name') border-red-500 @enderror"
                                   placeholder="ABC Corporation" required>
                            @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="legal_name" class="block text-sm font-medium text-gray-700 mb-2">Legal Name *</label>
                            <input type="text" name="legal_name" id="legal_name" value="{{ old('legal_name', $company->legal_name) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('legal_name') border-red-500 @enderror"
                                   placeholder="ABC Corporation Inc." required>
                            @error('legal_name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="business_type" class="block text-sm font-medium text-gray-700 mb-2">Business Type *</label>
                            <select name="business_type" id="business_type"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('business_type') border-red-500 @enderror" required>
                                <option value="">Select Business Type</option>
                                <option value="Corporation" {{ old('business_type', $company->business_type) == 'Corporation' ? 'selected' : '' }}>Corporation</option>
                                <option value="Partnership" {{ old('business_type', $company->business_type) == 'Partnership' ? 'selected' : '' }}>Partnership</option>
                                <option value="Sole Proprietorship" {{ old('business_type', $company->business_type) == 'Sole Proprietorship' ? 'selected' : '' }}>Sole Proprietorship</option>
                                <option value="Cooperative" {{ old('business_type', $company->business_type) == 'Cooperative' ? 'selected' : '' }}>Cooperative</option>
                                <option value="Non-Profit" {{ old('business_type', $company->business_type) == 'Non-Profit' ? 'selected' : '' }}>Non-Profit</option>
                            </select>
                            @error('business_type')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="industry" class="block text-sm font-medium text-gray-700 mb-2">Industry *</label>
                            <select name="industry" id="industry"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('industry') border-red-500 @enderror" required>
                                <option value="">Select Industry</option>
                                <option value="Technology" {{ old('industry', $company->industry) == 'Technology' ? 'selected' : '' }}>Technology</option>
                                <option value="Healthcare" {{ old('industry', $company->industry) == 'Healthcare' ? 'selected' : '' }}>Healthcare</option>
                                <option value="Finance" {{ old('industry', $company->industry) == 'Finance' ? 'selected' : '' }}>Finance</option>
                                <option value="Manufacturing" {{ old('industry', $company->industry) == 'Manufacturing' ? 'selected' : '' }}>Manufacturing</option>
                                <option value="Retail" {{ old('industry', $company->industry) == 'Retail' ? 'selected' : '' }}>Retail</option>
                                <option value="Education" {{ old('industry', $company->industry) == 'Education' ? 'selected' : '' }}>Education</option>
                                <option value="Construction" {{ old('industry', $company->industry) == 'Construction' ? 'selected' : '' }}>Construction</option>
                                <option value="Hospitality" {{ old('industry', $company->industry) == 'Hospitality' ? 'selected' : '' }}>Hospitality</option>
                                <option value="Real Estate" {{ old('industry', $company->industry) == 'Real Estate' ? 'selected' : '' }}>Real Estate</option>
                                <option value="Other" {{ old('industry', $company->industry) == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('industry')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="date_established" class="block text-sm font-medium text-gray-700 mb-2">Date Established *</label>
                            <input type="date" name="date_established" id="date_established" value="{{ old('date_established', $company->date_established->format('Y-m-d')) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('date_established') border-red-500 @enderror" required>
                            @error('date_established')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                <!-- Government Registration -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Government Registration</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="tin" class="block text-sm font-medium text-gray-700 mb-2">TIN *</label>
                            <input type="text" name="tin" id="tin" value="{{ old('tin', $company->tin) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('tin') border-red-500 @enderror"
                                   placeholder="123-456-789-000" maxlength="20" required>
                            @error('tin')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="bir_rdo_code" class="block text-sm font-medium text-gray-700 mb-2">BIR RDO Code *</label>
                            <input type="text" name="bir_rdo_code" id="bir_rdo_code" value="{{ old('bir_rdo_code', $company->bir_rdo_code) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('bir_rdo_code') border-red-500 @enderror"
                                   placeholder="050" maxlength="10" required>
                            @error('bir_rdo_code')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="sec_registration" class="block text-sm font-medium text-gray-700 mb-2">SEC Registration</label>
                            <input type="text" name="sec_registration" id="sec_registration" value="{{ old('sec_registration', $company->sec_registration) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('sec_registration') border-red-500 @enderror"
                                   placeholder="SEC Registration Number">
                            @error('sec_registration')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="dti_registration" class="block text-sm font-medium text-gray-700 mb-2">DTI Registration</label>
                            <input type="text" name="dti_registration" id="dti_registration" value="{{ old('dti_registration', $company->dti_registration) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('dti_registration') border-red-500 @enderror"
                                   placeholder="DTI Registration Number">
                            @error('dti_registration')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="sss_employer_number" class="block text-sm font-medium text-gray-700 mb-2">SSS Employer Number</label>
                            <input type="text" name="sss_employer_number" id="sss_employer_number" value="{{ old('sss_employer_number', $company->sss_employer_number) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('sss_employer_number') border-red-500 @enderror"
                                   placeholder="SSS Employer Number" maxlength="20">
                            @error('sss_employer_number')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="philhealth_employer_number" class="block text-sm font-medium text-gray-700 mb-2">PhilHealth Employer Number</label>
                            <input type="text" name="philhealth_employer_number" id="philhealth_employer_number" value="{{ old('philhealth_employer_number', $company->philhealth_employer_number) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('philhealth_employer_number') border-red-500 @enderror"
                                   placeholder="PhilHealth Employer Number" maxlength="20">
                            @error('philhealth_employer_number')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="pagibig_employer_number" class="block text-sm font-medium text-gray-700 mb-2">Pag-IBIG Employer Number</label>
                            <input type="text" name="pagibig_employer_number" id="pagibig_employer_number" value="{{ old('pagibig_employer_number', $company->pagibig_employer_number) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('pagibig_employer_number') border-red-500 @enderror"
                                   placeholder="Pag-IBIG Employer Number" maxlength="20">
                            @error('pagibig_employer_number')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                <!-- Address Information -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Address Information</h3>

                    <div id="addresses-container">
                        @foreach($company->addresses as $index => $address)
                        <div class="address-group border border-gray-200 rounded-lg p-4 mb-4">
                            <div class="flex justify-between items-center mb-4">
                                <h4 class="font-medium text-gray-800">Address #{{ $index + 1 }}</h4>
                                @if($index > 0)
                                <button type="button" class="text-red-600 hover:text-red-700 text-sm">Remove</button>
                                @endif
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Address Type *</label>
                                    <select name="addresses[{{ $index }}][type]" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" required>
                                        <option value="">Select Type</option>
                                        <option value="Main Office" {{ old("addresses.{$index}.type", $address['type']) == 'Main Office' ? 'selected' : '' }}>Main Office</option>
                                        <option value="Branch Office" {{ old("addresses.{$index}.type", $address['type']) == 'Branch Office' ? 'selected' : '' }}>Branch Office</option>
                                        <option value="Warehouse" {{ old("addresses.{$index}.type", $address['type']) == 'Warehouse' ? 'selected' : '' }}>Warehouse</option>
                                        <option value="Plant" {{ old("addresses.{$index}.type", $address['type']) == 'Plant' ? 'selected' : '' }}>Plant</option>
                                    </select>
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Street Address *</label>
                                    <input type="text" name="addresses[{{ $index }}][address]" value="{{ old("addresses.{$index}.address", $address['address']) }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                           placeholder="123 Main Street" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">City *</label>
                                    <input type="text" name="addresses[{{ $index }}][city]" value="{{ old("addresses.{$index}.city", $address['city']) }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                           placeholder="Makati City" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Province *</label>
                                    <input type="text" name="addresses[{{ $index }}][province]" value="{{ old("addresses.{$index}.province", $address['province']) }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                           placeholder="Metro Manila" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Region *</label>
                                    <input type="text" name="addresses[{{ $index }}][region]" value="{{ old("addresses.{$index}.region", $address['region'] ?? '') }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                           placeholder="NCR" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Postal Code *</label>
                                    <input type="text" name="addresses[{{ $index }}][postal_code]" value="{{ old("addresses.{$index}.postal_code", $address['postal_code'] ?? '') }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                           placeholder="1234" maxlength="10" required>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Contact Information</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($company->contact_numbers as $index => $number)
                        <div>
                            <label for="contact_numbers_{{ $index }}" class="block text-sm font-medium text-gray-700 mb-2">Contact Number {{ $index > 0 ? '#' . ($index + 1) : '*' }}</label>
                            <input type="text" name="contact_numbers[]" id="contact_numbers_{{ $index }}" value="{{ old("contact_numbers.{$index}", $number) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                   placeholder="+63 2 1234 5678" {{ $index == 0 ? 'required' : '' }}>
                        </div>
                        @endforeach

                        @foreach($company->email_addresses as $index => $email)
                        <div>
                            <label for="email_addresses_{{ $index }}" class="block text-sm font-medium text-gray-700 mb-2">Email Address {{ $index > 0 ? '#' . ($index + 1) : '*' }}</label>
                            <input type="email" name="email_addresses[]" id="email_addresses_{{ $index }}" value="{{ old("email_addresses.{$index}", $email) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                   placeholder="info@company.com" {{ $index == 0 ? 'required' : '' }}>
                        </div>
                        @endforeach

                        <div class="md:col-span-2">
                            <label for="website" class="block text-sm font-medium text-gray-700 mb-2">Website</label>
                            <input type="url" name="website" id="website" value="{{ old('website', $company->website) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('website') border-red-500 @enderror"
                                   placeholder="https://www.company.com">
                            @error('website')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                <!-- Business Details -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Business Details</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="authorized_capital" class="block text-sm font-medium text-gray-700 mb-2">Authorized Capital</label>
                            <input type="number" name="authorized_capital" id="authorized_capital" value="{{ old('authorized_capital', $company->authorized_capital) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('authorized_capital') border-red-500 @enderror"
                                   placeholder="1000000" step="0.01" min="0">
                            @error('authorized_capital')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="paid_up_capital" class="block text-sm font-medium text-gray-700 mb-2">Paid-up Capital</label>
                            <input type="number" name="paid_up_capital" id="paid_up_capital" value="{{ old('paid_up_capital', $company->paid_up_capital) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('paid_up_capital') border-red-500 @enderror"
                                   placeholder="500000" step="0.01" min="0">
                            @error('paid_up_capital')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="total_employees" class="block text-sm font-medium text-gray-700 mb-2">Total Employees</label>
                            <input type="number" name="total_employees" id="total_employees" value="{{ old('total_employees', $company->total_employees) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('total_employees') border-red-500 @enderror"
                                   placeholder="50" min="0">
                            @error('total_employees')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                <!-- System Configuration -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">System Configuration</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                            <select name="status" id="status"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('status') border-red-500 @enderror" required>
                                <option value="Active" {{ old('status', $company->status) == 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Inactive" {{ old('status', $company->status) == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="Suspended" {{ old('status', $company->status) == 'Suspended' ? 'selected' : '' }}>Suspended</option>
                            </select>
                            @error('status')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="subscription_plan" class="block text-sm font-medium text-gray-700 mb-2">Subscription Plan *</label>
                            <select name="subscription_plan" id="subscription_plan"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('subscription_plan') border-red-500 @enderror" required>
                                <option value="Basic" {{ old('subscription_plan', $company->subscription_plan) == 'Basic' ? 'selected' : '' }}>Basic</option>
                                <option value="Standard" {{ old('subscription_plan', $company->subscription_plan) == 'Standard' ? 'selected' : '' }}>Standard</option>
                                <option value="Premium" {{ old('subscription_plan', $company->subscription_plan) == 'Premium' ? 'selected' : '' }}>Premium</option>
                                <option value="Enterprise" {{ old('subscription_plan', $company->subscription_plan) == 'Enterprise' ? 'selected' : '' }}>Enterprise</option>
                            </select>
                            @error('subscription_plan')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="subscription_expires_at" class="block text-sm font-medium text-gray-700 mb-2">Subscription Expires At</label>
                            <input type="date" name="subscription_expires_at" id="subscription_expires_at" value="{{ old('subscription_expires_at', $company->subscription_expires_at?->format('Y-m-d')) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('subscription_expires_at') border-red-500 @enderror">
                            @error('subscription_expires_at')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="fiscal_year_start_month" class="block text-sm font-medium text-gray-700 mb-2">Fiscal Year Start Month *</label>
                            <select name="fiscal_year_start_month" id="fiscal_year_start_month"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('fiscal_year_start_month') border-red-500 @enderror" required>
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ old('fiscal_year_start_month', $company->fiscal_year_start_month) == $i ? 'selected' : '' }}>
                                        {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                    </option>
                                @endfor
                            </select>
                            @error('fiscal_year_start_month')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="fiscal_year_end_month" class="block text-sm font-medium text-gray-700 mb-2">Fiscal Year End Month *</label>
                            <select name="fiscal_year_end_month" id="fiscal_year_end_month"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('fiscal_year_end_month') border-red-500 @enderror" required>
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ old('fiscal_year_end_month', $company->fiscal_year_end_month) == $i ? 'selected' : '' }}>
                                        {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                    </option>
                                @endfor
                            </select>
                            @error('fiscal_year_end_month')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('companies.show', $company) }}"
                       class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium transition-colors">
                        Cancel
                    </a>
                    <button type="submit"
                            class="px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-medium transition-colors">
                        Update Company
                    </button>
                </div>
        </form>
    </div>
</div>
@endsection