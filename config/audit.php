<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Audit Trail Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration options for the audit trail system
    |
    */

    // Enable/disable audit trail globally
    'enabled' => env('AUDIT_ENABLED', true),

    // Models to exclude from audit trail
    'exclude_models' => [
        // Add model classes here to exclude them from audit tracking
        // Example: App\Models\TempModel::class,
    ],

    // Fields to exclude from audit trail (applied to all models)
    'exclude_fields' => [
        'created_at',
        'updated_at',
        'deleted_at',
        'password',
        'remember_token',
        'email_verified_at',
        'api_token',
    ],

    // Retention settings
    'retention' => [
        // Number of days to keep audit records (0 = never delete)
        'days' => env('AUDIT_RETENTION_DAYS', 365),

        // Enable automatic cleanup
        'auto_cleanup' => env('AUDIT_AUTO_CLEANUP', true),
    ],

    // Performance settings
    'performance' => [
        // Queue audit trail creation (recommended for production)
        'queue' => env('AUDIT_QUEUE', false),

        // Queue connection to use
        'queue_connection' => env('AUDIT_QUEUE_CONNECTION', 'default'),

        // Batch size for cleanup operations
        'cleanup_batch_size' => 1000,

        // Enable compression for large JSON data
        'compress_data' => env('AUDIT_COMPRESS_DATA', false),
    ],

    // Security settings
    'security' => [
        // Encrypt sensitive field changes
        'encrypt_changes' => env('AUDIT_ENCRYPT_CHANGES', false),

        // Fields that should always be encrypted in audit logs
        'encrypt_fields' => [
            'salary',
            'wage',
            'bank_account',
            'sss_number',
            'tin',
            'philhealth_number',
            'pagibig_number',
        ],
    ],

    // Model-specific settings
    'models' => [
        // Example: Custom settings per model
        // App\Models\Employee::class => [
        //     'exclude_fields' => ['photo', 'documents'],
        //     'retention_days' => 730, // 2 years
        // ],
    ],
];