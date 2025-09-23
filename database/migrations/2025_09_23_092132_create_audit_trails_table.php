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
            $table->string('auditable_type'); // Model class name (e.g., 'App\Models\Employee')
            $table->unsignedBigInteger('auditable_id'); // Model record ID
            $table->string('event'); // created, updated, deleted
            $table->json('old_values')->nullable(); // Previous values (for updates/deletes)
            $table->json('new_values')->nullable(); // New values (for creates/updates)
            $table->unsignedBigInteger('user_id')->nullable(); // Who made the change
            $table->string('user_type')->default('App\Models\User'); // User model type
            $table->string('ip_address')->nullable(); // IP address of user
            $table->text('user_agent')->nullable(); // Browser info
            $table->json('url')->nullable(); // Request URL and method
            $table->timestamps();

            // Indexes for performance
            $table->index(['auditable_type', 'auditable_id']);
            $table->index(['user_id', 'user_type']);
            $table->index('event');
            $table->index('created_at');

            // Foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
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
