<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CompanyBranch;
use App\Models\CompanyEvent;
use App\Models\CostCenter;
use App\Models\Department;
use App\Models\EmploymentStatus;
use App\Models\Holiday;
use App\Models\JobGrade;
use App\Models\LeaveType;
use App\Models\PayrollGroup;
use App\Models\Position;
use App\Models\WorkSchedule;

class ManageDataController extends Controller
{
    public function index()
    {
        // Get all data counts for dashboard
        $data = [
            'companies' => [
                'count' => Company::count(),
                'recent' => Company::latest()->take(3)->get(),
                'route' => 'companies.index',
                'create_route' => 'companies.create',
                'edit_route' => 'companies.edit',
                'icon' => 'building',
                'color' => 'blue',
                'description' => 'Company information and settings',
            ],
            'branches' => [
                'count' => CompanyBranch::count(),
                'recent' => CompanyBranch::with('company')->latest()->take(3)->get(),
                'route' => 'branches.index',
                'create_route' => 'branches.create',
                'edit_route' => 'branches.edit',
                'icon' => 'location',
                'color' => 'green',
                'description' => 'Company branch locations and details',
            ],
            'departments' => [
                'count' => Department::count(),
                'recent' => Department::with('company')->latest()->take(3)->get(),
                'route' => 'departments.index',
                'create_route' => 'departments.create',
                'edit_route' => 'departments.edit',
                'icon' => 'organization',
                'color' => 'purple',
                'description' => 'Organizational departments and structure',
            ],
            'positions' => [
                'count' => Position::count(),
                'recent' => Position::with('department')->latest()->take(3)->get(),
                'route' => 'positions.index',
                'create_route' => 'positions.create',
                'edit_route' => 'positions.edit',
                'icon' => 'briefcase',
                'color' => 'indigo',
                'description' => 'Job positions and roles',
            ],
            'job_grades' => [
                'count' => JobGrade::count(),
                'recent' => JobGrade::latest()->take(3)->get(),
                'route' => 'job-grades.index',
                'create_route' => 'job-grades.create',
                'edit_route' => 'job-grades.edit',
                'icon' => 'star',
                'color' => 'yellow',
                'description' => 'Salary grades and compensation levels',
            ],
            'employment_statuses' => [
                'count' => EmploymentStatus::count(),
                'recent' => EmploymentStatus::latest()->take(3)->get(),
                'route' => 'employment-statuses.index',
                'create_route' => 'employment-statuses.create',
                'edit_route' => 'employment-statuses.edit',
                'icon' => 'check',
                'color' => 'emerald',
                'description' => 'Employment status types',
            ],
            'cost_centers' => [
                'count' => CostCenter::count(),
                'recent' => CostCenter::with('company')->latest()->take(3)->get(),
                'route' => 'cost-centers.index',
                'create_route' => 'cost-centers.create',
                'edit_route' => 'cost-centers.edit',
                'icon' => 'calculator',
                'color' => 'orange',
                'description' => 'Budget allocation and cost centers',
            ],
            'work_schedules' => [
                'count' => WorkSchedule::count(),
                'recent' => WorkSchedule::latest()->take(3)->get(),
                'route' => 'work-schedules.index',
                'create_route' => 'work-schedules.create',
                'edit_route' => 'work-schedules.edit',
                'icon' => 'clock',
                'color' => 'cyan',
                'description' => 'Working time schedules and shifts',
            ],
            'payroll_groups' => [
                'count' => PayrollGroup::count(),
                'recent' => PayrollGroup::latest()->take(3)->get(),
                'route' => 'payroll-groups.index',
                'create_route' => 'payroll-groups.create',
                'edit_route' => 'payroll-groups.edit',
                'icon' => 'currency',
                'color' => 'red',
                'description' => 'Payroll processing groups',
            ],
            'leave_types' => [
                'count' => LeaveType::count(),
                'recent' => LeaveType::latest()->take(3)->get(),
                'route' => 'leave-types.index',
                'create_route' => 'leave-types.create',
                'edit_route' => 'leave-types.edit',
                'icon' => 'calendar',
                'color' => 'pink',
                'description' => 'Types of employee leave',
            ],
            'holidays' => [
                'count' => Holiday::count(),
                'recent' => Holiday::latest()->take(3)->get(),
                'route' => 'holidays.index',
                'create_route' => 'holidays.create',
                'edit_route' => 'holidays.edit',
                'icon' => 'gift',
                'color' => 'teal',
                'description' => 'Company and public holidays',
            ],
            'company_events' => [
                'count' => CompanyEvent::count(),
                'recent' => CompanyEvent::with('relatedEmployee')->latest()->take(3)->get(),
                'route' => 'company-events.index',
                'create_route' => 'company-events.create',
                'edit_route' => 'company-events.edit',
                'icon' => 'calendar-event',
                'color' => 'violet',
                'description' => 'Company events, meetings, and activities',
            ],
        ];

        return view('manage-data.index', compact('data'));
    }
}
