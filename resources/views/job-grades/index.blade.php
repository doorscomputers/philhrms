@extends('layouts.dashboard')

@section('title', 'Job Grades')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Job Grade Management</h1>
            <p class="text-gray-600">Manage salary grades and levels</p>
        </div>
        <a href="{{ route('job-grades.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg font-medium">
            Add Job Grade
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-sm">
        @forelse($jobGrades as $grade)
            <div class="px-6 py-4 border-b border-gray-100">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-medium">{{ $grade->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $grade->code }} • Level {{ $grade->level }}</p>
                        <p class="text-sm text-gray-400">₱{{ number_format($grade->min_salary, 2) }} - ₱{{ number_format($grade->max_salary, 2) }}</p>
                    </div>
                    <span class="px-2 py-1 text-xs rounded-full {{ $grade->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ $grade->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
            </div>
        @empty
            <div class="px-6 py-12 text-center">
                <h3 class="text-sm font-medium text-gray-900">No job grades</h3>
                <p class="mt-1 text-sm text-gray-500">Create your first job grade to get started.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection