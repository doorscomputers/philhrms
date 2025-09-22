<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, create default employment status records if they don't exist
        $defaultStatuses = [
            ['code' => 'PROB', 'name' => 'Probationary', 'description' => 'Employee under probationary period', 'color' => '#F59E0B', 'sort_order' => 1],
            ['code' => 'REG', 'name' => 'Regular', 'description' => 'Regular employee', 'color' => '#10B981', 'sort_order' => 2],
            ['code' => 'CONT', 'name' => 'Contractual', 'description' => 'Contractual employee', 'color' => '#3B82F6', 'sort_order' => 3],
            ['code' => 'PROJ', 'name' => 'Project-Based', 'description' => 'Project-based employee', 'color' => '#8B5CF6', 'sort_order' => 4],
            ['code' => 'CONS', 'name' => 'Consultant', 'description' => 'Consultant', 'color' => '#06B6D4', 'sort_order' => 5],
            ['code' => 'INT', 'name' => 'Intern', 'description' => 'Intern', 'color' => '#84CC16', 'sort_order' => 6],
            ['code' => 'RES', 'name' => 'Resigned', 'description' => 'Resigned employee', 'color' => '#EF4444', 'sort_order' => 7, 'is_active' => false],
            ['code' => 'TERM', 'name' => 'Terminated', 'description' => 'Terminated employee', 'color' => '#DC2626', 'sort_order' => 8, 'is_active' => false],
            ['code' => 'RET', 'name' => 'Retired', 'description' => 'Retired employee', 'color' => '#6B7280', 'sort_order' => 9, 'is_active' => false],
            ['code' => 'AWOL', 'name' => 'AWOL', 'description' => 'Absent without leave', 'color' => '#F87171', 'sort_order' => 10, 'is_active' => false],
        ];

        foreach ($defaultStatuses as $status) {
            DB::table('employment_statuses')->updateOrInsert(
                ['code' => $status['code']],
                array_merge([
                    'is_active' => true,
                    'requires_probation' => false,
                    'eligible_for_benefits' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ], $status)
            );
        }

        // Create a mapping of ENUM values to employment_statuses IDs
        $statusMapping = [
            'Probationary' => 'PROB',
            'Regular' => 'REG',
            'Contractual' => 'CONT',
            'Project-Based' => 'PROJ',
            'Consultant' => 'CONS',
            'Intern' => 'INT',
            'Resigned' => 'RES',
            'Terminated' => 'TERM',
            'Retired' => 'RET',
            'AWOL' => 'AWOL',
        ];

        // Add the new foreign key column
        Schema::table('employees', function (Blueprint $table) {
            $table->unsignedBigInteger('employment_status_id')->nullable()->after('employment_status');
        });

        // Migrate existing data from ENUM to foreign key
        foreach ($statusMapping as $enumValue => $code) {
            $statusId = DB::table('employment_statuses')->where('code', $code)->value('id');
            if ($statusId) {
                DB::table('employees')
                    ->where('employment_status', $enumValue)
                    ->update(['employment_status_id' => $statusId]);
            }
        }

        // Remove the old ENUM column and add foreign key constraint
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn('employment_status');
            $table->foreign('employment_status_id')->references('id')->on('employment_statuses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Create a reverse mapping of employment status IDs to ENUM values
        $reverseMapping = [];
        $statuses = DB::table('employment_statuses')->get();
        foreach ($statuses as $status) {
            $reverseMapping[$status->id] = $status->name;
        }

        // Add the ENUM column back
        Schema::table('employees', function (Blueprint $table) {
            $table->enum('employment_status', [
                'Probationary', 'Regular', 'Contractual', 'Project-Based',
                'Consultant', 'Intern', 'Resigned', 'Terminated', 'Retired', 'AWOL',
            ])->nullable()->after('employment_status_id');
        });

        // Migrate data back from foreign key to ENUM
        foreach ($reverseMapping as $statusId => $enumValue) {
            DB::table('employees')
                ->where('employment_status_id', $statusId)
                ->update(['employment_status' => $enumValue]);
        }

        // Drop the foreign key and column
        Schema::table('employees', function (Blueprint $table) {
            $table->dropForeign(['employment_status_id']);
            $table->dropColumn('employment_status_id');
        });
    }
};
