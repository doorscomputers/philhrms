<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PhilippineSalaryGradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Based on Philippine Government Salary Standardization Law (SSL) 2024 rates
        $salaryGrades = [
            ['code' => 'SG-1', 'name' => 'Salary Grade 1', 'level' => 1, 'min_salary' => 13000.00, 'mid_salary' => 14625.00, 'max_salary' => 16250.00],
            ['code' => 'SG-2', 'name' => 'Salary Grade 2', 'level' => 2, 'min_salary' => 14000.00, 'mid_salary' => 15750.00, 'max_salary' => 17500.00],
            ['code' => 'SG-3', 'name' => 'Salary Grade 3', 'level' => 3, 'min_salary' => 15000.00, 'mid_salary' => 16875.00, 'max_salary' => 18750.00],
            ['code' => 'SG-4', 'name' => 'Salary Grade 4', 'level' => 4, 'min_salary' => 16000.00, 'mid_salary' => 18000.00, 'max_salary' => 20000.00],
            ['code' => 'SG-5', 'name' => 'Salary Grade 5', 'level' => 5, 'min_salary' => 17500.00, 'mid_salary' => 19687.50, 'max_salary' => 21875.00],
            ['code' => 'SG-6', 'name' => 'Salary Grade 6', 'level' => 6, 'min_salary' => 19000.00, 'mid_salary' => 21375.00, 'max_salary' => 23750.00],
            ['code' => 'SG-7', 'name' => 'Salary Grade 7', 'level' => 7, 'min_salary' => 20500.00, 'mid_salary' => 23062.50, 'max_salary' => 25625.00],
            ['code' => 'SG-8', 'name' => 'Salary Grade 8', 'level' => 8, 'min_salary' => 22000.00, 'mid_salary' => 24750.00, 'max_salary' => 27500.00],
            ['code' => 'SG-9', 'name' => 'Salary Grade 9', 'level' => 9, 'min_salary' => 23500.00, 'mid_salary' => 26437.50, 'max_salary' => 29375.00],
            ['code' => 'SG-10', 'name' => 'Salary Grade 10', 'level' => 10, 'min_salary' => 25000.00, 'mid_salary' => 28125.00, 'max_salary' => 31250.00],
            ['code' => 'SG-11', 'name' => 'Salary Grade 11', 'level' => 11, 'min_salary' => 27000.00, 'mid_salary' => 30375.00, 'max_salary' => 33750.00],
            ['code' => 'SG-12', 'name' => 'Salary Grade 12', 'level' => 12, 'min_salary' => 29000.00, 'mid_salary' => 32625.00, 'max_salary' => 36250.00],
            ['code' => 'SG-13', 'name' => 'Salary Grade 13', 'level' => 13, 'min_salary' => 31000.00, 'mid_salary' => 34875.00, 'max_salary' => 38750.00],
            ['code' => 'SG-14', 'name' => 'Salary Grade 14', 'level' => 14, 'min_salary' => 33000.00, 'mid_salary' => 37125.00, 'max_salary' => 41250.00],
            ['code' => 'SG-15', 'name' => 'Salary Grade 15', 'level' => 15, 'min_salary' => 35000.00, 'mid_salary' => 39375.00, 'max_salary' => 43750.00],
            ['code' => 'SG-16', 'name' => 'Salary Grade 16', 'level' => 16, 'min_salary' => 37000.00, 'mid_salary' => 41625.00, 'max_salary' => 46250.00],
            ['code' => 'SG-17', 'name' => 'Salary Grade 17', 'level' => 17, 'min_salary' => 39000.00, 'mid_salary' => 43875.00, 'max_salary' => 48750.00],
            ['code' => 'SG-18', 'name' => 'Salary Grade 18', 'level' => 18, 'min_salary' => 42000.00, 'mid_salary' => 47250.00, 'max_salary' => 52500.00],
            ['code' => 'SG-19', 'name' => 'Salary Grade 19', 'level' => 19, 'min_salary' => 45000.00, 'mid_salary' => 50625.00, 'max_salary' => 56250.00],
            ['code' => 'SG-20', 'name' => 'Salary Grade 20', 'level' => 20, 'min_salary' => 48000.00, 'mid_salary' => 54000.00, 'max_salary' => 60000.00],
            ['code' => 'SG-21', 'name' => 'Salary Grade 21', 'level' => 21, 'min_salary' => 52000.00, 'mid_salary' => 58500.00, 'max_salary' => 65000.00],
            ['code' => 'SG-22', 'name' => 'Salary Grade 22', 'level' => 22, 'min_salary' => 56000.00, 'mid_salary' => 63000.00, 'max_salary' => 70000.00],
            ['code' => 'SG-23', 'name' => 'Salary Grade 23', 'level' => 23, 'min_salary' => 60000.00, 'mid_salary' => 67500.00, 'max_salary' => 75000.00],
            ['code' => 'SG-24', 'name' => 'Salary Grade 24', 'level' => 24, 'min_salary' => 65000.00, 'mid_salary' => 73125.00, 'max_salary' => 81250.00],
            ['code' => 'SG-25', 'name' => 'Salary Grade 25', 'level' => 25, 'min_salary' => 70000.00, 'mid_salary' => 78750.00, 'max_salary' => 87500.00],
            ['code' => 'SG-26', 'name' => 'Salary Grade 26', 'level' => 26, 'min_salary' => 75000.00, 'mid_salary' => 84375.00, 'max_salary' => 93750.00],
            ['code' => 'SG-27', 'name' => 'Salary Grade 27', 'level' => 27, 'min_salary' => 80000.00, 'mid_salary' => 90000.00, 'max_salary' => 100000.00],
            ['code' => 'SG-28', 'name' => 'Salary Grade 28', 'level' => 28, 'min_salary' => 85000.00, 'mid_salary' => 95625.00, 'max_salary' => 106250.00],
            ['code' => 'SG-29', 'name' => 'Salary Grade 29', 'level' => 29, 'min_salary' => 90000.00, 'mid_salary' => 101250.00, 'max_salary' => 112500.00],
            ['code' => 'SG-30', 'name' => 'Salary Grade 30', 'level' => 30, 'min_salary' => 95000.00, 'mid_salary' => 106875.00, 'max_salary' => 118750.00],
            ['code' => 'SG-31', 'name' => 'Salary Grade 31', 'level' => 31, 'min_salary' => 100000.00, 'mid_salary' => 112500.00, 'max_salary' => 125000.00],
            ['code' => 'SG-32', 'name' => 'Salary Grade 32', 'level' => 32, 'min_salary' => 110000.00, 'mid_salary' => 123750.00, 'max_salary' => 137500.00],
            ['code' => 'SG-33', 'name' => 'Salary Grade 33', 'level' => 33, 'min_salary' => 120000.00, 'mid_salary' => 135000.00, 'max_salary' => 150000.00],
        ];

        foreach ($salaryGrades as $grade) {
            \App\Models\JobGrade::create([
                'company_id' => 1, // Default company
                'code' => $grade['code'],
                'name' => $grade['name'],
                'description' => 'Philippine Government Salary Grade '.$grade['level'],
                'level' => $grade['level'],
                'min_salary' => $grade['min_salary'],
                'mid_salary' => $grade['mid_salary'],
                'max_salary' => $grade['max_salary'],
                'is_active' => true,
            ]);
        }
    }
}
