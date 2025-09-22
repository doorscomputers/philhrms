<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class EmploymentTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get the current ENUM values from the database schema
        $employmentTypes = $this->getCurrentEmploymentTypes();

        return response()->json($employmentTypes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        \Log::info('=== EMPLOYMENT TYPE STORE CALLED ===');
        \Log::info('Is AJAX: ' . ($request->ajax() ? 'YES' : 'NO'));
        \Log::info('Has name: ' . ($request->has('name') ? 'YES' : 'NO'));
        \Log::info('Request data: ' . json_encode($request->all()));

        try {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:50'],
                'description' => ['nullable', 'string', 'max:255'],
            ]);

            // Get current employment types
            $currentTypes = $this->getCurrentEmploymentTypes();

            // Check if the employment type already exists (case-insensitive)
            $existingType = collect($currentTypes)->first(function ($type) use ($validated) {
                return strtolower($type['value']) === strtolower($validated['name']);
            });

            if ($existingType) {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Employment type already exists.',
                    ], 422);
                }
                return back()->with('error', 'Employment type already exists.');
            }

            // Add the new employment type to the ENUM
            $newTypes = collect($currentTypes)->pluck('value')->push($validated['name'])->unique()->values()->toArray();

            // Create the enum string
            $enumString = "'" . implode("','", $newTypes) . "'";

            // Update the ENUM column
            DB::statement("ALTER TABLE employees MODIFY COLUMN employment_type ENUM({$enumString}) DEFAULT 'Full-time'");

            \Log::info('Employment type added successfully: ' . $validated['name']);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Employment type created successfully.',
                    'item' => [
                        'value' => $validated['name'],
                        'label' => $validated['name'],
                        'description' => $validated['description'] ?? null
                    ],
                ]);
            }

            return redirect()->back()->with('success', 'Employment type created successfully.');
        } catch (\Exception $e) {
            \Log::error('Employment Type creation failed: ' . $e->getMessage());

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create employment type. Please try again.',
                    'error' => $e->getMessage()
                ], 422);
            }

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create employment type: ' . $e->getMessage());
        }
    }

    /**
     * Get current employment types from the database schema
     */
    private function getCurrentEmploymentTypes()
    {
        // Query the column definition to get ENUM values
        $result = DB::select("SHOW COLUMNS FROM employees WHERE Field = 'employment_type'")[0];
        $typeDefinition = $result->Type;

        // Extract ENUM values from the type definition
        preg_match('/^enum\((.+)\)$/', $typeDefinition, $matches);

        if (!isset($matches[1])) {
            return [];
        }

        $enumValues = str_getcsv($matches[1], ',', "'");

        return collect($enumValues)->map(function ($value) {
            return [
                'value' => $value,
                'label' => $value,
            ];
        })->toArray();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
