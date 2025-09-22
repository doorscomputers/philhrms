@extends('layouts.dashboard')

@section('title', 'Positions')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Position Management</h1>
            <p class="text-gray-600">Manage job positions and roles</p>
        </div>
        <a href="{{ route('positions.create') }}"
           class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
            Add Position
        </a>
    </div>

    <!-- Positions List -->
    <div class="bg-white rounded-lg shadow-sm">
        @forelse($positions as $position)
            <div class="px-6 py-4 border-b border-gray-100 hover:bg-gray-50">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <h3 class="text-lg font-medium text-gray-900">{{ $position->title }}</h3>
                        <p class="text-sm text-gray-500">{{ $position->code }} • {{ $position->type }} • {{ $position->level }}</p>
                        @if($position->department)
                            <p class="text-sm text-gray-400">{{ $position->department->name }}</p>
                        @endif
                    </div>

                    <div class="flex items-center space-x-4">
                        @if($position->is_active)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Active
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                Inactive
                            </span>
                        @endif

                        <div class="flex space-x-2">
                            <a href="{{ route('positions.show', $position) }}" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </a>
                            <a href="{{ route('positions.edit', $position) }}" class="text-gray-400 hover:text-emerald-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="px-6 py-12 text-center">
                <h3 class="text-sm font-medium text-gray-900">No positions</h3>
                <p class="mt-1 text-sm text-gray-500">Create your first position to get started.</p>
                <div class="mt-6">
                    <a href="{{ route('positions.create') }}"
                       class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-emerald-600 hover:bg-emerald-700">
                        Add Position
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    @if($positions->hasPages())
        <div class="mt-6">
            {{ $positions->links() }}
        </div>
    @endif
</div>
@endsection