<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\CompanyBranch;
use App\Models\CostCenter;
use App\Models\EmploymentStatus;
use App\Models\WorkSchedule;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class QuickLookupSeeder extends Seeder
{
    public function run(): void
    {
        $company = Company::first();

        // Company Branch
        if (CompanyBranch::count() == 0) {
            CompanyBranch::create([
                'uuid' => Str::uuid(),
                'company_id' => $company->id,
                'name' => 'Main Office',
                'code' => 'MAIN',
                'address' => '123 Main Street',
                'city' => 'Manila',
                'state' => 'NCR',
                'postal_code' => '1000',
                'country' => 'Philippines',
                'is_active' => true,
            ]);
        }

        // Cost Center
        if (CostCenter::count() == 0) {
            CostCenter::create([
                'uuid' => Str::uuid(),
                'company_id' => $company->id,
                'name' => 'General Administration',
                'code' => 'GA001',
                'is_active' => true,
            ]);
        }

        // Work Schedule
        if (WorkSchedule::count() == 0) {
            WorkSchedule::create([
                'uuid' => Str::uuid(),
                'company_id' => $company->id,
                'name' => 'Standard Office Hours',
                'code' => 'STD',
                'start_time' => '09:00:00',
                'end_time' => '17:00:00',
                'break_duration' => 60,
                'working_days' => json_encode(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday']),
                'is_active' => true,
            ]);
        }

        // Employment Status
        if (EmploymentStatus::count() == 0) {
            EmploymentStatus::create([
                'uuid' => Str::uuid(),
                'company_id' => $company->id,
                'name' => 'Active',
                'code' => 'ACT',
                'is_active' => true,
            ]);
        }
    }
}
