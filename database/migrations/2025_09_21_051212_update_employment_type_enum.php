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
            $table->dropColumn('employment_type');
        });

        // Add the new enum with all required values
        Schema::table('employees', function (Blueprint $table) {
            $table->enum('employment_type', [
                'Full-time',
                'Part-time',
                'Contract',
                'Temporary',
                'Intern',
                'Casual',
            ])->default('Full-time')->after('employment_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            // Revert back to original enum values
            $table->dropColumn('employment_type');
        });

        Schema::table('employees', function (Blueprint $table) {
            $table->enum('employment_type', ['Full-time', 'Part-time', 'Casual'])
                ->after('employment_status');
        });
    }
};
