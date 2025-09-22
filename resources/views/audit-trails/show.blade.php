@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $modelName }} Audit Trail</h1>
                        <p class="text-gray-600 mt-1">Activity history for {{ $modelName }} ID: {{ $modelId }}</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('audit-trails.index') }}"
                           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Back to All Audits
                        </a>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            {{ number_format($auditTrails->total()) }} Activities
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Timeline -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            @if($auditTrails->isEmpty())
                <div class="text-center py-12">
                    <div class="text-gray-400 text-6xl mb-4">
                        <i class="fas fa-history"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No audit trail found</h3>
                    <p class="text-gray-600">This {{ $modelName }} has no recorded activities.</p>
                </div>
            @else
                <div class="p-6">
                    <div class="flow-root">
                        <ul class="-mb-8">
                            @foreach($auditTrails as $index => $trail)
                                <li>
                                    <div class="relative pb-8">
                                        @if(!$loop->last)
                                            <span class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                        @endif
                                        <div class="relative flex items-start space-x-3">
                                            <div class="relative">
                                                <div class="h-10 w-10 rounded-full flex items-center justify-center ring-8 ring-white
                                                            @if($trail->action === 'created') bg-green-500
                                                            @elseif($trail->action === 'updated') bg-blue-500
                                                            @elseif($trail->action === 'deleted') bg-red-500
                                                            @else bg-gray-500 @endif">
                                                    @if($trail->action === 'created')
                                                        <i class="fas fa-plus text-white text-sm"></i>
                                                    @elseif($trail->action === 'updated')
                                                        <i class="fas fa-edit text-white text-sm"></i>
                                                    @elseif($trail->action === 'deleted')
                                                        <i class="fas fa-trash text-white text-sm"></i>
                                                    @else
                                                        <i class="fas fa-info text-white text-sm"></i>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <div>
                                                    <div class="text-sm">
                                                        <span class="font-medium text-gray-900">{{ $trail->user_name }}</span>
                                                        <span class="text-gray-600">{{ $trail->description }}</span>
                                                    </div>
                                                    <p class="mt-0.5 text-sm text-gray-500">
                                                        {{ $trail->created_at->format('M j, Y \a\t g:i A') }}
                                                        @if($trail->ip_address)
                                                            • {{ $trail->ip_address }}
                                                        @endif
                                                    </p>
                                                </div>

                                                @if(!empty($trail->changed_fields))
                                                    <div class="mt-3 p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border border-blue-200">
                                                        <h4 class="text-sm font-semibold text-blue-900 mb-3 flex items-center">
                                                            <i class="fas fa-edit mr-2"></i>
                                                            Changes Made:
                                                        </h4>
                                                        <div class="space-y-3">
                                                            @foreach($trail->changed_fields as $field => $values)
                                                                <div class="bg-white rounded-lg p-3 border border-blue-100">
                                                                    <div class="text-sm font-semibold text-gray-800 mb-2 capitalize">
                                                                        {{ str_replace('_', ' ', $field) }}
                                                                    </div>
                                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                                                        <div class="space-y-1">
                                                                            <div class="text-xs font-medium text-red-700 uppercase tracking-wide">Previous Value</div>
                                                                            <div class="bg-red-50 border border-red-200 rounded-lg p-2">
                                                                                <span class="text-sm text-red-800 font-mono">
                                                                                    {{ $values['old'] ?? 'N/A' }}
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="space-y-1">
                                                                            <div class="text-xs font-medium text-green-700 uppercase tracking-wide">New Value</div>
                                                                            <div class="bg-green-50 border border-green-200 rounded-lg p-2">
                                                                                <span class="text-sm text-green-800 font-mono">
                                                                                    {{ $values['new'] ?? 'N/A' }}
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mt-2 flex items-center justify-center">
                                                                        <div class="flex items-center space-x-2 text-gray-500">
                                                                            <div class="w-8 h-px bg-gray-300"></div>
                                                                            <i class="fas fa-arrow-right text-xs"></i>
                                                                            <div class="w-8 h-px bg-gray-300"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif

                                                @if($trail->action === 'created' && !empty($trail->new_values))
                                                    <div class="mt-3 p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border border-green-200">
                                                        <h4 class="text-sm font-semibold text-green-900 mb-3 flex items-center">
                                                            <i class="fas fa-plus-circle mr-2"></i>
                                                            Initial Values:
                                                        </h4>
                                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                                            @foreach($trail->new_values as $field => $value)
                                                                @if(!in_array($field, ['id', 'created_at', 'updated_at', 'password']))
                                                                    <div class="bg-white rounded-lg p-3 border border-green-100">
                                                                        <div class="text-xs font-medium text-green-700 uppercase tracking-wide mb-1">
                                                                            {{ str_replace('_', ' ', $field) }}
                                                                        </div>
                                                                        <div class="bg-green-50 border border-green-200 rounded p-2">
                                                                            <span class="text-sm text-green-800 font-mono">
                                                                                {{ is_array($value) ? json_encode($value) : ($value ?: 'N/A') }}
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif

                                                @if($trail->user_agent)
                                                    <div class="mt-2 text-xs text-gray-500">
                                                        <i class="fas fa-desktop mr-1"></i>
                                                        {{ $trail->user_agent }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Pagination -->
                @if($auditTrails->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $auditTrails->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection