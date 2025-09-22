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
        // Temporarily change column to VARCHAR to avoid enum constraints
        DB::statement('ALTER TABLE employees MODIFY COLUMN pay_frequency VARCHAR(50)');

        // Update any existing 'Bi-monthly' values to 'Semi-monthly' to match frontend
        DB::table('employees')->where('pay_frequency', 'Bi-monthly')->update(['pay_frequency' => 'Semi-monthly']);

        // Now change back to enum with correct values
        DB::statement("ALTER TABLE employees MODIFY COLUMN pay_frequency ENUM('Daily', 'Weekly', 'Bi-weekly', 'Semi-monthly', 'Monthly') DEFAULT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to original enum values
        DB::statement('ALTER TABLE employees MODIFY COLUMN pay_frequency VARCHAR(50)');
        DB::table('employees')->where('pay_frequency', 'Semi-monthly')->update(['pay_frequency' => 'Bi-monthly']);
        DB::statement("ALTER TABLE employees MODIFY COLUMN pay_frequency ENUM('Monthly', 'Bi-monthly', 'Weekly', 'Daily') DEFAULT NULL");
    }
};
