<?php

namespace App\Http\Controllers;

use App\Models\CompanyBranch;
use App\Models\Department;
use App\Models\Employee;
use App\Models\EmployeeDocument;
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
            $activeEmployees = Employee::where('is_active', true)->count();

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

        // Log the employment status data being received
        \Log::info('Employment status data received:', [
            'employment_status_id' => $request->get('employment_status_id'),
            'employment_status' => $request->get('employment_status'),
        ]);

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
            'employment_status_id' => 'nullable|exists:employment_statuses,id',
            'employment_status' => 'nullable|string|max:100',
            'employment_type' => 'nullable|string|max:50',
            'hire_date' => 'nullable|date',
            'original_hire_date' => 'nullable|date',
            'supervisor_id' => 'nullable|exists:employees,id',

            // Employment Status Dates
            'probation_end_date' => 'nullable|date',
            'regularization_date' => 'nullable|date',
            'last_promotion_date' => 'nullable|date',
            'resignation_date' => 'nullable|date',
            'termination_date' => 'nullable|date',
            'retirement_date' => 'nullable|date',

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

        // Remove documents from validated data since we'll handle it separately
        unset($validated['documents']);

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
                'contact_numbers' => $validated['contact_numbers'],
            ]);

            $employee = Employee::create($validated);

            // Handle documents upload using the separate employee_documents table
            \Log::info('Documents processing:', [
                'has_documents_file' => $request->hasFile('documents'),
                'documents_in_request' => $request->has('documents'),
                'request_documents' => $request->get('documents'),
            ]);

            if ($request->hasFile('documents')) {
                \Log::info('Processing uploaded documents files...');
                foreach ($request->file('documents') as $file) {
                    $documentPath = $file->store('employee_documents', 'public');

                    $documentData = [
                        'employee_id' => $employee->id,
                        'document_type' => 'other', // Default type, could be made configurable
                        'document_name' => $file->getClientOriginalName(),
                        'file_name' => $file->getClientOriginalName(),
                        'file_path' => $documentPath,
                        'file_size' => $file->getSize(),
                        'mime_type' => $file->getClientMimeType(),
                        'uploaded_by' => auth()->id() ?? 1, // Use current user or default to admin
                        'is_required' => false,
                        'is_verified' => false,
                    ];

                    EmployeeDocument::create($documentData);
                    \Log::info('Document saved to employee_documents table:', $documentData);
                }
                \Log::info('All documents processed successfully');
            } else {
                \Log::info('No documents files found in request');
            }

            \Log::info('Employee created successfully:', [
                'id' => $employee->id,
                'name' => $employee->first_name . ' ' . $employee->last_name,
                'emergency_contacts_saved' => $employee->emergency_contacts,
                'documents_count' => $employee->documents()->count(),
            ]);

            // Check if this is an Inertia request that needs the employee data for document uploads
            if ($request->hasHeader('X-Inertia') && $request->header('Accept') === 'application/json') {
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

        // Format date fields for HTML date inputs (convert from timestamp to YYYY-MM-DD format)
        $dateFields = ['original_hire_date', 'probation_end_date', 'regularization_date', 'last_promotion_date', 'resignation_date', 'termination_date', 'retirement_date', 'hire_date'];
        foreach ($dateFields as $field) {
            if (!empty($employeeData[$field])) {
                $employeeData[$field] = date('Y-m-d', strtotime($employeeData[$field]));
            }
        }

        // Employment status date fields are now properly formatted for HTML date inputs

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
        $employeeDocuments = $employee->documents()->get();
        $employeeData['current_documents'] = [];
        foreach ($employeeDocuments as $doc) {
            $employeeData['current_documents'][] = [
                'id' => $doc->id,
                'name' => $doc->document_name,
                'url' => asset('storage/' . $doc->file_path),
                'type' => $doc->mime_type,
                'size' => $doc->file_size,
                'uploaded_at' => $doc->created_at->toDateTimeString(),
                'document_type' => $doc->document_type,
                'is_verified' => $doc->is_verified,
            ];

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
        \Log::info('=== EMPLOYEE UPDATE METHOD CALLED ===', [
            'employee_id' => $employee->id,
            'request_method' => $request->method(),
            'request_url' => $request->url(),
            'has_files' => $request->hasFile('documents'),
            'emergency_contact_name' => $request->get('emergency_contact_name'),
            'emergency_contact_phone' => $request->get('emergency_contact_phone'),
            'emergency_contact_relationship' => $request->get('emergency_contact_relationship'),
            'address_street' => $request->get('address_street'),
            'address_barangay' => $request->get('address_barangay'),
            'address_city' => $request->get('address_city'),
            'address_province' => $request->get('address_province'),
            'address_postal_code' => $request->get('address_postal_code'),
            'employment_status_id' => $request->get('employment_status_id'),
            'original_hire_date' => $request->get('original_hire_date'),
            'sick_leave_balance' => $request->get('sick_leave_balance'),
            'emergency_leave_balance' => $request->get('emergency_leave_balance'),
            'is_active' => $request->get('is_active'),
            'is_active_value' => $request->get('is_active') ? 'true' : 'false',
        ]);

        // Validate and process employment status date fields

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
            'employment_status_id' => 'nullable|exists:employment_statuses,id',
            'employment_status' => 'nullable|string|max:255',
            'employment_type' => 'nullable|string|max:50',
            'hire_date' => 'nullable|date',
            'original_hire_date' => 'nullable|date',
            'supervisor_id' => 'nullable|exists:employees,id',

            // Employment Status Dates
            'probation_end_date' => 'nullable|date',
            'regularization_date' => 'nullable|date',
            'last_promotion_date' => 'nullable|date',
            'resignation_date' => 'nullable|date',
            'termination_date' => 'nullable|date',
            'retirement_date' => 'nullable|date',

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

            // Transform individual contact fields back to JSON arrays for storage - PRESERVE existing data
            $existingContactNumbers = $employee->contact_numbers ?? [];
            $contactNumbers = [];

            // Preserve existing non-primary/secondary contacts
            if (is_array($existingContactNumbers)) {
                foreach ($existingContactNumbers as $contact) {
                    if (!in_array($contact['type'] ?? '', ['primary', 'secondary'])) {
                        $contactNumbers[] = $contact;
                    }
                }
            }

            // Add primary phone if provided
            if (!empty($validated['phone'])) {
                $contactNumbers[] = ['type' => 'primary', 'number' => $validated['phone']];
            }
            // Add secondary phone if provided
            if (!empty($validated['phone_secondary'])) {
                $contactNumbers[] = ['type' => 'secondary', 'number' => $validated['phone_secondary']];
            }
            $validated['contact_numbers'] = $contactNumbers;

            // Transform email back to JSON array for storage - PRESERVE existing data
            $existingEmailAddresses = $employee->email_addresses ?? [];
            $emailAddresses = [];

            // Preserve existing non-primary emails
            if (is_array($existingEmailAddresses)) {
                foreach ($existingEmailAddresses as $email) {
                    if (($email['type'] ?? '') !== 'primary') {
                        $emailAddresses[] = $email;
                    }
                }
            }

            // Add primary email if provided
            if (!empty($validated['email'])) {
                $emailAddresses[] = ['type' => 'primary', 'email' => $validated['email']];
            }
            $validated['email_addresses'] = $emailAddresses;

            // Transform emergency contact fields back to JSON array for storage - PRESERVE existing data
            $existingEmergencyContacts = $employee->emergency_contacts ?? [];
            $emergencyContacts = [];

            // Preserve existing non-primary emergency contacts
            if (is_array($existingEmergencyContacts)) {
                foreach ($existingEmergencyContacts as $contact) {
                    // Skip primary contacts (both type='primary' and is_primary=true)
                    $isPrimary = ($contact['type'] ?? '') === 'primary' ||
                                 ($contact['is_primary'] ?? false) === true;
                    if (!$isPrimary) {
                        $emergencyContacts[] = $contact;
                    }
                }
            }

            // Add primary emergency contact if provided
            \Log::info('Processing emergency contact fields:', [
                'emergency_contact_name' => $validated['emergency_contact_name'] ?? 'NULL',
                'emergency_contact_phone' => $validated['emergency_contact_phone'] ?? 'NULL',
                'emergency_contact_relationship' => $validated['emergency_contact_relationship'] ?? 'NULL',
                'existing_emergency_contacts_count' => count($existingEmergencyContacts),
                'preserved_non_primary_count' => count($emergencyContacts),
            ]);

            if (!empty($validated['emergency_contact_name']) || !empty($validated['emergency_contact_phone'])) {
                $newPrimaryContact = [
                    'name' => $validated['emergency_contact_name'] ?? '',
                    'phone' => $validated['emergency_contact_phone'] ?? '',
                    'relationship' => $validated['emergency_contact_relationship'] ?? '',
                    'type' => 'primary'
                ];
                $emergencyContacts[] = $newPrimaryContact;

                \Log::info('Added new primary emergency contact:', $newPrimaryContact);
            } else {
                \Log::info('No emergency contact data provided - skipping primary emergency contact creation');
            }
            $validated['emergency_contacts'] = $emergencyContacts;

            \Log::info('Final emergency contacts array:', [
                'count' => count($emergencyContacts),
                'contacts' => $emergencyContacts,
            ]);

            // Transform address fields back to JSON array for storage - PRESERVE existing data
            $existingAddresses = $employee->addresses ?? [];
            $addresses = [];

            // Preserve existing non-primary addresses
            if (is_array($existingAddresses)) {
                foreach ($existingAddresses as $address) {
                    // Skip primary addresses (both type='primary' and type='current')
                    $isPrimary = in_array($address['type'] ?? '', ['primary', 'current']);
                    if (!$isPrimary) {
                        $addresses[] = $address;
                    }
                }
            }

            // Add primary address if provided
            \Log::info('Processing address fields:', [
                'address_street' => $validated['address_street'] ?? 'NULL',
                'address_barangay' => $validated['address_barangay'] ?? 'NULL',
                'address_city' => $validated['address_city'] ?? 'NULL',
                'address_province' => $validated['address_province'] ?? 'NULL',
                'address_postal_code' => $validated['address_postal_code'] ?? 'NULL',
                'existing_addresses_count' => count($existingAddresses),
                'preserved_non_primary_count' => count($addresses),
            ]);

            if (!empty($validated['address_street']) || !empty($validated['address_city'])) {
                $newPrimaryAddress = [
                    'street' => $validated['address_street'] ?? '',
                    'barangay' => $validated['address_barangay'] ?? '',
                    'city' => $validated['address_city'] ?? '',
                    'province' => $validated['address_province'] ?? '',
                    'postal_code' => $validated['address_postal_code'] ?? '',
                    'type' => 'primary'
                ];
                $addresses[] = $newPrimaryAddress;

                \Log::info('Added new primary address:', $newPrimaryAddress);
            } else {
                \Log::info('No address data provided - skipping primary address creation');
            }
            $validated['addresses'] = $addresses;

            \Log::info('Final addresses array:', [
                'count' => count($addresses),
                'addresses' => $addresses,
            ]);

            // Handle employment status transformation - prioritize ID over string
            \Log::info('Employment status processing:', [
                'employment_status_id_before' => $validated['employment_status_id'] ?? 'NULL',
                'employment_status_string' => $validated['employment_status'] ?? 'NULL',
            ]);

            // Only convert from string if no ID is provided or ID is empty
            if (empty($validated['employment_status_id']) && !empty($validated['employment_status'])) {
                $employmentStatus = EmploymentStatus::where('name', $validated['employment_status'])->first();
                if ($employmentStatus) {
                    $validated['employment_status_id'] = $employmentStatus->id;
                    \Log::info('Employment status converted from string to ID:', [
                        'string' => $validated['employment_status'],
                        'new_id' => $employmentStatus->id,
                    ]);
                }
            } else {
                \Log::info('Using employment_status_id directly, skipping string conversion');
            }
            unset($validated['employment_status']); // Remove the string field

            \Log::info('Employment status processing complete:', [
                'final_employment_status_id' => $validated['employment_status_id'] ?? 'NULL',
            ]);

            // Map supervisor_id to immediate_supervisor_id
            if (isset($validated['supervisor_id'])) {
                $validated['immediate_supervisor_id'] = $validated['supervisor_id'];
                unset($validated['supervisor_id']);
            }

            // Remove individual fields that are now stored in JSON
            unset($validated['phone'], $validated['phone_secondary'], $validated['email']);
            unset($validated['emergency_contact_name'], $validated['emergency_contact_phone'], $validated['emergency_contact_relationship']);
            unset($validated['address_street'], $validated['address_barangay'], $validated['address_city'], $validated['address_province'], $validated['address_postal_code']);

            // Handle photo upload - preserve existing photo if no new photo uploaded
            if ($request->hasFile('photo')) {
                \Log::info('New photo being uploaded, will replace existing photo');
                // Delete old photo if exists
                if ($employee->photo && \Storage::disk('public')->exists($employee->photo)) {
                    \Storage::disk('public')->delete($employee->photo);
                    \Log::info('Deleted old photo: ' . $employee->photo);
                }

                // Store new photo
                $photoPath = $request->file('photo')->store('employee_photos', 'public');
                $validated['photo'] = $photoPath;
                \Log::info('New photo stored: ' . $photoPath);
            } else {
                \Log::info('No new photo uploaded, preserving existing photo: ' . ($employee->photo ?? 'none'));
                // Remove photo from validated data to preserve existing photo
                unset($validated['photo']);
            }

            // Handle document management using employee_documents table
            // Remove documents from validated data since we'll handle it separately
            unset($validated['documents']);

            // Handle new document uploads
            if ($request->hasFile('documents')) {
                \Log::info('Processing uploaded documents files for employee update...');
                foreach ($request->file('documents') as $file) {
                    $documentPath = $file->store('employee_documents', 'public');

                    $documentData = [
                        'employee_id' => $employee->id,
                        'document_type' => 'other', // Default type
                        'document_name' => $file->getClientOriginalName(),
                        'file_name' => $file->getClientOriginalName(),
                        'file_path' => $documentPath,
                        'file_size' => $file->getSize(),
                        'mime_type' => $file->getClientMimeType(),
                        'uploaded_by' => auth()->id() ?? 1,
                        'is_required' => false,
                        'is_verified' => false,
                    ];

                    EmployeeDocument::create($documentData);
                    \Log::info('Document saved to employee_documents table for update:', $documentData);
                }
                \Log::info('All documents processed successfully for update');
            }

            // Clean up the form data - remove our helper fields
            unset($validated['existing_documents'], $validated['removed_documents']);

            // Set defaults
            $validated['is_active'] = $validated['is_active'] ?? true;

            \Log::info('About to update employee with data:', [
                'employee_id' => $employee->id,
                'contact_numbers_count' => count($validated['contact_numbers'] ?? []),
                'email_addresses_count' => count($validated['email_addresses'] ?? []),
                'addresses_count' => count($validated['addresses'] ?? []),
                'emergency_contacts_count' => count($validated['emergency_contacts'] ?? []),
                'has_photo' => isset($validated['photo']),
                'employment_status_id' => $validated['employment_status_id'] ?? null,
                'original_hire_date' => $validated['original_hire_date'] ?? null,
            ]);

            // Update the employee
            $employee->update($validated);

            \Log::info('Employee updated successfully:', [
                'employee_id' => $employee->id,
                'name' => $employee->first_name . ' ' . $employee->last_name,
                'contact_numbers_after' => $employee->fresh()->contact_numbers,
                'email_addresses_after' => $employee->fresh()->email_addresses,
                'photo_after' => $employee->fresh()->photo,
                'employment_status_id' => $validated['employment_status_id'] ?? null,
                'original_hire_date' => $validated['original_hire_date'] ?? null,
            ]);

            // For Inertia requests, redirect back to edit page with success message
            return redirect()->back()->with('success', 'Employee updated successfully!');

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
