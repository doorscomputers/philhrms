<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJobGradeRequest;
use App\Http\Requests\UpdateJobGradeRequest;
use App\Models\Company;
use App\Models\JobGrade;

class JobGradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobGrades = JobGrade::select(['id', 'name', 'code', 'level', 'min_salary', 'max_salary', 'is_active'])
            ->where('company_id', 1)
            ->orderBy('level')
            ->get();

        return view('job-grades.index', compact('jobGrades'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Company::where('status', 'Active')->get();

        return view('job-grades.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJobGradeRequest $request)
    {
        try {
            $validated = $request->validated();
            $validated['company_id'] = $validated['company_id'] ?? 1;
            $validated['is_active'] = $validated['is_active'] ?? true;

            // For Quick Add requests, set default values for required fields
            if ($request->ajax() && $request->has('name') && $request->has('code')) {
                $validated['level'] = $validated['level'] ?? 1;
                $validated['min_salary'] = $validated['min_salary'] ?? 15000;
                $validated['max_salary'] = $validated['max_salary'] ?? 50000;
                $validated['description'] = $validated['description'] ?? 'Quick add job grade';
            }

            // Calculate mid_salary if not provided
            if (! isset($validated['mid_salary']) && isset($validated['min_salary']) && isset($validated['max_salary'])) {
                $validated['mid_salary'] = ($validated['min_salary'] + $validated['max_salary']) / 2;
            }

            $jobGrade = JobGrade::create($validated);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'item' => $jobGrade,
                    'message' => 'Job Grade created successfully',
                ]);
            }

            return redirect()->route('job-grades.index')
                ->with('success', 'Job Grade created successfully.');
        } catch (\Exception $e) {
            \Log::error('Job Grade creation failed: ' . $e->getMessage());

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create item. Please try again.',
                    'error' => $e->getMessage()
                ], 422);
            }

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create job grade: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(JobGrade $jobGrade)
    {
        $jobGrade->load(['company', 'positions', 'employees']);

        return view('job-grades.show', compact('jobGrade'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobGrade $jobGrade)
    {
        $companies = Company::where('status', 'Active')->get();

        return view('job-grades.edit', compact('jobGrade', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJobGradeRequest $request, JobGrade $jobGrade)
    {
        $validated = $request->validated();

        $jobGrade->update($validated);

        return redirect()->route('job-grades.index')
            ->with('success', 'Job Grade updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobGrade $jobGrade)
    {
        // Check if job grade has employees
        if ($jobGrade->employees()->count() > 0) {
            return redirect()->route('job-grades.index')
                ->with('error', 'Cannot delete job grade that has employees.');
        }

        // Check if job grade has positions
        if ($jobGrade->positions()->count() > 0) {
            return redirect()->route('job-grades.index')
                ->with('error', 'Cannot delete job grade that has positions.');
        }

        $jobGrade->delete();

        return redirect()->route('job-grades.index')
            ->with('success', 'Job Grade deleted successfully.');
    }
}
