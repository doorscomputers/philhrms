<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobGrade extends Model
{
    /** @use HasFactory<\Database\Factories\JobGradeFactory> */
    use Auditable, HasFactory;

    protected $fillable = [
        'company_id',
        'code',
        'name',
        'description',
        'level',
        'min_salary',
        'mid_salary',
        'max_salary',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'min_salary' => 'decimal:2',
            'mid_salary' => 'decimal:2',
            'max_salary' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function positions(): HasMany
    {
        return $this->hasMany(Position::class);
    }

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }
}
