<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Position extends Model
{
    /** @use HasFactory<\Database\Factories\PositionFactory> */
    use Auditable, HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'department_id',
        'job_grade_id',
        'code',
        'title',
        'description',
        'responsibilities',
        'qualifications',
        'reports_to_id',
        'type',
        'level',
        'is_exempt',
        'is_confidential',
        'authorized_headcount',
        'current_headcount',
        'vacant_positions',
        'min_salary',
        'max_salary',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_exempt' => 'boolean',
            'is_confidential' => 'boolean',
            'is_active' => 'boolean',
            'min_salary' => 'decimal:2',
            'max_salary' => 'decimal:2',
        ];
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function jobGrade(): BelongsTo
    {
        return $this->belongsTo(JobGrade::class);
    }

    public function reportsTo(): BelongsTo
    {
        return $this->belongsTo(Position::class, 'reports_to_id');
    }

    public function subordinates(): HasMany
    {
        return $this->hasMany(Position::class, 'reports_to_id');
    }

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }
}
