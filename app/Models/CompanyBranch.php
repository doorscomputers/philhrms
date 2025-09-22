<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyBranch extends Model
{
    /** @use HasFactory<\Database\Factories\CompanyBranchFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id', 'code', 'name', 'type', 'address', 'city', 'province',
        'region', 'postal_code', 'country', 'contact_numbers', 'email_addresses',
        'bir_rdo_code', 'business_permit', 'permit_expiry', 'operation_start_time',
        'operation_end_time', 'operation_days', 'timezone', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'contact_numbers' => 'array',
            'email_addresses' => 'array',
            'operation_days' => 'array',
            'permit_expiry' => 'date',
            'operation_start_time' => 'datetime:H:i',
            'operation_end_time' => 'datetime:H:i',
            'is_active' => 'boolean',
        ];
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function departments(): HasMany
    {
        return $this->hasMany(Department::class, 'branch_id');
    }

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class, 'branch_id');
    }
}
