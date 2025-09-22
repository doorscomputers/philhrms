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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('employee_id', 20);
            $table->string('badge_number', 20)->nullable();
            $table->string('biometric_id', 20)->nullable();

            // Personal Information
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('suffix', 10)->nullable();
            $table->string('maiden_name')->nullable();
            $table->string('nickname', 50)->nullable();
            $table->date('birth_date');
            $table->string('birth_place');
            $table->enum('gender', ['Male', 'Female']);
            $table->enum('civil_status', ['Single', 'Married', 'Divorced', 'Widowed', 'Separated', 'Annulled']);
            $table->string('nationality', 50)->default('Filipino');
            $table->string('religion', 50)->nullable();
            $table->enum('blood_type', ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'])->nullable();
            $table->decimal('height', 5, 2)->nullable();
            $table->decimal('weight', 5, 2)->nullable();

            // Contact Information
            $table->json('addresses');
            $table->json('contact_numbers');
            $table->json('email_addresses');

            // Government IDs
            $table->string('sss_number', 20)->unique()->nullable();
            $table->string('tin', 20)->unique()->nullable();
            $table->string('philhealth_number', 20)->unique()->nullable();
            $table->string('pagibig_number', 20)->unique()->nullable();
            $table->string('passport_number', 20)->nullable();
            $table->date('passport_expiry')->nullable();
            $table->string('drivers_license', 20)->nullable();
            $table->date('license_expiry')->nullable();
            $table->string('voters_id', 20)->nullable();

            // Employment Information
            $table->foreignId('department_id')->constrained()->restrictOnDelete();
            $table->foreignId('position_id')->constrained()->restrictOnDelete();
            $table->foreignId('job_grade_id')->constrained()->restrictOnDelete();
            $table->foreignId('cost_center_id')->nullable()->constrained('cost_centers');
            $table->foreignId('branch_id')->constrained('company_branches')->restrictOnDelete();
            $table->foreignId('immediate_supervisor_id')->nullable()->constrained('employees');

            // Employment Dates
            $table->date('hire_date');
            $table->date('original_hire_date')->nullable();
            $table->date('probation_end_date')->nullable();
            $table->date('regularization_date')->nullable();
            $table->date('last_promotion_date')->nullable();
            $table->date('resignation_date')->nullable();
            $table->date('termination_date')->nullable();
            $table->date('retirement_date')->nullable();

            // Employment Status
            $table->enum('employment_status', [
                'Probationary', 'Regular', 'Contractual', 'Project-Based',
                'Consultant', 'Intern', 'Resigned', 'Terminated', 'Retired', 'AWOL',
            ])->default('Probationary');
            $table->enum('employment_type', ['Full-time', 'Part-time', 'Casual']);
            $table->enum('pay_frequency', ['Monthly', 'Bi-monthly', 'Weekly', 'Daily']);
            $table->boolean('is_exempt')->default(false);

            // Compensation
            $table->decimal('basic_salary', 10, 2);
            $table->json('allowances')->nullable();
            $table->decimal('daily_rate', 8, 2)->nullable();
            $table->decimal('hourly_rate', 8, 2)->nullable();

            // Work Schedule
            $table->foreignId('work_schedule_id')->nullable()->constrained('work_schedules');
            $table->boolean('is_flexible_time')->default(false);
            $table->boolean('is_field_work')->default(false);

            // Tax Information
            $table->enum('tax_status', ['S', 'ME', 'S1', 'ME1', 'S2', 'ME2', 'S3', 'ME3', 'S4', 'ME4'])->default('S');
            $table->boolean('is_minimum_wage')->default(false);
            $table->decimal('tax_shield', 8, 2)->default(0);

            // Leave Credits
            $table->decimal('vacation_leave_balance', 5, 2)->default(0);
            $table->decimal('sick_leave_balance', 5, 2)->default(0);
            $table->decimal('emergency_leave_balance', 5, 2)->default(0);

            // Emergency Contact
            $table->json('emergency_contacts');

            // Medical Information
            $table->text('medical_conditions')->nullable();
            $table->text('allergies')->nullable();
            $table->text('medications')->nullable();

            // Photo & Documents
            $table->string('photo')->nullable();
            $table->json('documents')->nullable();

            // System Fields
            $table->boolean('is_active')->default(true);
            $table->text('remarks')->nullable();
            $table->json('custom_fields')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->unique(['company_id', 'employee_id']);
            $table->index(['company_id', 'employment_status']);
            $table->index(['company_id', 'department_id']);
            $table->index(['company_id', 'hire_date']);
            $table->index(['first_name', 'last_name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
