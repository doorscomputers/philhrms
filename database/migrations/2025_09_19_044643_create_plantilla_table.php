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
        Schema::create('plantilla', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('plantilla_number', 20)->unique();
            $table->string('title');
            $table->text('description')->nullable();

            // Organizational Details
            $table->foreignId('department_id')->constrained()->restrictOnDelete();
            $table->foreignId('division_id')->nullable()->constrained('departments');
            $table->foreignId('section_id')->nullable()->constrained('departments');
            $table->foreignId('unit_id')->nullable()->constrained('departments');

            // Position Classification
            $table->string('item_number', 20)->unique();
            $table->enum('position_level', ['Executive', 'Managerial', 'Supervisory', 'Technical', 'Clerical', 'Laborer']);
            $table->enum('employment_status', ['Permanent', 'Temporary', 'Casual', 'Contractual', 'Co-terminus']);
            $table->enum('nature_of_appointment', ['Original', 'Promotion', 'Transfer', 'Detail', 'Reassignment']);

            // Salary Information
            $table->integer('salary_grade');
            $table->integer('step_increment')->default(1);
            $table->decimal('monthly_salary', 10, 2);
            $table->decimal('annual_salary', 12, 2);

            // Position Status
            $table->enum('position_status', ['Authorized', 'Filled', 'Vacant', 'Abolished', 'Reclassified']);
            $table->date('position_created_date');
            $table->date('position_abolished_date')->nullable();
            $table->text('abolishment_reason')->nullable();

            // Qualifications
            $table->text('education_required');
            $table->text('experience_required');
            $table->text('training_required')->nullable();
            $table->text('eligibility_required')->nullable();

            // Publication Details
            $table->date('position_published_from')->nullable();
            $table->date('position_published_to')->nullable();
            $table->string('publication_reference')->nullable();
            $table->text('publication_remarks')->nullable();

            // Budget Information
            $table->string('fund_source');
            $table->string('budget_year');
            $table->boolean('is_budgeted')->default(true);

            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['company_id', 'position_status']);
            $table->index(['department_id', 'salary_grade']);
            $table->index(['position_published_from', 'position_published_to']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plantilla');
    }
};
