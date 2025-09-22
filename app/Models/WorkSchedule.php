<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WorkSchedule extends Model
{
    /** @use HasFactory<\Database\Factories\WorkScheduleFactory> */
    use HasFactory;

    protected $fillable = [
        'company_id', 'name', 'code', 'description', 'type',
        'hours_per_day', 'hours_per_week', 'days_per_week',
        'break_duration_minutes', 'is_break_paid', 'short_break_duration_minutes',
        'short_breaks_per_day', 'allow_overtime', 'max_overtime_hours_daily',
        'max_overtime_hours_weekly', 'auto_approve_overtime',
        'late_grace_minutes', 'early_departure_grace_minutes',
        'schedule_details', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'schedule_details' => 'array',
            'hours_per_day' => 'decimal:2',
            'hours_per_week' => 'decimal:2',
            'max_overtime_hours_daily' => 'decimal:2',
            'max_overtime_hours_weekly' => 'decimal:2',
            'is_break_paid' => 'boolean',
            'allow_overtime' => 'boolean',
            'auto_approve_overtime' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }
}
