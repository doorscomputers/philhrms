<?php

use App\Http\Controllers\AuditTrailController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CompanyBranchController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CostCenterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployeeDashboardController;
use App\Http\Controllers\EmployeeViewController;
use App\Http\Controllers\EmploymentStatusController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\JobGradeController;
use App\Http\Controllers\LeaveTypeController;
use App\Http\Controllers\ManageDataController;
use App\Http\Controllers\PayrollGroupController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\WorkScheduleController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect('/dashboard');
    }

    return redirect('/login');
});

Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Test CSRF route (public access for testing)
Route::get('/csrf-test', [EmployeeController::class, 'create'])->name('csrf.test');
Route::post('/csrf-test', function (\Illuminate\Http\Request $request) {
    \Log::info('CSRF Test POST received', $request->all());

    return response()->json(['status' => 'success', 'message' => 'POST request received successfully!', 'data' => $request->all()]);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Test route for fixed employee creation
    Route::get('/test-employee-fixed', [EmployeeController::class, 'create'])->name('test.employee.fixed');

    // Test route for minimal employee creation
    Route::get('/test-employee-minimal', function () {
        return Inertia::render('Employee/EmployeeTestMinimal');
    })->name('test.employee.minimal');

    // SPA Routes using Inertia - must come before other routes
    Route::prefix('spa')->group(function () {
        Route::get('/', function () {
            return redirect('/spa/employees');
        });
        Route::get('/employees', [EmployeeController::class, 'index'])->name('spa.employees.index');
        Route::get('/employees/create', [EmployeeController::class, 'create'])->name('spa.employees.create');
        Route::post('/employees', [EmployeeController::class, 'store'])->name('spa.employees.store');
        Route::post('/employees-simple', [EmployeeController::class, 'storeSimple'])->name('spa.employees.store-simple');
        Route::get('/employees/{employee}', [EmployeeViewController::class, 'show'])->name('spa.employees.show');
        Route::get('/employees/{employee}/timeline', [EmployeeViewController::class, 'timeline'])->name('spa.employees.timeline');
        Route::get('/employees/{employee}/edit', [EmployeeController::class, 'edit'])->name('spa.employees.edit');
        Route::put('/employees/{employee}', [EmployeeController::class, 'update'])->name('spa.employees.update');
        Route::delete('/employees/{employee}', [EmployeeController::class, 'destroy'])->name('spa.employees.destroy');

        // Quick Add Routes for Employee Creation
        Route::post('/departments', [DepartmentController::class, 'store'])->name('spa.departments.store');
        Route::post('/positions', [PositionController::class, 'store'])->name('spa.positions.store');
        Route::post('/job-grades', [JobGradeController::class, 'store'])->name('spa.job-grades.store');
        Route::post('/company-branches', [CompanyBranchController::class, 'store'])->name('spa.company-branches.store');
        Route::post('/cost-centers', [CostCenterController::class, 'store'])->name('spa.cost-centers.store');
        Route::post('/work-schedules', [WorkScheduleController::class, 'store'])->name('spa.work-schedules.store');
        Route::post('/employment-statuses', [EmploymentStatusController::class, 'store'])->name('spa.employment-statuses.store');
    });

    // Centralized Data Management
    Route::get('/manage-data', [ManageDataController::class, 'index'])->name('manage-data.index');

    // Organization Management
    Route::resource('companies', CompanyController::class);
    Route::resource('company-branches', CompanyBranchController::class)->names('branches');
    Route::resource('departments', DepartmentController::class);
    Route::resource('positions', PositionController::class);
    Route::resource('job-grades', JobGradeController::class)->names('job-grades');
    Route::resource('cost-centers', CostCenterController::class)->names('cost-centers');
    Route::resource('work-schedules', WorkScheduleController::class)->names('work-schedules');
    Route::resource('holidays', HolidayController::class);
    Route::resource('leave-types', LeaveTypeController::class)->names('leave-types');
    Route::resource('payroll-groups', PayrollGroupController::class)->names('payroll-groups');
    Route::resource('employment-statuses', EmploymentStatusController::class)->names('employment-statuses');

    // Employee Management
    Route::resource('employees', EmployeeController::class);

    // Employee Dashboard Routes
    Route::get('/employee-dashboard', [EmployeeDashboardController::class, 'index'])->name('employee-dashboard.index');
    Route::get('/employee-dashboard/{employee}', [EmployeeDashboardController::class, 'show'])->name('employee-dashboard.show');

    // Audit Trail Routes
    Route::get('/audit-trails', [AuditTrailController::class, 'index'])->name('audit-trails.index');
    Route::get('/audit-trails/{modelType}/{modelId}', [AuditTrailController::class, 'show'])->name('audit-trails.show');
});
