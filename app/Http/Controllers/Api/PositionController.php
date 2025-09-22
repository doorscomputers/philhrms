<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function index()
    {
        $positions = Position::where('is_active', true)
            ->orderBy('title')
            ->get(['id', 'title as name', 'description', 'is_active']);

        return response()->json($positions);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'department_id' => 'nullable|exists:departments,id',
        ]);

        // Map 'name' to 'title' for the Position model
        $validated['title'] = $validated['name'];
        unset($validated['name']);
        $validated['is_active'] = true;
        $validated['company_id'] = 1; // Default company

        // Set department_id from request - get the first available department if not provided
        if (empty($validated['department_id'])) {
            $firstDepartment = \App\Models\Department::where('company_id', 1)->first();
            $validated['department_id'] = $firstDepartment ? $firstDepartment->id : 1;
        }

        // Set default job_grade_id (we need to find a valid one or create a default)
        $defaultJobGrade = \App\Models\JobGrade::where('company_id', 1)->first();
        if (! $defaultJobGrade) {
            // Create a default job grade if none exists
            $defaultJobGrade = \App\Models\JobGrade::create([
                'name' => 'Default Grade',
                'description' => 'Default job grade for new positions',
                'company_id' => 1,
                'is_active' => true,
            ]);
        }
        $validated['job_grade_id'] = $defaultJobGrade->id;

        // Generate a unique position code if not provided
        $baseCode = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $validated['title']), 0, 6));
        $counter = 1;
        $code = $baseCode.str_pad($counter, 2, '0', STR_PAD_LEFT);

        // Check for uniqueness and increment if needed
        while (\App\Models\Position::where('company_id', 1)->where('code', $code)->exists()) {
            $counter++;
            $code = $baseCode.str_pad($counter, 2, '0', STR_PAD_LEFT);
        }
        $validated['code'] = $code;

        // Set default required enum fields
        $validated['type'] = 'Regular';
        $validated['level'] = 'Rank and File';

        $position = Position::create($validated);

        return response()->json([
            'message' => 'Position created successfully',
            'position' => $position,
        ], 201);
    }

    public function show(Position $position)
    {
        return response()->json($position);
    }

    public function update(Request $request, Position $position)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        // Map 'name' to 'title' for the Position model
        $validated['title'] = $validated['name'];
        unset($validated['name']);

        $position->update($validated);

        return response()->json([
            'message' => 'Position updated successfully',
            'position' => $position->fresh(),
        ]);
    }

    public function destroy(Position $position)
    {
        $position->update(['is_active' => false]);

        return response()->json([
            'message' => 'Position deactivated successfully',
        ]);
    }
}
