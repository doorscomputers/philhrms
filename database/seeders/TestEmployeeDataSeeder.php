<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;

class TestEmployeeDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update the first employee with test emergency contact and document data
        $employee = Employee::first();

        if ($employee) {
            $employee->update([
                'emergency_contacts' => [
                    [
                        'name' => 'Maria Santos',
                        'phone' => '09171234567',
                        'relationship' => 'Spouse'
                    ]
                ],
                'documents' => [
                    [
                        'name' => 'Employee_Contract.pdf',
                        'path' => 'employee_documents/sample_contract.pdf',
                        'type' => 'application/pdf',
                        'size' => 512000,
                        'uploaded_at' => now()->toDateTimeString()
                    ],
                    [
                        'name' => 'ID_Scan.jpg',
                        'path' => 'employee_documents/sample_id.jpg',
                        'type' => 'image/jpeg',
                        'size' => 256000,
                        'uploaded_at' => now()->toDateTimeString()
                    ]
                ]
            ]);

            $this->command->info('Updated employee ID: ' . $employee->id . ' with test data');
        } else {
            $this->command->error('No employees found to update');
        }
    }
}