<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EmploymentStatus;
use Illuminate\Http\Request;

class EmploymentStatusController extends Controller
{
    public function index()
    {
        $employmentStatuses = EmploymentStatus::where('is_active', true)
            ->orderBy('sort_order')
            ->get(['id', 'name', 'description', 'is_active']);

        return response()->json($employmentStatuses);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'code' => 'nullable|string|max:10',
            'color' => 'nullable|string|max:7',
            'requires_probation' => 'nullable|boolean',
            'eligible_for_benefits' => 'nullable|boolean',
        ]);

        $validated['is_active'] = true;
        $validated['sort_order'] = EmploymentStatus::max('sort_order') + 1;
        $validated['requires_probation'] = $validated['requires_probation'] ?? false;
        $validated['eligible_for_benefits'] = $validated['eligible_for_benefits'] ?? true;

        $employmentStatus = EmploymentStatus::create($validated);

        return response()->json([
            'message' => 'Employment Status created successfully',
            'employment_status' => $employmentStatus,
        ], 201);
    }

    public function show(EmploymentStatus $employmentStatus)
    {
        return response()->json($employmentStatus);
    }

    public function update(Request $request, EmploymentStatus $employmentStatus)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        $employmentStatus->update($validated);

        return response()->json([
            'message' => 'Employment Status updated successfully',
            'employmentStatus' => $employmentStatus->fresh(),
        ]);
    }

    public function destroy(EmploymentStatus $employmentStatus)
    {
        $employmentStatus->update(['is_active' => false]);

        return response()->json([
            'message' => 'Employment Status deactivated successfully',
        ]);
    }
}
