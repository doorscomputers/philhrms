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
        Schema::create('payroll_runs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('payroll_group_id')->constrained()->cascadeOnDelete();
            $table->string('run_number', 20);
            $table->string('description')->nullable();

            // Period Information
            $table->date('period_start');
            $table->date('period_end');
            $table->date('pay_date');
            $table->integer('period_year');
            $table->integer('period_month');
            $table->enum('period_type', ['1st Half', '2nd Half', 'Monthly', 'Weekly']);

            // Processing Status
            $table->enum('status', ['Draft', 'Processing', 'Review', 'Approved', 'Paid', 'Cancelled'])->default('Draft');
            $table->integer('employee_count')->default(0);

            // Totals
            $table->decimal('total_gross_pay', 15, 2)->default(0);
            $table->decimal('total_basic_pay', 15, 2)->default(0);
            $table->decimal('total_overtime_pay', 15, 2)->default(0);
            $table->decimal('total_allowances', 15, 2)->default(0);
            $table->decimal('total_benefits', 15, 2)->default(0);
            $table->decimal('total_government_deductions', 15, 2)->default(0);
            $table->decimal('total_company_deductions', 15, 2)->default(0);
            $table->decimal('total_loans', 15, 2)->default(0);
            $table->decimal('total_adjustments', 15, 2)->default(0);
            $table->decimal('total_net_pay', 15, 2)->default(0);

            // Processing Information
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('processed_by')->nullable()->constrained('users');
            $table->timestamp('processed_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->timestamp('approved_at')->nullable();
            $table->text('remarks')->nullable();

            $table->timestamps();

            $table->unique(['company_id', 'run_number']);
            $table->index(['company_id', 'period_start', 'period_end']);
            $table->index(['status', 'pay_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payroll_runs');
    }
};
