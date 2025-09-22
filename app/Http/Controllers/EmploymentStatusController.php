<?php

namespace App\Http\Controllers;

use App\Models\EmploymentStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EmploymentStatusController extends Controller
{
    public function index()
    {
        $employmentStatuses = EmploymentStatus::ordered()->paginate(15);

        return view('employment-statuses.index', compact('employmentStatuses'));
    }

    public function create()
    {
        return view('employment-statuses.create');
    }

    public function store(Request $request)
    {
        \Log::info('=== EMPLOYMENT STATUS STORE CALLED ===');
        \Log::info('Is AJAX: ' . ($request->ajax() ? 'YES' : 'NO'));
        \Log::info('Has name: ' . ($request->has('name') ? 'YES' : 'NO'));
        \Log::info('Has code: ' . ($request->has('code') ? 'YES' : 'NO'));
        \Log::info('Request data: ' . json_encode($request->all()));

        try {
            // Check if this is a Quick Add request (AJAX with just name and code)
            $isQuickAdd = $request->ajax() && $request->has('name') && $request->has('code');

            if ($isQuickAdd) {
                $validated = $request->validate([
                    'name' => ['required', 'string', 'max:255'],
                    'code' => ['required', 'string', 'max:20', 'unique:employment_statuses,code'],
                    'description' => ['nullable', 'string'],
                ]);

                // Set default values for Quick Add
                $validated['color'] = '#10B981'; // Default green color
                $validated['is_active'] = true;
                $validated['requires_probation'] = false;
                $validated['eligible_for_benefits'] = true;
                $validated['sort_order'] = 0;
                $validated['description'] = $validated['description'] ?? 'Quick add employment status';
            } else {
                // Full form validation
                $validated = $request->validate([
                    'code' => ['required', 'string', 'max:20', 'unique:employment_statuses,code'],
                    'name' => ['required', 'string', 'max:255'],
                    'description' => ['nullable', 'string'],
                    'color' => ['required', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
                    'is_active' => ['boolean'],
                    'requires_probation' => ['boolean'],
                    'eligible_for_benefits' => ['boolean'],
                    'sort_order' => ['integer', 'min:0'],
                ]);

                $validated['is_active'] = $validated['is_active'] ?? true;
                $validated['requires_probation'] = $validated['requires_probation'] ?? false;
                $validated['eligible_for_benefits'] = $validated['eligible_for_benefits'] ?? true;
                $validated['sort_order'] = $validated['sort_order'] ?? 0;
            }

            $employmentStatus = EmploymentStatus::create($validated);

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Employment status created successfully.',
                    'item' => $employmentStatus,
                ]);
            }

            return redirect()
                ->route('employment-statuses.index')
                ->with('success', 'Employment status created successfully.');
        } catch (\Exception $e) {
            \Log::error('Employment Status creation failed: ' . $e->getMessage());

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create item. Please try again.',
                    'error' => $e->getMessage()
                ], 422);
            }

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create employment status: ' . $e->getMessage());
        }
    }

    public function show(EmploymentStatus $employmentStatus)
    {
        $employmentStatus->load(['employees' => function ($query) {
            $query->select('id', 'employee_id', 'first_name', 'last_name', 'employment_status_id')
                ->latest()
                ->limit(10);
        }]);

        return view('employment-statuses.show', compact('employmentStatus'));
    }

    public function edit(EmploymentStatus $employmentStatus)
    {
        return view('employment-statuses.edit', compact('employmentStatus'));
    }

    public function update(Request $request, EmploymentStatus $employmentStatus)
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:20', 'unique:employment_statuses,code,'.$employmentStatus->id],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'color' => ['required', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'is_active' => ['boolean'],
            'requires_probation' => ['boolean'],
            'eligible_for_benefits' => ['boolean'],
            'sort_order' => ['integer', 'min:0'],
        ]);

        $validated['is_active'] = $validated['is_active'] ?? false;
        $validated['requires_probation'] = $validated['requires_probation'] ?? false;
        $validated['eligible_for_benefits'] = $validated['eligible_for_benefits'] ?? false;

        $employmentStatus->update($validated);

        return redirect()
            ->route('employment-statuses.show', $employmentStatus)
            ->with('success', 'Employment status updated successfully.');
    }

    public function destroy(EmploymentStatus $employmentStatus)
    {
        // Check if any employees are using this status
        if ($employmentStatus->employees()->count() > 0) {
            return redirect()
                ->route('employment-statuses.index')
                ->with('error', 'Cannot delete employment status that is assigned to employees.');
        }

        $employmentStatus->delete();

        return redirect()
            ->route('employment-statuses.index')
            ->with('success', 'Employment status deleted successfully.');
    }
}
