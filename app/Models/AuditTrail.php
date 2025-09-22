<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

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

    public function getFormattedChangesAttribute(): string
    {
        if (empty($this->changed_fields)) {
            return 'No specific changes recorded';
        }

        $changes = [];
        foreach ($this->changed_fields as $field => $values) {
            $oldValue = $values['old'] ?? 'N/A';
            $newValue = $values['new'] ?? 'N/A';
            $fieldName = str_replace('_', ' ', $field);
            $changes[] = ucfirst($fieldName).": '{$oldValue}' → '{$newValue}'";
        }

        return implode(', ', $changes);
    }

    public function getFormattedChangesHtmlAttribute(): string
    {
        if (empty($this->changed_fields)) {
            return '<span class="text-gray-500 text-sm">No specific changes recorded</span>';
        }

        $changes = [];
        foreach ($this->changed_fields as $field => $values) {
            $oldValue = $values['old'] ?? 'N/A';
            $newValue = $values['new'] ?? 'N/A';
            $fieldName = str_replace('_', ' ', $field);

            // Ensure values are strings for htmlspecialchars
            $oldValueStr = is_array($oldValue) ? json_encode($oldValue) : (string) $oldValue;
            $newValueStr = is_array($newValue) ? json_encode($newValue) : (string) $newValue;

            $changes[] = '<div class="mb-2 last:mb-0">'.
                '<span class="text-xs font-medium text-gray-600 uppercase tracking-wide">'.ucfirst($fieldName).'</span>'.
                '<div class="flex items-center space-x-2 mt-1">'.
                '<span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs border">'.htmlspecialchars($oldValueStr).'</span>'.
                '<i class="fas fa-arrow-right text-gray-400 text-xs"></i>'.
                '<span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs border">'.htmlspecialchars($newValueStr).'</span>'.
                '</div>'.
                '</div>';
        }

        return implode('', $changes);
    }

    public function getActionColorAttribute(): string
    {
        return match ($this->action) {
            'created' => 'green',
            'updated' => 'blue',
            'deleted' => 'red',
            default => 'gray',
        };
    }

    public function getActionIconAttribute(): string
    {
        return match ($this->action) {
            'created' => 'plus',
            'updated' => 'pencil',
            'deleted' => 'trash',
            default => 'info',
        };
    }
}
