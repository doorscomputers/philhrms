<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => ['required', 'string', 'max:20', 'unique:companies,code'],
            'name' => ['required', 'string', 'max:255'],
            'legal_name' => ['required', 'string', 'max:255'],
            'business_type' => ['required', 'string', 'max:255'],
            'industry' => ['required', 'string', 'max:255'],
            'tin' => ['required', 'string', 'max:20', 'unique:companies,tin'],
            'sec_registration' => ['nullable', 'string', 'max:255'],
            'dti_registration' => ['nullable', 'string', 'max:255'],
            'bir_rdo_code' => ['required', 'string', 'max:10'],
            'sss_employer_number' => ['nullable', 'string', 'max:20'],
            'philhealth_employer_number' => ['nullable', 'string', 'max:20'],
            'pagibig_employer_number' => ['nullable', 'string', 'max:20'],
            'addresses' => ['required', 'array'],
            'addresses.*.type' => ['required', 'string'],
            'addresses.*.address' => ['required', 'string'],
            'addresses.*.city' => ['required', 'string'],
            'addresses.*.province' => ['required', 'string'],
            'addresses.*.region' => ['required', 'string'],
            'addresses.*.postal_code' => ['required', 'string', 'max:10'],
            'contact_numbers' => ['required', 'array'],
            'contact_numbers.*' => ['string'],
            'email_addresses' => ['required', 'array'],
            'email_addresses.*' => ['email'],
            'website' => ['nullable', 'url'],
            'date_established' => ['required', 'date'],
            'authorized_capital' => ['nullable', 'numeric', 'min:0'],
            'paid_up_capital' => ['nullable', 'numeric', 'min:0'],
            'total_employees' => ['integer', 'min:0'],
            'settings' => ['nullable', 'array'],
            'status' => ['required', 'in:Active,Inactive,Suspended'],
            'subscription_plan' => ['required', 'in:Basic,Standard,Premium,Enterprise'],
            'subscription_expires_at' => ['nullable', 'date'],
            'fiscal_year_start_month' => ['required', 'integer', 'between:1,12'],
            'fiscal_year_end_month' => ['required', 'integer', 'between:1,12'],
        ];
    }

    public function messages(): array
    {
        return [
            'code.unique' => 'This company code is already taken.',
            'tin.unique' => 'This TIN is already registered.',
            'addresses.required' => 'At least one address is required.',
            'contact_numbers.required' => 'At least one contact number is required.',
            'email_addresses.required' => 'At least one email address is required.',
        ];
    }
}
