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

            // Accrual Configuration
            $table->enum('accrual_method', ['Annual', 'Monthly', 'Bi-monthly', 'Per Pay Period', 'Service-based'])->default('Annual');
            $table->decimal('accrual_rate', 5, 3)->default(0);
            $table->integer('accrual_start_month')->default(1);
            $table->boolean('prorated_accrual')->default(true);
            $table->integer('minimum_service_months')->default(0);

            // Carryover Rules
            $table->decimal('max_carryover_days', 5, 2)->default(0);
            $table->enum('carryover_policy', ['None', 'Unlimited', 'Limited', 'Use or Lose'])->default('Limited');
            $table->date('carryover_deadline')->nullable();
            $table->integer('carryover_grace_months')->default(3);
            $table->boolean('forfeit_excess')->default(true);

            // Expiration Rules
            $table->boolean('has_expiry')->default(false);
            $table->integer('expiry_months')->nullable();
            $table->enum('expiry_basis', ['Grant Date', 'Calendar Year', 'Anniversary'])->default('Grant Date');
            $table->boolean('warn_before_expiry')->default(true);
            $table->integer('warning_days')->default(30);

            // Cash Conversion Rules
            $table->boolean('allow_cash_conversion')->default(false);
            $table->decimal('conversion_rate', 4, 3)->default(1.000);
            $table->decimal('min_days_for_conversion', 5, 2)->default(5);
            $table->decimal('max_days_for_conversion', 5, 2)->nullable();
            $table->enum('conversion_timing', ['Year End', 'On Separation', 'Anytime', 'Scheduled'])->default('Year End');

            // Leave Year Configuration
            $table->enum('leave_year_basis', ['Calendar', 'Company Fiscal', 'Employee Anniversary'])->default('Calendar');
            $table->integer('leave_year_start_month')->default(1);

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

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_types');
    }
};
