<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCostCenterRequest;
use App\Http\Requests\UpdateCostCenterRequest;
use App\Models\CostCenter;

class CostCenterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $costCenters = CostCenter::select(['id', 'name', 'code', 'budget_amount', 'is_active'])
            ->where('company_id', 1)
            ->latest()
            ->get();

        return view('cost-centers.index', compact('costCenters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cost-centers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCostCenterRequest $request)
    {
        $validated = $request->validated();

        // Set default company_id if not provided
        if (! isset($validated['company_id'])) {
            $validated['company_id'] = 1;
        }

        // Auto-generate code if not provided
        if (! isset($validated['code']) || empty($validated['code'])) {
            $lastCostCenter = CostCenter::where('company_id', $validated['company_id'])
                ->where('code', 'LIKE', 'CC%')
                ->orderByRaw('CAST(SUBSTRING(code, 3) AS UNSIGNED) DESC')
                ->first();

            if ($lastCostCenter && preg_match('/CC(\d+)/', $lastCostCenter->code, $matches)) {
                $nextNumber = intval($matches[1]) + 1;
            } else {
                $nextNumber = 1;
            }

            $validated['code'] = 'CC'.str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        }

        $costCenter = CostCenter::create($validated);

        return redirect()
            ->route('cost-centers.index')
            ->with('success', 'Cost Center created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(CostCenter $costCenter)
    {
        $costCenter->load(['company', 'departments', 'employees']);

        return view('cost-centers.show', compact('costCenter'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CostCenter $costCenter)
    {
        return view('cost-centers.edit', compact('costCenter'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCostCenterRequest $request, CostCenter $costCenter)
    {
        $validated = $request->validated();

        $costCenter->update($validated);

        return redirect()->route('cost-centers.index')
            ->with('success', 'Cost Center updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CostCenter $costCenter)
    {
        // Check if cost center has departments
        if ($costCenter->departments()->count() > 0) {
            return redirect()->route('cost-centers.index')
                ->with('error', 'Cannot delete cost center that has departments.');
        }

        // Check if cost center has employees
        if ($costCenter->employees()->count() > 0) {
            return redirect()->route('cost-centers.index')
                ->with('error', 'Cannot delete cost center that has employees.');
        }

        $costCenter->delete();

        return redirect()->route('cost-centers.index')
            ->with('success', 'Cost Center deleted successfully.');
    }
}
