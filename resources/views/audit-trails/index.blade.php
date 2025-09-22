@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Audit Trail</h1>
                        <p class="text-gray-600 mt-1">Track all system changes and user activities</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            {{ number_format($auditTrails->total()) }} Records
                        </span>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="px-6 py-4">
                <form method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Search descriptions..."
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Model Type</label>
                        <select name="model_type" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">All Models</option>
                            @foreach($modelTypes as $type)
                                <option value="{{ $type['value'] }}" {{ request('model_type') === $type['value'] ? 'selected' : '' }}>
                                    {{ $type['label'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Action</label>
                        <select name="action" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">All Actions</option>
                            @foreach($actions as $action)
                                <option value="{{ $action }}" {{ request('action') === $action ? 'selected' : '' }}>
                                    {{ ucfirst($action) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date From</label>
                        <input type="date" name="date_from" value="{{ request('date_from') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date To</label>
                        <input type="date" name="date_to" value="{{ request('date_to') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div class="flex items-end space-x-2">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium transition-colors">
                            Filter
                        </button>
                        <a href="{{ route('audit-trails.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-medium transition-colors">
                            Clear
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Audit Trail List -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            @if($auditTrails->isEmpty())
                <div class="text-center py-12">
                    <div class="text-gray-400 text-6xl mb-4">
                        <i class="fas fa-history"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No audit trails found</h3>
                    <p class="text-gray-600">No activities match your current filters.</p>
                </div>
            @else
                <div class="overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Activity</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Model</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Changes</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Time</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IP Address</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($auditTrails as $trail)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-8 w-8 rounded-full flex items-center justify-center
                                                        @if($trail->action === 'created') bg-green-100 text-green-600
                                                        @elseif($trail->action === 'updated') bg-blue-100 text-blue-600
                                                        @elseif($trail->action === 'deleted') bg-red-100 text-red-600
                                                        @else bg-gray-100 text-gray-600 @endif">
                                                @if($trail->action === 'created')
                                                    <i class="fas fa-plus text-xs"></i>
                                                @elseif($trail->action === 'updated')
                                                    <i class="fas fa-edit text-xs"></i>
                                                @elseif($trail->action === 'deleted')
                                                    <i class="fas fa-trash text-xs"></i>
                                                @else
                                                    <i class="fas fa-info text-xs"></i>
                                                @endif
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900 capitalize">{{ $trail->action }}</div>
                                                <div class="text-sm text-gray-600">{{ $trail->description }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ class_basename($trail->model_type) }}</div>
                                        <div class="text-sm text-gray-600">ID: {{ $trail->model_id }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $trail->user_name }}</div>
                                        @if($trail->user_id)
                                            <div class="text-sm text-gray-600">ID: {{ $trail->user_id }}</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if(!empty($trail->changed_fields))
                                            <div class="space-y-2 max-w-sm">
                                                @foreach($trail->changed_fields as $field => $values)
                                                    <div class="bg-gray-50 rounded-lg p-2">
                                                        <div class="text-xs font-semibold text-gray-700 mb-1 capitalize">
                                                            {{ str_replace('_', ' ', $field) }}
                                                        </div>
                                                        <div class="flex items-center space-x-2 text-xs">
                                                            <span class="bg-red-100 text-red-800 px-2 py-1 rounded border">
                                                                {{ $values['old'] ?? 'N/A' }}
                                                            </span>
                                                            <i class="fas fa-arrow-right text-gray-400"></i>
                                                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded border">
                                                                {{ $values['new'] ?? 'N/A' }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @elseif($trail->action === 'created' && !empty($trail->new_values))
                                            <div class="text-sm text-green-700">
                                                <i class="fas fa-plus-circle mr-1"></i>
                                                New record created
                                            </div>
                                        @elseif($trail->action === 'deleted')
                                            <div class="text-sm text-red-700">
                                                <i class="fas fa-trash mr-1"></i>
                                                Record deleted
                                            </div>
                                        @else
                                            <span class="text-sm text-gray-500">No changes recorded</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $trail->created_at->format('M j, Y') }}</div>
                                        <div class="text-sm text-gray-600">{{ $trail->created_at->format('g:i A') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $trail->ip_address ?? 'N/A' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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