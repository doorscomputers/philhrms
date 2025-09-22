<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class EmployeeDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $employee = Employee::where('user_id', $user->id)
            ->orWhere('email_addresses', 'like', '%'.$user->email.'%')
            ->with(['department', 'position', 'jobGrade', 'company'])
            ->first();

        if (! $employee) {
            return redirect()->route('dashboard')->with('error', 'Employee profile not found.');
        }

        $dashboardData = [
            'employee' => $employee,
            'attendance_summary' => $this->getAttendanceSummary($employee),
            'leave_balances' => $this->getLeaveBalances($employee),
            'recent_activities' => $this->getRecentActivities($employee),
            'upcoming_events' => $this->getUpcomingEvents($employee),
        ];

        return view('employee-dashboard.index', $dashboardData);
    }

    public function show(Employee $employee)
    {
        $user = Auth::user();

        // Check if user can view this employee's dashboard
        if ($employee->user_id !== $user->id && ! $this->canViewEmployee($user, $employee)) {
            abort(403, 'Unauthorized to view this employee dashboard.');
        }

        $employee->load(['department', 'position', 'jobGrade', 'company']);

        $dashboardData = [
            'employee' => $employee,
            'attendance_summary' => $this->getAttendanceSummary($employee),
            'leave_balances' => $this->getLeaveBalances($employee),
            'recent_activities' => $this->getRecentActivities($employee),
            'upcoming_events' => $this->getUpcomingEvents($employee),
        ];

        return view('employee-dashboard.show', $dashboardData);
    }

    private function getAttendanceSummary(Employee $employee): array
    {
        // Mock data for now - in real implementation, this would query attendance records
        return [
            'present_days' => 22,
            'total_days' => 24,
            'attendance_rate' => 91.7,
            'late_days' => 2,
            'hours_worked' => 176,
            'overtime_hours' => 8,
        ];
    }

    private function getLeaveBalances(Employee $employee): array
    {
        return [
            'vacation_leave' => $employee->vacation_leave_balance ?? 15,
            'sick_leave' => $employee->sick_leave_balance ?? 10,
            'emergency_leave' => $employee->emergency_leave_balance ?? 5,
        ];
    }

    private function getRecentActivities(Employee $employee): array
    {
        // Mock data for now - in real implementation, this would query activity logs
        return [
            [
                'type' => 'clock_in',
                'description' => 'Clocked in at 9:00 AM',
                'date' => now()->subHours(2),
                'icon' => 'clock',
            ],
            [
                'type' => 'leave_request',
                'description' => 'Leave request approved for Dec 25-26',
                'date' => now()->subDays(1),
                'icon' => 'calendar',
            ],
            [
                'type' => 'document',
                'description' => 'Updated emergency contact information',
                'date' => now()->subDays(3),
                'icon' => 'document',
            ],
        ];
    }

    private function getUpcomingEvents(Employee $employee): array
    {
        // Mock data for now - in real implementation, this would query events/meetings
        return [
            [
                'title' => 'Team Meeting',
                'date' => now()->addDays(1),
                'time' => '10:00 AM',
                'type' => 'meeting',
            ],
            [
                'title' => 'Performance Review',
                'date' => now()->addDays(7),
                'time' => '2:00 PM',
                'type' => 'review',
            ],
            [
                'title' => 'Company Holiday - Christmas',
                'date' => now()->addDays(30),
                'time' => 'All Day',
                'type' => 'holiday',
            ],
        ];
    }

    private function canViewEmployee(User $user, Employee $employee): bool
    {
        // In a real implementation, this would check permissions/roles
        // For now, allow admin users to view any employee
        return $user->email === 'admin@test.com' ||
               $user->first_name === 'Admin';
    }
}
