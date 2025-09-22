<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\CompanyBranch;
use App\Models\Department;
use App\Models\Employee;
use App\Models\JobGrade;
use App\Models\Position;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class BasicTestDataSeeder extends Seeder
{
    public function run()
    {
        // Create Company
        $company = Company::updateOrCreate(
            ['code' => 'PHHRMS001'],
            [
                'uuid' => \Str::uuid(),
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

        // Create User
        $user = User::updateOrCreate(
            ['email' => 'admin@test.com'],
            [
                'uuid' => \Str::uuid(),
                'company_id' => $company->id,
                'username' => 'admin',
                'email' => 'admin@test.com',
                'password' => Hash::make('password'),
                'first_name' => 'Admin',
                'last_name' => 'User',
                'status' => 'Active',
            ]
        );

        // Create Departments
        $departments = [
            ['code' => 'HR', 'name' => 'Human Resources', 'company_id' => $company->id, 'is_active' => true],
            ['code' => 'IT', 'name' => 'Information Technology', 'company_id' => $company->id, 'is_active' => true],
            ['code' => 'ACCT', 'name' => 'Accounting', 'company_id' => $company->id, 'is_active' => true],
            ['code' => 'ENG', 'name' => 'Engineering', 'company_id' => $company->id, 'is_active' => true],
        ];

        foreach ($departments as $dept) {
            Department::updateOrCreate(
                ['code' => $dept['code'], 'company_id' => $company->id],
                $dept
            );
        }

        // Get created departments
        $hrDept = Department::where('code', 'HR')->first();
        $itDept = Department::where('code', 'IT')->first();
        $acctDept = Department::where('code', 'ACCT')->first();
        $engDept = Department::where('code', 'ENG')->first();

        // Create Positions
        $positions = [
            ['title' => 'HR Manager', 'company_id' => $company->id, 'department_id' => $hrDept->id, 'is_active' => true],
            ['title' => 'Software Developer', 'company_id' => $company->id, 'department_id' => $itDept->id, 'is_active' => true],
            ['title' => 'Accountant', 'company_id' => $company->id, 'department_id' => $acctDept->id, 'is_active' => true],
            ['title' => 'Project Manager', 'company_id' => $company->id, 'department_id' => $engDept->id, 'is_active' => true],
            ['title' => 'Senior Developer', 'company_id' => $company->id, 'department_id' => $itDept->id, 'is_active' => true],
        ];

        foreach ($positions as $pos) {
            Position::updateOrCreate(
                ['title' => $pos['title'], 'company_id' => $company->id],
                $pos
            );
        }

        // Create Job Grades
        $jobGrades = [
            ['name' => 'Entry Level', 'min_salary' => 25000, 'max_salary' => 35000, 'is_active' => true],
            ['name' => 'Mid Level', 'min_salary' => 35000, 'max_salary' => 55000, 'is_active' => true],
            ['name' => 'Senior Level', 'min_salary' => 55000, 'max_salary' => 85000, 'is_active' => true],
            ['name' => 'Management', 'min_salary' => 85000, 'max_salary' => 150000, 'is_active' => true],
        ];

        foreach ($jobGrades as $grade) {
            JobGrade::create($grade);
        }

        // Create Company Branch
        $branch = CompanyBranch::create([
            'company_id' => $company->id,
            'name' => 'Main Office',
            'address' => '123 Main Street, Makati City',
            'is_active' => true,
        ]);

        // Create Sample Employees
        $employees = [
            [
                'company_id' => $company->id,
                'employee_id' => 'EMP001',
                'first_name' => 'Juan',
                'middle_name' => 'Santos',
                'last_name' => 'Dela Cruz',
                'birth_date' => '1990-05-15',
                'gender' => 'Male',
                'civil_status' => 'Single',
                'department_id' => 2,
                'position_id' => 2,
                'job_grade_id' => 2,
                'branch_id' => $branch->id,
                'employment_status' => 'Regular',
                'hire_date' => '2023-01-15',
                'basic_salary' => 45000,
                'is_active' => true,
                'contact_numbers' => ['09171234567'],
                'email_addresses' => ['juan.delacruz@test.com'],
                'addresses' => [
                    [
                        'type' => 'Home',
                        'address' => '456 Sample Street',
                        'city' => 'Quezon City',
                        'province' => 'Metro Manila',
                    ],
                ],
            ],
            [
                'company_id' => $company->id,
                'employee_id' => 'EMP002',
                'first_name' => 'Maria',
                'middle_name' => 'Garcia',
                'last_name' => 'Santos',
                'birth_date' => '1988-03-20',
                'gender' => 'Female',
                'civil_status' => 'Married',
                'department_id' => 1,
                'position_id' => 1,
                'job_grade_id' => 3,
                'branch_id' => $branch->id,
                'employment_status' => 'Regular',
                'hire_date' => '2022-06-01',
                'basic_salary' => 65000,
                'is_active' => true,
                'contact_numbers' => ['09189876543'],
                'email_addresses' => ['maria.santos@test.com'],
                'addresses' => [
                    [
                        'type' => 'Home',
                        'address' => '789 Another Street',
                        'city' => 'Makati City',
                        'province' => 'Metro Manila',
                    ],
                ],
            ],
            [
                'company_id' => $company->id,
                'employee_id' => 'EMP003',
                'first_name' => 'Robert',
                'middle_name' => 'Lee',
                'last_name' => 'Tan',
                'birth_date' => '1985-12-10',
                'gender' => 'Male',
                'civil_status' => 'Married',
                'department_id' => 2,
                'position_id' => 5,
                'job_grade_id' => 3,
                'branch_id' => $branch->id,
                'employment_status' => 'Regular',
                'hire_date' => '2021-03-15',
                'basic_salary' => 75000,
                'is_active' => true,
                'contact_numbers' => ['09176543210'],
                'email_addresses' => ['robert.tan@test.com'],
                'addresses' => [
                    [
                        'type' => 'Home',
                        'address' => '321 Tech Street',
                        'city' => 'Pasig City',
                        'province' => 'Metro Manila',
                    ],
                ],
            ],
        ];

        foreach ($employees as $emp) {
            Employee::create($emp);
        }

        echo "Basic test data created successfully!\n";
        echo "Login with: admin@test.com / password\n";
    }
}
