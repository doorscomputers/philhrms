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
        Schema::create('work_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('code', 20);
            $table->text('description')->nullable();
            $table->enum('type', ['Fixed', 'Flexible', 'Shifting', 'Compressed']);

            // Standard Hours
            $table->decimal('hours_per_day', 4, 2)->default(8.00);
            $table->decimal('hours_per_week', 4, 2)->default(40.00);
            $table->integer('days_per_week')->default(5);

            // Break Configuration
            $table->integer('break_duration_minutes')->default(60);
            $table->boolean('is_break_paid')->default(false);
            $table->integer('short_break_duration_minutes')->default(15);
            $table->integer('short_breaks_per_day')->default(2);

            // Overtime Rules
            $table->boolean('allow_overtime')->default(true);
            $table->decimal('max_overtime_hours_daily', 4, 2)->default(4.00);
            $table->decimal('max_overtime_hours_weekly', 4, 2)->default(12.00);
            $table->boolean('auto_approve_overtime')->default(false);

            // Grace Period
            $table->integer('late_grace_minutes')->default(5);
            $table->integer('early_departure_grace_minutes')->default(5);

            // Schedule Details
            $table->json('schedule_details');

            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['company_id', 'code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_schedules');
    }
};
