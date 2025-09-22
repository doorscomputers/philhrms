@extends('layouts.dashboard')

@section('title', 'Cost Centers')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Cost Center Management</h1>
            <p class="text-gray-600">Manage budget allocation centers</p>
        </div>
        <a href="{{ route('cost-centers.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg font-medium">
            Add Cost Center
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-sm">
        @forelse($costCenters as $center)
            <div class="px-6 py-4 border-b border-gray-100">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-medium">{{ $center->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $center->code }}</p>
                        @if($center->budget_amount)
                            <p class="text-sm text-gray-400">Budget: ₱{{ number_format($center->budget_amount, 2) }}</p>
                        @endif
                    </div>
                    <span class="px-2 py-1 text-xs rounded-full {{ $center->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ $center->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
            </div>
        @empty
            <div class="px-6 py-12 text-center">
                <h3 class="text-sm font-medium text-gray-900">No cost centers</h3>
                <p class="mt-1 text-sm text-gray-500">Create your first cost center to get started.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection