<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CompanyBranch;
use Illuminate\Http\Request;

class OfficeController extends Controller
{
    public function index()
    {
        $offices = CompanyBranch::where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name', 'address', 'is_active']);

        return response()->json($offices);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:500',
        ]);

        $validated['is_active'] = true;
        $validated['company_id'] = 1; // Default company

        $office = CompanyBranch::create($validated);

        return response()->json([
            'message' => 'Office created successfully',
            'office' => $office,
        ], 201);
    }

    public function show(CompanyBranch $office)
    {
        return response()->json($office);
    }

    public function update(Request $request, CompanyBranch $office)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:500',
        ]);

        $office->update($validated);

        return response()->json([
            'message' => 'Office updated successfully',
            'office' => $office->fresh(),
        ]);
    }

    public function destroy(CompanyBranch $office)
    {
        $office->update(['is_active' => false]);

        return response()->json([
            'message' => 'Office deactivated successfully',
        ]);
    }
}
