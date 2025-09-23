<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('audit_trails', function (Blueprint $table) {
            // Add composite indexes for common query patterns
            $table->index(['model_type', 'model_id', 'created_at'], 'audit_model_date_idx');
            $table->index(['user_id', 'created_at'], 'audit_user_date_idx');
            $table->index(['action', 'created_at'], 'audit_action_date_idx');
            $table->index(['created_at'], 'audit_created_at_idx');

            // Add index for cleanup operations
            $table->index(['created_at', 'id'], 'audit_cleanup_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('audit_trails', function (Blueprint $table) {
            $table->dropIndex('audit_model_date_idx');
            $table->dropIndex('audit_user_date_idx');
            $table->dropIndex('audit_action_date_idx');
            $table->dropIndex('audit_created_at_idx');
            $table->dropIndex('audit_cleanup_idx');
        });
    }
};
