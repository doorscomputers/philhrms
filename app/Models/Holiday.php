<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Holiday extends Model
{
    protected $fillable = [
        'company_id',
        'name',
        'date',
        'type',
        'scope',
        'description',
        'pay_multiplier',
        'is_recurring',
        'applicable_branches',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'pay_multiplier' => 'decimal:2',
            'is_recurring' => 'boolean',
            'applicable_branches' => 'array',
        ];
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
