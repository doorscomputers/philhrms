<?php

namespace App\Traits;

use App\Models\AuditTrail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

trait Auditable
{
    protected static function bootAuditable()
    {
        static::created(function ($model) {
            $model->auditCreated();
        });

        static::updated(function ($model) {
            $model->auditUpdated();
        });

        static::deleted(function ($model) {
            $model->auditDeleted();
        });
    }

    protected function auditCreated()
    {
        $this->createAuditTrail('created', [], $this->getAuditableAttributes());
    }

    protected function auditUpdated()
    {
        $changes = [];
        $oldValues = [];
        $newValues = [];

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

        if (! empty($changes)) {
            $this->createAuditTrail('updated', $oldValues, $newValues, $changes);
        }
    }

    protected function auditDeleted()
    {
        $this->createAuditTrail('deleted', $this->getAuditableAttributes(), []);
    }

    protected function createAuditTrail(string $action, array $oldValues = [], array $newValues = [], array $changedFields = [])
    {
        $user = Auth::user();

        AuditTrail::create([
            'user_id' => $user?->id,
            'user_name' => $user?->name ?? 'System',
            'model_type' => get_class($this),
            'model_id' => $this->id,
            'action' => $action,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'changed_fields' => $changedFields,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
            'description' => $this->generateAuditDescription($action, $changedFields),
        ]);
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
        // Try common identifier fields
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

        return "ID: {$this->id}";
    }

    protected function getAuditableAttributes(): array
    {
        $attributes = $this->getAttributes();

        // Remove sensitive or irrelevant fields
        $excludedFields = ['password', 'remember_token', 'email_verified_at', 'created_at', 'updated_at'];

        return array_diff_key($attributes, array_flip($excludedFields));
    }

    public function auditTrails()
    {
        return $this->morphMany(AuditTrail::class, 'model');
    }
}
