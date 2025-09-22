<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use Auditable, HasFactory, SoftDeletes;

    protected $fillable = [
        'uuid', 'company_id', 'user_id', 'employee_id', 'badge_number', 'biometric_id',
        'first_name', 'middle_name', 'last_name', 'suffix', 'maiden_name', 'nickname',
        'birth_date', 'birth_place', 'gender', 'civil_status', 'nationality', 'religion',
        'blood_type', 'height', 'weight', 'addresses', 'contact_numbers', 'email_addresses',
        'sss_number', 'tin', 'philhealth_number', 'pagibig_number', 'passport_number',
        'passport_expiry', 'drivers_license', 'license_expiry', 'voters_id',
        'department_id', 'position_id', 'job_grade_id', 'cost_center_id', 'branch_id',
        'immediate_supervisor_id', 'hire_date', 'original_hire_date', 'probation_end_date',
        'regularization_date', 'last_promotion_date', 'resignation_date', 'termination_date',
        'retirement_date', 'employment_status_id', 'employment_type', 'pay_frequency', 'is_exempt',
        'basic_salary', 'allowances', 'daily_rate', 'hourly_rate', 'work_schedule_id',
        'is_flexible_time', 'is_field_work', 'tax_status', 'is_minimum_wage', 'tax_shield',
        'vacation_leave_balance', 'sick_leave_balance', 'emergency_leave_balance',
        'emergency_contacts', 'medical_conditions', 'allergies', 'medications', 'photo',
        'documents', 'is_active', 'remarks', 'custom_fields',
    ];

    protected function casts(): array
    {
        return [
            'addresses' => 'array',
            'contact_numbers' => 'array',
            'email_addresses' => 'array',
            'allowances' => 'array',
            'emergency_contacts' => 'array',
            'documents' => 'array',
            'custom_fields' => 'array',
            'birth_date' => 'date',
            'passport_expiry' => 'date',
            'license_expiry' => 'date',
            'hire_date' => 'date',
            'original_hire_date' => 'date',
            'probation_end_date' => 'date',
            'regularization_date' => 'date',
            'last_promotion_date' => 'date',
            'resignation_date' => 'date',
            'termination_date' => 'date',
            'retirement_date' => 'date',
            'basic_salary' => 'decimal:2',
            'daily_rate' => 'decimal:2',
            'hourly_rate' => 'decimal:2',
            'tax_shield' => 'decimal:2',
            'vacation_leave_balance' => 'decimal:2',
            'sick_leave_balance' => 'decimal:2',
            'emergency_leave_balance' => 'decimal:2',
            'height' => 'decimal:2',
            'weight' => 'decimal:2',
            'is_exempt' => 'boolean',
            'is_flexible_time' => 'boolean',
            'is_field_work' => 'boolean',
            'is_minimum_wage' => 'boolean',
            'is_active' => 'boolean',
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

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    public function jobGrade(): BelongsTo
    {
        return $this->belongsTo(JobGrade::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(CompanyBranch::class, 'branch_id');
    }

    public function costCenter(): BelongsTo
    {
        return $this->belongsTo(CostCenter::class);
    }

    public function workSchedule(): BelongsTo
    {
        return $this->belongsTo(WorkSchedule::class);
    }

    public function employmentStatus(): BelongsTo
    {
        return $this->belongsTo(EmploymentStatus::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(EmployeeDocument::class);
    }

    public function supervisor(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'immediate_supervisor_id');
    }

    public function subordinates(): HasMany
    {
        return $this->hasMany(Employee::class, 'immediate_supervisor_id');
    }

    public function auditTrails(): HasMany
    {
        return $this->hasMany(AuditTrail::class, 'model_id')->where('model_type', Employee::class);
    }
}
