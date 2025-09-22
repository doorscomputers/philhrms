<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CostCenter;
use Illuminate\Http\Request;

class CostCenterController extends Controller
{
    public function index()
    {
        $costCenters = CostCenter::where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name', 'description', 'is_active']);

        return response()->json($costCenters);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        $validated['is_active'] = true;

        $costCenter = CostCenter::create($validated);

        return response()->json([
            'message' => 'Cost Center created successfully',
            'costCenter' => $costCenter,
        ], 201);
    }

    public function show(CostCenter $costCenter)
    {
        return response()->json($costCenter);
    }

    public function update(Request $request, CostCenter $costCenter)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        $costCenter->update($validated);

        return response()->json([
            'message' => 'Cost Center updated successfully',
            'costCenter' => $costCenter->fresh(),
        ]);
    }

    public function destroy(CostCenter $costCenter)
    {
        $costCenter->update(['is_active' => false]);

        return response()->json([
            'message' => 'Cost Center deactivated successfully',
        ]);
    }
}
