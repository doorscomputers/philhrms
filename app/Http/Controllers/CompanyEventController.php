<?php

namespace App\Http\Controllers;

use App\Models\CompanyEvent;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyEventController extends Controller
{
    public function index()
    {
        $events = CompanyEvent::with(['creator', 'relatedEmployee'])
            ->latest('event_date')
            ->paginate(15);

        return view('company-events.index', compact('events'));
    }

    public function create()
    {
        $employees = Employee::select('id', 'first_name', 'last_name', 'employee_id')
            ->orderBy('first_name')
            ->get();

        $departments = Department::select('id', 'name')->orderBy('name')->get();
        $positions = Position::select('id', 'title')->orderBy('title')->get();

        return view('company-events.create', compact('employees', 'departments', 'positions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_type' => 'required|in:company_meeting,training,holiday,birthday,work_anniversary,team_building,performance_review,compliance_training,benefits_enrollment,social_event,conference,deadline,other',
            'priority' => 'required|in:low,medium,high,critical',
            'event_date' => 'required|date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'location' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:7',
            'is_recurring' => 'boolean',
            'recurrence_type' => 'nullable|in:daily,weekly,monthly,yearly',
            'recurrence_interval' => 'nullable|integer|min:1',
            'recurrence_end_date' => 'nullable|date|after:event_date',
            'is_all_day' => 'boolean',
            'requires_rsvp' => 'boolean',
            'max_attendees' => 'nullable|integer|min:1',
            'target_departments' => 'nullable|array',
            'target_departments.*' => 'exists:departments,id',
            'target_positions' => 'nullable|array',
            'target_positions.*' => 'exists:positions,id',
            'target_employees' => 'nullable|array',
            'target_employees.*' => 'exists:employees,id',
            'is_company_wide' => 'boolean',
            'notes' => 'nullable|string',
            'meeting_link' => 'nullable|url',
            'send_reminders' => 'boolean',
            'reminder_days_before' => 'nullable|integer|min:0',
            'related_employee_id' => 'nullable|exists:employees,id',
        ]);

        $validated['created_by'] = Auth::id();

        // Set default color if not provided
        if (empty($validated['color'])) {
            $validated['color'] = $this->getDefaultColor($validated['event_type']);
        }

        CompanyEvent::create($validated);

        return redirect()->route('company-events.index')
            ->with('success', 'Event created successfully!');
    }

    public function show(CompanyEvent $companyEvent)
    {
        $companyEvent->load(['creator', 'relatedEmployee']);
        return view('company-events.show', compact('companyEvent'));
    }

    public function edit(CompanyEvent $companyEvent)
    {
        $employees = Employee::select('id', 'first_name', 'last_name', 'employee_id')
            ->orderBy('first_name')
            ->get();

        $departments = Department::select('id', 'name')->orderBy('name')->get();
        $positions = Position::select('id', 'title')->orderBy('title')->get();

        return view('company-events.edit', compact('companyEvent', 'employees', 'departments', 'positions'));
    }

    public function update(Request $request, CompanyEvent $companyEvent)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_type' => 'required|in:company_meeting,training,holiday,birthday,work_anniversary,team_building,performance_review,compliance_training,benefits_enrollment,social_event,conference,deadline,other',
            'priority' => 'required|in:low,medium,high,critical',
            'event_date' => 'required|date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'location' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:7',
            'is_recurring' => 'boolean',
            'recurrence_type' => 'nullable|in:daily,weekly,monthly,yearly',
            'recurrence_interval' => 'nullable|integer|min:1',
            'recurrence_end_date' => 'nullable|date|after:event_date',
            'is_all_day' => 'boolean',
            'requires_rsvp' => 'boolean',
            'max_attendees' => 'nullable|integer|min:1',
            'target_departments' => 'nullable|array',
            'target_departments.*' => 'exists:departments,id',
            'target_positions' => 'nullable|array',
            'target_positions.*' => 'exists:positions,id',
            'target_employees' => 'nullable|array',
            'target_employees.*' => 'exists:employees,id',
            'is_company_wide' => 'boolean',
            'notes' => 'nullable|string',
            'meeting_link' => 'nullable|url',
            'send_reminders' => 'boolean',
            'reminder_days_before' => 'nullable|integer|min:0',
            'related_employee_id' => 'nullable|exists:employees,id',
        ]);

        // Set default color if not provided
        if (empty($validated['color'])) {
            $validated['color'] = $this->getDefaultColor($validated['event_type']);
        }

        $companyEvent->update($validated);

        return redirect()->route('company-events.index')
            ->with('success', 'Event updated successfully!');
    }

    public function destroy(CompanyEvent $companyEvent)
    {
        $companyEvent->delete();

        return redirect()->route('company-events.index')
            ->with('success', 'Event deleted successfully!');
    }

    private function getDefaultColor($eventType)
    {
        return match ($eventType) {
            'company_meeting' => '#3B82F6',
            'training' => '#10B981',
            'holiday' => '#8B5CF6',
            'birthday' => '#EC4899',
            'work_anniversary' => '#059669',
            'team_building' => '#06B6D4',
            'performance_review' => '#8B5CF6',
            'compliance_training' => '#F59E0B',
            'benefits_enrollment' => '#10B981',
            'social_event' => '#F59E0B',
            'conference' => '#6366F1',
            'deadline' => '#DC2626',
            'other' => '#6B7280',
            default => '#6B7280',
        };
    }
}