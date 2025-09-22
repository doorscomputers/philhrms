<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\CompanyBranch;
use App\Models\Department;
use App\Models\Employee;
use App\Models\JobGrade;
use App\Models\Position;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $company = Company::first();
        $departments = Department::all();
        $positions = Position::all();
        $jobGrades = JobGrade::all();
        $branch = CompanyBranch::first();

        if (! $company || $departments->isEmpty() || $positions->isEmpty()) {
            echo "Required data (company, departments, positions) not found. Please run the main seeder first.\n";

            return;
        }

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
                'department_id' => $departments->where('name', 'Information Technology')->first()->id ?? $departments->first()->id,
                'position_id' => $positions->where('title', 'Software Developer')->first()->id ?? $positions->first()->id,
                'job_grade_id' => $jobGrades->where('name', 'Mid Level')->first()->id ?? $jobGrades->first()->id ?? 1,
                'branch_id' => $branch->id ?? 1,
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
                'department_id' => $departments->where('name', 'Human Resources')->first()->id ?? $departments->first()->id,
                'position_id' => $positions->where('title', 'HR Manager')->first()->id ?? $positions->first()->id,
                'job_grade_id' => $jobGrades->where('name', 'Senior Level')->first()->id ?? $jobGrades->first()->id ?? 1,
                'branch_id' => $branch->id ?? 1,
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
                'department_id' => $departments->where('name', 'Information Technology')->first()->id ?? $departments->first()->id,
                'position_id' => $positions->where('title', 'Senior Developer')->first()->id ?? $positions->first()->id,
                'job_grade_id' => $jobGrades->where('name', 'Senior Level')->first()->id ?? $jobGrades->first()->id ?? 1,
                'branch_id' => $branch->id ?? 1,
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
            Employee::updateOrCreate(
                ['employee_id' => $emp['employee_id']],
                $emp
            );
        }

        echo "Employees created successfully!\n";
    }
}
