<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    /** @use HasFactory<\Database\Factories\CompanyFactory> */
    use HasFactory, SoftDeletes;

    protected function casts(): array
    {
        return [
            'addresses' => 'array',
            'contact_numbers' => 'array',
            'email_addresses' => 'array',
            'settings' => 'array',
            'date_established' => 'date',
            'subscription_expires_at' => 'datetime',
            'authorized_capital' => 'decimal:2',
            'paid_up_capital' => 'decimal:2',
        ];
    }

    protected $fillable = [
        'uuid',
        'code',
        'name',
        'legal_name',
        'business_type',
        'industry',
        'tin',
        'sec_registration',
        'dti_registration',
        'bir_rdo_code',
        'sss_employer_number',
        'philhealth_employer_number',
        'pagibig_employer_number',
        'addresses',
        'contact_numbers',
        'email_addresses',
        'website',
        'date_established',
        'authorized_capital',
        'paid_up_capital',
        'total_employees',
        'settings',
        'status',
        'subscription_plan',
        'subscription_expires_at',
        'fiscal_year_start_month',
        'fiscal_year_end_month',
    ];

    public function branches(): HasMany
    {
        return $this->hasMany(CompanyBranch::class);
    }

    public function departments(): HasMany
    {
        return $this->hasMany(Department::class);
    }

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }

    public function costCenters(): HasMany
    {
        return $this->hasMany(CostCenter::class);
    }

    public function jobGrades(): HasMany
    {
        return $this->hasMany(JobGrade::class);
    }

    public function workSchedules(): HasMany
    {
        return $this->hasMany(WorkSchedule::class);
    }

    public function positions(): HasMany
    {
        return $this->hasMany(Position::class);
    }
}
