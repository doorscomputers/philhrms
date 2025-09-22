<?php

namespace App\Console\Commands;

use App\Http\Requests\StoreDepartmentRequest;
use App\Models\Company;
use App\Models\Department;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class TestDepartmentAdd extends Command
{
    protected $signature = 'test:department-add';

    protected $description = 'Test Department Quick Add functionality';

    public function handle()
    {
        $this->info('Testing Department Quick Add functionality...');

        // Test data from the modal
        $uniqueCode = 'TEST'.time();
        $data = [
            'company_id' => 1,
            'code' => $uniqueCode,
            'name' => 'Test Department',
            'description' => 'Test description',
            'budget_amount' => 50000,
            'max_headcount' => 10,
            'level' => 1,
            'is_active' => true,
        ];

        $this->info('Data to submit:');
        $this->table(['Field', 'Value'], collect($data)->map(function ($value, $key) {
            return [$key, $value];
        })->toArray());

        // Test validation rules
        $this->info('=== Testing Validation Rules ===');
        $request = new StoreDepartmentRequest;
        $rules = $request->rules();
        $this->table(['Field', 'Rule'], collect($rules)->map(function ($rule, $field) {
            return [$field, $rule];
        })->toArray());

        // Test validation
        $this->info('=== Testing Data Validation ===');
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            $this->error('VALIDATION FAILED:');
            foreach ($validator->errors()->toArray() as $field => $errors) {
                $this->error("$field: ".implode(', ', $errors));
            }
        } else {
            $this->info('Validation PASSED!');
        }

        // Check if company exists
        $this->info('=== Checking Company Exists ===');
        $company = Company::find(1);
        if ($company) {
            $this->info("Company ID 1 exists: {$company->name}");
        } else {
            $this->error('ERROR: Company ID 1 does not exist!');
        }

        // Try to create the department
        $this->info('=== Attempting to Create Department ===');
        try {
            // Check if code already exists
            $existing = Department::where('code', $uniqueCode)->first();
            if ($existing) {
                $this->info("Department with code {$uniqueCode} already exists, deleting it first...");
                $existing->delete();
            }

            $department = Department::create($data);
            $this->info("SUCCESS: Department created with ID {$department->id}");

            // Clean up
            $department->delete();
            $this->info('Test department deleted.');

        } catch (\Exception $e) {
            $this->error('ERROR creating department: '.$e->getMessage());
        }

        $this->info('Test completed.');
    }
}
