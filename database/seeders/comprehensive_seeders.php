<?php

// =======================================================================================
// COMPREHENSIVE SEEDERS FOR COMPLETE HRMS SYSTEM
// =======================================================================================

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\*;
use Carbon\Carbon;

// =======================================================================================
// PHILIPPINE HOLIDAYS SEEDER
// =======================================================================================

class PhilippineHolidaysSeeder extends Seeder
{
    public function run()
    {
        $currentYear = now()->year;
        $nextYear = $currentYear + 1;

        $holidays = $this->getPhilippineHolidays($currentYear);
        $holidays = array_merge($holidays, $this->getPhilippineHolidays($nextYear));

        foreach ($holidays as $holiday) {
            Holiday::create($holiday);
        }
    }

    private function getPhilippineHolidays(int $year): array
    {
        return [
            // Regular Holidays
            [
                'company_id' => 1,
                'holiday_name' => 'New Year\'s Day',
                'description' => 'First day of the Gregorian calendar year',
                'holiday_type' => 'Regular Holiday',
                'scope' => 'National',
                'holiday_date' => Carbon::create($year, 1, 1),
                'holiday_year' => $year,
                'is_recurring' => true,
                'pay_multiplier' => 2.00,
                'requires_work_for_pay' => false,
                'affects_overtime_calculation' => true,
                'legal_basis' => 'Republic Act No. 9492',
            ],
            [
                'company_id' => 1,
                'holiday_name' => 'Maundy Thursday',
                'description' => 'Thursday before Easter Sunday',
                'holiday_type' => 'Regular Holiday',
                'scope' => 'National',
                'holiday_date' => $this->getEasterDate($year)->subDays(3),
                'holiday_year' => $year,
                'is_recurring' => true,
                'pay_multiplier' => 2.00,
                'requires_work_for_pay' => false,
                'affects_overtime_calculation' => true,
                'legal_basis' => 'Republic Act No. 9492',
            ],
            [
                'company_id' => 1,
                'holiday_name' => 'Good Friday',
                'description' => 'Friday before Easter Sunday',
                'holiday_type' => 'Regular Holiday',
                'scope' => 'National',
                'holiday_date' => $this->getEasterDate($year)->subDays(2),
                'holiday_year' => $year,
                'is_recurring' => true,
                'pay_multiplier' => 2.00,
                'requires_work_for_pay' => false,
                'affects_overtime_calculation' => true,
                'legal_basis' => 'Republic Act No. 9492',
            ],
            [
                'company_id' => 1,
                'holiday_name' => 'Araw ng Kagitingan (Day of Valor)',
                'description' => 'Commemoration of the fall of Bataan',
                'holiday_type' => 'Regular Holiday',
                'scope' => 'National',
                'holiday_date' => Carbon::create($year, 4, 9),
                'holiday_year' => $year,
                'is_recurring' => true,
                'pay_multiplier' => 2.00,
                'requires_work_for_pay' => false,
                'affects_overtime_calculation' => true,
                'legal_basis' => 'Republic Act No. 9492',
            ],
            [
                'company_id' => 1,
                'holiday_name' => 'Labor Day',
                'description' => 'International Workers\' Day',
                'holiday_type' => 'Regular Holiday',
                'scope' => 'National',
                'holiday_date' => Carbon::create($year, 5, 1),
                'holiday_year' => $year,
                'is_recurring' => true,
                'pay_multiplier' => 2.00,
                'requires_work_for_pay' => false,
                'affects_overtime_calculation' => true,
                'legal_basis' => 'Republic Act No. 9492',
            ],
            [
                'company_id' => 1,
                'holiday_name' => 'Independence Day',
                'description' => 'Philippine Declaration of Independence from Spain',
                'holiday_type' => 'Regular Holiday',
                'scope' => 'National',
                'holiday_date' => Carbon::create($year, 6, 12),
                'holiday_year' => $year,
                'is_recurring' => true,
                'pay_multiplier' => 2.00,
                'requires_work_for_pay' => false,
                'affects_overtime_calculation' => true,
                'legal_basis' => 'Republic Act No. 9492',
            ],
            [
                'company_id' => 1,
                'holiday_name' => 'National Heroes Day',
                'description' => 'Honoring Filipino heroes',
                'holiday_type' => 'Regular Holiday',
                'scope' => 'National',
                'holiday_date' => $this->getLastMondayOfAugust($year),
                'holiday_year' => $year,
                'is_recurring' => true,
                'pay_multiplier' => 2.00,
                'requires_work_for_pay' => false,
                'affects_overtime_calculation' => true,
                'legal_basis' => 'Republic Act No. 9492',
            ],
            [
                'company_id' => 1,
                'holiday_name' => 'Bonifacio Day',
                'description' => 'Birthday of Andres Bonifacio',
                'holiday_type' => 'Regular Holiday',
                'scope' => 'National',
                'holiday_date' => Carbon::create($year, 11, 30),
                'holiday_year' => $year,
                'is_recurring' => true,
                'pay_multiplier' => 2.00,
                'requires_work_for_pay' => false,
                'affects_overtime_calculation' => true,
                'legal_basis' => 'Republic Act No. 9492',
            ],
            [
                'company_id' => 1,
                'holiday_name' => 'Christmas Day',
                'description' => 'Birth of Jesus Christ',
                'holiday_type' => 'Regular Holiday',
                'scope' => 'National',
                'holiday_date' => Carbon::create($year, 12, 25),
                'holiday_year' => $year,
                'is_recurring' => true,
                'pay_multiplier' => 2.00,
                'requires_work_for_pay' => false,
                'affects_overtime_calculation' => true,
                'legal_basis' => 'Republic Act No. 9492',
            ],
            [
                'company_id' => 1,
                'holiday_name' => 'Rizal Day',
                'description' => 'Death anniversary of Dr. Jose Rizal',
                'holiday_type' => 'Regular Holiday',
                'scope' => 'National',
                'holiday_date' => Carbon::create($year, 12, 30),
                'holiday_year' => $year,
                'is_recurring' => true,
                'pay_multiplier' => 2.00,
                'requires_work_for_pay' => false,
                'affects_overtime_calculation' => true,
                'legal_basis' => 'Republic Act No. 9492',
            ],

            // Special Non-Working Holidays
            [
                'company_id' => 1,
                'holiday_name' => 'Chinese New Year',
                'description' => 'First day of the Chinese calendar',
                'holiday_type' => 'Special Non-Working Holiday',
                'scope' => 'National',
                'holiday_date' => $this->getChineseNewYear($year),
                'holiday_year' => $year,
                'is_recurring' => true,
                'pay_multiplier' => 1.30,
                'requires_work_for_pay' => true,
                'affects_overtime_calculation' => true,
                'legal_basis' => 'Republic Act No. 9492',
            ],
            [
                'company_id' => 1,
                'holiday_name' => 'EDSA People Power Revolution Anniversary',
                'description' => 'Anniversary of the People Power Revolution',
                'holiday_type' => 'Special Non-Working Holiday',
                'scope' => 'National',
                'holiday_date' => Carbon::create($year, 2, 25),
                'holiday_year' => $year,
                'is_recurring' => true,
                'pay_multiplier' => 1.30,
                'requires_work_for_pay' => true,
                'affects_overtime_calculation' => true,
                'legal_basis' => 'Republic Act No. 9492',
            ],
            [
                'company_id' => 1,
                'holiday_name' => 'Black Saturday',
                'description' => 'Saturday before Easter Sunday',
                'holiday_type' => 'Special Non-Working Holiday',
                'scope' => 'National',
                'holiday_date' => $this->getEasterDate($year)->subDays(1),
                'holiday_year' => $year,
                'is_recurring' => true,
                'pay_multiplier' => 1.30,
                'requires_work_for_pay' => true,
                'affects_overtime_calculation' => true,
                'legal_basis' => 'Republic Act No. 9492',
            ],
            [
                'company_id' => 1,
                'holiday_name' => 'Ninoy Aquino Day',
                'description' => 'Death anniversary of Benigno "Ninoy" Aquino Jr.',
                'holiday_type' => 'Special Non-Working Holiday',
                'scope' => 'National',
                'holiday_date' => Carbon::create($year, 8, 21),
                'holiday_year' => $year,
                'is_recurring' => true,
                'pay_multiplier' => 1.30,
                'requires_work_for_pay' => true,
                'affects_overtime_calculation' => true,
                'legal_basis' => 'Republic Act No. 9492',
            ],
            [
                'company_id' => 1,
                'holiday_name' => 'All Saints\' Day',
                'description' => 'Christian festival honoring all saints',
                'holiday_type' => 'Special Non-Working Holiday',
                'scope' => 'National',
                'holiday_date' => Carbon::create($year, 11, 1),
                'holiday_year' => $year,
                'is_recurring' => true,
                'pay_multiplier' => 1.30,
                'requires_work_for_pay' => true,
                'affects_overtime_calculation' => true,
                'legal_basis' => 'Republic Act No. 9492',
            ],
            [
                'company_id' => 1,
                'holiday_name' => 'All Souls\' Day',
                'description' => 'Day of prayer for the dead',
                'holiday_type' => 'Special Non-Working Holiday',
                'scope' => 'National',
                'holiday_date' => Carbon::create($year, 11, 2),
                'holiday_year' => $year,
                'is_recurring' => true,
                'pay_multiplier' => 1.30,
                'requires_work_for_pay' => true,
                'affects_overtime_calculation' => true,
                'legal_basis' => 'Republic Act No. 9492',
            ],
            [
                'company_id' => 1,
                'holiday_name' => 'Immaculate Conception',
                'description' => 'Catholic dogma of the Immaculate Conception',
                'holiday_type' => 'Special Non-Working Holiday',
                'scope' => 'National',
                'holiday_date' => Carbon::create($year, 12, 8),
                'holiday_year' => $year,
                'is_recurring' => true,
                'pay_multiplier' => 1.30,
                'requires_work_for_pay' => true,
                'affects_overtime_calculation' => true,
                'legal_basis' => 'Republic Act No. 9492',
            ],
            [
                'company_id' => 1,
                'holiday_name' => 'New Year\'s Eve',
                'description' => 'Last day of the Gregorian calendar year',
                'holiday_type' => 'Special Non-Working Holiday',
                'scope' => 'National',
                'holiday_date' => Carbon::create($year, 12, 31),
                'holiday_year' => $year,
                'is_recurring' => true,
                'pay_multiplier' => 1.30,
                'requires_work_for_pay' => true,
                'affects_overtime_calculation' => true,
                'legal_basis' => 'Republic Act No. 9492',
            ],
        ];
    }

    private function getEasterDate(int $year): Carbon
    {
        // Algorithm to calculate Easter date
        $a = $year % 19;
        $b = intval($year / 100);
        $c = $year % 100;
        $d = intval($b / 4);
        $e = $b % 4;
        $f = intval(($b + 8) / 25);
        $g = intval(($b - $f + 1) / 3);
        $h = (19 * $a + $b - $d - $g + 15) % 30;
        $i = intval($c / 4);
        $k = $c % 4;
        $l = (32 + 2 * $e + 2 * $i - $h - $k) % 7;
        $m = intval(($a + 11 * $h + 22 * $l) / 451);
        $month = intval(($h + $l - 7 * $m + 114) / 31);
        $day = (($h + $l - 7 * $m + 114) % 31) + 1;

        return Carbon::create($year, $month, $day);
    }

    private function getLastMondayOfAugust(int $year): Carbon
    {
        $lastDay = Carbon::create($year, 8, 31);

        while ($lastDay->dayOfWeek !== Carbon::MONDAY) {
            $lastDay->subDay();
        }

        return $lastDay;
    }

    private function getChineseNewYear(int $year): Carbon
    {
        // Simplified - actual dates would need to be looked up
        $chineseNewYearDates = [
            2024 => Carbon::create(2024, 2, 10),
            2025 => Carbon::create(2025, 1, 29),
            2026 => Carbon::create(2026, 2, 17),
        ];

        return $chineseNewYearDates[$year] ?? Carbon::create($year, 2, 1);
    }
}

// =======================================================================================
// GOVERNMENT RATES SEEDER
// =======================================================================================

class GovernmentRatesSeeder extends Seeder
{
    public function run()
    {
        $this->seedSSSRates();
        $this->seedPhilHealthRates();
        $this->seedPagIBIGRates();
        $this->seedTaxTables();
    }

    private function seedSSSRates()
    {
        $sssRates = [
            ['salary_from' => 0, 'salary_to' => 4249.99, 'employee_amount' => 180, 'employer_amount' => 380],
            ['salary_from' => 4250, 'salary_to' => 4749.99, 'employee_amount' => 202.50, 'employer_amount' => 427.50],
            ['salary_from' => 4750, 'salary_to' => 5249.99, 'employee_amount' => 225, 'employer_amount' => 475],
            ['salary_from' => 5250, 'salary_to' => 5749.99, 'employee_amount' => 247.50, 'employer_amount' => 522.50],
            ['salary_from' => 5750, 'salary_to' => 6249.99, 'employee_amount' => 270, 'employer_amount' => 570],
            ['salary_from' => 6250, 'salary_to' => 6749.99, 'employee_amount' => 292.50, 'employer_amount' => 617.50],
            ['salary_from' => 6750, 'salary_to' => 7249.99, 'employee_amount' => 315, 'employer_amount' => 665],
            ['salary_from' => 7250, 'salary_to' => 7749.99, 'employee_amount' => 337.50, 'employer_amount' => 712.50],
            ['salary_from' => 7750, 'salary_to' => 8249.99, 'employee_amount' => 360, 'employer_amount' => 760],
            ['salary_from' => 8250, 'salary_to' => 8749.99, 'employee_amount' => 382.50, 'employer_amount' => 807.50],
            ['salary_from' => 8750, 'salary_to' => 9249.99, 'employee_amount' => 405, 'employer_amount' => 855],
            ['salary_from' => 9250, 'salary_to' => 9749.99, 'employee_amount' => 427.50, 'employer_amount' => 902.50],
            ['salary_from' => 9750, 'salary_to' => 10249.99, 'employee_amount' => 450, 'employer_amount' => 950],
            ['salary_from' => 10250, 'salary_to' => 10749.99, 'employee_amount' => 472.50, 'employer_amount' => 997.50],
            ['salary_from' => 10750, 'salary_to' => 11249.99, 'employee_amount' => 495, 'employer_amount' => 1045],
            ['salary_from' => 11250, 'salary_to' => 11749.99, 'employee_amount' => 517.50, 'employer_amount' => 1092.50],
            ['salary_from' => 11750, 'salary_to' => 12249.99, 'employee_amount' => 540, 'employer_amount' => 1140],
            ['salary_from' => 12250, 'salary_to' => 12749.99, 'employee_amount' => 562.50, 'employer_amount' => 1187.50],
            ['salary_from' => 12750, 'salary_to' => 13249.99, 'employee_amount' => 585, 'employer_amount' => 1235],
            ['salary_from' => 13250, 'salary_to' => 13749.99, 'employee_amount' => 607.50, 'employer_amount' => 1282.50],
            ['salary_from' => 13750, 'salary_to' => 14249.99, 'employee_amount' => 630, 'employer_amount' => 1330],
            ['salary_from' => 14250, 'salary_to' => 14749.99, 'employee_amount' => 652.50, 'employer_amount' => 1377.50],
            ['salary_from' => 14750, 'salary_to' => 15249.99, 'employee_amount' => 675, 'employer_amount' => 1425],
            ['salary_from' => 15250, 'salary_to' => 15749.99, 'employee_amount' => 697.50, 'employer_amount' => 1472.50],
            ['salary_from' => 15750, 'salary_to' => 16249.99, 'employee_amount' => 720, 'employer_amount' => 1520],
            ['salary_from' => 16250, 'salary_to' => 16749.99, 'employee_amount' => 742.50, 'employer_amount' => 1567.50],
            ['salary_from' => 16750, 'salary_to' => 17249.99, 'employee_amount' => 765, 'employer_amount' => 1615],
            ['salary_from' => 17250, 'salary_to' => 17749.99, 'employee_amount' => 787.50, 'employer_amount' => 1662.50],
            ['salary_from' => 17750, 'salary_to' => 18249.99, 'employee_amount' => 810, 'employer_amount' => 1710],
            ['salary_from' => 18250, 'salary_to' => 18749.99, 'employee_amount' => 832.50, 'employer_amount' => 1757.50],
            ['salary_from' => 18750, 'salary_to' => 19249.99, 'employee_amount' => 855, 'employer_amount' => 1805],
            ['salary_from' => 19250, 'salary_to' => 19749.99, 'employee_amount' => 877.50, 'employer_amount' => 1852.50],
            ['salary_from' => 19750, 'salary_to' => null, 'employee_amount' => 900, 'employer_amount' => 1900],
        ];

        foreach ($sssRates as $rate) {
            GovernmentRate::create([
                'company_id' => 1,
                'type' => 'SSS',
                'effective_year' => now()->year,
                'salary_from' => $rate['salary_from'],
                'salary_to' => $rate['salary_to'],
                'employee_amount' => $rate['employee_amount'],
                'employer_amount' => $rate['employer_amount'],
                'total_amount' => $rate['employee_amount'] + $rate['employer_amount'],
            ]);
        }
    }

    private function seedPhilHealthRates()
    {
        $philHealthRates = [
            ['salary_from' => 0, 'salary_to' => 10000, 'employee_amount' => 500, 'employer_amount' => 500],
            ['salary_from' => 10000.01, 'salary_to' => 100000, 'employee_rate' => 0.05, 'employer_rate' => 0.05],
            ['salary_from' => 100000.01, 'salary_to' => null, 'employee_amount' => 5000, 'employer_amount' => 5000],
        ];

        foreach ($philHealthRates as $rate) {
            GovernmentRate::create([
                'company_id' => 1,
                'type' => 'PhilHealth',
                'effective_year' => now()->year,
                'salary_from' => $rate['salary_from'],
                'salary_to' => $rate['salary_to'],
                'employee_rate' => $rate['employee_rate'] ?? null,
                'employer_rate' => $rate['employer_rate'] ?? null,
                'employee_amount' => $rate['employee_amount'] ?? null,
                'employer_amount' => $rate['employer_amount'] ?? null,
            ]);
        }
    }

    private function seedPagIBIGRates()
    {
        $pagibigRates = [
            ['salary_from' => 0, 'salary_to' => 1500, 'employee_rate' => 0.01, 'employer_rate' => 0.02],
            ['salary_from' => 1500.01, 'salary_to' => 5000, 'employee_rate' => 0.02, 'employer_rate' => 0.02],
            ['salary_from' => 5000.01, 'salary_to' => null, 'employee_amount' => 100, 'employer_amount' => 100],
        ];

        foreach ($pagibigRates as $rate) {
            GovernmentRate::create([
                'company_id' => 1,
                'type' => 'Pag-IBIG',
                'effective_year' => now()->year,
                'salary_from' => $rate['salary_from'],
                'salary_to' => $rate['salary_to'],
                'employee_rate' => $rate['employee_rate'] ?? null,
                'employer_rate' => $rate['employer_rate'] ?? null,
                'employee_amount' => $rate['employee_amount'] ?? null,
                'employer_amount' => $rate['employer_amount'] ?? null,
            ]);
        }
    }

    private function seedTaxTables()
    {
        // Monthly Tax Table
        $monthlyTaxTable = [
            ['status' => 'S', 'income_from' => 0, 'income_to' => 25000, 'base_tax' => 0, 'tax_rate' => 0.00, 'excess_over' => 0],
            ['status' => 'S', 'income_from' => 25000.01, 'income_to' => 33333, 'base_tax' => 0, 'tax_rate' => 0.15, 'excess_over' => 25000],
            ['status' => 'S', 'income_from' => 33333.01, 'income_to' => 66667, 'base_tax' => 1250, 'tax_rate' => 0.20, 'excess_over' => 33333],
            ['status' => 'S', 'income_from' => 66667.01, 'income_to' => 166667, 'base_tax' => 8083.33, 'tax_rate' => 0.25, 'excess_over' => 66667],
            ['status' => 'S', 'income_from' => 166667.01, 'income_to' => 666667, 'base_tax' => 33083.33, 'tax_rate' => 0.30, 'excess_over' => 166667],
            ['status' => 'S', 'income_from' => 666667.01, 'income_to' => null, 'base_tax' => 183083.33, 'tax_rate' => 0.35, 'excess_over' => 666667],

            ['status' => 'ME', 'income_from' => 0, 'income_to' => 25000, 'base_tax' => 0, 'tax_rate' => 0.00, 'excess_over' => 0],
            ['status' => 'ME', 'income_from' => 25000.01, 'income_to' => 33333, 'base_tax' => 0, 'tax_rate' => 0.15, 'excess_over' => 25000],
            ['status' => 'ME', 'income_from' => 33333.01, 'income_to' => 66667, 'base_tax' => 1250, 'tax_rate' => 0.20, 'excess_over' => 33333],
            ['status' => 'ME', 'income_from' => 66667.01, 'income_to' => 166667, 'base_tax' => 8083.33, 'tax_rate' => 0.25, 'excess_over' => 66667],
            ['status' => 'ME', 'income_from' => 166667.01, 'income_to' => 666667, 'base_tax' => 33083.33, 'tax_rate' => 0.30, 'excess_over' => 166667],
            ['status' => 'ME', 'income_from' => 666667.01, 'income_to' => null, 'base_tax' => 183083.33, 'tax_rate' => 0.35, 'excess_over' => 666667],

            ['status' => 'S1', 'income_from' => 0, 'income_to' => 25000, 'base_tax' => 0, 'tax_rate' => 0.00, 'excess_over' => 0],
            ['status' => 'S1', 'income_from' => 25000.01, 'income_to' => 33333, 'base_tax' => 0, 'tax_rate' => 0.15, 'excess_over' => 25000],
            ['status' => 'S1', 'income_from' => 33333.01, 'income_to' => 66667, 'base_tax' => 1250, 'tax_rate' => 0.20, 'excess_over' => 33333],
            ['status' => 'S1', 'income_from' => 66667.01, 'income_to' => 166667, 'base_tax' => 8083.33, 'tax_rate' => 0.25, 'excess_over' => 66667],
            ['status' => 'S1', 'income_from' => 166667.01, 'income_to' => 666667, 'base_tax' => 33083.33, 'tax_rate' => 0.30, 'excess_over' => 166667],
            ['status' => 'S1', 'income_from' => 666667.01, 'income_to' => null, 'base_tax' => 183083.33, 'tax_rate' => 0.35, 'excess_over' => 666667],

            ['status' => 'ME1', 'income_from' => 0, 'income_to' => 25000, 'base_tax' => 0, 'tax_rate' => 0.00, 'excess_over' => 0],
            ['status' => 'ME1', 'income_from' => 25000.01, 'income_to' => 33333, 'base_tax' => 0, 'tax_rate' => 0.15, 'excess_over' => 25000],
            ['status' => 'ME1', 'income_from' => 33333.01, 'income_to' => 66667, 'base_tax' => 1250, 'tax_rate' => 0.20, 'excess_over' => 33333],
            ['status' => 'ME1', 'income_from' => 66667.01, 'income_to' => 166667, 'base_tax' => 8083.33, 'tax_rate' => 0.25, 'excess_over' => 66667],
            ['status' => 'ME1', 'income_from' => 166667.01, 'income_to' => 666667, 'base_tax' => 33083.33, 'tax_rate' => 0.30, 'excess_over' => 166667],
            ['status' => 'ME1', 'income_from' => 666667.01, 'income_to' => null, 'base_tax' => 183083.33, 'tax_rate' => 0.35, 'excess_over' => 666667],
        ];

        foreach ($monthlyTaxTable as $tax) {
            TaxTable::create([
                'company_id' => 1,
                'tax_year' => now()->year,
                'frequency' => 'Monthly',
                'status' => $tax['status'],
                'income_from' => $tax['income_from'],
                'income_to' => $tax['income_to'],
                'base_tax' => $tax['base_tax'],
                'tax_rate' => $tax['tax_rate'],
                'excess_over' => $tax['excess_over'],
            ]);
        }
    }
}

// =======================================================================================
// WORK SCHEDULES SEEDER
// =======================================================================================

class WorkSchedulesSeeder extends Seeder
{
    public function run()
    {
        $schedules = [
            [
                'company_id' => 1,
                'schedule_name' => 'Regular Office Hours',
                'schedule_code' => 'REG',
                'description' => 'Standard 8-hour work schedule for office employees',
                'schedule_type' => 'Fixed',
                'work_arrangement' => 'On-site',
                'work_days' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
                'work_days_per_week' => 5,
                'work_hours_per_day' => 8.00,
                'work_hours_per_week' => 40.00,
                'start_time' => '08:00',
                'end_time' => '17:00',
                'break_start_time' => '12:00',
                'break_end_time' => '13:00',
                'break_minutes' => 60,
                'late_grace_minutes' => 15,
                'early_out_grace_minutes' => 15,
                'allow_overtime' => true,
                'overtime_multiplier' => 1.25,
                'night_differential_rate' => 0.10,
                'night_differential_start' => '22:00',
                'night_differential_end' => '06:00',
            ],
            [
                'company_id' => 1,
                'schedule_name' => 'Flexible Time',
                'schedule_code' => 'FLEX',
                'description' => 'Flexible working hours with core time',
                'schedule_type' => 'Flexible',
                'work_arrangement' => 'Hybrid',
                'work_days' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
                'work_days_per_week' => 5,
                'work_hours_per_day' => 8.00,
                'work_hours_per_week' => 40.00,
                'start_time' => '08:00',
                'end_time' => '17:00',
                'break_start_time' => '12:00',
                'break_end_time' => '13:00',
                'break_minutes' => 60,
                'late_grace_minutes' => 0,
                'early_out_grace_minutes' => 0,
                'allow_overtime' => true,
                'overtime_multiplier' => 1.25,
                'night_differential_rate' => 0.10,
                'night_differential_start' => '22:00',
                'night_differential_end' => '06:00',
                'flex_start_earliest' => '06:00',
                'flex_start_latest' => '10:00',
                'core_time_start' => '10:00',
                'core_time_end' => '15:00',
            ],
            [
                'company_id' => 1,
                'schedule_name' => 'Night Shift',
                'schedule_code' => 'NIGHT',
                'description' => 'Night shift schedule with night differential',
                'schedule_type' => 'Fixed',
                'work_arrangement' => 'On-site',
                'work_days' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
                'work_days_per_week' => 5,
                'work_hours_per_day' => 8.00,
                'work_hours_per_week' => 40.00,
                'start_time' => '22:00',
                'end_time' => '06:00',
                'break_start_time' => '02:00',
                'break_end_time' => '03:00',
                'break_minutes' => 60,
                'late_grace_minutes' => 15,
                'early_out_grace_minutes' => 15,
                'allow_overtime' => true,
                'overtime_multiplier' => 1.25,
                'night_differential_rate' => 0.10,
                'night_differential_start' => '22:00',
                'night_differential_end' => '06:00',
            ],
            [
                'company_id' => 1,
                'schedule_name' => '24/7 Operations - Day Shift',
                'schedule_code' => '24_7_DAY',
                'description' => 'Day shift for 24/7 operations',
                'schedule_type' => 'Shift',
                'work_arrangement' => 'On-site',
                'work_days' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
                'work_days_per_week' => 7,
                'work_hours_per_day' => 8.00,
                'work_hours_per_week' => 56.00,
                'start_time' => '06:00',
                'end_time' => '14:00',
                'break_start_time' => '10:00',
                'break_end_time' => '11:00',
                'break_minutes' => 60,
                'late_grace_minutes' => 10,
                'early_out_grace_minutes' => 10,
                'allow_overtime' => true,
                'overtime_multiplier' => 1.25,
                'night_differential_rate' => 0.10,
                'night_differential_start' => '22:00',
                'night_differential_end' => '06:00',
            ],
            [
                'company_id' => 1,
                'schedule_name' => '24/7 Operations - Afternoon Shift',
                'schedule_code' => '24_7_AFT',
                'description' => 'Afternoon shift for 24/7 operations',
                'schedule_type' => 'Shift',
                'work_arrangement' => 'On-site',
                'work_days' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
                'work_days_per_week' => 7,
                'work_hours_per_day' => 8.00,
                'work_hours_per_week' => 56.00,
                'start_time' => '14:00',
                'end_time' => '22:00',
                'break_start_time' => '18:00',
                'break_end_time' => '19:00',
                'break_minutes' => 60,
                'late_grace_minutes' => 10,
                'early_out_grace_minutes' => 10,
                'allow_overtime' => true,
                'overtime_multiplier' => 1.25,
                'night_differential_rate' => 0.10,
                'night_differential_start' => '22:00',
                'night_differential_end' => '06:00',
            ],
            [
                'company_id' => 1,
                'schedule_name' => '24/7 Operations - Night Shift',
                'schedule_code' => '24_7_NIGHT',
                'description' => 'Night shift for 24/7 operations',
                'schedule_type' => 'Shift',
                'work_arrangement' => 'On-site',
                'work_days' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
                'work_days_per_week' => 7,
                'work_hours_per_day' => 8.00,
                'work_hours_per_week' => 56.00,
                'start_time' => '22:00',
                'end_time' => '06:00',
                'break_start_time' => '02:00',
                'break_end_time' => '03:00',
                'break_minutes' => 60,
                'late_grace_minutes' => 10,
                'early_out_grace_minutes' => 10,
                'allow_overtime' => true,
                'overtime_multiplier' => 1.25,
                'night_differential_rate' => 0.10,
                'night_differential_start' => '22:00',
                'night_differential_end' => '06:00',
            ],
        ];

        foreach ($schedules as $schedule) {
            WorkSchedule::create($schedule);
        }
    }
}

// =======================================================================================
// LEAVE TYPES SEEDER
// =======================================================================================

class LeaveTypesSeeder extends Seeder
{
    public function run()
    {
        $leaveTypes = [
            [
                'company_id' => 1,
                'name' => 'Service Incentive Leave',
                'code' => 'SIL',
                'description' => 'Mandatory 5-day leave benefit for employees',
                'category' => 'Special',
                'is_paid' => true,
                'requires_medical_certificate' => false,
                'can_be_carried_over' => true,
                'can_be_converted_to_cash' => true,
                'annual_entitlement' => 5.0,
                'max_carry_over' => 5.0,
                'min_days_advance_filing' => 3,
                'max_consecutive_days' => 5,
                'gender_restriction' => 'None',
                'allowed_employment_status' => ['Regular', 'Contractual'],
                'requires_approval' => true,
                'approval_levels' => 1,
            ],
            [
                'company_id' => 1,
                'name' => 'Vacation Leave',
                'code' => 'VL',
                'description' => 'Annual vacation leave for regular employees',
                'category' => 'Vacation',
                'is_paid' => true,
                'requires_medical_certificate' => false,
                'can_be_carried_over' => true,
                'can_be_converted_to_cash' => false,
                'annual_entitlement' => 15.0,
                'max_carry_over' => 5.0,
                'min_days_advance_filing' => 3,
                'max_consecutive_days' => 10,
                'gender_restriction' => 'None',
                'allowed_employment_status' => ['Regular'],
                'requires_approval' => true,
                'approval_levels' => 2,
            ],
            [
                'company_id' => 1,
                'name' => 'Sick Leave',
                'code' => 'SL',
                'description' => 'Leave for illness or medical reasons',
                'category' => 'Sick',
                'is_paid' => true,
                'requires_medical_certificate' => true,
                'can_be_carried_over' => false,
                'can_be_converted_to_cash' => false,
                'annual_entitlement' => 15.0,
                'max_carry_over' => 0.0,
                'min_days_advance_filing' => 0,
                'max_consecutive_days' => null,
                'gender_restriction' => 'None',
                'allowed_employment_status' => ['Regular', 'Probationary'],
                'requires_approval' => true,
                'approval_levels' => 1,
            ],
            [
                'company_id' => 1,
                'name' => 'Emergency Leave',
                'code' => 'EL',
                'description' => 'Leave for family emergencies',
                'category' => 'Emergency',
                'is_paid' => true,
                'requires_medical_certificate' => false,
                'can_be_carried_over' => false,
                'can_be_converted_to_cash' => false,
                'annual_entitlement' => 5.0,
                'max_carry_over' => 0.0,
                'min_days_advance_filing' => 0,
                'max_consecutive_days' => 3,
                'gender_restriction' => 'None',
                'allowed_employment_status' => ['Regular', 'Probationary'],
                'requires_approval' => true,
                'approval_levels' => 1,
            ],
            [
                'company_id' => 1,
                'name' => 'Maternity Leave',
                'code' => 'ML',
                'description' => '105-day maternity leave benefit',
                'category' => 'Maternity',
                'is_paid' => true,
                'requires_medical_certificate' => true,
                'can_be_carried_over' => false,
                'can_be_converted_to_cash' => false,
                'annual_entitlement' => 105.0,
                'max_carry_over' => 0.0,
                'min_days_advance_filing' => 30,
                'max_consecutive_days' => 105,
                'gender_restriction' => 'Female',
                'allowed_employment_status' => ['Regular', 'Probationary', 'Contractual'],
                'requires_approval' => true,
                'approval_levels' => 1,
            ],
            [
                'company_id' => 1,
                'name' => 'Paternity Leave',
                'code' => 'PL',
                'description' => '7-day paternity leave benefit',
                'category' => 'Paternity',
                'is_paid' => true,
                'requires_medical_certificate' => true,
                'can_be_carried_over' => false,
                'can_be_converted_to_cash' => false,
                'annual_entitlement' => 7.0,
                'max_carry_over' => 0.0,
                'min_days_advance_filing' => 7,
                'max_consecutive_days' => 7,
                'gender_restriction' => 'Male',
                'allowed_employment_status' => ['Regular', 'Probationary', 'Contractual'],
                'requires_approval' => true,
                'approval_levels' => 1,
            ],
            [
                'company_id' => 1,
                'name' => 'Solo Parent Leave',
                'code' => 'SPL',
                'description' => '7-day leave for solo parents',
                'category' => 'Special',
                'is_paid' => true,
                'requires_medical_certificate' => false,
                'can_be_carried_over' => false,
                'can_be_converted_to_cash' => false,
                'annual_entitlement' => 7.0,
                'max_carry_over' => 0.0,
                'min_days_advance_filing' => 3,
                'max_consecutive_days' => 7,
                'gender_restriction' => 'None',
                'allowed_employment_status' => ['Regular', 'Probationary'],
                'requires_approval' => true,
                'approval_levels' => 1,
            ],
            [
                'company_id' => 1,
                'name' => 'Bereavement Leave',
                'code' => 'BL',
                'description' => 'Leave for death in the family',
                'category' => 'Special',
                'is_paid' => true,
                'requires_medical_certificate' => false,
                'can_be_carried_over' => false,
                'can_be_converted_to_cash' => false,
                'annual_entitlement' => 3.0,
                'max_carry_over' => 0.0,
                'min_days_advance_filing' => 0,
                'max_consecutive_days' => 3,
                'gender_restriction' => 'None',
                'allowed_employment_status' => ['Regular', 'Probationary', 'Contractual'],
                'requires_approval' => true,
                'approval_levels' => 1,
            ],
        ];

        foreach ($leaveTypes as $leaveType) {
            LeaveType::create($leaveType);
        }
    }
}

// =======================================================================================
// REPORT TEMPLATES SEEDER
// =======================================================================================

class ReportTemplatesSeeder extends Seeder
{
    public function run()
    {
        $reportTemplates = [
            // Plantilla Reports
            [
                'company_id' => 1,
                'report_name' => 'Current Plantilla Report',
                'report_code' => 'CURRENT_PLANTILLA',
                'report_category' => 'Plantilla',
                'description' => 'Shows current authorized positions and incumbents',
                'report_fields' => [
                    'item_number', 'position_title', 'salary_grade', 'monthly_salary',
                    'department', 'incumbent_name', 'appointment_date', 'position_status'
                ],
                'filter_options' => ['department_id', 'salary_grade', 'position_status'],
                'sort_options' => ['department', 'salary_grade', 'position_title'],
                'grouping_options' => ['department', 'salary_grade'],
                'required_permissions' => ['plantilla.view'],
                'can_be_scheduled' => true,
                'output_formats' => ['PDF', 'Excel', 'CSV'],
                'default_format' => 'PDF',
            ],
            [
                'company_id' => 1,
                'report_name' => 'Vacant Positions Report',
                'report_code' => 'VACANT_POSITIONS',
                'report_category' => 'Plantilla',
                'description' => 'Lists all vacant authorized positions',
                'report_fields' => [
                    'item_number', 'position_title', 'salary_grade', 'monthly_salary',
                    'department', 'position_created_date', 'publication_status'
                ],
                'filter_options' => ['department_id', 'salary_grade'],
                'sort_options' => ['department', 'salary_grade', 'position_created_date'],
                'required_permissions' => ['plantilla.view'],
                'can_be_scheduled' => true,
                'output_formats' => ['PDF', 'Excel'],
                'default_format' => 'PDF',
            ],

            // Payroll Reports
            [
                'company_id' => 1,
                'report_name' => 'Payroll Register',
                'report_code' => 'PAYROLL_REGISTER',
                'report_category' => 'Payroll',
                'description' => 'Detailed payroll register for a specific payroll run',
                'report_fields' => [
                    'employee_id', 'employee_name', 'department', 'basic_pay',
                    'overtime_pay', 'allowances', 'gross_pay', 'deductions', 'net_pay'
                ],
                'filter_options' => ['payroll_run_id', 'department_id'],
                'sort_options' => ['employee_name', 'department', 'net_pay'],
                'required_permissions' => ['payroll.view'],
                'can_be_scheduled' => false,
                'output_formats' => ['PDF', 'Excel'],
                'default_format' => 'PDF',
            ],
            [
                'company_id' => 1,
                'report_name' => 'Department Payroll Summary',
                'report_code' => 'DEPT_PAYROLL_SUMMARY',
                'report_category' => 'Payroll',
                'description' => 'Payroll summary grouped by department',
                'report_fields' => [
                    'department_name', 'employee_count', 'total_basic_pay',
                    'total_overtime_pay', 'total_gross_pay', 'total_deductions', 'total_net_pay'
                ],
                'filter_options' => ['date_range', 'department_id'],
                'sort_options' => ['department_name', 'total_gross_pay'],
                'required_permissions' => ['payroll.view'],
                'can_be_scheduled' => true,
                'output_formats' => ['PDF', 'Excel'],
                'default_format' => 'Excel',
            ],

            // Government Compliance Reports
            [
                'company_id' => 1,
                'report_name' => 'BIR Alpha List',
                'report_code' => 'BIR_ALPHA_LIST',
                'report_category' => 'Government',
                'description' => 'Alphabetical list of employees for BIR filing',
                'report_fields' => [
                    'tin', 'employee_name', 'gross_compensation', 'tax_withheld'
                ],
                'filter_options' => ['year'],
                'sort_options' => ['employee_name'],
                'required_permissions' => ['reports.government'],
                'can_be_scheduled' => true,
                'output_formats' => ['PDF', 'Excel'],
                'default_format' => 'Excel',
            ],
            [
                'company_id' => 1,
                'report_name' => 'SSS R-3 Report',
                'report_code' => 'SSS_R3',
                'report_category' => 'Government',
                'description' => 'SSS monthly collection list',
                'report_fields' => [
                    'sss_number', 'employee_name', 'wages', 'employee_contribution',
                    'employer_contribution', 'total_contribution'
                ],
                'filter_options' => ['month', 'year'],
                'sort_options' => ['employee_name'],
                'required_permissions' => ['reports.government'],
                'can_be_scheduled' => true,
                'output_formats' => ['PDF', 'Excel'],
                'default_format' => 'Excel',
            ],

            // Attendance Reports
            [
                'company_id' => 1,
                'report_name' => 'Daily Time Record',
                'report_code' => 'DTR',
                'report_category' => 'Attendance',
                'description' => 'Individual employee daily time record',
                'report_fields' => [
                    'date', 'time_in', 'time_out', 'total_hours', 'overtime_hours',
                    'late_minutes', 'undertime_minutes', 'attendance_status'
                ],
                'filter_options' => ['employee_id', 'date_range'],
                'sort_options' => ['date'],
                'required_permissions' => ['attendance.view'],
                'can_be_scheduled' => false,
                'output_formats' => ['PDF'],
                'default_format' => 'PDF',
            ],
            [
                'company_id' => 1,
                'report_name' => 'Monthly Attendance Summary',
                'report_code' => 'MONTHLY_ATTENDANCE',
                'report_category' => 'Attendance',
                'description' => 'Monthly attendance summary for all employees',
                'report_fields' => [
                    'employee_name', 'department', 'days_worked', 'days_absent',
                    'total_late_minutes', 'total_overtime_hours', 'attendance_rate'
                ],
                'filter_options' => ['month', 'year', 'department_id'],
                'sort_options' => ['employee_name', 'attendance_rate'],
                'required_permissions' => ['attendance.view'],
                'can_be_scheduled' => true,
                'output_formats' => ['PDF', 'Excel'],
                'default_format' => 'Excel',
            ],

            // Leave Reports
            [
                'company_id' => 1,
                'report_name' => 'Leave Balances Report',
                'report_code' => 'LEAVE_BALANCES',
                'report_category' => 'Leave',
                'description' => 'Current leave balances for all employees',
                'report_fields' => [
                    'employee_name', 'department', 'vl_balance', 'sl_balance',
                    'el_balance', 'sil_balance', 'total_balance'
                ],
                'filter_options' => ['department_id', 'as_of_date'],
                'sort_options' => ['employee_name', 'department'],
                'required_permissions' => ['leaves.view'],
                'can_be_scheduled' => true,
                'output_formats' => ['PDF', 'Excel'],
                'default_format' => 'Excel',
            ],

            // Employee Reports
            [
                'company_id' => 1,
                'report_name' => 'Employee Master List',
                'report_code' => 'EMPLOYEE_MASTER_LIST',
                'report_category' => 'Demographics',
                'description' => 'Complete list of all employees',
                'report_fields' => [
                    'employee_id', 'full_name', 'position', 'department',
                    'hire_date', 'employment_status', 'basic_salary'
                ],
                'filter_options' => ['department_id', 'employment_status'],
                'sort_options' => ['employee_name', 'hire_date', 'department'],
                'required_permissions' => ['employees.view'],
                'can_be_scheduled' => true,
                'output_formats' => ['PDF', 'Excel', 'CSV'],
                'default_format' => 'Excel',
            ],
        ];

        foreach ($reportTemplates as $template) {
            ReportTemplate::create($template);
        }
    }
}

// =======================================================================================
// COMPREHENSIVE SYSTEM SETTINGS SEEDER
// =======================================================================================

class SystemSettingsSeeder extends Seeder
{
    public function run()
    {
        $settings = [
            // Payroll Settings
            ['key' => 'payroll.default_frequency', 'value' => 'Bi-monthly', 'type' => 'string', 'category' => 'payroll'],
            ['key' => 'payroll.overtime_multiplier', 'value' => '1.25', 'type' => 'decimal', 'category' => 'payroll'],
            ['key' => 'payroll.night_differential_rate', 'value' => '0.10', 'type' => 'decimal', 'category' => 'payroll'],
            ['key' => 'payroll.holiday_multiplier', 'value' => '2.00', 'type' => 'decimal', 'category' => 'payroll'],
            ['key' => 'payroll.rest_day_multiplier', 'value' => '1.30', 'type' => 'decimal', 'category' => 'payroll'],

            // Attendance Settings
            ['key' => 'attendance.grace_period_minutes', 'value' => '15', 'type' => 'integer', 'category' => 'attendance'],
            ['key' => 'attendance.auto_break_deduction', 'value' => 'true', 'type' => 'boolean', 'category' => 'attendance'],
            ['key' => 'attendance.minimum_work_hours', 'value' => '8.0', 'type' => 'decimal', 'category' => 'attendance'],
            ['key' => 'attendance.overtime_threshold_hours', 'value' => '8.0', 'type' => 'decimal', 'category' => 'attendance'],

            // Leave Settings
            ['key' => 'leave.sil_entitlement', 'value' => '5.0', 'type' => 'decimal', 'category' => 'leave'],
            ['key' => 'leave.default_vl_entitlement', 'value' => '15.0', 'type' => 'decimal', 'category' => 'leave'],
            ['key' => 'leave.default_sl_entitlement', 'value' => '15.0', 'type' => 'decimal', 'category' => 'leave'],
            ['key' => 'leave.maximum_carryover_days', 'value' => '5.0', 'type' => 'decimal', 'category' => 'leave'],
            ['key' => 'leave.minimum_service_months', 'value' => '6', 'type' => 'integer', 'category' => 'leave'],

            // System Settings
            ['key' => 'system.company_timezone', 'value' => 'Asia/Manila', 'type' => 'string', 'category' => 'system'],
            ['key' => 'system.fiscal_year_start', 'value' => '1', 'type' => 'integer', 'category' => 'system'],
            ['key' => 'system.backup_retention_days', 'value' => '30', 'type' => 'integer', 'category' => 'system'],
            ['key' => 'system.session_timeout_minutes', 'value' => '480', 'type' => 'integer', 'category' => 'system'],

            // Security Settings
            ['key' => 'security.password_min_length', 'value' => '8', 'type' => 'integer', 'category' => 'security'],
            ['key' => 'security.password_require_special_chars', 'value' => 'true', 'type' => 'boolean', 'category' => 'security'],
            ['key' => 'security.max_login_attempts', 'value' => '5', 'type' => 'integer', 'category' => 'security'],
            ['key' => 'security.account_lockout_minutes', 'value' => '30', 'type' => 'integer', 'category' => 'security'],

            // Notification Settings
            ['key' => 'notifications.email_enabled', 'value' => 'true', 'type' => 'boolean', 'category' => 'notifications'],
            ['key' => 'notifications.sms_enabled', 'value' => 'false', 'type' => 'boolean', 'category' => 'notifications'],
            ['key' => 'notifications.leave_approval_email', 'value' => 'true', 'type' => 'boolean', 'category' => 'notifications'],
            ['key' => 'notifications.payslip_email', 'value' => 'true', 'type' => 'boolean', 'category' => 'notifications'],
        ];

        foreach ($settings as $setting) {
            CompanySetting::create([
                'company_id' => 1,
                'key' => $setting['key'],
                'value' => $setting['value'],
                'type' => $setting['type'],
                'category' => $setting['category'],
                'description' => $this->getSettingDescription($setting['key']),
            ]);
        }
    }

    private function getSettingDescription(string $key): string
    {
        $descriptions = [
            'payroll.default_frequency' => 'Default payroll processing frequency',
            'payroll.overtime_multiplier' => 'Overtime pay multiplier rate',
            'payroll.night_differential_rate' => 'Night differential percentage rate',
            'payroll.holiday_multiplier' => 'Holiday pay multiplier rate',
            'payroll.rest_day_multiplier' => 'Rest day work multiplier rate',
            'attendance.grace_period_minutes' => 'Grace period for late arrivals in minutes',
            'attendance.auto_break_deduction' => 'Automatically deduct break time from work hours',
            'attendance.minimum_work_hours' => 'Minimum required work hours per day',
            'attendance.overtime_threshold_hours' => 'Hours threshold before overtime calculation',
            'leave.sil_entitlement' => 'Service Incentive Leave days per year',
            'leave.default_vl_entitlement' => 'Default Vacation Leave days per year',
            'leave.default_sl_entitlement' => 'Default Sick Leave days per year',
            'leave.maximum_carryover_days' => 'Maximum leave days that can be carried over',
            'leave.minimum_service_months' => 'Minimum service months before leave entitlement',
            'system.company_timezone' => 'Company default timezone',
            'system.fiscal_year_start' => 'Fiscal year starting month (1-12)',
            'system.backup_retention_days' => 'Number of days to retain backup files',
            'system.session_timeout_minutes' => 'User session timeout in minutes',
            'security.password_min_length' => 'Minimum password length requirement',
            'security.password_require_special_chars' => 'Require special characters in passwords',
            'security.max_login_attempts' => 'Maximum failed login attempts before lockout',
            'security.account_lockout_minutes' => 'Account lockout duration in minutes',
            'notifications.email_enabled' => 'Enable email notifications',
            'notifications.sms_enabled' => 'Enable SMS notifications',
            'notifications.leave_approval_email' => 'Send email for leave approvals',
            'notifications.payslip_email' => 'Send payslips via email',
        ];

        return $descriptions[$key] ?? '';
    }
}

?>