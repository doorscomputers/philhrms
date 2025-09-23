<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CompanyEvent;
use App\Models\Employee;
use App\Models\User;
use Carbon\Carbon;

class CompanyEventSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $admin = User::first();
        $employees = Employee::take(10)->get();

        // Sample events for demonstration
        $events = [
            // Company Meetings
            [
                'title' => 'Monthly All-Hands Meeting',
                'description' => 'Company-wide meeting to discuss quarterly goals and achievements.',
                'event_type' => 'company_meeting',
                'priority' => 'high',
                'event_date' => Carbon::now()->addDays(7),
                'start_time' => '09:00:00',
                'end_time' => '10:30:00',
                'location' => 'Conference Room A',
                'color' => '#3B82F6',
                'is_recurring' => true,
                'recurrence_type' => 'monthly',
                'recurrence_interval' => 1,
                'is_company_wide' => true,
                'created_by' => $admin->id,
                'meeting_link' => 'https://meet.google.com/xyz-abc-def',
                'send_reminders' => true,
                'reminder_days_before' => 2,
            ],
            [
                'title' => 'Board Meeting',
                'description' => 'Quarterly board meeting with stakeholders.',
                'event_type' => 'company_meeting',
                'priority' => 'critical',
                'event_date' => Carbon::now()->addDays(14),
                'start_time' => '14:00:00',
                'end_time' => '16:00:00',
                'location' => 'Executive Conference Room',
                'color' => '#EF4444',
                'is_company_wide' => false,
                'created_by' => $admin->id,
                'notes' => 'Management and department heads only.',
            ],

            // Training Events
            [
                'title' => 'Cybersecurity Awareness Training',
                'description' => 'Mandatory training on cybersecurity best practices and data protection.',
                'event_type' => 'compliance_training',
                'priority' => 'high',
                'event_date' => Carbon::now()->addDays(10),
                'start_time' => '10:00:00',
                'end_time' => '12:00:00',
                'location' => 'Training Room B',
                'color' => '#F59E0B',
                'is_company_wide' => true,
                'created_by' => $admin->id,
                'requires_rsvp' => true,
                'max_attendees' => 50,
            ],
            [
                'title' => 'New Employee Orientation',
                'description' => 'Comprehensive orientation program for new hires.',
                'event_type' => 'training',
                'priority' => 'medium',
                'event_date' => Carbon::now()->addDays(3),
                'start_time' => '09:00:00',
                'end_time' => '17:00:00',
                'location' => 'HR Training Center',
                'color' => '#10B981',
                'is_all_day' => false,
                'created_by' => $admin->id,
                'notes' => 'Lunch will be provided.',
            ],

            // Holidays
            [
                'title' => 'Independence Day',
                'description' => 'National holiday - Office closed.',
                'event_type' => 'holiday',
                'priority' => 'medium',
                'event_date' => Carbon::now()->addDays(30),
                'is_all_day' => true,
                'color' => '#8B5CF6',
                'is_company_wide' => true,
                'created_by' => $admin->id,
            ],
            [
                'title' => 'Christmas Day',
                'description' => 'Christmas holiday - Office closed.',
                'event_type' => 'holiday',
                'priority' => 'medium',
                'event_date' => Carbon::create(2025, 12, 25),
                'is_all_day' => true,
                'color' => '#EF4444',
                'is_company_wide' => true,
                'created_by' => $admin->id,
            ],

            // Social Events
            [
                'title' => 'Team Building Activity',
                'description' => 'Outdoor team building activities and lunch.',
                'event_type' => 'team_building',
                'priority' => 'medium',
                'event_date' => Carbon::now()->addDays(21),
                'start_time' => '10:00:00',
                'end_time' => '16:00:00',
                'location' => 'Adventure Park',
                'color' => '#06B6D4',
                'is_company_wide' => true,
                'created_by' => $admin->id,
                'requires_rsvp' => true,
                'notes' => 'Comfortable clothing recommended.',
            ],
            [
                'title' => 'Company Anniversary Celebration',
                'description' => 'Celebrating 10 years of excellence!',
                'event_type' => 'social_event',
                'priority' => 'high',
                'event_date' => Carbon::now()->addDays(45),
                'start_time' => '18:00:00',
                'end_time' => '22:00:00',
                'location' => 'Grand Ballroom, Hotel Central',
                'color' => '#F59E0B',
                'is_company_wide' => true,
                'created_by' => $admin->id,
                'requires_rsvp' => true,
                'notes' => 'Formal attire required. Plus ones welcome.',
            ],

            // Performance Reviews
            [
                'title' => 'Q4 Performance Review Period',
                'description' => 'Annual performance review cycle begins.',
                'event_type' => 'performance_review',
                'priority' => 'high',
                'event_date' => Carbon::now()->addDays(60),
                'start_time' => '09:00:00',
                'end_time' => '17:00:00',
                'color' => '#8B5CF6',
                'is_company_wide' => true,
                'created_by' => $admin->id,
                'notes' => 'All employees will receive calendar invites for individual sessions.',
            ],

            // Conference/Meeting
            [
                'title' => 'Technology Conference 2025',
                'description' => 'Annual technology conference featuring latest trends.',
                'event_type' => 'conference',
                'priority' => 'medium',
                'event_date' => Carbon::now()->addDays(35),
                'start_time' => '08:00:00',
                'end_time' => '18:00:00',
                'location' => 'Convention Center',
                'color' => '#6366F1',
                'is_company_wide' => false,
                'created_by' => $admin->id,
                'requires_rsvp' => true,
                'max_attendees' => 20,
                'notes' => 'Priority for IT and development teams.',
            ],

            // Deadline
            [
                'title' => 'Annual Report Submission Deadline',
                'description' => 'Final deadline for annual report submission to regulatory bodies.',
                'event_type' => 'deadline',
                'priority' => 'critical',
                'event_date' => Carbon::now()->addDays(28),
                'start_time' => '17:00:00',
                'color' => '#DC2626',
                'is_company_wide' => false,
                'created_by' => $admin->id,
                'notes' => 'Finance and legal teams responsible.',
            ],
        ];

        // Add birthday events for some employees
        if ($employees->isNotEmpty()) {
            foreach ($employees->take(5) as $index => $employee) {
                $birthdayDate = Carbon::now()->addDays(5 + ($index * 15));
                $events[] = [
                    'title' => $employee->first_name . ' ' . $employee->last_name . '\'s Birthday',
                    'description' => 'Birthday celebration for ' . $employee->first_name . '!',
                    'event_type' => 'birthday',
                    'priority' => 'low',
                    'event_date' => $birthdayDate,
                    'start_time' => '15:00:00',
                    'end_time' => '16:00:00',
                    'location' => 'Break Room',
                    'color' => '#EC4899',
                    'is_company_wide' => true,
                    'created_by' => $admin->id,
                    'related_employee_id' => $employee->id,
                    'notes' => 'Cake and refreshments will be provided.',
                ];

                // Add work anniversary
                $anniversaryDate = Carbon::now()->addDays(10 + ($index * 20));
                $years = rand(1, 8);
                $events[] = [
                    'title' => $employee->first_name . ' ' . $employee->last_name . ' - ' . $years . ' Year Anniversary',
                    'description' => 'Celebrating ' . $years . ' years of dedicated service!',
                    'event_type' => 'work_anniversary',
                    'priority' => 'medium',
                    'event_date' => $anniversaryDate,
                    'start_time' => '14:00:00',
                    'end_time' => '14:30:00',
                    'location' => 'Main Office',
                    'color' => '#059669',
                    'is_company_wide' => true,
                    'created_by' => $admin->id,
                    'related_employee_id' => $employee->id,
                    'notes' => 'Recognition ceremony and certificate presentation.',
                ];
            }
        }

        // Create all events
        foreach ($events as $eventData) {
            CompanyEvent::create($eventData);
        }

        $this->command->info('Created ' . count($events) . ' company events successfully!');
    }
}