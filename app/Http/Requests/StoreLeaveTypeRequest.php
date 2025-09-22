<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLeaveTypeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'company_id' => 'required|exists:companies,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:20|unique:leave_types,code',
            'description' => 'nullable|string',
            'category' => 'required|in:Vacation,Sick,Emergency,Maternity,Paternity,Special,Others',
            'is_paid' => 'boolean',
            'requires_medical_certificate' => 'boolean',
            'can_be_carried_over' => 'boolean',
            'can_be_converted_to_cash' => 'boolean',
            'annual_entitlement' => 'required|numeric|min:0|max:999.99',
            'max_carry_over' => 'nullable|numeric|min:0|max:999.99',
            'min_days_advance_filing' => 'required|integer|min:0',
            'max_consecutive_days' => 'nullable|integer|min:1',
            'accrual_method' => 'required|in:Annual,Monthly,Bi-monthly,Per Pay Period,Service-based',
            'accrual_rate' => 'required|numeric|min:0|max:99.999',
            'accrual_start_month' => 'required|integer|min:1|max:12',
            'prorated_accrual' => 'boolean',
            'minimum_service_months' => 'required|integer|min:0',
            'max_carryover_days' => 'nullable|numeric|min:0|max:999.99',
            'carryover_policy' => 'required|in:None,Unlimited,Limited,Use or Lose',
            'carryover_deadline' => 'nullable|date',
            'carryover_grace_months' => 'required|integer|min:0|max:12',
            'forfeit_excess' => 'boolean',
            'has_expiry' => 'boolean',
            'expiry_months' => 'nullable|integer|min:1',
            'expiry_basis' => 'required|in:Grant Date,Calendar Year,Anniversary',
            'warn_before_expiry' => 'boolean',
            'warning_days' => 'required|integer|min:1|max:365',
            'allow_cash_conversion' => 'boolean',
            'conversion_rate' => 'required|numeric|min:0|max:9.999',
            'min_days_for_conversion' => 'nullable|numeric|min:0|max:999.99',
            'max_days_for_conversion' => 'nullable|numeric|min:0|max:999.99',
            'conversion_timing' => 'required|in:Year End,On Separation,Anytime,Scheduled',
            'leave_year_basis' => 'required|in:Calendar,Company Fiscal,Employee Anniversary',
            'leave_year_start_month' => 'required|integer|min:1|max:12',
            'gender_restriction' => 'required|in:None,Male,Female',
            'allowed_employment_status' => 'nullable|array',
            'allowed_employment_status.*' => 'string',
            'requires_approval' => 'boolean',
            'approval_levels' => 'required|integer|min:1|max:5',
            'is_active' => 'boolean',
        ];
    }
}
