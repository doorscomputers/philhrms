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
        Schema::create('pay_frequencies', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "Weekly", "Bi-weekly", "Monthly"
            $table->string('code')->unique(); // e.g., "WKL", "BWK", "MTH"
            $table->text('description')->nullable();
            $table->integer('days_per_period'); // Number of days in pay period
            $table->integer('periods_per_year'); // Number of pay periods per year
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pay_frequencies');
    }
};
