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
        Schema::create('audit_trails', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable(); // User who made the change
            $table->string('user_name')->nullable(); // User name for display
            $table->string('model_type'); // Model class name (e.g., 'App\Models\Employee')
            $table->unsignedBigInteger('model_id'); // ID of the record
            $table->string('action'); // 'created', 'updated', 'deleted'
            $table->json('old_values')->nullable(); // Previous values
            $table->json('new_values')->nullable(); // New values
            $table->json('changed_fields')->nullable(); // Only changed fields
            $table->string('ip_address')->nullable(); // User's IP address
            $table->string('user_agent')->nullable(); // Browser/device info
            $table->text('description')->nullable(); // Human readable description
            $table->timestamps();

            // Indexes for better performance
            $table->index(['model_type', 'model_id']);
            $table->index('user_id');
            $table->index('action');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_trails');
    }
};
