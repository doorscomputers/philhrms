<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDepartmentRequest extends FormRequest
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
                'code' => 'required|string|max:10|unique:departments,code',
                'company_id' => 'nullable|exists:companies,id',
                'description' => 'nullable|string',
            ];
        }

        // Full form validation rules
        return [
            'company_id' => 'required|exists:companies,id',
            'branch_id' => 'nullable|exists:company_branches,id',
            'cost_center_id' => 'nullable|exists:cost_centers,id',
            'code' => 'required|string|max:10|unique:departments,code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:departments,id',
            'head_id' => 'nullable|exists:users,id',
            'level' => 'nullable|integer|min:1',
            'full_path' => 'nullable|string',
            'budget_amount' => 'nullable|numeric|min:0',
            'max_headcount' => 'nullable|integer|min:1',
            'current_headcount' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ];
    }
}
