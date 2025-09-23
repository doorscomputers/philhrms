<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class CompanyEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'event_type', 'priority', 'event_date',
        'start_time', 'end_time', 'location', 'color', 'is_recurring',
        'recurrence_type', 'recurrence_interval', 'recurrence_end_date',
        'is_all_day', 'requires_rsvp', 'max_attendees', 'target_departments',
        'target_positions', 'target_employees', 'is_company_wide',
        'created_by', 'notes', 'meeting_link', 'attachments',
        'send_reminders', 'reminder_days_before', 'is_active',
        'related_employee_id'
    ];

    protected function casts(): array
    {
        return [
            'event_date' => 'date',
            'start_time' => 'datetime:H:i',
            'end_time' => 'datetime:H:i',
            'recurrence_end_date' => 'date',
            'is_recurring' => 'boolean',
            'is_all_day' => 'boolean',
            'requires_rsvp' => 'boolean',
            'is_company_wide' => 'boolean',
            'send_reminders' => 'boolean',
            'is_active' => 'boolean',
            'target_departments' => 'array',
            'target_positions' => 'array',
            'target_employees' => 'array',
            'attachments' => 'array',
        ];
    }

    // Relationships
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function relatedEmployee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'related_employee_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('event_date', '>=', today());
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('event_date', now()->month)
                    ->whereYear('event_date', now()->year);
    }

    public function scopeByType($query, string $type)
    {
        return $query->where('event_type', $type);
    }

    public function scopeByPriority($query, string $priority)
    {
        return $query->where('priority', $priority);
    }

    public function scopeForDepartment($query, int $departmentId)
    {
        return $query->where(function ($q) use ($departmentId) {
            $q->where('is_company_wide', true)
              ->orWhereJsonContains('target_departments', $departmentId);
        });
    }

    // Accessors & Mutators
    public function getFormattedDateAttribute(): string
    {
        return $this->event_date->format('M j, Y');
    }

    public function getFormattedTimeAttribute(): ?string
    {
        if ($this->is_all_day) {
            return 'All Day';
        }

        if ($this->start_time && $this->end_time) {
            return $this->start_time->format('g:i A') . ' - ' . $this->end_time->format('g:i A');
        }

        if ($this->start_time) {
            return $this->start_time->format('g:i A');
        }

        return null;
    }

    public function getPriorityColorAttribute(): string
    {
        return match ($this->priority) {
            'low' => 'bg-green-100 text-green-800',
            'medium' => 'bg-blue-100 text-blue-800',
            'high' => 'bg-orange-100 text-orange-800',
            'critical' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function getTypeIconAttribute(): string
    {
        return match ($this->event_type) {
            'company_meeting' => 'fas fa-users',
            'training' => 'fas fa-graduation-cap',
            'holiday' => 'fas fa-calendar-day',
            'birthday' => 'fas fa-birthday-cake',
            'work_anniversary' => 'fas fa-award',
            'team_building' => 'fas fa-handshake',
            'performance_review' => 'fas fa-chart-line',
            'compliance_training' => 'fas fa-shield-alt',
            'benefits_enrollment' => 'fas fa-file-medical',
            'social_event' => 'fas fa-glass-cheers',
            'conference' => 'fas fa-microphone',
            'deadline' => 'fas fa-clock',
            default => 'fas fa-calendar',
        };
    }

    public function getTypeNameAttribute(): string
    {
        return match ($this->event_type) {
            'company_meeting' => 'Company Meeting',
            'training' => 'Training',
            'holiday' => 'Holiday',
            'birthday' => 'Birthday',
            'work_anniversary' => 'Work Anniversary',
            'team_building' => 'Team Building',
            'performance_review' => 'Performance Review',
            'compliance_training' => 'Compliance Training',
            'benefits_enrollment' => 'Benefits Enrollment',
            'social_event' => 'Social Event',
            'conference' => 'Conference',
            'deadline' => 'Deadline',
            default => 'Other Event',
        };
    }

    public function getDaysUntilAttribute(): int
    {
        return today()->diffInDays($this->event_date, false);
    }

    public function getIsUpcomingAttribute(): bool
    {
        return $this->event_date >= today();
    }

    // Static methods
    public static function getEventTypes(): array
    {
        return [
            'company_meeting' => 'Company Meeting',
            'training' => 'Training',
            'holiday' => 'Holiday',
            'birthday' => 'Birthday',
            'work_anniversary' => 'Work Anniversary',
            'team_building' => 'Team Building',
            'performance_review' => 'Performance Review',
            'compliance_training' => 'Compliance Training',
            'benefits_enrollment' => 'Benefits Enrollment',
            'social_event' => 'Social Event',
            'conference' => 'Conference',
            'deadline' => 'Deadline',
            'other' => 'Other Event',
        ];
    }

    public static function getPriorityLevels(): array
    {
        return [
            'low' => 'Low Priority',
            'medium' => 'Medium Priority',
            'high' => 'High Priority',
            'critical' => 'Critical',
        ];
    }
}
