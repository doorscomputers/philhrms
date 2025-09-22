<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWorkScheduleRequest extends FormRequest
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
        $workScheduleId = $this->route('work_schedule')->id;

        return [
            'company_id' => 'nullable|exists:companies,id',
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:10|unique:work_schedules,code,'.$workScheduleId,
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
