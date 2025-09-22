<?php

// =======================================================================================
// COMPREHENSIVE REPORTING FRAMEWORK FOR COMPLETE HRMS SYSTEM
// =======================================================================================

namespace App\Reports;

use App\Models\*;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

// =======================================================================================
// PHILIPPINE GOVERNMENT COMPLIANCE REPORTS
// =======================================================================================

class BIRReports
{
    /**
     * BIR Form 2316 - Certificate of Compensation Payment/Tax Withheld
     */
    public function generateForm2316(int $employeeId, int $year): array
    {
        $employee = Employee::with(['payrollItems' => function ($query) use ($year) {
            $query->whereYear('created_at', $year);
        }])->findOrFail($employeeId);

        $yearlyTotals = $employee->payrollItems->reduce(function ($carry, $item) {
            $carry['gross_compensation'] += $item->gross_pay;
            $carry['basic_salary'] += $item->basic_pay;
            $carry['overtime_pay'] += $item->overtime_pay;
            $carry['allowances'] += $item->allowances;
            $carry['13th_month_pay'] += $item->thirteenth_month_pay ?? 0;
            $carry['sss_contribution'] += $item->sss_employee;
            $carry['philhealth_contribution'] += $item->philhealth_employee;
            $carry['pagibig_contribution'] += $item->pagibig_employee;
            $carry['tax_withheld'] += $item->withholding_tax;
            return $carry;
        }, [
            'gross_compensation' => 0,
            'basic_salary' => 0,
            'overtime_pay' => 0,
            'allowances' => 0,
            '13th_month_pay' => 0,
            'sss_contribution' => 0,
            'philhealth_contribution' => 0,
            'pagibig_contribution' => 0,
            'tax_withheld' => 0,
        ]);

        return [
            'employee_info' => [
                'tin' => $employee->tin,
                'full_name' => $employee->full_name,
                'address' => $employee->addresses['present'] ?? '',
                'zip_code' => $employee->addresses['present']['postal_code'] ?? '',
            ],
            'employer_info' => [
                'tin' => $employee->company->tin,
                'employer_name' => $employee->company->legal_name,
                'address' => $employee->company->addresses['head_office'] ?? '',
                'zip_code' => $employee->company->addresses['head_office']['postal_code'] ?? '',
            ],
            'compensation_details' => $yearlyTotals,
            'year' => $year,
            'generated_date' => now()->format('Y-m-d'),
        ];
    }

    /**
     * BIR Alpha List of Employees
     */
    public function generateAlphaList(int $companyId, int $year): array
    {
        $employees = Employee::where('company_id', $companyId)
            ->whereHas('payrollItems', function ($query) use ($year) {
                $query->whereYear('created_at', $year);
            })
            ->with(['payrollItems' => function ($query) use ($year) {
                $query->whereYear('created_at', $year);
            }])
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        $alphaList = $employees->map(function ($employee) {
            $yearlyTotals = $employee->payrollItems->reduce(function ($carry, $item) {
                return [
                    'gross_compensation' => $carry['gross_compensation'] + $item->gross_pay,
                    'tax_withheld' => $carry['tax_withheld'] + $item->withholding_tax,
                ];
            }, ['gross_compensation' => 0, 'tax_withheld' => 0]);

            return [
                'sequence_number' => '',
                'tin' => $employee->tin,
                'employee_name' => $employee->full_name,
                'gross_compensation' => $yearlyTotals['gross_compensation'],
                'tax_withheld' => $yearlyTotals['tax_withheld'],
            ];
        });

        return [
            'company_info' => Company::find($companyId),
            'year' => $year,
            'employees' => $alphaList->toArray(),
            'total_employees' => $alphaList->count(),
            'total_gross_compensation' => $alphaList->sum('gross_compensation'),
            'total_tax_withheld' => $alphaList->sum('tax_withheld'),
        ];
    }

    /**
     * BIR Monthly Remittance Return
     */
    public function generateMonthlyRemittanceReturn(int $companyId, int $month, int $year): array
    {
        $payrollItems = PayrollItem::whereHas('employee', function ($query) use ($companyId) {
                $query->where('company_id', $companyId);
            })
            ->whereHas('payrollRun', function ($query) use ($month, $year) {
                $query->whereMonth('period_start', $month)
                      ->whereYear('period_start', $year);
            })
            ->with('employee')
            ->get();

        $totals = $payrollItems->reduce(function ($carry, $item) {
            return [
                'total_compensation' => $carry['total_compensation'] + $item->gross_pay,
                'total_tax_withheld' => $carry['total_tax_withheld'] + $item->withholding_tax,
            ];
        }, ['total_compensation' => 0, 'total_tax_withheld' => 0]);

        return [
            'company_info' => Company::find($companyId),
            'period' => "$year-$month",
            'totals' => $totals,
            'employee_count' => $payrollItems->count(),
        ];
    }
}

class SSSReports
{
    /**
     * SSS R-3 Monthly Collection List
     */
    public function generateR3Report(int $companyId, int $month, int $year): array
    {
        $payrollItems = PayrollItem::whereHas('employee', function ($query) use ($companyId) {
                $query->where('company_id', $companyId);
            })
            ->whereHas('payrollRun', function ($query) use ($month, $year) {
                $query->whereMonth('period_start', $month)
                      ->whereYear('period_start', $year);
            })
            ->with('employee')
            ->get();

        $employees = $payrollItems->map(function ($item) {
            $employee = $item->employee;
            return [
                'sss_number' => $employee->sss_number,
                'employee_name' => $employee->full_name,
                'wages' => $item->taxable_income,
                'employee_contribution' => $item->sss_employee,
                'employer_contribution' => $item->sss_employer,
                'total_contribution' => $item->sss_employee + $item->sss_employer,
            ];
        });

        $totals = [
            'total_employees' => $employees->count(),
            'total_wages' => $employees->sum('wages'),
            'total_employee_contribution' => $employees->sum('employee_contribution'),
            'total_employer_contribution' => $employees->sum('employer_contribution'),
            'total_contributions' => $employees->sum('total_contribution'),
        ];

        return [
            'company_info' => Company::find($companyId),
            'period' => Carbon::create($year, $month, 1)->format('F Y'),
            'employees' => $employees->toArray(),
            'totals' => $totals,
        ];
    }

    /**
     * SSS R-5 Annual Reconciliation
     */
    public function generateR5Report(int $companyId, int $year): array
    {
        $payrollItems = PayrollItem::whereHas('employee', function ($query) use ($companyId) {
                $query->where('company_id', $companyId);
            })
            ->whereHas('payrollRun', function ($query) use ($year) {
                $query->whereYear('period_start', $year);
            })
            ->with('employee')
            ->get();

        $employeeAnnualData = $payrollItems->groupBy('employee_id')->map(function ($items, $employeeId) {
            $employee = $items->first()->employee;
            $yearlyTotals = $items->reduce(function ($carry, $item) {
                return [
                    'total_wages' => $carry['total_wages'] + $item->taxable_income,
                    'total_employee_contribution' => $carry['total_employee_contribution'] + $item->sss_employee,
                    'total_employer_contribution' => $carry['total_employer_contribution'] + $item->sss_employer,
                ];
            }, ['total_wages' => 0, 'total_employee_contribution' => 0, 'total_employer_contribution' => 0]);

            return [
                'sss_number' => $employee->sss_number,
                'employee_name' => $employee->full_name,
                'annual_wages' => $yearlyTotals['total_wages'],
                'annual_employee_contribution' => $yearlyTotals['total_employee_contribution'],
                'annual_employer_contribution' => $yearlyTotals['total_employer_contribution'],
                'total_annual_contribution' => $yearlyTotals['total_employee_contribution'] + $yearlyTotals['total_employer_contribution'],
            ];
        });

        return [
            'company_info' => Company::find($companyId),
            'year' => $year,
            'employees' => $employeeAnnualData->values()->toArray(),
            'summary' => [
                'total_employees' => $employeeAnnualData->count(),
                'total_annual_wages' => $employeeAnnualData->sum('annual_wages'),
                'total_annual_contributions' => $employeeAnnualData->sum('total_annual_contribution'),
            ],
        ];
    }
}

class PhilHealthReports
{
    /**
     * PhilHealth RF-1 Monthly Premium Report
     */
    public function generateRF1Report(int $companyId, int $month, int $year): array
    {
        $payrollItems = PayrollItem::whereHas('employee', function ($query) use ($companyId) {
                $query->where('company_id', $companyId);
            })
            ->whereHas('payrollRun', function ($query) use ($month, $year) {
                $query->whereMonth('period_start', $month)
                      ->whereYear('period_start', $year);
            })
            ->with('employee')
            ->get();

        $employees = $payrollItems->map(function ($item) {
            $employee = $item->employee;
            return [
                'philhealth_number' => $employee->philhealth_number,
                'employee_name' => $employee->full_name,
                'monthly_salary' => $item->basic_pay,
                'employee_share' => $item->philhealth_employee,
                'employer_share' => $item->philhealth_employer,
                'total_premium' => $item->philhealth_employee + $item->philhealth_employer,
            ];
        });

        return [
            'company_info' => Company::find($companyId),
            'period' => Carbon::create($year, $month, 1)->format('F Y'),
            'employees' => $employees->toArray(),
            'totals' => [
                'total_employees' => $employees->count(),
                'total_salaries' => $employees->sum('monthly_salary'),
                'total_employee_share' => $employees->sum('employee_share'),
                'total_employer_share' => $employees->sum('employer_share'),
                'total_premiums' => $employees->sum('total_premium'),
            ],
        ];
    }
}

class PagIBIGReports
{
    /**
     * Pag-IBIG Monthly Collection Report
     */
    public function generateMonthlyCollectionReport(int $companyId, int $month, int $year): array
    {
        $payrollItems = PayrollItem::whereHas('employee', function ($query) use ($companyId) {
                $query->where('company_id', $companyId);
            })
            ->whereHas('payrollRun', function ($query) use ($month, $year) {
                $query->whereMonth('period_start', $month)
                      ->whereYear('period_start', $year);
            })
            ->with('employee')
            ->get();

        $employees = $payrollItems->map(function ($item) {
            $employee = $item->employee;
            return [
                'pagibig_number' => $employee->pagibig_number,
                'employee_name' => $employee->full_name,
                'monthly_compensation' => $item->basic_pay,
                'employee_contribution' => $item->pagibig_employee,
                'employer_contribution' => $item->pagibig_employer,
                'total_contribution' => $item->pagibig_employee + $item->pagibig_employer,
            ];
        });

        return [
            'company_info' => Company::find($companyId),
            'period' => Carbon::create($year, $month, 1)->format('F Y'),
            'employees' => $employees->toArray(),
            'totals' => [
                'total_employees' => $employees->count(),
                'total_compensation' => $employees->sum('monthly_compensation'),
                'total_employee_contribution' => $employees->sum('employee_contribution'),
                'total_employer_contribution' => $employees->sum('employer_contribution'),
                'total_contributions' => $employees->sum('total_contribution'),
            ],
        ];
    }
}

// =======================================================================================
// PLANTILLA AND POSITION REPORTS
// =======================================================================================

class PlantillaReports
{
    /**
     * Current Plantilla Report
     */
    public function generateCurrentPlantilla(int $companyId, Carbon $asOfDate = null): array
    {
        $asOfDate = $asOfDate ?? now();

        $plantillaItems = Plantilla::where('company_id', $companyId)
            ->where('is_active', true)
            ->with(['department', 'currentIncumbent', 'salaryGrade'])
            ->orderBy('department_id')
            ->orderBy('salary_grade')
            ->orderBy('position_title')
            ->get();

        $groupedByDepartment = $plantillaItems->groupBy('department.name');

        $departmentSummaries = $groupedByDepartment->map(function ($items, $departmentName) {
            return [
                'department_name' => $departmentName,
                'total_positions' => $items->count(),
                'filled_positions' => $items->where('position_status', 'Filled')->count(),
                'vacant_positions' => $items->where('position_status', 'Vacant')->count(),
                'positions' => $items->map(function ($item) {
                    return [
                        'item_number' => $item->item_number,
                        'position_title' => $item->title,
                        'salary_grade' => $item->salary_grade,
                        'step_increment' => $item->step_increment,
                        'monthly_salary' => number_format($item->monthly_salary, 2),
                        'position_status' => $item->position_status,
                        'incumbent_name' => $item->currentIncumbent?->full_name ?? 'VACANT',
                        'appointment_date' => $item->currentIncumbent?->hire_date?->format('Y-m-d') ?? '',
                    ];
                })->toArray(),
            ];
        });

        return [
            'company_info' => Company::find($companyId),
            'as_of_date' => $asOfDate->format('Y-m-d'),
            'departments' => $departmentSummaries->toArray(),
            'summary' => [
                'total_authorized_positions' => $plantillaItems->count(),
                'total_filled_positions' => $plantillaItems->where('position_status', 'Filled')->count(),
                'total_vacant_positions' => $plantillaItems->where('position_status', 'Vacant')->count(),
                'utilization_rate' => $plantillaItems->count() > 0
                    ? round(($plantillaItems->where('position_status', 'Filled')->count() / $plantillaItems->count()) * 100, 2)
                    : 0,
            ],
        ];
    }

    /**
     * Position Publication Report
     */
    public function generatePositionPublications(int $companyId, Carbon $fromDate, Carbon $toDate): array
    {
        $publications = Plantilla::where('company_id', $companyId)
            ->whereBetween('position_published_from', [$fromDate, $toDate])
            ->with(['department'])
            ->orderBy('position_published_from')
            ->get();

        return [
            'company_info' => Company::find($companyId),
            'period' => [
                'from' => $fromDate->format('Y-m-d'),
                'to' => $toDate->format('Y-m-d'),
            ],
            'publications' => $publications->map(function ($item) {
                return [
                    'item_number' => $item->item_number,
                    'position_title' => $item->title,
                    'department' => $item->department->name,
                    'salary_grade' => $item->salary_grade,
                    'monthly_salary' => number_format($item->monthly_salary, 2),
                    'publication_from' => $item->position_published_from?->format('Y-m-d'),
                    'publication_to' => $item->position_published_to?->format('Y-m-d'),
                    'publication_reference' => $item->publication_reference,
                    'publication_status' => $this->getPublicationStatus($item),
                ];
            })->toArray(),
            'summary' => [
                'total_publications' => $publications->count(),
                'by_status' => $publications->groupBy(function ($item) {
                    return $this->getPublicationStatus($item);
                })->map->count(),
            ],
        ];
    }

    private function getPublicationStatus(Plantilla $plantilla): string
    {
        $now = now();

        if (!$plantilla->position_published_from) {
            return 'Not Published';
        }

        if ($plantilla->position_published_from > $now) {
            return 'Scheduled';
        }

        if ($plantilla->position_published_to && $plantilla->position_published_to < $now) {
            return 'Closed';
        }

        return 'Active';
    }

    /**
     * Appointments Report
     */
    public function generateAppointmentsReport(int $companyId, Carbon $fromDate, Carbon $toDate, int $employeeId = null): array
    {
        $query = EmployeeAppointment::whereHas('employee', function ($q) use ($companyId) {
                $q->where('company_id', $companyId);
            })
            ->whereBetween('appointment_date', [$fromDate, $toDate])
            ->with(['employee', 'plantilla', 'fromPlantilla']);

        if ($employeeId) {
            $query->where('employee_id', $employeeId);
        }

        $appointments = $query->orderBy('appointment_date')->get();

        return [
            'company_info' => Company::find($companyId),
            'period' => [
                'from' => $fromDate->format('Y-m-d'),
                'to' => $toDate->format('Y-m-d'),
            ],
            'appointments' => $appointments->map(function ($appointment) {
                return [
                    'appointment_number' => $appointment->appointment_number,
                    'employee_name' => $appointment->employee->full_name,
                    'appointment_type' => $appointment->appointment_type,
                    'appointment_date' => $appointment->appointment_date->format('Y-m-d'),
                    'effective_date' => $appointment->effective_date->format('Y-m-d'),
                    'from_position' => $appointment->from_position_title,
                    'to_position' => $appointment->plantilla->title,
                    'from_salary_grade' => $appointment->from_salary_grade,
                    'to_salary_grade' => $appointment->salary_grade,
                    'salary_difference' => $appointment->monthly_salary - ($appointment->fromPlantilla?->monthly_salary ?? 0),
                    'appointing_authority' => $appointment->appointing_authority,
                    'csc_action' => $appointment->csc_action,
                    'status' => $appointment->status,
                ];
            })->toArray(),
            'summary' => [
                'total_appointments' => $appointments->count(),
                'by_type' => $appointments->groupBy('appointment_type')->map->count(),
                'by_status' => $appointments->groupBy('status')->map->count(),
            ],
        ];
    }
}

// =======================================================================================
// PAYROLL REPORTS
// =======================================================================================

class PayrollReports
{
    /**
     * Detailed Payroll Register
     */
    public function generatePayrollRegister(int $payrollRunId): array
    {
        $payrollRun = PayrollRun::with(['company', 'payrollGroup'])->findOrFail($payrollRunId);
        $payrollItems = PayrollItem::where('payroll_run_id', $payrollRunId)
            ->with('employee')
            ->orderBy('employee.last_name')
            ->orderBy('employee.first_name')
            ->get();

        return [
            'payroll_run_info' => [
                'run_number' => $payrollRun->run_number,
                'description' => $payrollRun->description,
                'period_start' => $payrollRun->period_start->format('Y-m-d'),
                'period_end' => $payrollRun->period_end->format('Y-m-d'),
                'pay_date' => $payrollRun->pay_date->format('Y-m-d'),
                'period_type' => $payrollRun->period_type,
                'status' => $payrollRun->status,
            ],
            'company_info' => $payrollRun->company,
            'employees' => $payrollItems->map(function ($item) {
                return [
                    'employee_id' => $item->employee->employee_id,
                    'employee_name' => $item->employee->full_name,
                    'position' => $item->employee->position->title ?? '',
                    'department' => $item->employee->department->name ?? '',
                    'basic_pay' => number_format($item->basic_pay, 2),
                    'overtime_pay' => number_format($item->overtime_pay, 2),
                    'allowances' => number_format($item->allowances, 2),
                    'gross_pay' => number_format($item->gross_pay, 2),
                    'sss_employee' => number_format($item->sss_employee, 2),
                    'philhealth_employee' => number_format($item->philhealth_employee, 2),
                    'pagibig_employee' => number_format($item->pagibig_employee, 2),
                    'withholding_tax' => number_format($item->withholding_tax, 2),
                    'loans' => number_format($item->loans, 2),
                    'other_deductions' => number_format($item->other_deductions, 2),
                    'total_deductions' => number_format($item->total_deductions, 2),
                    'net_pay' => number_format($item->net_pay, 2),
                ];
            })->toArray(),
            'totals' => [
                'employee_count' => $payrollItems->count(),
                'total_basic_pay' => number_format($payrollItems->sum('basic_pay'), 2),
                'total_overtime_pay' => number_format($payrollItems->sum('overtime_pay'), 2),
                'total_allowances' => number_format($payrollItems->sum('allowances'), 2),
                'total_gross_pay' => number_format($payrollItems->sum('gross_pay'), 2),
                'total_deductions' => number_format($payrollItems->sum('total_deductions'), 2),
                'total_net_pay' => number_format($payrollItems->sum('net_pay'), 2),
            ],
        ];
    }

    /**
     * Department Payroll Summary
     */
    public function generateDepartmentPayrollSummary(int $companyId, Carbon $fromDate, Carbon $toDate): array
    {
        $payrollData = DB::table('payroll_items')
            ->join('employees', 'payroll_items.employee_id', '=', 'employees.id')
            ->join('departments', 'employees.department_id', '=', 'departments.id')
            ->join('payroll_runs', 'payroll_items.payroll_run_id', '=', 'payroll_runs.id')
            ->where('employees.company_id', $companyId)
            ->whereBetween('payroll_runs.period_start', [$fromDate, $toDate])
            ->select(
                'departments.name as department_name',
                DB::raw('COUNT(DISTINCT employees.id) as employee_count'),
                DB::raw('SUM(payroll_items.basic_pay) as total_basic_pay'),
                DB::raw('SUM(payroll_items.overtime_pay) as total_overtime_pay'),
                DB::raw('SUM(payroll_items.allowances) as total_allowances'),
                DB::raw('SUM(payroll_items.gross_pay) as total_gross_pay'),
                DB::raw('SUM(payroll_items.total_deductions) as total_deductions'),
                DB::raw('SUM(payroll_items.net_pay) as total_net_pay'),
                DB::raw('AVG(payroll_items.gross_pay) as average_gross_pay')
            )
            ->groupBy('departments.id', 'departments.name')
            ->orderBy('departments.name')
            ->get();

        return [
            'company_info' => Company::find($companyId),
            'period' => [
                'from' => $fromDate->format('Y-m-d'),
                'to' => $toDate->format('Y-m-d'),
            ],
            'departments' => $payrollData->map(function ($dept) {
                return [
                    'department_name' => $dept->department_name,
                    'employee_count' => $dept->employee_count,
                    'total_basic_pay' => number_format($dept->total_basic_pay, 2),
                    'total_overtime_pay' => number_format($dept->total_overtime_pay, 2),
                    'total_allowances' => number_format($dept->total_allowances, 2),
                    'total_gross_pay' => number_format($dept->total_gross_pay, 2),
                    'total_deductions' => number_format($dept->total_deductions, 2),
                    'total_net_pay' => number_format($dept->total_net_pay, 2),
                    'average_gross_pay' => number_format($dept->average_gross_pay, 2),
                ];
            })->toArray(),
            'grand_totals' => [
                'total_employees' => $payrollData->sum('employee_count'),
                'total_gross_pay' => number_format($payrollData->sum('total_gross_pay'), 2),
                'total_deductions' => number_format($payrollData->sum('total_deductions'), 2),
                'total_net_pay' => number_format($payrollData->sum('total_net_pay'), 2),
            ],
        ];
    }
}

// =======================================================================================
// ATTENDANCE REPORTS
// =======================================================================================

class AttendanceReports
{
    /**
     * Daily Time Record (DTR)
     */
    public function generateDTR(int $employeeId, Carbon $fromDate, Carbon $toDate): array
    {
        $employee = Employee::with(['company', 'department', 'position'])->findOrFail($employeeId);
        $timeLogs = TimeLog::where('employee_id', $employeeId)
            ->whereBetween('log_date', [$fromDate, $toDate])
            ->orderBy('log_date')
            ->get();

        $dtrData = $timeLogs->map(function ($log) {
            return [
                'date' => $log->log_date->format('Y-m-d'),
                'day' => $log->log_date->format('l'),
                'time_in' => $log->time_in?->format('H:i'),
                'time_out' => $log->time_out?->format('H:i'),
                'break_out' => $log->break_out?->format('H:i'),
                'break_in' => $log->break_in?->format('H:i'),
                'total_hours' => number_format($log->total_hours, 2),
                'regular_hours' => number_format($log->regular_hours, 2),
                'overtime_hours' => number_format($log->overtime_hours, 2),
                'late_minutes' => $log->late_minutes,
                'undertime_minutes' => $log->undertime_minutes,
                'attendance_status' => $log->attendance_status,
                'remarks' => $this->getAttendanceRemarks($log),
            ];
        });

        $summary = [
            'total_days_worked' => $timeLogs->where('attendance_status', 'Present')->count(),
            'total_regular_hours' => $timeLogs->sum('regular_hours'),
            'total_overtime_hours' => $timeLogs->sum('overtime_hours'),
            'total_late_minutes' => $timeLogs->sum('late_minutes'),
            'total_undertime_minutes' => $timeLogs->sum('undertime_minutes'),
            'attendance_rate' => $timeLogs->count() > 0
                ? round(($timeLogs->where('attendance_status', 'Present')->count() / $timeLogs->count()) * 100, 2)
                : 0,
        ];

        return [
            'employee_info' => [
                'employee_id' => $employee->employee_id,
                'full_name' => $employee->full_name,
                'position' => $employee->position?->title,
                'department' => $employee->department?->name,
            ],
            'company_info' => $employee->company,
            'period' => [
                'from' => $fromDate->format('Y-m-d'),
                'to' => $toDate->format('Y-m-d'),
            ],
            'attendance_records' => $dtrData->toArray(),
            'summary' => $summary,
        ];
    }

    private function getAttendanceRemarks(TimeLog $log): string
    {
        $remarks = [];

        if ($log->late_minutes > 0) {
            $remarks[] = "Late: {$log->late_minutes} mins";
        }

        if ($log->undertime_minutes > 0) {
            $remarks[] = "Undertime: {$log->undertime_minutes} mins";
        }

        if ($log->overtime_hours > 0) {
            $remarks[] = "Overtime: " . number_format($log->overtime_hours, 2) . " hrs";
        }

        if ($log->holiday_id) {
            $remarks[] = "Holiday";
        }

        return implode(', ', $remarks);
    }

    /**
     * Monthly Attendance Summary
     */
    public function generateMonthlyAttendanceSummary(int $companyId, int $month, int $year): array
    {
        $employees = Employee::where('company_id', $companyId)
            ->where('employment_status', '!=', 'Resigned')
            ->with(['department', 'timeLogs' => function ($query) use ($month, $year) {
                $query->whereMonth('log_date', $month)
                      ->whereYear('log_date', $year);
            }])
            ->get();

        $attendanceData = $employees->map(function ($employee) {
            $timeLogs = $employee->timeLogs;

            return [
                'employee_id' => $employee->employee_id,
                'employee_name' => $employee->full_name,
                'department' => $employee->department?->name,
                'days_worked' => $timeLogs->where('attendance_status', 'Present')->count(),
                'days_absent' => $timeLogs->where('attendance_status', 'Absent')->count(),
                'days_late' => $timeLogs->where('late_minutes', '>', 0)->count(),
                'total_late_minutes' => $timeLogs->sum('late_minutes'),
                'total_overtime_hours' => $timeLogs->sum('overtime_hours'),
                'attendance_rate' => $timeLogs->count() > 0
                    ? round(($timeLogs->where('attendance_status', 'Present')->count() / $timeLogs->count()) * 100, 2)
                    : 0,
            ];
        });

        return [
            'company_info' => Company::find($companyId),
            'period' => Carbon::create($year, $month, 1)->format('F Y'),
            'employees' => $attendanceData->toArray(),
            'summary' => [
                'total_employees' => $attendanceData->count(),
                'average_attendance_rate' => $attendanceData->avg('attendance_rate'),
                'total_absent_days' => $attendanceData->sum('days_absent'),
                'total_late_incidents' => $attendanceData->sum('days_late'),
                'total_overtime_hours' => $attendanceData->sum('total_overtime_hours'),
            ],
        ];
    }
}

// =======================================================================================
// LEAVE REPORTS
// =======================================================================================

class LeaveReports
{
    /**
     * Leave Balances Report
     */
    public function generateLeaveBalances(int $companyId, Carbon $asOfDate = null): array
    {
        $asOfDate = $asOfDate ?? now();
        $year = $asOfDate->year;

        $employees = Employee::where('company_id', $companyId)
            ->where('employment_status', '!=', 'Resigned')
            ->with([
                'department',
                'leaveEntitlements' => function ($query) use ($year) {
                    $query->where('year', $year)->with('leaveType');
                }
            ])
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        $leaveTypes = LeaveType::where('company_id', $companyId)
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $leaveBalanceData = $employees->map(function ($employee) use ($leaveTypes) {
            $balances = [];

            foreach ($leaveTypes as $leaveType) {
                $entitlement = $employee->leaveEntitlements
                    ->where('leave_type_id', $leaveType->id)
                    ->first();

                $balances[$leaveType->code] = [
                    'entitled' => $entitlement?->entitled_days ?? 0,
                    'earned' => $entitlement?->earned_days ?? 0,
                    'used' => $entitlement?->used_days ?? 0,
                    'balance' => $entitlement?->balance_days ?? 0,
                ];
            }

            return [
                'employee_id' => $employee->employee_id,
                'employee_name' => $employee->full_name,
                'department' => $employee->department?->name,
                'hire_date' => $employee->hire_date->format('Y-m-d'),
                'years_of_service' => $employee->hire_date->diffInYears($asOfDate),
                'leave_balances' => $balances,
            ];
        });

        return [
            'company_info' => Company::find($companyId),
            'as_of_date' => $asOfDate->format('Y-m-d'),
            'leave_types' => $leaveTypes->pluck('name', 'code')->toArray(),
            'employees' => $leaveBalanceData->toArray(),
        ];
    }

    /**
     * Leave Applications Report
     */
    public function generateLeaveApplications(int $companyId, Carbon $fromDate, Carbon $toDate, string $status = null): array
    {
        $query = LeaveApplication::whereHas('employee', function ($q) use ($companyId) {
                $q->where('company_id', $companyId);
            })
            ->whereBetween('filed_date', [$fromDate, $toDate])
            ->with(['employee', 'leaveType']);

        if ($status) {
            $query->where('status', $status);
        }

        $applications = $query->orderBy('filed_date')->get();

        $applicationData = $applications->map(function ($application) {
            return [
                'application_number' => $application->application_number,
                'employee_name' => $application->employee->full_name,
                'employee_id' => $application->employee->employee_id,
                'department' => $application->employee->department?->name,
                'leave_type' => $application->leaveType->name,
                'start_date' => $application->start_date->format('Y-m-d'),
                'end_date' => $application->end_date->format('Y-m-d'),
                'total_days' => $application->total_days,
                'reason' => $application->reason,
                'filed_date' => $application->filed_date->format('Y-m-d'),
                'status' => $application->status,
                'final_approved_by' => $application->finalApprovedBy?->name,
                'final_approved_at' => $application->final_approved_at?->format('Y-m-d'),
            ];
        });

        return [
            'company_info' => Company::find($companyId),
            'period' => [
                'from' => $fromDate->format('Y-m-d'),
                'to' => $toDate->format('Y-m-d'),
            ],
            'filter_status' => $status,
            'applications' => $applicationData->toArray(),
            'summary' => [
                'total_applications' => $applications->count(),
                'by_status' => $applications->groupBy('status')->map->count(),
                'by_leave_type' => $applications->groupBy('leaveType.name')->map->count(),
                'total_days_requested' => $applications->sum('total_days'),
            ],
        ];
    }
}

?>