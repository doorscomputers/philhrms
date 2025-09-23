<?php

namespace App\Traits;

use App\Models\AuditTrail;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

trait Auditable
{
    protected static function bootAuditable(): void
    {
        // Check if audit trail is globally enabled
        if (!config('audit.enabled', true)) {
            return;
        }

        // Check if this model is excluded
        $excludedModels = config('audit.exclude_models', []);
        if (in_array(static::class, $excludedModels)) {
            return;
        }

        static::created(function ($model) {
            $model->auditEvent('created');
        });

        static::updated(function ($model) {
            if ($model->wasChanged() && !$model->isAuditExcluded()) {
                $model->auditEvent('updated');
            }
        });

        static::deleted(function ($model) {
            $model->auditEvent('deleted');
        });
    }

    public function auditTrails(): MorphMany
    {
        return $this->morphMany(AuditTrail::class, 'model');
    }

    protected function auditEvent(string $event): void
    {
        $changes = [];
        $oldValues = [];
        $newValues = [];

        if ($event === 'created') {
            $newValues = $this->getAuditableAttributes();
        } elseif ($event === 'updated') {
            foreach ($this->getDirty() as $key => $newValue) {
                $oldValue = $this->getOriginal($key);
                if ($oldValue != $newValue) {
                    $changes[$key] = [
                        'old' => $oldValue,
                        'new' => $newValue,
                    ];
                    $oldValues[$key] = $oldValue;
                    $newValues[$key] = $newValue;
                }
            }
        } elseif ($event === 'deleted') {
            $oldValues = $this->getAuditableAttributes();
        }

        if ($event !== 'updated' || !empty($changes)) {
            $user = auth()->user();

            AuditTrail::create([
                'user_id' => $user?->id,
                'user_name' => $user?->name ?? 'System',
                'model_type' => get_class($this),
                'model_id' => $this->getKey(),
                'action' => $event,
                'old_values' => $oldValues,
                'new_values' => $newValues,
                'changed_fields' => $changes,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'description' => $this->generateAuditDescription($event, $changes),
            ]);
        }
    }

    protected function generateAuditDescription(string $action, array $changedFields = []): string
    {
        $modelName = class_basename($this);
        $identifier = $this->getAuditIdentifier();

        switch ($action) {
            case 'created':
                return "Created new {$modelName}: {$identifier}";
            case 'updated':
                $fields = array_keys($changedFields);
                $fieldList = implode(', ', $fields);
                return "Updated {$modelName} {$identifier}. Changed fields: {$fieldList}";
            case 'deleted':
                return "Deleted {$modelName}: {$identifier}";
            default:
                return "{$action} {$modelName}: {$identifier}";
        }
    }

    protected function getAuditIdentifier(): string
    {
        if (isset($this->name)) {
            return $this->name;
        }
        if (isset($this->title)) {
            return $this->title;
        }
        if (isset($this->first_name) && isset($this->last_name)) {
            return "{$this->first_name} {$this->last_name}";
        }
        if (isset($this->email)) {
            return $this->email;
        }

        return "ID: {$this->getKey()}";
    }

    protected function getAuditableAttributes(): array
    {
        $attributes = $this->getAttributes();
        $excludedFields = $this->getAuditExcludedFields();

        return array_diff_key($attributes, array_flip($excludedFields));
    }

    protected function getAuditExcludedFields(): array
    {
        // Get global excluded fields from config
        $globalExcluded = config('audit.exclude_fields', [
            'created_at', 'updated_at', 'deleted_at', 'password',
            'remember_token', 'email_verified_at', 'api_token'
        ]);

        // Get model-specific excluded fields from config
        $modelConfig = config('audit.models.' . static::class . '.exclude_fields', []);

        // Merge with model property
        $modelExcluded = $this->auditExclude ?? [];

        return array_merge($globalExcluded, $modelConfig, $modelExcluded);
    }

    protected function isAuditExcluded(): bool
    {
        return property_exists($this, 'auditEnabled') && !$this->auditEnabled;
    }

    public function getLatestAuditTrail()
    {
        return $this->auditTrails()->latest()->first();
    }

    public function getAuditTrailForEvent(string $event)
    {
        return $this->auditTrails()->where('event', $event)->latest()->first();
    }
}
