@extends('layouts.dashboard')

@section('title', 'Create Employment Status')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <a href="{{ route('employment-statuses.index') }}" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Create Employment Status</h1>
                <p class="text-gray-600">Add a new employment status to the system</p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <form method="POST" action="{{ route('employment-statuses.store') }}" class="space-y-6">
        @csrf

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="border-b border-gray-200 bg-gray-50/50 px-6 py-4">
                <h2 class="text-lg font-semibold text-gray-900">Employment Status Information</h2>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Code -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-900">Code <span class="text-red-500">*</span></label>
                        <input type="text" name="code" value="{{ old('code') }}" required
                               class="w-full h-10 px-3 text-sm border border-gray-300 rounded-lg bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors @error('code') border-red-500 @enderror"
                               placeholder="e.g., PROB, REG, CONT">
                        @error('code')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Name -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-900">Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                               class="w-full h-10 px-3 text-sm border border-gray-300 rounded-lg bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors @error('name') border-red-500 @enderror"
                               placeholder="e.g., Probationary, Regular, Contractual">
                        @error('name')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Color -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-900">Color <span class="text-red-500">*</span></label>
                        <div class="flex items-center space-x-3">
                            <input type="color" name="color" value="{{ old('color', '#6B7280') }}"
                                   class="w-12 h-10 border border-gray-300 rounded-lg cursor-pointer @error('color') border-red-500 @enderror">
                            <input type="text" name="color_hex" value="{{ old('color', '#6B7280') }}"
                                   class="flex-1 h-10 px-3 text-sm border border-gray-300 rounded-lg bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                   placeholder="#6B7280" readonly>
                        </div>
                        @error('color')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Sort Order -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-900">Sort Order</label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0"
                               class="w-full h-10 px-3 text-sm border border-gray-300 rounded-lg bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors @error('sort_order') border-red-500 @enderror"
                               placeholder="0">
                        @error('sort_order')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2 space-y-2">
                        <label class="block text-sm font-medium text-gray-900">Description</label>
                        <textarea name="description" rows="3"
                                  class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors resize-vertical @error('description') border-red-500 @enderror"
                                  placeholder="Brief description of this employment status">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Properties -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="border-b border-gray-200 bg-gray-50/50 px-6 py-4">
                <h2 class="text-lg font-semibold text-gray-900">Properties</h2>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Active Status -->
                    <div class="space-y-2">
                        <div class="flex items-center space-x-2">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }}
                                   class="w-4 h-4 text-emerald-600 bg-white border-gray-300 rounded focus:ring-emerald-500 focus:ring-2">
                            <label class="text-sm font-medium text-gray-900">Active Status</label>
                        </div>
                        <p class="text-xs text-gray-500">When enabled, this status will be available for selection</p>
                    </div>

                    <!-- Requires Probation -->
                    <div class="space-y-2">
                        <div class="flex items-center space-x-2">
                            <input type="hidden" name="requires_probation" value="0">
                            <input type="checkbox" name="requires_probation" value="1" {{ old('requires_probation') ? 'checked' : '' }}
                                   class="w-4 h-4 text-emerald-600 bg-white border-gray-300 rounded focus:ring-emerald-500 focus:ring-2">
                            <label class="text-sm font-medium text-gray-900">Requires Probation</label>
                        </div>
                        <p class="text-xs text-gray-500">Employees with this status must complete probation period</p>
                    </div>

                    <!-- Eligible for Benefits -->
                    <div class="space-y-2 md:col-span-2">
                        <div class="flex items-center space-x-2">
                            <input type="hidden" name="eligible_for_benefits" value="0">
                            <input type="checkbox" name="eligible_for_benefits" value="1" {{ old('eligible_for_benefits', 1) ? 'checked' : '' }}
                                   class="w-4 h-4 text-emerald-600 bg-white border-gray-300 rounded focus:ring-emerald-500 focus:ring-2">
                            <label class="text-sm font-medium text-gray-900">Eligible for Benefits</label>
                        </div>
                        <p class="text-xs text-gray-500">Employees with this status are eligible for company benefits</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex items-center justify-end space-x-4">
            <a href="{{ route('employment-statuses.index') }}"
               class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-colors">
                Cancel
            </a>
            <button type="submit"
                    class="px-4 py-2 text-sm font-medium text-white bg-emerald-600 border border-transparent rounded-lg hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-colors">
                Create Employment Status
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const colorPicker = document.querySelector('input[type="color"]');
    const colorHex = document.querySelector('input[name="color_hex"]');

    colorPicker.addEventListener('change', function() {
        colorHex.value = this.value;
        // Update the hidden color field
        const hiddenColorField = document.querySelector('input[name="color"]');
        if (!hiddenColorField) {
            // Create hidden field if it doesn't exist
            const hidden = document.createElement('input');
            hidden.type = 'hidden';
            hidden.name = 'color';
            this.parentNode.appendChild(hidden);
        }
        document.querySelector('input[name="color"]').value = this.value;
    });

    colorHex.addEventListener('input', function() {
        if (/^#[0-9A-Fa-f]{6}$/.test(this.value)) {
            colorPicker.value = this.value;
            document.querySelector('input[name="color"]').value = this.value;
        }
    });
});
</script>
@endsection