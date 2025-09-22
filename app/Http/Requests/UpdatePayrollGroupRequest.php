<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePayrollGroupRequest extends FormRequest
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
        $payrollGroupId = $this->route('payroll_group') ? $this->route('payroll_group')->id : null;

        return [
            'company_id' => 'required|exists:companies,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:20|unique:payroll_groups,code,'.$payrollGroupId,
            'description' => 'nullable|string',
            'pay_frequency' => 'required|in:Monthly,Bi-monthly,Weekly,Daily',
            'pay_dates' => 'required|array',
            'pay_dates.*' => 'integer|min:1|max:31',
            'is_active' => 'boolean',
        ];
    }
}
