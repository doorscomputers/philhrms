<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Models\Department;
use Inertia\Inertia;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Department::with(['company', 'parent'])
            ->withCount(['employees', 'children'])
            ->where('company_id', 1) // Assuming single company for now
            ->latest()
            ->paginate(15);

        return Inertia::render('Organization/DepartmentIndex', [
            'departments' => $departments,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = \App\Models\Company::where('status', 'Active')->get();
        $parentDepartments = Department::where('company_id', 1)->where('is_active', true)->get();

        return Inertia::render('Organization/DepartmentCreate', [
            'companies' => $companies,
            'parentDepartments' => $parentDepartments,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDepartmentRequest $request)
    {
        try {
            $validated = $request->validated();
            $validated['company_id'] = $validated['company_id'] ?? 1;
            $validated['is_active'] = $validated['is_active'] ?? true;

            // For Quick Add requests, set default values for required fields
            if ($request->ajax() && $request->has('name') && $request->has('code')) {
                $validated['description'] = $validated['description'] ?? 'Quick add department';
                $validated['level'] = 1;
                $validated['current_headcount'] = 0;
            }

            $department = Department::create($validated);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'item' => $department,
                    'message' => 'Department created successfully',
                ]);
            }

            return redirect()->route('departments.index');
        } catch (\Exception $e) {
            \Log::error('Department creation failed: ' . $e->getMessage());

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create item. Please try again.',
                    'error' => $e->getMessage()
                ], 422);
            }

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create department: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        $department->load(['company', 'parent', 'children', 'employees']);

        return Inertia::render('Organization/DepartmentShow', [
            'department' => $department,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        $companies = \App\Models\Company::where('status', 'Active')->get();
        $parentDepartments = Department::where('company_id', 1)
            ->where('is_active', true)
            ->where('id', '!=', $department->id)
            ->get();

        return Inertia::render('Organization/DepartmentEdit', [
            'department' => $department,
            'companies' => $companies,
            'parentDepartments' => $parentDepartments,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepartmentRequest $request, Department $department)
    {
        $validated = $request->validated();

        $department->update($validated);

        return redirect()->route('departments.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        // Check if department has employees
        if ($department->employees()->count() > 0) {
            return redirect()->route('departments.index')
                ->with('error', 'Cannot delete department that has employees.');
        }

        // Check if department has child departments
        if ($department->children()->count() > 0) {
            return redirect()->route('departments.index')
                ->with('error', 'Cannot delete department that has sub-departments.');
        }

        $department->delete();

        return redirect()->route('departments.index')
            ->with('success', 'Department deleted successfully.');
    }
}
