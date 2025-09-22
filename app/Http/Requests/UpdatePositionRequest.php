<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePositionRequest extends FormRequest
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
        $positionId = $this->route('position')->id;

        return [
            'company_id' => 'required|exists:companies,id',
            'department_id' => 'required|exists:departments,id',
            'job_grade_id' => 'required|exists:job_grades,id',
            'code' => 'required|string|max:10|unique:positions,code,'.$positionId,
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
