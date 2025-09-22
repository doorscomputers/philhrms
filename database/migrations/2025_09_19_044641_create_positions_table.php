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

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('positions');
    }
};
