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

            // Business Registration
            $table->string('bir_rdo_code', 10)->nullable();
            $table->string('business_permit')->nullable();
            $table->date('permit_expiry')->nullable();

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

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_branches');
    }
};
