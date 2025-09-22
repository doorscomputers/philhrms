<?php

use App\Http\Controllers\Api\CostCenterController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\EmploymentStatusController;
use App\Http\Controllers\Api\JobGradeController;
use App\Http\Controllers\Api\OfficeController;
use App\Http\Controllers\Api\PositionController;
use App\Http\Controllers\Api\WorkScheduleController;
use App\Http\Controllers\EmploymentTypeController;
use App\Http\Controllers\EmployeeDocumentController;
use Illuminate\Support\Facades\Route;

// For demonstration purposes, temporarily remove auth middleware
// TODO: Implement proper SPA authentication

// Dashboard API
Route::get('/dashboard/stats', [DashboardController::class, 'stats']);
Route::get('/dashboard/recent-activity', [DashboardController::class, 'recentActivity']);

// Employee CRUD API
Route::apiResource('employees', EmployeeController::class);

// Employee document management - New system
Route::get('/employee-documents/types', [EmployeeDocumentController::class, 'getDocumentTypes']);
Route::get('/employee-documents', [EmployeeDocumentController::class, 'index']);
Route::post('/employee-documents', [EmployeeDocumentController::class, 'store']);
Route::get('/employee-documents/{document}/download', [EmployeeDocumentController::class, 'download']);
Route::put('/employee-documents/{document}', [EmployeeDocumentController::class, 'update']);
Route::delete('/employee-documents/{document}', [EmployeeDocumentController::class, 'destroy']);
Route::get('/employee-documents/expiring-soon', [EmployeeDocumentController::class, 'getExpiringSoon']);

// Management Data APIs
Route::apiResource('departments', DepartmentController::class);
Route::apiResource('offices', OfficeController::class);
Route::apiResource('positions', PositionController::class);
Route::apiResource('job-grades', JobGradeController::class);
Route::apiResource('cost-centers', CostCenterController::class);
Route::apiResource('work-schedules', WorkScheduleController::class);
Route::apiResource('employment-statuses', EmploymentStatusController::class);
Route::apiResource('employment-types', EmploymentTypeController::class);
