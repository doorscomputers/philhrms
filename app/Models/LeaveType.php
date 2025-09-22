<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeaveType extends Model
{
    protected $fillable = [
        'company_id',
        'name',
        'code',
        'description',
        'category',
        'is_paid',
        'requires_medical_certificate',
        'can_be_carried_over',
        'can_be_converted_to_cash',
        'annual_entitlement',
        'max_carry_over',
        'min_days_advance_filing',
        'max_consecutive_days',
        'accrual_method',
        'accrual_rate',
        'accrual_start_month',
        'prorated_accrual',
        'minimum_service_months',
        'max_carryover_days',
        'carryover_policy',
        'carryover_deadline',
        'carryover_grace_months',
        'forfeit_excess',
        'has_expiry',
        'expiry_months',
        'expiry_basis',
        'warn_before_expiry',
        'warning_days',
        'allow_cash_conversion',
        'conversion_rate',
        'min_days_for_conversion',
        'max_days_for_conversion',
        'conversion_timing',
        'leave_year_basis',
        'leave_year_start_month',
        'gender_restriction',
        'allowed_employment_status',
        'requires_approval',
        'approval_levels',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_paid' => 'boolean',
            'requires_medical_certificate' => 'boolean',
            'can_be_carried_over' => 'boolean',
            'can_be_converted_to_cash' => 'boolean',
            'annual_entitlement' => 'decimal:2',
            'max_carry_over' => 'decimal:2',
            'accrual_rate' => 'decimal:3',
            'prorated_accrual' => 'boolean',
            'max_carryover_days' => 'decimal:2',
            'carryover_deadline' => 'date',
            'forfeit_excess' => 'boolean',
            'has_expiry' => 'boolean',
            'warn_before_expiry' => 'boolean',
            'allow_cash_conversion' => 'boolean',
            'conversion_rate' => 'decimal:3',
            'min_days_for_conversion' => 'decimal:2',
            'max_days_for_conversion' => 'decimal:2',
            'is_active' => 'boolean',
            'allowed_employment_status' => 'array',
        ];
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
