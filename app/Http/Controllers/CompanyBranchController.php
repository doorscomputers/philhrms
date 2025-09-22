<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyBranchRequest;
use App\Http\Requests\UpdateCompanyBranchRequest;
use App\Models\Company;
use App\Models\CompanyBranch;

class CompanyBranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $branches = CompanyBranch::select(['id', 'name', 'code', 'type', 'city', 'is_active'])
            ->where('company_id', 1)
            ->latest()
            ->get();

        return view('branches.index', compact('branches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Company::where('status', 'Active')->get();

        return view('branches.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompanyBranchRequest $request)
    {
        $validated = $request->validated();
        $validated['company_id'] = $validated['company_id'] ?? 1;
        $validated['is_active'] = $validated['is_active'] ?? true;

        // Auto-generate code if not provided
        if (empty($validated['code'])) {
            $lastBranch = CompanyBranch::where('company_id', $validated['company_id'])
                ->where('code', 'LIKE', 'BR%')
                ->orderByRaw('CAST(SUBSTRING(code, 3) AS UNSIGNED) DESC')
                ->first();

            if ($lastBranch && preg_match('/BR(\d+)/', $lastBranch->code, $matches)) {
                $nextNumber = intval($matches[1]) + 1;
            } else {
                $nextNumber = 1;
            }

            $validated['code'] = 'BR'.str_pad($nextNumber, 2, '0', STR_PAD_LEFT);
        }

        // Process JSON fields from comma-separated input
        $jsonFields = ['contact_numbers', 'email_addresses', 'operation_days'];
        foreach ($jsonFields as $field) {
            if ($request->has($field) && $request->$field) {
                // Handle comma-separated input
                $values = array_map('trim', explode(',', $request->$field));
                $validated[$field] = array_filter($values); // Remove empty values
            } else {
                $validated[$field] = [];
            }
        }

        // Remove null values for fields with database defaults to allow defaults to apply
        $fieldsWithDefaults = ['operation_start_time', 'operation_end_time', 'timezone'];
        foreach ($fieldsWithDefaults as $field) {
            if (array_key_exists($field, $validated) && is_null($validated[$field])) {
                unset($validated[$field]);
            }
        }

        $branch = CompanyBranch::create($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'item' => $branch,
                'message' => 'Branch created successfully',
            ]);
        }

        return redirect()->route('branches.index')
            ->with('success', 'Branch created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(CompanyBranch $companyBranch)
    {
        $companyBranch->load(['company', 'departments', 'employees']);
        $branch = $companyBranch; // Alias for view consistency

        return view('branches.show', compact('branch'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CompanyBranch $companyBranch)
    {
        $companies = Company::where('status', 'Active')->get();
        $branch = $companyBranch; // Alias for view consistency

        return view('branches.edit', compact('branch', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompanyBranchRequest $request, CompanyBranch $companyBranch)
    {
        $validated = $request->validated();

        // Process JSON fields from comma-separated input
        $jsonFields = ['contact_numbers', 'email_addresses', 'operation_days'];
        foreach ($jsonFields as $field) {
            if ($request->has($field) && $request->$field) {
                // Handle comma-separated input
                $values = array_map('trim', explode(',', $request->$field));
                $validated[$field] = array_filter($values); // Remove empty values
            } else {
                $validated[$field] = [];
            }
        }

        $companyBranch->update($validated);

        return redirect()->route('branches.index')
            ->with('success', 'Branch updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CompanyBranch $companyBranch)
    {
        // Check if branch has employees
        if ($companyBranch->employees()->count() > 0) {
            return redirect()->route('branches.index')
                ->with('error', 'Cannot delete branch that has employees.');
        }

        // Check if branch has departments
        if ($companyBranch->departments()->count() > 0) {
            return redirect()->route('branches.index')
                ->with('error', 'Cannot delete branch that has departments.');
        }

        $companyBranch->delete();

        return redirect()->route('branches.index')
            ->with('success', 'Branch deleted successfully.');
    }
}
