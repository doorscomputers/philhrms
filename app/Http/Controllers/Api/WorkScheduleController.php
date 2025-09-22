<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WorkSchedule;
use Illuminate\Http\Request;

class WorkScheduleController extends Controller
{
    public function index()
    {
        $workSchedules = WorkSchedule::where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name', 'description', 'is_active']);

        return response()->json($workSchedules);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        $validated['is_active'] = true;

        $workSchedule = WorkSchedule::create($validated);

        return response()->json([
            'message' => 'Work Schedule created successfully',
            'workSchedule' => $workSchedule,
        ], 201);
    }

    public function show(WorkSchedule $workSchedule)
    {
        return response()->json($workSchedule);
    }

    public function update(Request $request, WorkSchedule $workSchedule)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        $workSchedule->update($validated);

        return response()->json([
            'message' => 'Work Schedule updated successfully',
            'workSchedule' => $workSchedule->fresh(),
        ]);
    }

    public function destroy(WorkSchedule $workSchedule)
    {
        $workSchedule->update(['is_active' => false]);

        return response()->json([
            'message' => 'Work Schedule deactivated successfully',
        ]);
    }
}
