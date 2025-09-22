<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWorkScheduleRequest;
use App\Http\Requests\UpdateWorkScheduleRequest;
use App\Models\WorkSchedule;

class WorkScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $workSchedules = WorkSchedule::select(['id', 'name', 'code', 'type', 'hours_per_day', 'is_active'])
            ->where('company_id', 1)
            ->latest()
            ->get();

        return view('work-schedules.index', compact('workSchedules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('work-schedules.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWorkScheduleRequest $request)
    {
        try {
            $validated = $request->validated();

            // Set default company_id if not provided
            if (! isset($validated['company_id'])) {
                $validated['company_id'] = 1;
            }

            // For Quick Add requests, set default values for required fields
            if ($request->ajax() && $request->has('name') && $request->has('code')) {
                $validated['type'] = $validated['type'] ?? 'Fixed';
                $validated['hours_per_day'] = $validated['hours_per_day'] ?? 8;
                $validated['days_per_week'] = $validated['days_per_week'] ?? 5;
                $validated['break_duration_minutes'] = $validated['break_duration_minutes'] ?? 60;
                $validated['description'] = $validated['description'] ?? 'Quick add work schedule';
            }

            $validated['is_active'] = $validated['is_active'] ?? true;

            // Auto-generate code if not provided
            if (! isset($validated['code']) || empty($validated['code'])) {
                $lastSchedule = WorkSchedule::where('company_id', $validated['company_id'])
                    ->where('code', 'LIKE', 'WS%')
                    ->orderByRaw('CAST(SUBSTRING(code, 3) AS UNSIGNED) DESC')
                    ->first();

                if ($lastSchedule && preg_match('/WS(\d+)/', $lastSchedule->code, $matches)) {
                    $nextNumber = intval($matches[1]) + 1;
                } else {
                    $nextNumber = 1;
                }

                $validated['code'] = 'WS'.str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
            }

            // Ensure schedule_details JSON field has a default
            if (! isset($validated['schedule_details'])) {
                $validated['schedule_details'] = [
                    'monday' => ['start' => '08:00', 'end' => '17:00', 'is_working_day' => true],
                    'tuesday' => ['start' => '08:00', 'end' => '17:00', 'is_working_day' => true],
                    'wednesday' => ['start' => '08:00', 'end' => '17:00', 'is_working_day' => true],
                    'thursday' => ['start' => '08:00', 'end' => '17:00', 'is_working_day' => true],
                    'friday' => ['start' => '08:00', 'end' => '17:00', 'is_working_day' => true],
                    'saturday' => ['start' => '08:00', 'end' => '17:00', 'is_working_day' => false],
                    'sunday' => ['start' => '08:00', 'end' => '17:00', 'is_working_day' => false],
                ];
            }

            $workSchedule = WorkSchedule::create($validated);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'item' => $workSchedule,
                    'message' => 'Work Schedule created successfully',
                ]);
            }

            return redirect()
                ->route('work-schedules.index')
                ->with('success', 'Work Schedule created successfully.');
        } catch (\Exception $e) {
            \Log::error('Work Schedule creation failed: ' . $e->getMessage());

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create item. Please try again.',
                    'error' => $e->getMessage()
                ], 422);
            }

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create work schedule: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(WorkSchedule $workSchedule)
    {
        $workSchedule->load(['company', 'employees']);

        return view('work-schedules.show', compact('workSchedule'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WorkSchedule $workSchedule)
    {
        return view('work-schedules.edit', compact('workSchedule'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWorkScheduleRequest $request, WorkSchedule $workSchedule)
    {
        $validated = $request->validated();

        $workSchedule->update($validated);

        return redirect()->route('work-schedules.index')
            ->with('success', 'Work Schedule updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkSchedule $workSchedule)
    {
        // Check if work schedule has employees
        if ($workSchedule->employees()->count() > 0) {
            return redirect()->route('work-schedules.index')
                ->with('error', 'Cannot delete work schedule that has employees.');
        }

        $workSchedule->delete();

        return redirect()->route('work-schedules.index')
            ->with('success', 'Work Schedule deleted successfully.');
    }
}
