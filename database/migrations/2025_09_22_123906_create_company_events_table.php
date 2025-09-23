<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('company_events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('event_type', [
                'company_meeting', 'training', 'holiday', 'birthday', 'work_anniversary',
                'team_building', 'performance_review', 'compliance_training',
                'benefits_enrollment', 'social_event', 'conference', 'deadline', 'other'
            ]);
            $table->enum('priority', ['low', 'medium', 'high', 'critical'])->default('medium');
            $table->date('event_date');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->string('location')->nullable();
            $table->string('color', 7)->default('#3B82F6'); // Hex color for calendar display
            $table->boolean('is_recurring')->default(false);
            $table->enum('recurrence_type', ['daily', 'weekly', 'monthly', 'yearly'])->nullable();
            $table->integer('recurrence_interval')->default(1); // Every X days/weeks/months/years
            $table->date('recurrence_end_date')->nullable();
            $table->boolean('is_all_day')->default(false);
            $table->boolean('requires_rsvp')->default(false);
            $table->integer('max_attendees')->nullable();
            $table->json('target_departments')->nullable(); // Array of department IDs
            $table->json('target_positions')->nullable(); // Array of position IDs
            $table->json('target_employees')->nullable(); // Array of specific employee IDs
            $table->boolean('is_company_wide')->default(true);
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->text('notes')->nullable();
            $table->string('meeting_link')->nullable(); // For virtual meetings
            $table->json('attachments')->nullable(); // File paths
            $table->boolean('send_reminders')->default(true);
            $table->integer('reminder_days_before')->default(1);
            $table->boolean('is_active')->default(true);
            $table->foreignId('related_employee_id')->nullable()->constrained('employees')->onDelete('cascade'); // For birthdays/anniversaries
            $table->timestamps();

            // Indexes for performance
            $table->index('event_date');
            $table->index('event_type');
            $table->index('is_active');
            $table->index(['event_date', 'event_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_events');
    }
};
