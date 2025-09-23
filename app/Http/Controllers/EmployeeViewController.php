<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeDocument;
use App\Models\AuditTrail;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EmployeeViewController extends Controller
{
    /**
     * Display the specified employee with all related data
     */
    public function show(Employee $employee)
    {
        // Load all related data
        $employee->load([
            'department',
            'position',
            'jobGrade',
            'branch',
            'costCenter',
            'workSchedule',
            'employmentStatus',
            'supervisor:id,first_name,last_name',
            'documents.uploader:id,first_name,last_name',
            'documents.verifier:id,first_name,last_name'
        ]);

        // Get employee documents separately for better organization
        $documents = $employee->documents()
            ->with(['uploader:id,first_name,last_name', 'verifier:id,first_name,last_name'])
            ->orderBy('document_type')
            ->orderBy('created_at', 'desc')
            ->get();

        // Organize documents by type
        $documentsByType = $documents->groupBy('document_type');

        // Get expired and expiring documents
        $expiredDocuments = $documents->filter(function ($doc) {
            return $doc->expiry_date && $doc->expiry_date->isPast();
        });

        $expiringDocuments = $documents->filter(function ($doc) {
            return $doc->expiry_date &&
                   $doc->expiry_date->isFuture() &&
                   $doc->expiry_date->diffInDays() <= 30;
        });

        return Inertia::render('Employee/EmployeeViewEnhanced', [
            'employee' => $employee,
            'documents' => $documents,
            'documentsByType' => $documentsByType,
            'expiredDocuments' => $expiredDocuments,
            'expiringDocuments' => $expiringDocuments,
            'documentTypes' => EmployeeDocument::getDocumentTypes(),
        ]);
    }

    /**
     * Display employee documents tab
     */
    public function documents(Employee $employee)
    {
        $documents = $employee->documents()
            ->with(['uploader:id,first_name,last_name', 'verifier:id,first_name,last_name'])
            ->orderBy('document_type')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'documents' => $documents,
            'documentTypes' => EmployeeDocument::getDocumentTypes(),
        ]);
    }

    /**
     * Get employee timeline/activity from audit trails
     */
    public function timeline(Employee $employee)
    {
        // Get audit trails for this employee using direct query
        $auditTrails = AuditTrail::where('model_type', Employee::class)
            ->where('model_id', $employee->id)
            ->with(['user:id,first_name,last_name,preferred_name'])
            ->orderBy('created_at', 'desc')
            ->get();

        $timeline = collect();

        // Get lookup data for foreign key translations
        $lookupData = [
            'companies' => \App\Models\Company::pluck('name', 'id')->toArray(),
            'departments' => \App\Models\Department::pluck('name', 'id')->toArray(),
            'positions' => \App\Models\Position::pluck('title', 'id')->toArray(),
            'jobGrades' => \App\Models\JobGrade::pluck('name', 'id')->toArray(),
            'employmentStatuses' => \App\Models\EmploymentStatus::pluck('name', 'id')->toArray(),
            'workSchedules' => \App\Models\WorkSchedule::pluck('name', 'id')->toArray(),
            'branches' => \App\Models\CompanyBranch::pluck('name', 'id')->toArray(),
            'costCenters' => \App\Models\CostCenter::pluck('name', 'id')->toArray(),
            'employees' => \App\Models\Employee::get()->mapWithKeys(function ($emp) {
                return [$emp->id => $emp->first_name . ' ' . $emp->last_name];
            })->toArray(),
        ];

        // Add audit trail entries
        if ($auditTrails && $auditTrails->count() > 0) {
            foreach ($auditTrails as $audit) {
            $timeline->push([
                'type' => $audit->action,
                'date' => $audit->created_at,
                'description' => $audit->description ?? 'Record modified',
                'user' => $audit->user_name ?? ($audit->user ? $audit->user->name : 'System'),
                'changes' => $this->formatUserFriendlyChanges($audit->changed_fields, $lookupData),
                'ip_address' => $audit->ip_address,
                'user_agent' => $audit->user_agent,
                'action_color' => $this->getActionColor($audit->action),
                'action_icon' => $this->getActionIcon($audit->action),
            ]);
            }
        }

        // Load employee documents with relationships
        $employee->load(['documents.uploader:id,first_name,last_name', 'documents.verifier:id,first_name,last_name']);

        // Add document uploads to timeline
        if ($employee->documents && $employee->documents->count() > 0) {
            foreach ($employee->documents as $document) {
            $timeline->push([
                'type' => 'document_uploaded',
                'date' => $document->created_at,
                'description' => "Document uploaded: {$document->document_name} ({$document->document_type})",
                'user' => ($document->uploader->first_name ?? '') . ' ' . ($document->uploader->last_name ?? '') ?: 'Unknown',
                'changes' => null,
                'ip_address' => null,
                'user_agent' => null,
                'action_color' => 'blue',
                'action_icon' => 'file-upload',
            ]);

            // Add document verification events
            if ($document->is_verified && $document->verified_at) {
                $timeline->push([
                    'type' => 'document_verified',
                    'date' => $document->verified_at,
                    'description' => "Document verified: {$document->document_name}",
                    'user' => ($document->verifier->first_name ?? '') . ' ' . ($document->verifier->last_name ?? '') ?: 'Unknown',
                    'changes' => null,
                    'ip_address' => null,
                    'user_agent' => null,
                    'action_color' => 'green',
                    'action_icon' => 'check-circle',
                ]);
            }
            }
        }

        // Add milestone events
        if ($employee->hire_date) {
            $timeline->push([
                'type' => 'milestone',
                'date' => $employee->hire_date,
                'description' => 'Employee hired',
                'user' => 'HR Department',
                'changes' => null,
                'ip_address' => null,
                'user_agent' => null,
                'action_color' => 'green',
                'action_icon' => 'briefcase',
            ]);
        }

        if ($employee->probation_end_date) {
            $timeline->push([
                'type' => 'milestone',
                'date' => $employee->probation_end_date,
                'description' => 'Probation period ended',
                'user' => 'System',
                'changes' => null,
                'ip_address' => null,
                'user_agent' => null,
                'action_color' => 'yellow',
                'action_icon' => 'clock',
            ]);
        }

        if ($employee->regularization_date) {
            $timeline->push([
                'type' => 'milestone',
                'date' => $employee->regularization_date,
                'description' => 'Employee regularized',
                'user' => 'HR Department',
                'changes' => null,
                'ip_address' => null,
                'user_agent' => null,
                'action_color' => 'green',
                'action_icon' => 'user-check',
            ]);
        }

        return response()->json([
            'timeline' => $timeline->sortByDesc('date')->values()
        ]);
    }

    /**
     * Get action color for timeline entries
     */
    private function getActionColor(string $action): string
    {
        return match ($action) {
            'created' => 'green',
            'updated' => 'blue',
            'deleted' => 'red',
            default => 'gray',
        };
    }

    /**
     * Get action icon for timeline entries
     */
    private function getActionIcon(string $action): string
    {
        return match ($action) {
            'created' => 'plus',
            'updated' => 'pencil',
            'deleted' => 'trash',
            default => 'info',
        };
    }

    /**
     * Format audit trail changes with human-readable values
     */
    private function formatUserFriendlyChanges($changedFields, $lookupData): string
    {
        if (empty($changedFields) || !is_array($changedFields)) {
            return 'No specific changes recorded';
        }

        $formatted = [];
        foreach ($changedFields as $field => $values) {
            $oldValue = $values['old'] ?? null;
            $newValue = $values['new'] ?? null;

            // Format field name
            $fieldDisplayName = $this->getFieldDisplayName($field);

            // Format values using lookup data
            $formattedOldValue = $this->formatDisplayValue($field, $oldValue, $lookupData);
            $formattedNewValue = $this->formatDisplayValue($field, $newValue, $lookupData);

            $formatted[] = "<strong>{$fieldDisplayName}:</strong> {$formattedOldValue} → {$formattedNewValue}";
        }

        return implode('<br>', $formatted);
    }

    /**
     * Get user-friendly field display name
     */
    private function getFieldDisplayName(string $fieldName): string
    {
        $fieldMappings = [
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'middle_name' => 'Middle Name',
            'preferred_name' => 'Preferred Name',
            'employee_id' => 'Employee ID',
            'badge_number' => 'Badge Number',
            'biometric_id' => 'Biometric ID',
            'email' => 'Email Address',
            'phone' => 'Phone Number',
            'mobile_phone' => 'Mobile Phone',
            'hire_date' => 'Hire Date',
            'birth_date' => 'Birth Date',
            'gender' => 'Gender',
            'marital_status' => 'Marital Status',
            'nationality' => 'Nationality',
            'religion' => 'Religion',
            'department_id' => 'Department',
            'position_id' => 'Position',
            'job_grade_id' => 'Job Grade',
            'employment_status_id' => 'Employment Status',
            'employment_type' => 'Employment Type',
            'work_schedule_id' => 'Work Schedule',
            'branch_id' => 'Branch',
            'cost_center_id' => 'Cost Center',
            'company_id' => 'Company',
            'supervisor_id' => 'Supervisor',
            'immediate_supervisor_id' => 'Immediate Supervisor',
            'is_active' => 'Active Status',
            'basic_salary' => 'Basic Salary',
            'allowances' => 'Allowances',
            'probation_end_date' => 'Probation End Date',
            'regularization_date' => 'Regularization Date',
            'contract_start_date' => 'Contract Start Date',
            'contract_end_date' => 'Contract End Date',
            'addresses' => 'Addresses',
            'emergency_contacts' => 'Emergency Contacts',
            'education_background' => 'Education Background',
            'work_experience' => 'Work Experience',
            'certifications' => 'Certifications',
            'skills' => 'Skills',
            'tin_number' => 'TIN Number',
            'sss_number' => 'SSS Number',
            'philhealth_number' => 'PhilHealth Number',
            'pagibig_number' => 'Pag-IBIG Number',
            'updated_at' => 'Last Updated',
        ];

        return $fieldMappings[$fieldName] ?? ucfirst(str_replace('_', ' ', $fieldName));
    }

    /**
     * Format display value using lookup data
     */
    private function formatDisplayValue(string $fieldName, $value, array $lookupData): string
    {
        if ($value === null || $value === '') {
            return '<em>Not specified</em>';
        }

        // Handle boolean values
        if (is_bool($value)) {
            return $value ? 'Yes' : 'No';
        }

        // Handle specific field formatting
        switch ($fieldName) {
            case 'is_active':
                return ($value === true || $value === 1 || $value === '1') ? 'Active' : 'Inactive';

            case 'gender':
                return $value === 'M' ? 'Male' : ($value === 'F' ? 'Female' : $value);

            case 'basic_salary':
            case 'allowances':
                return is_numeric($value) ?
                    '₱' . number_format((float)$value, 2) : $value;

            case 'hire_date':
            case 'birth_date':
            case 'probation_end_date':
            case 'regularization_date':
            case 'contract_start_date':
            case 'contract_end_date':
                return $value ? date('F j, Y', strtotime($value)) : 'Not specified';

            case 'updated_at':
                return $value ? date('F j, Y g:i:s A', strtotime($value)) : 'Not specified';

            case 'department_id':
                return $lookupData['departments'][$value] ?? "Department (ID: {$value})";

            case 'position_id':
                return $lookupData['positions'][$value] ?? "Position (ID: {$value})";

            case 'job_grade_id':
                return $lookupData['jobGrades'][$value] ?? "Job Grade (ID: {$value})";

            case 'employment_status_id':
                return $lookupData['employmentStatuses'][$value] ?? "Employment Status (ID: {$value})";

            case 'work_schedule_id':
                return $lookupData['workSchedules'][$value] ?? "Work Schedule (ID: {$value})";

            case 'branch_id':
                return $lookupData['branches'][$value] ?? "Branch (ID: {$value})";

            case 'cost_center_id':
                return $lookupData['costCenters'][$value] ?? "Cost Center (ID: {$value})";

            case 'company_id':
                return $lookupData['companies'][$value] ?? "Company (ID: {$value})";

            case 'supervisor_id':
            case 'immediate_supervisor_id':
                return $lookupData['employees'][$value] ?? "Supervisor (ID: {$value})";

            default:
                // Handle arrays and objects
                if (is_array($value)) {
                    return count($value) > 0 ? count($value) . ' items' : 'Empty';
                }

                if (is_object($value)) {
                    return 'Complex data';
                }

                return (string)$value;
        }
    }
}
