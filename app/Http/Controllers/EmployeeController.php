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
            $employees = Employee::with(['department', 'position'])
                ->orderBy('created_at', 'desc')
                ->paginate(20);

            return Inertia::render('Employee/EmployeeList', [
                'employees' => $employees,
                'departments' => Department::all(),
                'positions' => Position::all(),
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
            'employmentStatuses' => [
                ['id' => 'Probationary', 'name' => 'Probationary'],
                ['id' => 'Regular', 'name' => 'Regular'],
                ['id' => 'Contractual', 'name' => 'Contractual'],
                ['id' => 'Project-Based', 'name' => 'Project-Based'],
                ['id' => 'Consultant', 'name' => 'Consultant'],
                ['id' => 'Intern', 'name' => 'Intern'],
            ],
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

            return redirect()->route('spa.employees.index')->with('success', 'Employee created successfully!');
        } catch (\Exception $e) {
            \Log::error('Employee creation failed: '.$e->getMessage());

            return back()->withErrors(['error' => 'Failed to create employee: '.$e->getMessage()]);
        }
    }

    public function store(Request $request)
    {
        // Debug logging
        \Log::info('=== EMPLOYEE STORE METHOD CALLED ===');
        \Log::info('Request method: '.$request->method());
        \Log::info('Request data keys: '.implode(', ', array_keys($request->all())));
        \Log::info('Request has first_name: '.($request->has('first_name') ? 'YES' : 'NO'));
        \Log::info('Request first_name value: '.$request->get('first_name', 'NOT SET'));

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
        if ($validated['emergency_contact_name'] ?? false) {
            $emergencyContacts[] = [
                'name' => $validated['emergency_contact_name'],
                'phone' => $validated['emergency_contact_phone'] ?? '',
                'relationship' => $validated['emergency_contact_relationship'] ?? '',
            ];
        }
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
        if ($request->hasFile('documents')) {
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
        }
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
            $employee = Employee::create($validated);

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
        return Inertia::render('Employee/EmployeeEdit', [
            'employee' => $employee,
            'departments' => Department::select('id', 'name')->get(),
            'positions' => Position::select('id', 'title')->get(),
            'jobGrades' => JobGrade::select('id', 'name')->get(),
            'branches' => CompanyBranch::select('id', 'name')->get(),
            'workSchedules' => WorkSchedule::select('id', 'name')->get(),
            'employmentStatuses' => EmploymentStatus::select('id', 'name')->get(),
            'employees' => Employee::select('id', 'first_name', 'last_name')->where('is_active', true)->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        // Validation rules for Inertia form
        $validated = $request->validate([
            // Employee ID & Badge
            'employee_id' => 'nullable|string|max:20',
            'badge_number' => 'nullable|string|max:50',
            'biometric_id' => 'nullable|string|max:50',

            // Personal Information
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:Male,Female,Other',
            'civil_status' => 'nullable|in:Single,Married,Divorced,Widowed',

            // Contact Information (JSON strings)
            'addresses' => 'nullable|json',
            'contact_numbers' => 'nullable|json',
            'email_addresses' => 'nullable|json',

            // Employment Information
            'department_id' => 'nullable|exists:departments,id',
            'position_id' => 'nullable|exists:positions,id',
            'employment_status' => 'nullable|string|max:255',

            // Medical Information (comma-separated strings)
            'medical_conditions' => 'nullable|string',
            'allergies' => 'nullable|string',

            // Files
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:5120', // 5MB
            'documents' => 'nullable|array',
            'documents.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240', // 10MB

            // Additional
            'remarks' => 'nullable|string',
            'is_active' => 'required|boolean',

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
                ->route('employees.edit', $employee)
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
}
