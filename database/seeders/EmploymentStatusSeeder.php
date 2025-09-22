<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EmploymentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            [
                'code' => 'PROB',
                'name' => 'Probationary',
                'description' => 'Employee is serving probationary period before regularization',
                'color' => '#F59E0B',
                'is_active' => true,
                'requires_probation' => true,
                'eligible_for_benefits' => false,
                'sort_order' => 1,
            ],
            [
                'code' => 'REG',
                'name' => 'Regular',
                'description' => 'Permanent employee with full benefits and job security',
                'color' => '#10B981',
                'is_active' => true,
                'requires_probation' => false,
                'eligible_for_benefits' => true,
                'sort_order' => 2,
            ],
            [
                'code' => 'CONT',
                'name' => 'Contractual',
                'description' => 'Fixed-term contract employee',
                'color' => '#3B82F6',
                'is_active' => true,
                'requires_probation' => false,
                'eligible_for_benefits' => false,
                'sort_order' => 3,
            ],
            [
                'code' => 'PROJ',
                'name' => 'Project-Based',
                'description' => 'Employee hired for specific project duration',
                'color' => '#8B5CF6',
                'is_active' => true,
                'requires_probation' => false,
                'eligible_for_benefits' => false,
                'sort_order' => 4,
            ],
            [
                'code' => 'CONS',
                'name' => 'Consultant',
                'description' => 'Professional consultant providing specialized services',
                'color' => '#EC4899',
                'is_active' => true,
                'requires_probation' => false,
                'eligible_for_benefits' => false,
                'sort_order' => 5,
            ],
            [
                'code' => 'INTERN',
                'name' => 'Intern',
                'description' => 'Student or trainee gaining work experience',
                'color' => '#14B8A6',
                'is_active' => true,
                'requires_probation' => false,
                'eligible_for_benefits' => false,
                'sort_order' => 6,
            ],
            [
                'code' => 'RESIG',
                'name' => 'Resigned',
                'description' => 'Employee who has voluntarily left the company',
                'color' => '#6B7280',
                'is_active' => true,
                'requires_probation' => false,
                'eligible_for_benefits' => false,
                'sort_order' => 7,
            ],
            [
                'code' => 'TERM',
                'name' => 'Terminated',
                'description' => 'Employee whose employment was terminated by the company',
                'color' => '#EF4444',
                'is_active' => true,
                'requires_probation' => false,
                'eligible_for_benefits' => false,
                'sort_order' => 8,
            ],
            [
                'code' => 'RET',
                'name' => 'Retired',
                'description' => 'Employee who has reached retirement age or retired early',
                'color' => '#F97316',
                'is_active' => true,
                'requires_probation' => false,
                'eligible_for_benefits' => true,
                'sort_order' => 9,
            ],
            [
                'code' => 'AWOL',
                'name' => 'AWOL',
                'description' => 'Absent Without Official Leave',
                'color' => '#DC2626',
                'is_active' => true,
                'requires_probation' => false,
                'eligible_for_benefits' => false,
                'sort_order' => 10,
            ],
        ];

        foreach ($statuses as $status) {
            \App\Models\EmploymentStatus::create($status);
        }
    }
}
