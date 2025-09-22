<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyBranchRequest extends FormRequest
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
        $branchId = $this->route('company_branch')->id;

        return [
            'company_id' => 'required|exists:companies,id',
            'code' => 'required|string|max:10|unique:company_branches,code,'.$branchId,
            'name' => 'required|string|max:255',
            'type' => 'required|in:Head Office,Branch,Warehouse,Plant,Sales Office',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'region' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'country' => 'required|string|max:3',
            'contact_numbers' => 'nullable|string',
            'email_addresses' => 'nullable|string',
            'bir_rdo_code' => 'nullable|string|max:20',
            'business_permit' => 'nullable|string|max:50',
            'permit_expiry' => 'nullable|date|after:today',
            'operation_start_time' => 'nullable|date_format:H:i',
            'operation_end_time' => 'nullable|date_format:H:i|after:operation_start_time',
            'operation_days' => 'nullable|string',
            'timezone' => 'nullable|string|max:50',
            'is_active' => 'boolean',
        ];
    }
}
