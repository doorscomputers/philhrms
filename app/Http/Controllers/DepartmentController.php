<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Models\Department;

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

        return view('departments.index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = \App\Models\Company::where('status', 'Active')->get();
        $parentDepartments = Department::where('company_id', 1)->where('is_active', true)->get();

        return view('departments.create', compact('companies', 'parentDepartments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDepartmentRequest $request)
    {
        $validated = $request->validated();
        $validated['company_id'] = $validated['company_id'] ?? 1;
        $validated['is_active'] = $validated['is_active'] ?? true;

        $department = Department::create($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'item' => $department,
                'message' => 'Department created successfully',
            ]);
        }

        return redirect()->route('departments.index')
            ->with('success', 'Department created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        $department->load(['company', 'parent', 'children', 'employees']);

        return view('departments.show', compact('department'));
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

        return view('departments.edit', compact('department', 'companies', 'parentDepartments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepartmentRequest $request, Department $department)
    {
        $validated = $request->validated();

        $department->update($validated);

        return redirect()->route('departments.index')
            ->with('success', 'Department updated successfully.');
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
