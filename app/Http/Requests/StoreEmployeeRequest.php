<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Company and Employee ID
            'company_id' => ['nullable', 'exists:companies,id'],
            'employee_id' => ['nullable', 'string', 'max:20'],
            'badge_number' => ['nullable', 'string', 'max:20'],
            'biometric_id' => ['nullable', 'string', 'max:20'],

            // Personal Information
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'suffix' => ['nullable', 'string', 'max:10'],
            'maiden_name' => ['nullable', 'string', 'max:255'],
            'nickname' => ['nullable', 'string', 'max:50'],
            'birth_date' => ['nullable', 'date'],
            'birth_place' => ['nullable', 'string', 'max:255'],
            'gender' => ['nullable', 'in:Male,Female,Other'],
            'civil_status' => ['nullable', 'in:Single,Married,Divorced,Widowed'],
            'nationality' => ['nullable', 'string', 'max:50'],
            'religion' => ['nullable', 'string', 'max:50'],
            'blood_type' => ['nullable', 'in:A+,A-,B+,B-,AB+,AB-,O+,O-'],
            'height' => ['nullable', 'numeric', 'min:0', 'max:999.99'],
            'weight' => ['nullable', 'numeric', 'min:0', 'max:999.99'],

            // Contact Information - accepts JSON strings from textarea
            'addresses' => ['nullable', 'string'],
            'contact_numbers' => ['nullable', 'string'],
            'email_addresses' => ['nullable', 'string'],

            // Government IDs
            'sss_number' => ['nullable', 'string', 'max:20'],
            'tin' => ['nullable', 'string', 'max:20'],
            'philhealth_number' => ['nullable', 'string', 'max:20'],
            'pagibig_number' => ['nullable', 'string', 'max:20'],
            'passport_number' => ['nullable', 'string', 'max:20'],
            'passport_expiry' => ['nullable', 'date', 'after:today'],
            'drivers_license' => ['nullable', 'string', 'max:20'],
            'license_expiry' => ['nullable', 'date', 'after:today'],
            'voters_id' => ['nullable', 'string', 'max:20'],

            // Employment Information
            'department_id' => ['nullable', 'exists:departments,id'],
            'position_id' => ['nullable', 'exists:positions,id'],
            'job_grade_id' => ['nullable', 'exists:job_grades,id'],
            'cost_center_id' => ['nullable', 'exists:cost_centers,id'],
            'branch_id' => ['nullable', 'exists:company_branches,id'],
            'immediate_supervisor_id' => ['nullable', 'exists:employees,id'],

            // Employment Dates
            'hire_date' => ['nullable', 'date'],
            'original_hire_date' => ['nullable', 'date'],
            'probation_end_date' => ['nullable', 'date'],
            'regularization_date' => ['nullable', 'date'],
            'last_promotion_date' => ['nullable', 'date'],
            'resignation_date' => ['nullable', 'date'],
            'termination_date' => ['nullable', 'date'],
            'retirement_date' => ['nullable', 'date'],

            // Employment Status - adjusted to match database enum
            'employment_status' => ['nullable', 'string', 'max:100'],
            'employment_type' => ['nullable', 'in:Full-time,Part-time,Contract,Temporary,Intern'],
            'pay_frequency' => ['nullable', 'in:Daily,Weekly,Bi-weekly,Semi-monthly,Monthly'],
            'is_exempt' => ['boolean'],

            // Compensation
            'basic_salary' => ['nullable', 'numeric', 'min:0'],
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

            // Emergency Contact - accepts JSON string from textarea
            'emergency_contacts' => ['nullable', 'string'],

            // Medical Information
            'medical_conditions' => ['nullable', 'string'],
            'allergies' => ['nullable', 'string'],
            'medications' => ['nullable', 'string'],

            // Leave Balances
            'vacation_leave_balance' => ['nullable', 'numeric', 'min:0'],
            'sick_leave_balance' => ['nullable', 'numeric', 'min:0'],
            'emergency_leave_balance' => ['nullable', 'numeric', 'min:0'],

            // Files
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:5120'],
            'documents' => ['nullable', 'array'],
            'documents.*' => ['nullable', 'file', 'max:10240'],

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
