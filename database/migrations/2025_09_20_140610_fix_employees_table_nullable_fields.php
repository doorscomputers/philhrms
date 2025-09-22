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
        Schema::table('employees', function (Blueprint $table) {
            // Make fields that should be nullable actually nullable
            $table->date('birth_date')->nullable()->change();
            $table->string('birth_place')->nullable()->change();
            $table->enum('gender', ['Male', 'Female', 'Other'])->nullable()->change();
            $table->enum('civil_status', ['Single', 'Married', 'Divorced', 'Widowed', 'Separated', 'Annulled'])->nullable()->change();
            $table->foreignId('department_id')->nullable()->change();
            $table->foreignId('position_id')->nullable()->change();
            $table->foreignId('job_grade_id')->nullable()->change();
            $table->foreignId('branch_id')->nullable()->change();
            $table->date('hire_date')->nullable()->change();
            $table->decimal('basic_salary', 10, 2)->nullable()->change();
            $table->enum('employment_status', [
                'Probationary', 'Regular', 'Contractual', 'Project-Based',
                'Consultant', 'Intern', 'Resigned', 'Terminated', 'Retired', 'AWOL',
            ])->nullable()->change();
            $table->enum('employment_type', ['Full-time', 'Part-time', 'Casual'])->nullable()->change();
            $table->enum('pay_frequency', ['Monthly', 'Bi-monthly', 'Weekly', 'Daily'])->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            // Revert back to NOT NULL constraints (with defaults where appropriate)
            $table->date('birth_date')->change();
            $table->string('birth_place')->change();
            $table->enum('gender', ['Male', 'Female', 'Other'])->change();
            $table->enum('civil_status', ['Single', 'Married', 'Divorced', 'Widowed', 'Separated', 'Annulled'])->change();
            $table->foreignId('department_id')->constrained()->restrictOnDelete()->change();
            $table->foreignId('position_id')->constrained()->restrictOnDelete()->change();
            $table->foreignId('job_grade_id')->constrained()->restrictOnDelete()->change();
            $table->foreignId('branch_id')->constrained('company_branches')->restrictOnDelete()->change();
            $table->date('hire_date')->change();
            $table->decimal('basic_salary', 10, 2)->change();
            $table->enum('employment_status', [
                'Probationary', 'Regular', 'Contractual', 'Project-Based',
                'Consultant', 'Intern', 'Resigned', 'Terminated', 'Retired', 'AWOL',
            ])->default('Probationary')->change();
            $table->enum('employment_type', ['Full-time', 'Part-time', 'Casual'])->change();
            $table->enum('pay_frequency', ['Monthly', 'Bi-monthly', 'Weekly', 'Daily'])->change();
        });
    }
};
