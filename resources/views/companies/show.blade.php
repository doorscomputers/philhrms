@extends('layouts.dashboard')

@section('title', $company->name)

@section('content')
<div class="min-h-screen bg-gray-50/30">
    <!-- Header -->
    <div class="bg-white border-b border-gray-200 mb-8">
        <div class="px-6 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('companies.index') }}"
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
                            <a href="{{ route('companies.index') }}" class="hover:text-gray-700">Companies</a>
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-900 font-medium">{{ $company->name }}</span>
                        </nav>
                        <h1 class="text-3xl font-bold text-gray-900">{{ $company->name }}</h1>
                        <p class="text-gray-600 mt-1">{{ $company->code }} • {{ $company->industry }}</p>
                    </div>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('companies.edit', $company) }}"
                       class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-lg font-medium transition-colors flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        <span>Edit Company</span>
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
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Basic Information</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Company Code</label>
                            <p class="text-gray-900 font-medium">{{ $company->code }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Legal Name</label>
                            <p class="text-gray-900">{{ $company->legal_name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Business Type</label>
                            <p class="text-gray-900">{{ $company->business_type }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Industry</label>
                            <p class="text-gray-900">{{ $company->industry }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Date Established</label>
                            <p class="text-gray-900">{{ $company->date_established->format('F j, Y') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Total Employees</label>
                            <p class="text-gray-900">{{ number_format($company->total_employees) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Government Registration -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Government Registration</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">TIN</label>
                            <p class="text-gray-900 font-mono">{{ $company->tin }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">BIR RDO Code</label>
                            <p class="text-gray-900">{{ $company->bir_rdo_code }}</p>
                        </div>
                        @if($company->sec_registration)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">SEC Registration</label>
                            <p class="text-gray-900">{{ $company->sec_registration }}</p>
                        </div>
                        @endif
                        @if($company->dti_registration)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">DTI Registration</label>
                            <p class="text-gray-900">{{ $company->dti_registration }}</p>
                        </div>
                        @endif
                        @if($company->sss_employer_number)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">SSS Employer Number</label>
                            <p class="text-gray-900">{{ $company->sss_employer_number }}</p>
                        </div>
                        @endif
                        @if($company->philhealth_employer_number)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">PhilHealth Employer Number</label>
                            <p class="text-gray-900">{{ $company->philhealth_employer_number }}</p>
                        </div>
                        @endif
                        @if($company->pagibig_employer_number)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Pag-IBIG Employer Number</label>
                            <p class="text-gray-900">{{ $company->pagibig_employer_number }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Address Information -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Address Information</h3>

                    <div class="space-y-4">
                        @foreach($company->addresses as $address)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex items-center space-x-2 mb-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $address['type'] }}
                                </span>
                            </div>
                            <div class="text-gray-900">
                                <p>{{ $address['address'] }}</p>
                                <p>{{ $address['city'] }}, {{ $address['province'] }}</p>
                                @if(isset($address['region']))<p>{{ $address['region'] }}</p>@endif
                                @if(isset($address['postal_code']))<p>{{ $address['postal_code'] }}</p>@endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Contact Information</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-3">Contact Numbers</label>
                            <div class="space-y-2">
                                @foreach($company->contact_numbers as $number)
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                    <span class="text-gray-900">{{ $number }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-3">Email Addresses</label>
                            <div class="space-y-2">
                                @foreach($company->email_addresses as $email)
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                    <a href="mailto:{{ $email }}" class="text-emerald-600 hover:text-emerald-700">{{ $email }}</a>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @if($company->website)
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-500 mb-2">Website</label>
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9m0 9c-5 0-9-4-9-9s4-9 9-9"></path>
                                </svg>
                                <a href="{{ $company->website }}" target="_blank" class="text-emerald-600 hover:text-emerald-700">{{ $company->website }}</a>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-8">
                <!-- Status & Info -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Status & Information</h3>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-2">Status</label>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                @if($company->status === 'Active') bg-green-100 text-green-800
                                @elseif($company->status === 'Inactive') bg-gray-100 text-gray-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ $company->status }}
                            </span>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-2">Subscription Plan</label>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                {{ $company->subscription_plan }}
                            </span>
                        </div>

                        @if($company->subscription_expires_at)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Subscription Expires</label>
                            <p class="text-gray-900">{{ $company->subscription_expires_at->format('F j, Y') }}</p>
                        </div>
                        @endif

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Fiscal Year</label>
                            <p class="text-gray-900">
                                {{ DateTime::createFromFormat('!m', $company->fiscal_year_start_month)->format('F') }} -
                                {{ DateTime::createFromFormat('!m', $company->fiscal_year_end_month)->format('F') }}
                            </p>
                        </div>

                        @if($company->authorized_capital)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Authorized Capital</label>
                            <p class="text-gray-900">₱{{ number_format($company->authorized_capital, 2) }}</p>
                        </div>
                        @endif

                        @if($company->paid_up_capital)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Paid-up Capital</label>
                            <p class="text-gray-900">₱{{ number_format($company->paid_up_capital, 2) }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Quick Stats</h3>

                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Branches</span>
                            <span class="font-semibold text-gray-900">{{ $company->branches->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Departments</span>
                            <span class="font-semibold text-gray-900">{{ $company->departments->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Employees</span>
                            <span class="font-semibold text-gray-900">{{ $company->employees->count() }}</span>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Recent Branches</h3>

                    @forelse($company->branches->take(5) as $branch)
                    <div class="flex items-center space-x-3 py-3 border-b border-gray-100 last:border-b-0">
                        <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h4M9 7h6m-6 4h6m-6 4h6"></path>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ $branch->name }}</p>
                            <p class="text-xs text-gray-500">{{ $branch->type }}</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-gray-500 text-sm">No branches yet</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection