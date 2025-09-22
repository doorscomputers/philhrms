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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('code', 20)->unique();
            $table->string('name');
            $table->string('legal_name');
            $table->string('business_type');
            $table->string('industry');

            // Government Registration
            $table->string('tin', 20)->unique();
            $table->string('sec_registration')->nullable();
            $table->string('dti_registration')->nullable();
            $table->string('bir_rdo_code', 10);
            $table->string('sss_employer_number', 20)->nullable();
            $table->string('philhealth_employer_number', 20)->nullable();
            $table->string('pagibig_employer_number', 20)->nullable();

            // Contact Information
            $table->json('addresses');
            $table->json('contact_numbers');
            $table->json('email_addresses');
            $table->string('website')->nullable();

            // Business Details
            $table->date('date_established');
            $table->decimal('authorized_capital', 15, 2)->nullable();
            $table->decimal('paid_up_capital', 15, 2)->nullable();
            $table->integer('total_employees')->default(0);

            // System Configuration
            $table->json('settings');
            $table->enum('status', ['Active', 'Inactive', 'Suspended'])->default('Active');
            $table->enum('subscription_plan', ['Basic', 'Standard', 'Premium', 'Enterprise'])->default('Basic');
            $table->timestamp('subscription_expires_at')->nullable();

            // Fiscal Year
            $table->integer('fiscal_year_start_month')->default(1);
            $table->integer('fiscal_year_end_month')->default(12);

            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'subscription_plan']);
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
