<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditTrail extends Model
{
    protected $fillable = [
        'user_id',
        'user_name',
        'model_type',
        'model_id',
        'action',
        'old_values',
        'new_values',
        'changed_fields',
        'ip_address',
        'user_agent',
        'description',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
        'changed_fields' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function auditable(): MorphTo
    {
        return $this->morphTo('model');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getChangedFieldsAttribute(): array
    {
        if (empty($this->old_values) || empty($this->new_values)) {
            return [];
        }

        $changes = [];
        $oldValues = $this->old_values;
        $newValues = $this->new_values;

        foreach ($newValues as $field => $newValue) {
            $oldValue = $oldValues[$field] ?? null;
            if ($oldValue !== $newValue) {
                $changes[$field] = [
                    'old' => $oldValue,
                    'new' => $newValue
                ];
            }
        }

        return $changes;
    }

    public function getFormattedChangesAttribute(): string
    {
        $changes = $this->changed_fields;
        if (empty($changes)) {
            return 'No specific changes recorded';
        }

        $formatted = [];
        foreach ($changes as $field => $values) {
            $oldValue = $values['old'] ?? 'N/A';
            $newValue = $values['new'] ?? 'N/A';

            // Handle array values by converting them to JSON or readable format
            if (is_array($oldValue)) {
                $oldValue = json_encode($oldValue);
            }
            if (is_array($newValue)) {
                $newValue = json_encode($newValue);
            }

            $fieldName = str_replace('_', ' ', $field);
            $formatted[] = ucfirst($fieldName).": '{$oldValue}' → '{$newValue}'";
        }

        return implode(', ', $formatted);
    }

    public function getEventColorAttribute(): string
    {
        return match ($this->event) {
            'created' => 'green',
            'updated' => 'blue',
            'deleted' => 'red',
            default => 'gray',
        };
    }

    public function getEventIconAttribute(): string
    {
        return match ($this->event) {
            'created' => 'plus',
            'updated' => 'pencil',
            'deleted' => 'trash',
            default => 'info',
        };
    }
}
