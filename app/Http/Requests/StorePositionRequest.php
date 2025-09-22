<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePositionRequest extends FormRequest
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
        // Check if this is a Quick Add request (AJAX with just name and code)
        $isQuickAdd = $this->ajax() && $this->has('name') && $this->has('code');

        if ($isQuickAdd) {
            return [
                'name' => 'required|string|max:255',
                'code' => 'required|string|max:10|unique:positions,code',
                'company_id' => 'nullable|exists:companies,id',
                'department_id' => 'nullable|exists:departments,id',
                'job_grade_id' => 'nullable|exists:job_grades,id',
                'type' => 'nullable|in:Regular,Contractual,Consultant,Intern',
                'level' => 'nullable|in:Executive,Managerial,Supervisory,Rank and File',
                'authorized_headcount' => 'nullable|integer|min:1',
            ];
        }

        // Full form validation rules
        return [
            'company_id' => 'nullable|exists:companies,id',
            'department_id' => 'required|exists:departments,id',
            'job_grade_id' => 'required|exists:job_grades,id',
            'code' => 'required|string|max:10|unique:positions,code',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'responsibilities' => 'nullable|string',
            'qualifications' => 'nullable|string',
            'reports_to_id' => 'nullable|exists:positions,id',
            'type' => 'required|in:Regular,Contractual,Consultant,Intern',
            'level' => 'required|in:Executive,Managerial,Supervisory,Rank and File',
            'is_exempt' => 'boolean',
            'is_confidential' => 'boolean',
            'authorized_headcount' => 'required|integer|min:1',
            'current_headcount' => 'nullable|integer|min:0',
            'vacant_positions' => 'nullable|integer|min:0',
            'min_salary' => 'nullable|numeric|min:0',
            'max_salary' => 'nullable|numeric|min:0|gte:min_salary',
            'is_active' => 'boolean',
        ];
    }
}
