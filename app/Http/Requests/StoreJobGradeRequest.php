<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreJobGradeRequest extends FormRequest
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
            'code' => 'required|string|max:10|unique:job_grades,code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'level' => 'required|integer|min:1|max:99',
            'min_salary' => 'required|numeric|min:0',
            'mid_salary' => 'nullable|numeric|min:0|gte:min_salary',
            'max_salary' => 'required|numeric|min:0|gte:min_salary',
            'is_active' => 'boolean',
        ];
    }
}
