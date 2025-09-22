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
        Schema::create('time_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained('company_branches');
            $table->date('log_date');
            $table->timestamp('time_in')->nullable();
            $table->timestamp('time_out')->nullable();
            $table->timestamp('break_out')->nullable();
            $table->timestamp('break_in')->nullable();

            // Calculated Fields
            $table->decimal('total_hours', 5, 2)->default(0);
            $table->decimal('regular_hours', 5, 2)->default(0);
            $table->decimal('overtime_hours', 5, 2)->default(0);
            $table->decimal('undertime_hours', 5, 2)->default(0);
            $table->integer('late_minutes')->default(0);
            $table->integer('early_departure_minutes')->default(0);

            // Status
            $table->enum('status', ['Present', 'Absent', 'Late', 'Undertime', 'Overtime', 'Holiday', 'Leave']);
            $table->boolean('is_holiday')->default(false);
            $table->foreignId('holiday_id')->nullable()->constrained();

            // Manual Adjustments
            $table->text('remarks')->nullable();
            $table->foreignId('adjusted_by')->nullable()->constrained('users');
            $table->timestamp('adjusted_at')->nullable();
            $table->json('original_values')->nullable();

            // Biometric Integration
            $table->string('device_id')->nullable();
            $table->enum('log_source', ['Biometric', 'Manual', 'Web', 'Mobile'])->default('Biometric');

            $table->timestamps();

            $table->unique(['employee_id', 'log_date']);
            $table->index(['employee_id', 'log_date']);
            $table->index(['log_date', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('time_logs');
    }
};
