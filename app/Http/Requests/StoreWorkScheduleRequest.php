<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWorkScheduleRequest extends FormRequest
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
                'code' => 'nullable|string|max:10|unique:work_schedules,code',
                'company_id' => 'nullable|exists:companies,id',
                'type' => 'nullable|in:Fixed,Flexible,Shift,Compressed',
                'hours_per_day' => 'nullable|numeric|min:1|max:24',
            ];
        }

        // Full form validation rules
        return [
            'company_id' => 'nullable|exists:companies,id',
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:10|unique:work_schedules,code',
            'type' => 'required|in:Fixed,Flexible,Shift,Compressed',
            'hours_per_day' => 'required|numeric|min:1|max:24',
            'days_per_week' => 'nullable|integer|min:1|max:7',
            'break_duration_minutes' => 'nullable|integer|min:0|max:480',
            'schedule_details' => 'nullable|array',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ];
    }
}
