<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $query = Employee::with(['department', 'position'])
            ->select(['id', 'employee_id', 'first_name', 'last_name', 'department_id', 'position_id', 'employment_status', 'employment_type', 'is_active', 'hire_date', 'contact_numbers', 'email_addresses', 'photo'])
            ->where('company_id', 1);

        // Apply filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('employee_id', 'like', "%{$search}%");
            });
        }

        if ($request->filled('department')) {
            $query->whereHas('department', function ($q) use ($request) {
                $q->where('name', $request->department);
            });
        }

        if ($request->filled('status')) {
            // Map frontend status to actual database fields
            if ($request->status === 'Active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'Inactive') {
                $query->where('is_active', false);
            } else {
                $query->where('employment_status', $request->status);
            }
        }

        if ($request->filled('employment_type')) {
            $query->where('employment_type', $request->employment_type);
        }

        $employees = $query->latest()->paginate(15);

        // Transform the data to include computed fields
        $employees->getCollection()->transform(function ($employee) {
            return [
                'id' => $employee->id,
                'employee_id' => $employee->employee_id,
                'first_name' => $employee->first_name,
                'last_name' => $employee->last_name,
                'department' => $employee->department?->name,
                'position' => $employee->position?->title,
                'employment_type' => $employee->employment_type,
                'status' => $employee->is_active ? 'Active' : 'Inactive',
                'hire_date' => $employee->hire_date,
                'photo' => $employee->photo,
            ];
        });

        return response()->json($employees);
    }

    public function store(Request $request)
    {
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
            'blood_type' => 'nullable|string|max:5',
            'height' => 'nullable|numeric|min:0',
            'weight' => 'nullable|numeric|min:0',

            // Contact Information (JSON fields)
            'addresses' => 'nullable|json',
            'contact_numbers' => 'nullable|json',
            'email_addresses' => 'nullable|json',
            'emergency_contacts' => 'nullable|json',

            // Government IDs
            'sss_number' => 'nullable|string|max:50',
            'tin' => 'nullable|string|max:50',
            'philhealth_number' => 'nullable|string|max:50',
            'pagibig_number' => 'nullable|string|max:50',
            'passport_number' => 'nullable|string|max:50',
            'passport_expiry' => 'nullable|date',
            'drivers_license' => 'nullable|string|max:50',
            'license_expiry' => 'nullable|date',
            'voters_id' => 'nullable|string|max:50',

            // Employment Information
            'department_id' => 'nullable|exists:departments,id',
            'position_id' => 'nullable|exists:positions,id',
            'job_grade_id' => 'nullable|exists:job_grades,id',
            'cost_center_id' => 'nullable|exists:cost_centers,id',
            'branch_id' => 'nullable|exists:company_branches,id',
            'immediate_supervisor_id' => 'nullable|exists:employees,id',
            'employment_status' => 'nullable|string|max:100',
            'employment_type' => 'nullable|in:Full-time,Part-time,Contract,Temporary,Intern',
            'work_schedule_id' => 'nullable|exists:work_schedules,id',

            // Employment Dates
            'hire_date' => 'nullable|date',
            'original_hire_date' => 'nullable|date',
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
            'pay_frequency' => 'nullable|in:Daily,Weekly,Bi-weekly,Semi-monthly,Monthly',
            'tax_status' => 'nullable|string|max:10',
            'tax_shield' => 'nullable|numeric|min:0',
            'allowances' => 'nullable|json',
            'is_exempt' => 'nullable|boolean',
            'is_minimum_wage' => 'nullable|boolean',

            // Work Preferences
            'is_flexible_time' => 'nullable|boolean',
            'is_field_work' => 'nullable|boolean',

            // Leave Balances
            'vacation_leave_balance' => 'nullable|numeric|min:0',
            'sick_leave_balance' => 'nullable|numeric|min:0',
            'emergency_leave_balance' => 'nullable|numeric|min:0',

            // Medical Information
            'medical_conditions' => 'nullable|string',
            'allergies' => 'nullable|string',
            'medications' => 'nullable|string',

            // Files
            'photo' => 'sometimes|nullable|image|mimes:jpeg,png,jpg|max:5120',
            'documents.*' => 'nullable|file|max:10240',

            // Additional
            'remarks' => 'nullable|string',
            'custom_fields' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        try {
            // Add required UUID
            $validated['uuid'] = (string) Str::uuid();

            // Set default company_id
            $validated['company_id'] = 1;

            // Auto-generate employee_id if not provided
            if (empty($validated['employee_id'])) {
                // Get the next employee number for this company
                $lastEmployee = Employee::where('company_id', 1)
                    ->orderBy('employee_id', 'desc')
                    ->first();

                if ($lastEmployee && preg_match('/EMP(\d+)/', $lastEmployee->employee_id, $matches)) {
                    $nextNumber = intval($matches[1]) + 1;
                } else {
                    $nextNumber = 1;
                }

                $validated['employee_id'] = 'EMP'.str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
            }

            // Process JSON fields (medical fields are text, not JSON)
            $jsonFields = ['addresses', 'contact_numbers', 'email_addresses', 'emergency_contacts', 'allowances', 'custom_fields'];
            foreach ($jsonFields as $field) {
                if (isset($validated[$field]) && ! empty($validated[$field])) {
                    // If it's already a JSON string, decode it; if it's an array, keep it
                    if (is_string($validated[$field])) {
                        $decoded = json_decode($validated[$field], true);
                        $validated[$field] = is_array($decoded) ? $decoded : [$validated[$field]];
                    } elseif (is_array($validated[$field])) {
                        // It's already an array, keep it as is
                        $validated[$field] = $validated[$field];
                    } else {
                        $validated[$field] = [];
                    }
                } else {
                    $validated[$field] = [];
                }
            }

            // Process text fields for medical information
            $textFields = ['medical_conditions', 'allergies', 'medications'];
            foreach ($textFields as $field) {
                if (isset($validated[$field]) && ! empty($validated[$field])) {
                    // If it's an array (from frontend), convert to text
                    if (is_array($validated[$field])) {
                        $validated[$field] = implode(', ', array_filter($validated[$field]));
                    } elseif (is_string($validated[$field])) {
                        // If it's a JSON string, decode and convert to text
                        $decoded = json_decode($validated[$field], true);
                        if (is_array($decoded)) {
                            $validated[$field] = implode(', ', array_filter($decoded));
                        }
                        // If it's already a string, leave it as is
                    }
                }
            }

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

            // Set boolean defaults
            $validated['is_active'] = $validated['is_active'] ?? true;
            $validated['is_exempt'] = $validated['is_exempt'] ?? false;
            $validated['is_flexible_time'] = $validated['is_flexible_time'] ?? false;
            $validated['is_field_work'] = $validated['is_field_work'] ?? false;
            $validated['is_minimum_wage'] = $validated['is_minimum_wage'] ?? false;

            // Set numeric defaults
            $validated['basic_salary'] = $validated['basic_salary'] ?? 0.00;
            $validated['daily_rate'] = $validated['daily_rate'] ?? 0.00;
            $validated['hourly_rate'] = $validated['hourly_rate'] ?? 0.00;
            $validated['tax_shield'] = $validated['tax_shield'] ?? 0.00;
            $validated['vacation_leave_balance'] = $validated['vacation_leave_balance'] ?? 0.00;
            $validated['sick_leave_balance'] = $validated['sick_leave_balance'] ?? 0.00;
            $validated['emergency_leave_balance'] = $validated['emergency_leave_balance'] ?? 0.00;

            // Set default values for required fields
            $validated['employment_type'] = $validated['employment_type'] ?? 'Full-time';
            $validated['birth_place'] = $validated['birth_place'] ?? 'Not Specified';
            $validated['tax_status'] = $validated['tax_status'] ?? 'S';

            $employee = Employee::create($validated);

            return response()->json([
                'message' => 'Employee created successfully',
                'employee' => $employee->load(['department', 'position', 'jobGrade', 'branch', 'costCenter', 'workSchedule']),
            ], 201);

        } catch (\Exception $e) {
            \Log::error('Employee creation failed: '.$e->getMessage());

            return response()->json([
                'message' => 'Failed to create employee',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(Employee $employee)
    {
        $employee->load(['department', 'position', 'jobGrade', 'branch', 'company']);

        return response()->json($employee);
    }

    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            // Employee Identification
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

            // Contact Information (JSON fields)
            'addresses' => 'nullable|json',
            'contact_numbers' => 'nullable|json',
            'email_addresses' => 'nullable|json',
            'emergency_contacts' => 'nullable|json',

            // Government IDs
            'sss_number' => 'nullable|string|max:20',
            'tin' => 'nullable|string|max:20',
            'philhealth_number' => 'nullable|string|max:20',
            'pagibig_number' => 'nullable|string|max:20',
            'passport_number' => 'nullable|string|max:20',
            'passport_expiry' => 'nullable|date',
            'drivers_license' => 'nullable|string|max:20',
            'license_expiry' => 'nullable|date',
            'voters_id' => 'nullable|string|max:20',

            // Employment Information
            'department_id' => 'nullable|exists:departments,id',
            'position_id' => 'nullable|exists:positions,id',
            'employment_type' => 'nullable|in:Full-time,Part-time,Contract,Temporary,Intern',
            'hire_date' => 'nullable|date',
            'employment_status' => 'nullable|string|max:100',

            // Compensation & Benefits
            'basic_salary' => 'nullable|numeric|min:0',
            'daily_rate' => 'nullable|numeric|min:0',
            'hourly_rate' => 'nullable|numeric|min:0',
            'pay_frequency' => 'nullable|in:Daily,Weekly,Bi-weekly,Semi-monthly,Monthly',
            'tax_status' => 'nullable|string|max:10',
            'allowances' => 'nullable|json',

            // Medical Information
            'medical_conditions' => 'nullable|string',
            'allergies' => 'nullable|string',
            'medications' => 'nullable|string',

            // Files
            'photo' => 'sometimes|nullable|image|mimes:jpeg,png,jpg|max:5120',
            'documents' => 'nullable|array',
            'documents.*' => 'nullable|file|max:10240',
            'existing_documents' => 'nullable|json',

            // Additional Information
            'is_active' => 'nullable|boolean',
            'remarks' => 'nullable|string',
        ]);

        try {
            // Handle photo upload
            if ($request->hasFile('photo')) {
                // Delete old photo if exists
                if ($employee->photo && \Storage::disk('public')->exists($employee->photo)) {
                    \Storage::disk('public')->delete($employee->photo);
                }

                $photoPath = $request->file('photo')->store('employee_photos', 'public');
                $validated['photo'] = $photoPath;
            }

            // Handle documents upload
            $existingDocuments = [];
            if ($request->has('existing_documents')) {
                $existingDocuments = json_decode($request->input('existing_documents'), true) ?: [];
            } elseif ($employee->documents) {
                $existingDocuments = is_string($employee->documents)
                    ? json_decode($employee->documents, true)
                    : $employee->documents;
            }

            $newDocuments = [];
            if ($request->hasFile('documents')) {
                foreach ($request->file('documents') as $file) {
                    $documentPath = $file->store('employee_documents', 'public');
                    $newDocuments[] = [
                        'name' => $file->getClientOriginalName(),
                        'path' => $documentPath,
                        'type' => $file->getClientMimeType(),
                        'size' => $file->getSize(),
                        'uploaded_at' => now()->toDateTimeString(),
                    ];
                }
            }

            // Merge existing and new documents
            $allDocuments = array_merge($existingDocuments ?: [], $newDocuments);
            $validated['documents'] = $allDocuments;

            $employee->update($validated);

            return response()->json([
                'message' => 'Employee updated successfully',
                'employee' => $employee->fresh()->load(['department', 'position']),
            ]);

        } catch (\Exception $e) {
            \Log::error('Employee update failed: '.$e->getMessage());

            return response()->json([
                'message' => 'Failed to update employee',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(Employee $employee)
    {
        try {
            // Delete associated photo if exists
            if ($employee->photo && \Storage::disk('public')->exists($employee->photo)) {
                \Storage::disk('public')->delete($employee->photo);
            }

            $employee->delete();

            return response()->json([
                'message' => 'Employee deleted successfully',
            ]);

        } catch (\Exception $e) {
            \Log::error('Employee deletion failed: '.$e->getMessage());

            return response()->json([
                'message' => 'Failed to delete employee',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function downloadDocument(Employee $employee, $documentIndex)
    {
        try {
            $documents = is_string($employee->documents)
                ? json_decode($employee->documents, true)
                : $employee->documents;

            if (! $documents || ! isset($documents[$documentIndex])) {
                return response()->json(['message' => 'Document not found'], 404);
            }

            $document = $documents[$documentIndex];
            $filePath = storage_path('app/public/'.$document['path']);

            if (! file_exists($filePath)) {
                return response()->json(['message' => 'File not found on server'], 404);
            }

            return response()->download($filePath, $document['name']);

        } catch (\Exception $e) {
            \Log::error('Document download failed: '.$e->getMessage());

            return response()->json([
                'message' => 'Failed to download document',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function deleteDocument(Employee $employee, $documentIndex)
    {
        try {
            $documents = is_string($employee->documents)
                ? json_decode($employee->documents, true)
                : $employee->documents;

            if (! $documents || ! isset($documents[$documentIndex])) {
                return response()->json(['message' => 'Document not found'], 404);
            }

            $document = $documents[$documentIndex];

            // Delete file from storage
            if (\Storage::disk('public')->exists($document['path'])) {
                \Storage::disk('public')->delete($document['path']);
            }

            // Remove document from array
            unset($documents[$documentIndex]);
            $documents = array_values($documents); // Re-index array

            // Update employee record
            $employee->update(['documents' => $documents]);

            return response()->json([
                'message' => 'Document deleted successfully',
                'documents' => $documents,
            ]);

        } catch (\Exception $e) {
            \Log::error('Document deletion failed: '.$e->getMessage());

            return response()->json([
                'message' => 'Failed to delete document',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
