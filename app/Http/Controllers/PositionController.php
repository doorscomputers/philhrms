<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePositionRequest;
use App\Http\Requests\UpdatePositionRequest;
use App\Models\Company;
use App\Models\Department;
use App\Models\JobGrade;
use App\Models\Position;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $positions = Position::with(['department', 'jobGrade'])
            ->select(['id', 'title', 'code', 'department_id', 'job_grade_id', 'type', 'level', 'is_active', 'created_at'])
            ->where('company_id', 1)
            ->latest()
            ->paginate(15);

        return view('positions.index', compact('positions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Company::where('status', 'Active')->get();
        $departments = Department::where('is_active', true)->get();
        $jobGrades = JobGrade::where('is_active', true)->get();
        $supervisorPositions = Position::where('is_active', true)->get();

        return view('positions.create', compact('companies', 'departments', 'jobGrades', 'supervisorPositions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePositionRequest $request)
    {
        try {
            $validated = $request->validated();
            $validated['company_id'] = $validated['company_id'] ?? 1;
            $validated['is_active'] = $validated['is_active'] ?? true;

            // For Quick Add requests, set default values for required fields
            if ($request->ajax() && $request->has('name') && $request->has('code')) {
                // Map 'name' to 'title' for Quick Add
                if (!isset($validated['title']) && isset($validated['name'])) {
                    $validated['title'] = $validated['name'];
                    unset($validated['name']);
                }

                // Set default values for required fields
                $validated['department_id'] = $validated['department_id'] ?? 1; // Default department
                $validated['job_grade_id'] = $validated['job_grade_id'] ?? 1; // Default job grade
                $validated['type'] = $validated['type'] ?? 'Regular';
                $validated['level'] = $validated['level'] ?? 'Rank and File';
                $validated['authorized_headcount'] = $validated['authorized_headcount'] ?? 1;
                $validated['current_headcount'] = 0;
                $validated['vacant_positions'] = 1;
            }

            $position = Position::create($validated);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'item' => $position,
                    'message' => 'Position created successfully',
                ]);
            }

            return redirect()->route('positions.index')
                ->with('success', 'Position created successfully.');
        } catch (\Exception $e) {
            \Log::error('Position creation failed: ' . $e->getMessage());

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create item. Please try again.',
                    'error' => $e->getMessage()
                ], 422);
            }

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create position: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Position $position)
    {
        $position->load(['company', 'department', 'jobGrade', 'reportsTo', 'subordinates', 'employees']);

        return view('positions.show', compact('position'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Position $position)
    {
        $companies = Company::where('status', 'Active')->get();
        $departments = Department::where('is_active', true)->get();
        $jobGrades = JobGrade::where('is_active', true)->get();
        $positions = Position::where('is_active', true)
            ->where('id', '!=', $position->id)
            ->get();

        return view('positions.edit', compact('position', 'companies', 'departments', 'jobGrades', 'positions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePositionRequest $request, Position $position)
    {
        $validated = $request->validated();

        $position->update($validated);

        return redirect()->route('positions.index')
            ->with('success', 'Position updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Position $position)
    {
        // Check if position has employees
        if ($position->employees()->count() > 0) {
            return redirect()->route('positions.index')
                ->with('error', 'Cannot delete position that has employees.');
        }

        // Check if position has subordinate positions
        if ($position->subordinates()->count() > 0) {
            return redirect()->route('positions.index')
                ->with('error', 'Cannot delete position that has subordinate positions.');
        }

        $position->delete();

        return redirect()->route('positions.index')
            ->with('success', 'Position deleted successfully.');
    }
}
