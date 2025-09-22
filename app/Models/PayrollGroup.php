<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PayrollGroup extends Model
{
    protected $fillable = [
        'company_id',
        'name',
        'code',
        'description',
        'pay_frequency',
        'pay_dates',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'pay_dates' => 'array',
            'is_active' => 'boolean',
        ];
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
