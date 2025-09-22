<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $employeeId = $this->route('employee')->id;

        return [
            // Company and Employee ID
            'company_id' => ['required', 'exists:companies,id'],
            'employee_id' => ['required', 'string', 'max:20'],
            'badge_number' => ['nullable', 'string', 'max:20'],
            'biometric_id' => ['nullable', 'string', 'max:20'],

            // Personal Information
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'suffix' => ['nullable', 'string', 'max:10'],
            'maiden_name' => ['nullable', 'string', 'max:255'],
            'nickname' => ['nullable', 'string', 'max:50'],
            'birth_date' => ['required', 'date', 'before:today'],
            'birth_place' => ['nullable', 'string', 'max:255'],
            'gender' => ['required', 'in:Male,Female'],
            'civil_status' => ['required', 'in:Single,Married,Divorced,Widowed,Separated,Annulled'],
            'nationality' => ['nullable', 'string', 'max:50'],
            'religion' => ['nullable', 'string', 'max:50'],
            'blood_type' => ['nullable', 'in:A+,A-,B+,B-,AB+,AB-,O+,O-'],
            'height' => ['nullable', 'numeric', 'min:0', 'max:999.99'],
            'weight' => ['nullable', 'numeric', 'min:0', 'max:999.99'],

            // Contact Information - now accepts arrays from form inputs
            'addresses' => ['nullable', 'array'],
            'addresses.*.type' => ['nullable', 'string', 'max:50'],
            'addresses.*.address' => ['nullable', 'string', 'max:500'],
            'addresses.*.city' => ['nullable', 'string', 'max:100'],
            'addresses.*.province' => ['nullable', 'string', 'max:100'],
            'addresses.*.postal_code' => ['nullable', 'string', 'max:20'],
            'contact_numbers' => ['nullable', 'array'],
            'contact_numbers.*' => ['nullable', 'string', 'max:50'],
            'email_addresses' => ['nullable', 'array'],
            'email_addresses.*' => ['nullable', 'email', 'max:255'],

            // Government IDs (with ignore for current record)
            'sss_number' => ['nullable', 'string', 'max:20', Rule::unique('employees', 'sss_number')->ignore($employeeId)],
            'tin' => ['nullable', 'string', 'max:20', Rule::unique('employees', 'tin')->ignore($employeeId)],
            'philhealth_number' => ['nullable', 'string', 'max:20', Rule::unique('employees', 'philhealth_number')->ignore($employeeId)],
            'pagibig_number' => ['nullable', 'string', 'max:20', Rule::unique('employees', 'pagibig_number')->ignore($employeeId)],
            'passport_number' => ['nullable', 'string', 'max:20'],
            'passport_expiry' => ['nullable', 'date', 'after:today'],
            'drivers_license' => ['nullable', 'string', 'max:20'],
            'license_expiry' => ['nullable', 'date', 'after:today'],
            'voters_id' => ['nullable', 'string', 'max:20'],
            'photo' => ['nullable', 'file', 'mimes:jpg,jpeg,png,gif', 'max:2048'],
            'documents' => ['nullable', 'string'],

            // Employment Information
            'department_id' => ['required', 'exists:departments,id'],
            'position_id' => ['required', 'exists:positions,id'],
            'job_grade_id' => ['required', 'exists:job_grades,id'],
            'cost_center_id' => ['nullable', 'exists:cost_centers,id'],
            'branch_id' => ['required', 'exists:company_branches,id'],
            'immediate_supervisor_id' => ['nullable', 'exists:employees,id'],

            // Employment Dates
            'hire_date' => ['required', 'date'],
            'original_hire_date' => ['nullable', 'date'],
            'probation_end_date' => ['nullable', 'date', 'after:hire_date'],
            'regularization_date' => ['nullable', 'date', 'after:hire_date'],
            'last_promotion_date' => ['nullable', 'date', 'after:hire_date'],
            'resignation_date' => ['nullable', 'date', 'after:hire_date'],
            'termination_date' => ['nullable', 'date', 'after:hire_date'],
            'retirement_date' => ['nullable', 'date', 'after:hire_date'],

            // Employment Status
            'employment_status' => ['required', 'in:Probationary,Regular,Contractual,Project-Based,Consultant,Intern,Resigned,Terminated,Retired,AWOL'],
            'employment_type' => ['nullable', 'in:Full-time,Part-time,Casual'],
            'pay_frequency' => ['nullable', 'in:Monthly,Bi-monthly,Weekly,Daily'],
            'is_exempt' => ['boolean'],

            // Compensation
            'basic_salary' => ['required', 'numeric', 'min:0'],
            'allowances' => ['nullable', 'string'],
            'daily_rate' => ['nullable', 'numeric', 'min:0'],
            'hourly_rate' => ['nullable', 'numeric', 'min:0'],

            // Work Schedule
            'work_schedule_id' => ['nullable', 'exists:work_schedules,id'],
            'is_flexible_time' => ['boolean'],
            'is_field_work' => ['boolean'],

            // Tax Information
            'tax_status' => ['nullable', 'in:S,ME,S1,ME1,S2,ME2,S3,ME3,S4,ME4'],
            'is_minimum_wage' => ['boolean'],
            'tax_shield' => ['nullable', 'numeric', 'min:0'],

            // Leave Credits
            'vacation_leave_balance' => ['nullable', 'numeric', 'min:0', 'max:999.99'],
            'sick_leave_balance' => ['nullable', 'numeric', 'min:0', 'max:999.99'],
            'emergency_leave_balance' => ['nullable', 'numeric', 'min:0', 'max:999.99'],

            // Emergency Contacts - now accepts arrays from form inputs
            'emergency_contacts' => ['nullable', 'array'],
            'emergency_contacts.*.name' => ['nullable', 'string', 'max:255'],
            'emergency_contacts.*.relationship' => ['nullable', 'string', 'max:100'],
            'emergency_contacts.*.phone' => ['nullable', 'string', 'max:50'],

            // Allowances - now accepts arrays from form inputs
            'allowances' => ['nullable', 'array'],
            'allowances.*.type' => ['nullable', 'string', 'max:100'],
            'allowances.*.amount' => ['nullable', 'numeric', 'min:0'],

            // Documents - now accepts arrays from form inputs
            'documents' => ['nullable', 'array'],
            'documents.*.type' => ['nullable', 'string', 'max:100'],
            'documents.*.filename' => ['nullable', 'string', 'max:255'],

            // Custom Fields - now accepts key-value arrays from form inputs
            'custom_fields_keys' => ['nullable', 'array'],
            'custom_fields_keys.*' => ['nullable', 'string', 'max:100'],
            'custom_fields_values' => ['nullable', 'array'],
            'custom_fields_values.*' => ['nullable', 'string'],

            // Medical Information
            'medical_conditions' => ['nullable', 'string'],
            'allergies' => ['nullable', 'string'],
            'medications' => ['nullable', 'string'],

            // System Fields
            'is_active' => ['boolean'],
            'remarks' => ['nullable', 'string'],
            'custom_fields' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'employee_id.unique' => 'This employee ID is already taken within the company.',
            'sss_number.unique' => 'This SSS number is already registered.',
            'tin.unique' => 'This TIN is already registered.',
            'philhealth_number.unique' => 'This PhilHealth number is already registered.',
            'pagibig_number.unique' => 'This Pag-IBIG number is already registered.',
            'birth_date.before' => 'Birth date must be before today.',
            'addresses.required' => 'At least one address is required.',
            'contact_numbers.required' => 'At least one contact number is required.',
            'email_addresses.required' => 'At least one email address is required.',
            'emergency_contacts.required' => 'At least one emergency contact is required.',
        ];
    }
}
