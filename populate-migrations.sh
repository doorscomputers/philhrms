#!/bin/bash

# Script to populate all HRMS migration files
echo "🚀 Populating HRMS Migration Files..."

# Company Branches Migration
cat > database/migrations/2025_09_19_032640_create_company_branches_table.php << 'EOF'
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('company_branches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('code', 20);
            $table->string('name');
            $table->enum('type', ['Head Office', 'Branch', 'Warehouse', 'Plant', 'Sales Office']);

            // Address
            $table->text('address');
            $table->string('city');
            $table->string('province');
            $table->string('region');
            $table->string('postal_code', 10);
            $table->string('country', 3)->default('PH');

            // Contact
            $table->json('contact_numbers')->nullable();
            $table->json('email_addresses')->nullable();

            // Operations
            $table->time('operation_start_time')->default('08:00');
            $table->time('operation_end_time')->default('17:00');
            $table->json('operation_days')->default('["Monday","Tuesday","Wednesday","Thursday","Friday"]');
            $table->string('timezone')->default('Asia/Manila');

            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['company_id', 'code']);
            $table->index(['company_id', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('company_branches');
    }
};
EOF

# Cost Centers Migration
cat > database/migrations/2025_09_19_034119_create_cost_centers_table.php << 'EOF'
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cost_centers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('code', 20);
            $table->string('name');
            $table->text('description')->nullable();
            $table->foreignId('parent_id')->nullable()->constrained('cost_centers');
            $table->integer('level')->default(1);
            $table->string('full_path')->nullable();
            $table->decimal('budget_amount', 15, 2)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['company_id', 'code']);
            $table->index(['company_id', 'parent_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cost_centers');
    }
};
EOF

# Departments Migration
cat > database/migrations/2025_09_19_032642_create_departments_table.php << 'EOF'
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('branch_id')->nullable()->constrained('company_branches');
            $table->foreignId('cost_center_id')->nullable()->constrained('cost_centers');
            $table->string('code', 20);
            $table->string('name');
            $table->text('description')->nullable();
            $table->foreignId('parent_id')->nullable()->constrained('departments');
            $table->foreignId('head_id')->nullable()->constrained('users');

            // Hierarchy
            $table->integer('level')->default(1);
            $table->string('full_path')->nullable();

            // Budget & Staffing
            $table->decimal('budget_amount', 15, 2)->nullable();
            $table->integer('max_headcount')->nullable();
            $table->integer('current_headcount')->default(0);

            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['company_id', 'code']);
            $table->index(['company_id', 'parent_id']);
            $table->index(['company_id', 'head_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
EOF

# Job Grades Migration
cat > database/migrations/2025_09_19_034121_create_job_grades_table.php << 'EOF'
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('code', 10);
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('level');
            $table->decimal('min_salary', 10, 2);
            $table->decimal('mid_salary', 10, 2);
            $table->decimal('max_salary', 10, 2);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['company_id', 'code']);
            $table->index(['company_id', 'level']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_grades');
    }
};
EOF

# Positions Migration
cat > database/migrations/2025_09_19_032644_create_positions_table.php << 'EOF'
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('department_id')->constrained()->cascadeOnDelete();
            $table->foreignId('job_grade_id')->constrained()->cascadeOnDelete();
            $table->string('code', 20);
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('responsibilities')->nullable();
            $table->text('qualifications')->nullable();
            $table->foreignId('reports_to_id')->nullable()->constrained('positions');

            // Position Details
            $table->enum('type', ['Regular', 'Contractual', 'Consultant', 'Intern']);
            $table->enum('level', ['Executive', 'Managerial', 'Supervisory', 'Rank and File']);
            $table->boolean('is_exempt')->default(false);
            $table->boolean('is_confidential')->default(false);

            // Headcount
            $table->integer('authorized_headcount')->default(1);
            $table->integer('current_headcount')->default(0);
            $table->integer('vacant_positions')->default(0);

            // Salary Range
            $table->decimal('min_salary', 10, 2)->nullable();
            $table->decimal('max_salary', 10, 2)->nullable();

            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['company_id', 'code']);
            $table->index(['company_id', 'department_id']);
            $table->index(['company_id', 'reports_to_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('positions');
    }
};
EOF

# Work Schedules Migration
cat > database/migrations/2025_09_19_034122_create_work_schedules_table.php << 'EOF'
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('work_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('schedule_name');
            $table->string('schedule_code', 20);
            $table->text('description')->nullable();

            // Schedule Type
            $table->enum('schedule_type', ['Fixed', 'Flexible', 'Shift', 'Compressed', 'Rotating']);
            $table->enum('work_arrangement', ['On-site', 'Remote', 'Hybrid']);

            // Work Days
            $table->json('work_days');
            $table->integer('work_days_per_week')->default(5);
            $table->decimal('work_hours_per_day', 4, 2)->default(8.00);
            $table->decimal('work_hours_per_week', 5, 2)->default(40.00);

            // Time Settings
            $table->time('start_time')->default('08:00');
            $table->time('end_time')->default('17:00');
            $table->time('break_start_time')->nullable();
            $table->time('break_end_time')->nullable();
            $table->integer('break_minutes')->default(60);

            // Grace Periods
            $table->integer('late_grace_minutes')->default(0);
            $table->integer('early_out_grace_minutes')->default(0);

            // Overtime Rules
            $table->boolean('allow_overtime')->default(true);
            $table->decimal('overtime_multiplier', 4, 2)->default(1.25);
            $table->decimal('night_differential_rate', 4, 2)->default(0.10);

            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['company_id', 'schedule_code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('work_schedules');
    }
};
EOF

# Employees Migration
cat > database/migrations/2025_09_19_032646_create_employees_table.php << 'EOF'
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('employee_id', 20);
            $table->string('badge_number', 20)->nullable();

            // Personal Information
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('suffix', 10)->nullable();
            $table->date('birth_date');
            $table->string('birth_place');
            $table->enum('gender', ['Male', 'Female']);
            $table->enum('civil_status', ['Single', 'Married', 'Divorced', 'Widowed', 'Separated']);
            $table->string('nationality', 50)->default('Filipino');

            // Contact Information
            $table->json('addresses');
            $table->json('contact_numbers');
            $table->json('email_addresses');

            // Government IDs
            $table->string('sss_number', 20)->unique()->nullable();
            $table->string('tin', 20)->unique()->nullable();
            $table->string('philhealth_number', 20)->unique()->nullable();
            $table->string('pagibig_number', 20)->unique()->nullable();

            // Employment Information
            $table->foreignId('department_id')->constrained()->restrictOnDelete();
            $table->foreignId('position_id')->constrained()->restrictOnDelete();
            $table->foreignId('job_grade_id')->constrained()->restrictOnDelete();
            $table->foreignId('branch_id')->constrained('company_branches')->restrictOnDelete();
            $table->foreignId('work_schedule_id')->nullable()->constrained('work_schedules');
            $table->foreignId('immediate_supervisor_id')->nullable()->constrained('employees');

            // Employment Dates
            $table->date('hire_date');
            $table->date('original_hire_date')->nullable();
            $table->date('probation_end_date')->nullable();
            $table->date('regularization_date')->nullable();

            // Employment Status
            $table->enum('employment_status', [
                'Probationary', 'Regular', 'Contractual', 'Project-Based',
                'Consultant', 'Intern', 'Resigned', 'Terminated', 'Retired', 'AWOL'
            ])->default('Probationary');
            $table->enum('employment_type', ['Full-time', 'Part-time', 'Casual']);
            $table->enum('pay_frequency', ['Monthly', 'Bi-monthly', 'Weekly', 'Daily']);
            $table->boolean('is_exempt')->default(false);

            // Compensation
            $table->decimal('basic_salary', 10, 2);
            $table->json('allowances')->nullable();
            $table->decimal('daily_rate', 8, 2)->nullable();
            $table->decimal('hourly_rate', 8, 2)->nullable();

            // Tax Information
            $table->enum('tax_status', ['S', 'ME', 'S1', 'ME1', 'S2', 'ME2', 'S3', 'ME3', 'S4', 'ME4'])->default('S');

            // Emergency Contact
            $table->json('emergency_contacts');

            // System Fields
            $table->boolean('is_active')->default(true);
            $table->text('remarks')->nullable();
            $table->json('custom_fields')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->unique(['company_id', 'employee_id']);
            $table->index(['company_id', 'employment_status']);
            $table->index(['company_id', 'department_id']);
            $table->index(['first_name', 'last_name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
EOF

# Leave Types Migration
cat > database/migrations/2025_09_19_034124_create_leave_types_table.php << 'EOF'
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leave_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('code', 20);
            $table->text('description')->nullable();
            $table->enum('category', ['Vacation', 'Sick', 'Emergency', 'Maternity', 'Paternity', 'Special', 'Others']);

            // Leave Rules
            $table->boolean('is_paid')->default(true);
            $table->boolean('requires_medical_certificate')->default(false);
            $table->boolean('can_be_carried_over')->default(true);
            $table->boolean('can_be_converted_to_cash')->default(false);
            $table->decimal('annual_entitlement', 5, 2)->default(0);
            $table->decimal('max_carry_over', 5, 2)->default(0);
            $table->integer('min_days_advance_filing')->default(1);
            $table->integer('max_consecutive_days')->nullable();

            // Gender Restrictions
            $table->enum('gender_restriction', ['None', 'Male', 'Female'])->default('None');

            // Employment Status Restrictions
            $table->json('allowed_employment_status')->nullable();

            // Approval Requirements
            $table->boolean('requires_approval')->default(true);
            $table->integer('approval_levels')->default(1);

            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['company_id', 'code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leave_types');
    }
};
EOF

echo "✅ All migration files populated successfully!"
echo "📋 Ready to run: php artisan migrate"