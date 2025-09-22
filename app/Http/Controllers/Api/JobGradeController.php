<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JobGrade;
use Illuminate\Http\Request;

class JobGradeController extends Controller
{
    public function index()
    {
        $jobGrades = JobGrade::where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name', 'description', 'is_active']);

        return response()->json($jobGrades);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        $validated['is_active'] = true;

        $jobGrade = JobGrade::create($validated);

        return response()->json([
            'message' => 'Job Grade created successfully',
            'jobGrade' => $jobGrade,
        ], 201);
    }

    public function show(JobGrade $jobGrade)
    {
        return response()->json($jobGrade);
    }

    public function update(Request $request, JobGrade $jobGrade)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        $jobGrade->update($validated);

        return response()->json([
            'message' => 'Job Grade updated successfully',
            'jobGrade' => $jobGrade->fresh(),
        ]);
    }

    public function destroy(JobGrade $jobGrade)
    {
        $jobGrade->update(['is_active' => false]);

        return response()->json([
            'message' => 'Job Grade deactivated successfully',
        ]);
    }
}
