<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Position;

class DashboardController extends Controller
{
    public function stats()
    {
        $stats = [
            'totalEmployees' => Employee::count(),
            'activeEmployees' => Employee::where('is_active', true)->count(),
            'departments' => Department::where('is_active', true)->count(),
            'positions' => Position::where('is_active', true)->count(),
        ];

        return response()->json($stats);
    }

    public function recentActivity()
    {
        // For now, return mock data. In a real app, you'd have an activity log
        $activities = [
            [
                'id' => 1,
                'description' => 'New employee John Doe was added',
                'created_at' => now()->subHours(2)->toISOString(),
            ],
            [
                'id' => 2,
                'description' => 'Employee Jane Smith was updated',
                'created_at' => now()->subHours(5)->toISOString(),
            ],
            [
                'id' => 3,
                'description' => 'Department Engineering was created',
                'created_at' => now()->subDay()->toISOString(),
            ],
        ];

        return response()->json($activities);
    }
}
