<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TestDataSeeder extends Seeder
{
    public function run(): void
    {
        // Create a test company
        $companyId = DB::table('companies')->insertGetId([
            'uuid' => (string) Str::uuid(),
            'code' => 'TEST001',
            'name' => 'Test Company Inc.',
            'legal_name' => 'Test Company Incorporated',
            'business_type' => 'Corporation',
            'industry' => 'Technology',
            'tin' => '123456789012',
            'bir_rdo_code' => '001',
            'addresses' => json_encode([
                'main' => [
                    'street' => '123 Test Street',
                    'city' => 'Manila',
                    'province' => 'Metro Manila',
                    'postal_code' => '1000',
                ],
            ]),
            'contact_numbers' => json_encode([
                'main' => '+63 2 1234 5678',
            ]),
            'email_addresses' => json_encode([
                'main' => 'info@testcompany.com',
            ]),
            'date_established' => '2020-01-01',
            'settings' => json_encode([]),
            'status' => 'Active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create company branch
        $branchId = DB::table('company_branches')->insertGetId([
            'company_id' => $companyId,
            'code' => 'HO',
            'name' => 'Head Office',
            'type' => 'Head Office',
            'address' => '123 Test Street, Manila',
            'city' => 'Manila',
            'province' => 'Metro Manila',
            'region' => 'NCR',
            'postal_code' => '1000',
            'country' => 'PH',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create cost center
        $costCenterId = DB::table('cost_centers')->insertGetId([
            'company_id' => $companyId,
            'code' => 'CC001',
            'name' => 'General Administration',
            'description' => 'General Administration Cost Center',
            'level' => 1,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create job grade
        $jobGradeId = DB::table('job_grades')->insertGetId([
            'company_id' => $companyId,
            'code' => 'JG01',
            'name' => 'Grade 1',
            'description' => 'Entry Level',
            'level' => 1,
            'min_salary' => 25000,
            'mid_salary' => 30000,
            'max_salary' => 35000,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create department
        $departmentId = DB::table('departments')->insertGetId([
            'company_id' => $companyId,
            'branch_id' => $branchId,
            'cost_center_id' => $costCenterId,
            'code' => 'HR',
            'name' => 'Human Resources',
            'description' => 'Human Resources Department',
            'level' => 1,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create position
        $positionId = DB::table('positions')->insertGetId([
            'company_id' => $companyId,
            'department_id' => $departmentId,
            'job_grade_id' => $jobGradeId,
            'code' => 'HR001',
            'title' => 'HR Manager',
            'description' => 'Human Resources Manager',
            'type' => 'Regular',
            'level' => 'Managerial',
            'authorized_headcount' => 1,
            'min_salary' => 30000,
            'max_salary' => 35000,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create test user (using existing users table structure)
        $userId = DB::table('users')->insertGetId([
            'name' => 'Test Admin',
            'email' => 'admin@testcompany.com',
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create employee record
        DB::table('employees')->insert([
            'uuid' => (string) Str::uuid(),
            'company_id' => $companyId,
            'user_id' => $userId,
            'employee_id' => 'EMP001',
            'first_name' => 'Test',
            'last_name' => 'Admin',
            'birth_date' => '1990-01-01',
            'birth_place' => 'Manila',
            'gender' => 'Male',
            'civil_status' => 'Single',
            'addresses' => json_encode([
                'current' => [
                    'street' => '456 Admin Street',
                    'city' => 'Manila',
                    'province' => 'Metro Manila',
                    'postal_code' => '1000',
                ],
            ]),
            'contact_numbers' => json_encode([
                'mobile' => '+63 917 123 4567',
            ]),
            'email_addresses' => json_encode([
                'work' => 'admin@testcompany.com',
            ]),
            'department_id' => $departmentId,
            'position_id' => $positionId,
            'job_grade_id' => $jobGradeId,
            'branch_id' => $branchId,
            'hire_date' => '2024-01-01',
            'employment_status' => 'Regular',
            'employment_type' => 'Full-time',
            'pay_frequency' => 'Monthly',
            'basic_salary' => 30000,
            'emergency_contacts' => json_encode([]),
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
