<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\CompanyBranch;
use App\Models\Department;
use App\Models\JobGrade;
use App\Models\Position;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class QuickDataSeeder extends Seeder
{
    public function run(): void
    {
        // Create or get company
        $company = Company::updateOrCreate(
            ['code' => 'PHHRMS001'],
            [
                'uuid' => Str::uuid(),
                'code' => 'PHHRMS001',
                'name' => 'PH-HRMS Test Company',
                'legal_name' => 'PH-HRMS Test Company Inc.',
                'business_type' => 'Corporation',
                'industry' => 'Technology',
                'tin' => '123-456-789-000',
                'bir_rdo_code' => '050',
                'addresses' => [['type' => 'Main Office', 'address' => '123 Test Street', 'city' => 'Makati', 'province' => 'Metro Manila']],
                'contact_numbers' => ['02-1234567'],
                'email_addresses' => ['info@phhrms.com'],
                'date_established' => '2020-01-01',
                'settings' => [],
                'status' => 'Active',
            ]
        );

        // Create branch
        $branch = CompanyBranch::updateOrCreate(
            ['company_id' => $company->id, 'name' => 'Main Office'],
            [
                'code' => 'MAIN',
                'address' => '123 Main Street',
                'city' => 'Makati City',
                'province' => 'Metro Manila',
                'region' => 'NCR',
                'is_active' => true,
            ]
        );

        // Create departments
        $departments = [
            ['code' => 'HR', 'name' => 'Human Resources'],
            ['code' => 'IT', 'name' => 'Information Technology'],
            ['code' => 'ACCT', 'name' => 'Accounting'],
            ['code' => 'ENG', 'name' => 'Engineering'],
        ];

        foreach ($departments as $dept) {
            Department::updateOrCreate(
                ['code' => $dept['code'], 'company_id' => $company->id],
                [
                    'company_id' => $company->id,
                    'code' => $dept['code'],
                    'name' => $dept['name'],
                    'is_active' => true,
                ]
            );
        }

        // Create job grades
        $jobGrades = [
            ['name' => 'Entry Level', 'min_salary' => 25000, 'max_salary' => 35000],
            ['name' => 'Mid Level', 'min_salary' => 35000, 'max_salary' => 55000],
            ['name' => 'Senior Level', 'min_salary' => 55000, 'max_salary' => 85000],
            ['name' => 'Management', 'min_salary' => 85000, 'max_salary' => 150000],
        ];

        foreach ($jobGrades as $grade) {
            JobGrade::updateOrCreate(
                ['name' => $grade['name']],
                [
                    'name' => $grade['name'],
                    'min_salary' => $grade['min_salary'],
                    'max_salary' => $grade['max_salary'],
                    'is_active' => true,
                ]
            );
        }

        // Get created departments for positions
        $hrDept = Department::where('code', 'HR')->first();
        $itDept = Department::where('code', 'IT')->first();
        $acctDept = Department::where('code', 'ACCT')->first();
        $engDept = Department::where('code', 'ENG')->first();
        $firstJobGrade = JobGrade::first();

        // Create positions
        $positions = [
            ['title' => 'HR Manager', 'department_id' => $hrDept->id],
            ['title' => 'Software Developer', 'department_id' => $itDept->id],
            ['title' => 'Senior Developer', 'department_id' => $itDept->id],
            ['title' => 'Accountant', 'department_id' => $acctDept->id],
            ['title' => 'Project Manager', 'department_id' => $engDept->id],
        ];

        foreach ($positions as $pos) {
            Position::updateOrCreate(
                ['title' => $pos['title'], 'company_id' => $company->id],
                [
                    'company_id' => $company->id,
                    'title' => $pos['title'],
                    'department_id' => $pos['department_id'],
                    'job_grade_id' => $firstJobGrade->id,
                    'is_active' => true,
                ]
            );
        }

        echo "Quick data seeded successfully!\n";
    }
}
