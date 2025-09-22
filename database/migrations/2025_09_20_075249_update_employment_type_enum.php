<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, update any existing 'Contract' values to 'Contractual'
        DB::statement("UPDATE employees SET employment_type = 'Contractual' WHERE employment_type = 'Contract'");

        // Drop and recreate the enum with more values
        DB::statement("ALTER TABLE employees MODIFY COLUMN employment_type ENUM('Full-time', 'Part-time', 'Casual', 'Contractual', 'Contract', 'Temporary', 'Intern', 'Consultant') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to original enum values
        DB::statement("ALTER TABLE employees MODIFY COLUMN employment_type ENUM('Full-time', 'Part-time', 'Casual') NOT NULL");
    }
};
