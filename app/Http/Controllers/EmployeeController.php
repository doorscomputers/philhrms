<?php

namespace App\Http\Controllers;

use App\Models\CompanyBranch;
use App\Models\Department;
use App\Models\Employee;
use App\Models\EmploymentStatus;
use App\Models\JobGrade;
use App\Models\Position;
use App\Models\WorkSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Inertia\Inertia;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Check if this is a SPA route and render appropriate page
        if (request()->is('spa/*')) {
            $employees = Employee::with(['department', 'position', 'employmentStatus'])
                ->orderBy('created_at', 'desc')
                ->paginate(20);

            // Calculate comprehensive HR insights
            $totalEmployees = Employee::count();
            $activeEmployees = Employee::whereHas('employmentStatus', function($query) {
                $query->where('name', 'like', '%active%');
            })->count();

            // Gender distribution
            $genderStats = Employee::selectRaw('gender, COUNT(*) as count')
                ->whereNotNull('gender')
                ->groupBy('gender')
                ->get()
                ->pluck('count', 'gender')
                ->toArray();

            // Birthdays this month
            $currentMonth = now()->month;
            $birthdaysThisMonth = Employee::whereMonth('birth_date', $currentMonth)
                ->select('id', 'first_name', 'last_name', 'birth_date')
                ->orderBy('birth_date')
                ->get();

            // Department distribution
            $departmentStats = Employee::with('department')
                ->select('department_id')
                ->whereNotNull('department_id')
                ->get()
                ->groupBy('department.name')
                ->map(function($employees) {
                    return $employees->count();
                })
                ->sortDesc();

            // Employment type distribution
            $employmentTypeStats = Employee::selectRaw('employment_type, COUNT(*) as count')
                ->whereNotNull('employment_type')
                ->groupBy('employment_type')
                ->get()
                ->pluck('count', 'employment_type')
                ->toArray();

            // Recent hires (last 30 days)
            $recentHires = Employee::where('hire_date', '>=', now()->subDays(30))
                ->select('id', 'first_name', 'last_name', 'hire_date', 'department_id')
                ->with('department:id,name')
                ->orderBy('hire_date', 'desc')
                ->get();

            // Upcoming events (next 30 days) - includes all company events
            $upcomingEvents = \App\Models\CompanyEvent::active()
                ->upcoming()
                ->where('event_date', '<=', now()->addDays(30))
                ->with(['relatedEmployee:id,first_name,last_name'])
                ->orderBy('event_date')
                ->orderBy('start_time')
                ->limit(10)
                ->get();

            // Age distribution
            $ageStats = Employee::selectRaw('
                CASE
                    WHEN TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) < 25 THEN "Under 25"
                    WHEN TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) BETWEEN 25 AND 34 THEN "25-34"
                    WHEN TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) BETWEEN 35 AND 44 THEN "35-44"
                    WHEN TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) BETWEEN 45 AND 54 THEN "45-54"
                    WHEN TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) >= 55 THEN "55+"
                    ELSE "Unknown"
                END as age_group,
                COUNT(*) as count
            ')
            ->whereNotNull('birth_date')
            ->groupBy('age_group')
            ->get()
            ->pluck('count', 'age_group')
            ->toArray();

            return Inertia::render('Employee/EmployeeList', [
                'employees' => $employees,
                'departments' => Department::all(),
                'positions' => Position::all(),
                'employmentStatuses' => EmploymentStatus::where('is_active', true)
                    ->orderBy('sort_order')
                    ->select('id', 'name', 'code', 'description')
                    ->get(),
                'employmentTypes' => $this->getCurrentEmploymentTypes(),
                'hrInsights' => [
                    'totalEmployees' => $totalEmployees,
                    'activeEmployees' => $activeEmployees,
                    'genderStats' => $genderStats,
                    'birthdaysThisMonth' => $birthdaysThisMonth,
                    'departmentStats' => $departmentStats,
                    'employmentTypeStats' => $employmentTypeStats,
                    'recentHires' => $recentHires,
                    'upcomingEvents' => $upcomingEvents,
                    'ageStats' => $ageStats,
                    'currentMonth' => now()->format('F'),
                ]
            ]);
        }

        // For non-SPA routes, redirect to SPA
        return redirect('/spa/employees');
    }

    public function create()
    {
        // Check if this is a request for simple CRUD
        if (request()->get('simple') === 'true') {
            return Inertia::render('Employee/EmployeeSimpleCRUD', [
                'departments' => Department::select('id', 'name')->get(),
                'positions' => Position::select('id', 'title')->get(),
            ]);
        }

        // Render the comprehensive employee creation form
        return Inertia::render('Employee/EmployeeCreateNew', [
            'departments' => Department::select('id', 'name')->get(),
            'positions' => Position::select('id', 'title')->get(),
            'jobGrades' => JobGrade::select('id', 'name')->get(),
            'branches' => CompanyBranch::select('id', 'name')->get(),
            'workSchedules' => WorkSchedule::select('id', 'name')->get(),
            'employmentStatuses' => EmploymentStatus::where('is_active', true)
                ->orderBy('sort_order')
                ->select('id', 'name', 'code', 'description')
                ->get(),
            'employees' => Employee::select('id', 'first_name', 'last_name')->where('is_active', true)->get(),
        ]);
    }

    public function storeSimple(Request $request)
    {
        // Simple validation for basic fields only
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'department_id' => 'nullable|exists:departments,id',
            'position_id' => 'nullable|exists:positions,id',
            'basic_salary' => 'nullable|numeric|min:0',
            'hire_date' => 'nullable|date',
            'is_active' => 'boolean',
        ]);

        // Set required defaults
        $validated['uuid'] = (string) \Illuminate\Support\Str::uuid();
        $validated['employee_id'] = 'EMP'.str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT);
        $validated['company_id'] = 1;
        $validated['birth_place'] = 'Not Specified';
        $validated['employment_type'] = 'Full-time';
        $validated['pay_frequency'] = 'Monthly';
        $validated['tax_status'] = 'S';

        // Set defaults for required fields
        $validated['department_id'] = $validated['department_id'] ?? Department::first()?->id;
        $validated['position_id'] = $validated['position_id'] ?? Position::first()?->id;
        $validated['job_grade_id'] = JobGrade::first()?->id;
        $validated['branch_id'] = CompanyBranch::first()?->id;

        // Set empty arrays for JSON fields
        $validated['addresses'] = [];
        $validated['contact_numbers'] = [];
        $validated['email_addresses'] = [];
        $validated['emergency_contacts'] = [];
        $validated['allowances'] = [];
        $validated['documents'] = [];
        $validated['custom_fields'] = [];

        // Set numeric defaults
        $validated['tax_shield'] = 0.00;
        $validated['vacation_leave_balance'] = 0.00;
        $validated['sick_leave_balance'] = 0.00;
        $validated['emergency_leave_balance'] = 0.00;
        $validated['daily_rate'] = 0.00;
        $validated['hourly_rate'] = 0.00;

        // Set boolean defaults
        $validated['is_active'] = $validated['is_active'] ?? true;
        $validated['is_exempt'] = false;
        $validated['is_flexible_time'] = false;
        $validated['is_field_work'] = false;
        $validated['is_minimum_wage'] = false;

        try {
            $employee = Employee::create($validated);

            // Check if this is an Inertia request that needs the employee data for document uploads
            if ($request->hasHeader('X-Inertia')) {
                return response()->json([
                    'success' => true,
                    'message' => 'Employee created successfully!',
                    'employee' => $employee,
                    'redirect' => route('spa.employees.index')
                ]);
            }

            return redirect()->route('spa.employees.index')->with('success', 'Employee created successfully!');
        } catch (\Exception $e) {
            \Log::error('Employee creation failed: '.$e->getMessage());

            return back()->withErrors(['error' => 'Failed to create employee: '.$e->getMessage()]);
        }
    }

    public function store(Request $request)
    {

        // Comprehensive validation for all fields
        $validated = $request->validate([
            // Identification
            'employee_id' => 'nullable|string|max:20',
            'badge_number' => 'nullable|string|max:50',
            'biometric_id' => 'nullable|string|max:50',

            // Personal Information
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'suffix' => 'nullable|string|max:10',
            'maiden_name' => 'nullable|string|max:255',
            'nickname' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'birth_place' => 'nullable|string|max:255',
            'gender' => 'nullable|in:Male,Female,Other',
            'civil_status' => 'nullable|in:Single,Married,Divorced,Widowed',
            'nationality' => 'nullable|string|max:100',
            'religion' => 'nullable|string|max:100',
            'blood_type' => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'height' => 'nullable|numeric|min:0',
            'weight' => 'nullable|numeric|min:0',

            // Government IDs
            'sss_number' => 'nullable|string|max:20',
            'tin' => 'nullable|string|max:20',
            'philhealth_number' => 'nullable|string|max:20',
            'pagibig_number' => 'nullable|string|max:20',
            'passport_number' => 'nullable|string|max:20',
            'drivers_license' => 'nullable|string|max:20',
            'voters_id' => 'nullable|string|max:20',

            // Contact Information
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'phone_secondary' => 'nullable|string|max:20',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'emergency_contact_relationship' => 'nullable|string|max:100',

            // Emergency contacts array (from dynamic form) - temporarily more permissive
            'emergency_contacts' => 'nullable',

            // Address
            'address_street' => 'nullable|string|max:255',
            'address_barangay' => 'nullable|string|max:100',
            'address_city' => 'nullable|string|max:100',
            'address_province' => 'nullable|string|max:100',
            'address_postal_code' => 'nullable|string|max:10',

            // Employment
            'department_id' => 'nullable|exists:departments,id',
            'position_id' => 'nullable|exists:positions,id',
            'job_grade_id' => 'nullable|exists:job_grades,id',
            'branch_id' => 'nullable|exists:company_branches,id',
            'work_schedule_id' => 'nullable|exists:work_schedules,id',
            'employment_status' => 'nullable|string|max:100',
            'employment_type' => 'nullable|string|max:50',
            'hire_date' => 'nullable|date',
            'supervisor_id' => 'nullable|exists:employees,id',

            // Compensation
            'basic_salary' => 'nullable|numeric|min:0',
            'daily_rate' => 'nullable|numeric|min:0',
            'hourly_rate' => 'nullable|numeric|min:0',
            'pay_frequency' => 'nullable|string|max:50',
            'tax_status' => 'nullable|string|max:10',
            'tax_shield' => 'nullable|numeric|min:0',
            'vacation_leave_balance' => 'nullable|numeric|min:0',
            'sick_leave_balance' => 'nullable|numeric|min:0',
            'emergency_leave_balance' => 'nullable|numeric|min:0',

            // Employment Settings
            'is_active' => 'boolean',
            'is_exempt' => 'boolean',
            'is_flexible_time' => 'boolean',
            'is_field_work' => 'boolean',
            'is_minimum_wage' => 'boolean',

            // Medical
            'medical_conditions' => 'nullable|string',
            'allergies' => 'nullable|string',

            // Additional
            'remarks' => 'nullable|string',

            // Files
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:5120', // 5MB
            'documents' => 'nullable|array',
            'documents.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240', // 10MB
        ]);

        // Set required defaults using proven working approach
        $validated['uuid'] = (string) Str::uuid();
        $validated['employee_id'] = $validated['employee_id'] ?? 'EMP'.str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT);
        $validated['company_id'] = 1;
        $validated['birth_place'] = $validated['birth_place'] ?? 'Not Specified';
        $validated['employment_type'] = $validated['employment_type'] ?? 'Full-time';
        $validated['pay_frequency'] = $validated['pay_frequency'] ?? 'Monthly';
        $validated['tax_status'] = $validated['tax_status'] ?? 'S';

        // Set defaults for required foreign keys
        $validated['department_id'] = $validated['department_id'] ?? Department::first()?->id;
        $validated['position_id'] = $validated['position_id'] ?? Position::first()?->id;
        $validated['job_grade_id'] = $validated['job_grade_id'] ?? JobGrade::first()?->id;
        $validated['branch_id'] = $validated['branch_id'] ?? CompanyBranch::first()?->id;

        // Fix employment_status mapping - convert display names to enum values
        $employmentStatusMap = [
            'Active Employee' => 'Regular',
            'Probationary Employee' => 'Probationary',
            'Contract Employee' => 'Contractual',
            'Project Employee' => 'Project-Based',
            'Consultant' => 'Consultant',
            'Intern' => 'Intern',
            'dfdsf' => 'Regular', // Handle invalid test data
        ];

        if (isset($validated['employment_status'])) {
            $validated['employment_status'] = $employmentStatusMap[$validated['employment_status']] ?? 'Regular';
        } else {
            $validated['employment_status'] = 'Regular';
        }

        // Handle address as JSON (combining individual fields)
        $addresses = [];
        if (($validated['address_street'] ?? null) || ($validated['address_city'] ?? null)) {
            $addresses[] = [
                'type' => 'current',
                'street' => $validated['address_street'] ?? '',
                'barangay' => $validated['address_barangay'] ?? '',
                'city' => $validated['address_city'] ?? '',
                'province' => $validated['address_province'] ?? '',
                'postal_code' => $validated['address_postal_code'] ?? '',
            ];
        }
        $validated['addresses'] = $addresses;

        // Handle contact numbers as JSON
        $contactNumbers = [];
        if ($validated['phone'] ?? false) {
            $contactNumbers[] = ['type' => 'primary', 'number' => $validated['phone']];
        }
        if ($validated['phone_secondary'] ?? false) {
            $contactNumbers[] = ['type' => 'secondary', 'number' => $validated['phone_secondary']];
        }
        $validated['contact_numbers'] = $contactNumbers;

        // Handle email addresses as JSON
        $emailAddresses = [];
        if ($validated['email'] ?? false) {
            $emailAddresses[] = ['type' => 'primary', 'email' => $validated['email']];
        }
        $validated['email_addresses'] = $emailAddresses;

        // Handle emergency contacts as JSON
        $emergencyContacts = [];

        // Debug logging
        \Log::info('Emergency contacts processing:', [
            'raw_emergency_contacts' => $validated['emergency_contacts'] ?? 'null',
            'is_array' => is_array($validated['emergency_contacts'] ?? null),
            'type' => gettype($validated['emergency_contacts'] ?? null),
        ]);

        // Check if emergency contacts are sent as JSON string (from dynamic form)
        if (!empty($validated['emergency_contacts'])) {
            if (is_string($validated['emergency_contacts'])) {
                // Decode JSON string to array
                $decodedContacts = json_decode($validated['emergency_contacts'], true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decodedContacts)) {
                    $emergencyContacts = $decodedContacts;
                    \Log::info('Emergency contacts decoded from JSON string:', $emergencyContacts);
                } else {
                    \Log::error('Failed to decode emergency contacts JSON:', [
                        'raw' => $validated['emergency_contacts'],
                        'error' => json_last_error_msg()
                    ]);
                }
            } elseif (is_array($validated['emergency_contacts'])) {
                // Use array data directly
                $emergencyContacts = $validated['emergency_contacts'];
                \Log::info('Emergency contacts received as array:', $emergencyContacts);
            }
        } elseif ($validated['emergency_contact_name'] ?? false) {
            // Fallback to individual fields format
            $emergencyContacts[] = [
                'name' => $validated['emergency_contact_name'],
                'phone' => $validated['emergency_contact_phone'] ?? '',
                'relationship' => $validated['emergency_contact_relationship'] ?? '',
            ];
            \Log::info('Emergency contacts from individual fields:', $emergencyContacts);
        }

        \Log::info('Final emergency contacts to save:', $emergencyContacts);
        $validated['emergency_contacts'] = $emergencyContacts;

        // Set empty arrays for other JSON fields
        $validated['allowances'] = [];
        $validated['custom_fields'] = [];

        // Set numeric defaults
        $validated['tax_shield'] = $validated['tax_shield'] ?? 0.00;
        $validated['vacation_leave_balance'] = $validated['vacation_leave_balance'] ?? 0.00;
        $validated['sick_leave_balance'] = $validated['sick_leave_balance'] ?? 0.00;
        $validated['emergency_leave_balance'] = $validated['emergency_leave_balance'] ?? 0.00;
        $validated['daily_rate'] = $validated['daily_rate'] ?? 0.00;
        $validated['hourly_rate'] = $validated['hourly_rate'] ?? 0.00;
        $validated['basic_salary'] = $validated['basic_salary'] ?? 0.00;

        // Set boolean defaults
        $validated['is_active'] = $validated['is_active'] ?? true;
        $validated['is_exempt'] = $validated['is_exempt'] ?? false;
        $validated['is_flexible_time'] = $validated['is_flexible_time'] ?? false;
        $validated['is_field_work'] = $validated['is_field_work'] ?? false;
        $validated['is_minimum_wage'] = $validated['is_minimum_wage'] ?? false;

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('employee_photos', 'public');
            $validated['photo'] = $photoPath;
        }

        // Handle documents upload
        $documents = [];
        \Log::info('Documents processing:', [
            'has_documents_file' => $request->hasFile('documents'),
            'documents_in_request' => $request->has('documents'),
            'request_documents' => $request->get('documents'),
        ]);

        if ($request->hasFile('documents')) {
            \Log::info('Processing uploaded documents files...');
            foreach ($request->file('documents') as $file) {
                $documentPath = $file->store('employee_documents', 'public');
                $documents[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $documentPath,
                    'type' => $file->getClientMimeType(),
                    'size' => $file->getSize(),
                    'uploaded_at' => now()->toDateTimeString(),
                ];
            }
            \Log::info('Documents processed:', $documents);
        } else {
            \Log::info('No documents files found in request');
        }

        \Log::info('Final documents to save:', $documents);
        $validated['documents'] = $documents;

        // Remove individual address/contact fields since we've converted them to JSON
        $fieldsToRemove = ['address_street', 'address_barangay', 'address_city',
            'address_province', 'address_postal_code',
            'phone', 'phone_secondary', 'email',
            'emergency_contact_name', 'emergency_contact_phone',
            'emergency_contact_relationship'];

        foreach ($fieldsToRemove as $field) {
            unset($validated[$field]);
        }

        try {
            \Log::info('Creating employee with validated data:', [
                'emergency_contacts' => $validated['emergency_contacts'],
                'documents' => $validated['documents'],
                'contact_numbers' => $validated['contact_numbers'],
            ]);

            $employee = Employee::create($validated);

            \Log::info('Employee created successfully:', [
                'id' => $employee->id,
                'name' => $employee->first_name . ' ' . $employee->last_name,
                'emergency_contacts_saved' => $employee->emergency_contacts,
                'documents_saved' => $employee->documents,
            ]);

            return redirect()->route('spa.employees.index')->with('success', 'Employee created successfully!');
        } catch (\Exception $e) {
            \Log::error('Employee creation failed: '.$e->getMessage());

            return back()->withErrors(['error' => 'Failed to create employee: '.$e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        // Redirect to the new Vue.js comprehensive employee show page
        return redirect('/spa/employees/'.$employee->id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        // Load employee with relationships
        $employee->load(['department', 'position', 'jobGrade', 'branch', 'employmentStatus', 'workSchedule']);

        // Transform employee data for the frontend form
        $employeeData = $employee->toArray();

        // Extract individual fields from JSON arrays for the form
        $contactNumbers = $employee->contact_numbers ?? [];
        $emailAddresses = $employee->email_addresses ?? [];
        $addresses = $employee->addresses ?? [];
        $emergencyContacts = $employee->emergency_contacts ?? [];

        // Map contact data to individual fields (handle object array structure)
        $employeeData['phone'] = '';
        $employeeData['phone_secondary'] = '';
        if (is_array($contactNumbers)) {
            foreach ($contactNumbers as $contact) {
                if (isset($contact['type']) && $contact['type'] === 'primary' && isset($contact['number'])) {
                    $employeeData['phone'] = $contact['number'];
                }
                if (isset($contact['type']) && $contact['type'] === 'secondary' && isset($contact['number'])) {
                    $employeeData['phone_secondary'] = $contact['number'];
                }
            }
        }

        $employeeData['email'] = '';
        if (is_array($emailAddresses)) {
            foreach ($emailAddresses as $email) {
                if (isset($email['type']) && $email['type'] === 'primary' && isset($email['email'])) {
                    $employeeData['email'] = $email['email'];
                }
            }
        }

        // Map emergency contact data (uses direct object structure)
        $employeeData['emergency_contact_name'] = '';
        $employeeData['emergency_contact_phone'] = '';
        $employeeData['emergency_contact_relationship'] = '';
        if (is_array($emergencyContacts) && !empty($emergencyContacts)) {
            $primaryEmergencyContact = $emergencyContacts[0] ?? [];
            $employeeData['emergency_contact_name'] = $primaryEmergencyContact['name'] ?? '';
            $employeeData['emergency_contact_phone'] = $primaryEmergencyContact['phone'] ?? '';
            $employeeData['emergency_contact_relationship'] = $primaryEmergencyContact['relationship'] ?? '';

        }

        // Map address data to individual fields
        $employeeData['address_street'] = '';
        $employeeData['address_barangay'] = '';
        $employeeData['address_city'] = '';
        $employeeData['address_province'] = '';
        $employeeData['address_postal_code'] = '';
        if (!empty($addresses)) {
            $primaryAddress = is_array($addresses) ? ($addresses[0] ?? []) : [];
            $employeeData['address_street'] = $primaryAddress['street'] ?? '';
            $employeeData['address_barangay'] = $primaryAddress['barangay'] ?? '';
            $employeeData['address_city'] = $primaryAddress['city'] ?? '';
            $employeeData['address_province'] = $primaryAddress['province'] ?? '';
            $employeeData['address_postal_code'] = $primaryAddress['postal_code'] ?? '';
        }

        // Map employment status relationship to string
        $employeeData['employment_status'] = $employee->employmentStatus->name ?? '';

        // Map supervisor relationship
        $employeeData['supervisor_id'] = $employee->immediate_supervisor_id;

        // Ensure date fields are properly formatted for input[type="date"]
        if ($employee->birth_date) {
            $employeeData['birth_date'] = $employee->birth_date->format('Y-m-d');
        }
        if ($employee->hire_date) {
            $employeeData['hire_date'] = $employee->hire_date->format('Y-m-d');
        }

        // Handle photo URL for display
        if ($employee->photo) {
            $employeeData['current_photo_url'] = asset('storage/' . $employee->photo);
        }

        // Handle documents for display
        $documents = $employee->documents ?? [];
        $employeeData['current_documents'] = [];
        if (is_array($documents)) {
            foreach ($documents as $doc) {
                if (isset($doc['name']) && isset($doc['path'])) {
                    $employeeData['current_documents'][] = [
                        'name' => $doc['name'],
                        'url' => asset('storage/' . $doc['path']),
                        'type' => $doc['type'] ?? '',
                        'size' => $doc['size'] ?? 0,
                        'uploaded_at' => $doc['uploaded_at'] ?? '',
                    ];
                }
            }

        }



        return Inertia::render('Employee/EmployeeEdit', [
            'employee' => $employeeData,
            'departments' => Department::select('id', 'name')->get(),
            'positions' => Position::select('id', 'title')->get(),
            'jobGrades' => JobGrade::select('id', 'name')->get(),
            'branches' => CompanyBranch::select('id', 'name')->get(),
            'workSchedules' => WorkSchedule::select('id', 'name')->get(),
            'employmentStatuses' => EmploymentStatus::where('is_active', true)
                ->orderBy('sort_order')
                ->select('id', 'name', 'code', 'description')
                ->get(),
            'employees' => Employee::select('id', 'first_name', 'last_name')->where('is_active', true)->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        // Validation rules for comprehensive Inertia form
        $validated = $request->validate([
            // Employee ID & Badge
            'employee_id' => 'nullable|string|max:20',
            'badge_number' => 'nullable|string|max:50',
            'biometric_id' => 'nullable|string|max:50',

            // Personal Information
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'suffix' => 'nullable|string|max:10',
            'maiden_name' => 'nullable|string|max:255',
            'nickname' => 'nullable|string|max:100',
            'birth_date' => 'nullable|date',
            'birth_place' => 'nullable|string|max:255',
            'gender' => 'nullable|in:Male,Female,Other',
            'civil_status' => 'nullable|in:Single,Married,Divorced,Widowed',
            'nationality' => 'nullable|string|max:100',
            'religion' => 'nullable|string|max:100',
            'blood_type' => 'nullable|string|max:10',
            'height' => 'nullable|numeric|min:0|max:300',
            'weight' => 'nullable|numeric|min:0|max:500',

            // Government IDs
            'sss_number' => 'nullable|string|max:20',
            'tin' => 'nullable|string|max:20',
            'philhealth_number' => 'nullable|string|max:20',
            'pagibig_number' => 'nullable|string|max:20',
            'passport_number' => 'nullable|string|max:20',
            'drivers_license' => 'nullable|string|max:50',
            'voters_id' => 'nullable|string|max:50',

            // Contact Information
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'phone_secondary' => 'nullable|string|max:20',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'emergency_contact_relationship' => 'nullable|string|max:100',

            // Address fields
            'address_street' => 'nullable|string|max:255',
            'address_barangay' => 'nullable|string|max:100',
            'address_city' => 'nullable|string|max:100',
            'address_province' => 'nullable|string|max:100',
            'address_postal_code' => 'nullable|string|max:20',

            // Employment Information
            'department_id' => 'nullable|exists:departments,id',
            'position_id' => 'nullable|exists:positions,id',
            'job_grade_id' => 'nullable|exists:job_grades,id',
            'branch_id' => 'nullable|exists:company_branches,id',
            'work_schedule_id' => 'nullable|exists:work_schedules,id',
            'employment_status' => 'nullable|string|max:255',
            'employment_type' => 'nullable|string|max:50',
            'hire_date' => 'nullable|date',
            'supervisor_id' => 'nullable|exists:employees,id',

            // Compensation
            'basic_salary' => 'nullable|numeric|min:0',
            'daily_rate' => 'nullable|numeric|min:0',
            'hourly_rate' => 'nullable|numeric|min:0',
            'pay_frequency' => 'nullable|string|max:50',
            'tax_status' => 'nullable|string|max:10',
            'tax_shield' => 'nullable|numeric|min:0',
            'vacation_leave_balance' => 'nullable|numeric|min:0',
            'sick_leave_balance' => 'nullable|numeric|min:0',
            'emergency_leave_balance' => 'nullable|numeric|min:0',

            // Employment Settings
            'is_active' => 'nullable|boolean',
            'is_exempt' => 'nullable|boolean',
            'is_flexible_time' => 'nullable|boolean',
            'is_field_work' => 'nullable|boolean',
            'is_minimum_wage' => 'nullable|boolean',

            // Medical Information
            'medical_conditions' => 'nullable|string',
            'allergies' => 'nullable|string',

            // Files
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:5120', // 5MB
            'documents' => 'nullable|array',
            'documents.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240', // 10MB

            // Additional
            'remarks' => 'nullable|string',

            // Legacy JSON fields (for backward compatibility)
            'addresses' => 'nullable|json',
            'contact_numbers' => 'nullable|json',
            'email_addresses' => 'nullable|json',

            // Document management
            'existing_documents' => 'nullable|json',
            'removed_documents' => 'nullable|json',
        ]);

        try {
            // Handle JSON fields - they're already JSON strings from the frontend
            $jsonFields = ['addresses', 'contact_numbers', 'email_addresses'];
            foreach ($jsonFields as $field) {
                if (isset($validated[$field]) && ! empty($validated[$field])) {
                    // Decode JSON string to array for database storage
                    $decoded = json_decode($validated[$field], true);
                    $validated[$field] = is_array($decoded) ? $decoded : [];
                } else {
                    $validated[$field] = [];
                }
            }

            // Set default boolean values
            $validated['is_active'] = $validated['is_active'] ?? true;
            $validated['is_exempt'] = $validated['is_exempt'] ?? false;
            $validated['is_flexible_time'] = $validated['is_flexible_time'] ?? false;
            $validated['is_field_work'] = $validated['is_field_work'] ?? false;
            $validated['is_minimum_wage'] = $validated['is_minimum_wage'] ?? false;

            // Transform individual contact fields back to JSON arrays for storage
            $contactNumbers = [];
            if (!empty($validated['phone'])) {
                $contactNumbers['primary'] = $validated['phone'];
            }
            if (!empty($validated['phone_secondary'])) {
                $contactNumbers['secondary'] = $validated['phone_secondary'];
            }
            $validated['contact_numbers'] = $contactNumbers;

            $emailAddresses = [];
            if (!empty($validated['email'])) {
                $emailAddresses['primary'] = $validated['email'];
            }
            $validated['email_addresses'] = $emailAddresses;

            // Transform emergency contact fields back to JSON array for storage
            $emergencyContacts = [];
            if (!empty($validated['emergency_contact_name']) || !empty($validated['emergency_contact_phone'])) {
                $emergencyContacts[] = [
                    'name' => $validated['emergency_contact_name'] ?? '',
                    'phone' => $validated['emergency_contact_phone'] ?? '',
                    'relationship' => $validated['emergency_contact_relationship'] ?? '',
                    'type' => 'primary'
                ];
            }
            $validated['emergency_contacts'] = $emergencyContacts;

            // Transform address fields back to JSON array for storage
            $addresses = [];
            if (!empty($validated['address_street']) || !empty($validated['address_city'])) {
                $addresses[] = [
                    'street' => $validated['address_street'] ?? '',
                    'barangay' => $validated['address_barangay'] ?? '',
                    'city' => $validated['address_city'] ?? '',
                    'province' => $validated['address_province'] ?? '',
                    'postal_code' => $validated['address_postal_code'] ?? '',
                    'type' => 'primary'
                ];
            }
            $validated['addresses'] = $addresses;

            // Handle employment status transformation
            if (!empty($validated['employment_status'])) {
                $employmentStatus = EmploymentStatus::where('name', $validated['employment_status'])->first();
                if ($employmentStatus) {
                    $validated['employment_status_id'] = $employmentStatus->id;
                }
            }
            unset($validated['employment_status']); // Remove the string field

            // Map supervisor_id to immediate_supervisor_id
            if (isset($validated['supervisor_id'])) {
                $validated['immediate_supervisor_id'] = $validated['supervisor_id'];
                unset($validated['supervisor_id']);
            }

            // Remove individual fields that are now stored in JSON
            unset($validated['phone'], $validated['phone_secondary'], $validated['email']);
            unset($validated['emergency_contact_name'], $validated['emergency_contact_phone'], $validated['emergency_contact_relationship']);
            unset($validated['address_street'], $validated['address_barangay'], $validated['address_city'], $validated['address_province'], $validated['address_postal_code']);

            // Handle photo upload
            if ($request->hasFile('photo')) {
                // Delete old photo if exists
                if ($employee->photo && \Storage::disk('public')->exists($employee->photo)) {
                    \Storage::disk('public')->delete($employee->photo);
                }

                // Store new photo
                $photoPath = $request->file('photo')->store('employee_photos', 'public');
                $validated['photo'] = $photoPath;
            }

            // Handle document management
            $finalDocuments = [];

            // Start with existing documents that weren't removed
            if (isset($validated['existing_documents'])) {
                $existingDocs = json_decode($validated['existing_documents'], true) ?? [];
                $finalDocuments = array_merge($finalDocuments, $existingDocs);
            }

            // Add new uploaded documents
            if ($request->hasFile('documents')) {
                foreach ($request->file('documents') as $file) {
                    $documentPath = $file->store('employee_documents', 'public');
                    $finalDocuments[] = [
                        'name' => $file->getClientOriginalName(),
                        'path' => $documentPath,
                        'type' => $file->getClientMimeType(),
                        'size' => $file->getSize(),
                        'uploaded_at' => now()->toDateTimeString(),
                    ];
                }
            }

            $validated['documents'] = $finalDocuments;

            // Clean up the form data - remove our helper fields
            unset($validated['existing_documents'], $validated['removed_documents']);

            // Set defaults
            $validated['is_active'] = $validated['is_active'] ?? true;

            // Update the employee
            $employee->update($validated);

            return redirect()
                ->route('spa.employees.edit', $employee)
                ->with('success', 'Employee updated successfully.');

        } catch (\Exception $e) {
            \Log::error('Employee update failed: '.$e->getMessage());

            return back()
                ->withInput()
                ->withErrors(['error' => 'Failed to update employee. Please try again.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        try {
            // Soft delete the employee
            $employee->delete();

            return redirect()
                ->route('spa.employees.index')
                ->with('success', 'Employee deleted successfully!');

        } catch (\Exception $e) {
            \Log::error('Employee deletion failed: '.$e->getMessage());

            return redirect()
                ->route('spa.employees.index')
                ->with('error', 'Failed to delete employee. Please try again.');
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
}
