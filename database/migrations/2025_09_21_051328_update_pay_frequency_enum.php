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
            // First drop the existing enum column
            $table->dropColumn('pay_frequency');
        });

        // Add the new enum with all required values
        Schema::table('employees', function (Blueprint $table) {
            $table->enum('pay_frequency', [
                'Daily',
                'Weekly',
                'Bi-weekly',
                'Semi-monthly',
                'Monthly',
            ])->default('Monthly')->after('employment_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            // Revert back to original enum values
            $table->dropColumn('pay_frequency');
        });

        Schema::table('employees', function (Blueprint $table) {
            $table->enum('pay_frequency', ['Monthly', 'Bi-monthly', 'Weekly', 'Daily'])
                ->after('employment_type');
        });
    }
};
