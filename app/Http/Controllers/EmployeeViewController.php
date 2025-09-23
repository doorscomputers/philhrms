<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeDocument;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EmployeeViewController extends Controller
{
    /**
     * Display the specified employee with all related data
     */
    public function show(Employee $employee)
    {
        // Load all related data
        $employee->load([
            'department',
            'position',
            'jobGrade',
            'branch',
            'costCenter',
            'workSchedule',
            'employmentStatus',
            'supervisor:id,first_name,last_name',
            'documents.uploader:id,first_name,last_name',
            'documents.verifier:id,first_name,last_name'
        ]);

        // Get employee documents separately for better organization
        $documents = $employee->documents()
            ->with(['uploader:id,first_name,last_name', 'verifier:id,first_name,last_name'])
            ->orderBy('document_type')
            ->orderBy('created_at', 'desc')
            ->get();

        // Organize documents by type
        $documentsByType = $documents->groupBy('document_type');

        // Get expired and expiring documents
        $expiredDocuments = $documents->filter(function ($doc) {
            return $doc->expiry_date && $doc->expiry_date->isPast();
        });

        $expiringDocuments = $documents->filter(function ($doc) {
            return $doc->expiry_date &&
                   $doc->expiry_date->isFuture() &&
                   $doc->expiry_date->diffInDays() <= 30;
        });

        return Inertia::render('Employee/EmployeeViewEnhanced', [
            'employee' => $employee,
            'documents' => $documents,
            'documentsByType' => $documentsByType,
            'expiredDocuments' => $expiredDocuments,
            'expiringDocuments' => $expiringDocuments,
            'documentTypes' => EmployeeDocument::getDocumentTypes(),
        ]);
    }

    /**
     * Display employee documents tab
     */
    public function documents(Employee $employee)
    {
        $documents = $employee->documents()
            ->with(['uploader:id,first_name,last_name', 'verifier:id,first_name,last_name'])
            ->orderBy('document_type')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'documents' => $documents,
            'documentTypes' => EmployeeDocument::getDocumentTypes(),
        ]);
    }

    /**
     * Get employee timeline/activity from audit trails
     */
    public function timeline(Employee $employee)
    {
        // Get audit trails for this employee
        $auditTrails = $employee->auditTrails()
            ->orderBy('created_at', 'desc')
            ->get();

        $timeline = collect();

        // Add audit trail entries
        foreach ($auditTrails as $audit) {
            $timeline->push([
                'type' => $audit->action,
                'date' => $audit->created_at,
                'description' => $audit->description,
                'user' => $audit->user_name,
                'changes' => $audit->formatted_changes_html,
                'ip_address' => $audit->ip_address,
                'user_agent' => $audit->user_agent,
                'action_color' => $audit->action_color,
                'action_icon' => $audit->action_icon,
            ]);
        }

        // Add document uploads to timeline
        foreach ($employee->documents as $document) {
            $timeline->push([
                'type' => 'document_uploaded',
                'date' => $document->created_at,
                'description' => "Document uploaded: {$document->document_name} ({$document->document_type})",
                'user' => ($document->uploader->first_name ?? '') . ' ' . ($document->uploader->last_name ?? '') ?: 'Unknown',
                'changes' => null,
                'ip_address' => null,
                'user_agent' => null,
                'action_color' => 'blue',
                'action_icon' => 'file-upload',
            ]);

            // Add document verification events
            if ($document->is_verified && $document->verified_at) {
                $timeline->push([
                    'type' => 'document_verified',
                    'date' => $document->verified_at,
                    'description' => "Document verified: {$document->document_name}",
                    'user' => ($document->verifier->first_name ?? '') . ' ' . ($document->verifier->last_name ?? '') ?: 'Unknown',
                    'changes' => null,
                    'ip_address' => null,
                    'user_agent' => null,
                    'action_color' => 'green',
                    'action_icon' => 'check-circle',
                ]);
            }
        }

        // Add milestone events
        if ($employee->hire_date) {
            $timeline->push([
                'type' => 'milestone',
                'date' => $employee->hire_date,
                'description' => 'Employee hired',
                'user' => 'HR Department',
                'changes' => null,
                'ip_address' => null,
                'user_agent' => null,
                'action_color' => 'green',
                'action_icon' => 'briefcase',
            ]);
        }

        if ($employee->probation_end_date) {
            $timeline->push([
                'type' => 'milestone',
                'date' => $employee->probation_end_date,
                'description' => 'Probation period ended',
                'user' => 'System',
                'changes' => null,
                'ip_address' => null,
                'user_agent' => null,
                'action_color' => 'yellow',
                'action_icon' => 'clock',
            ]);
        }

        if ($employee->regularization_date) {
            $timeline->push([
                'type' => 'milestone',
                'date' => $employee->regularization_date,
                'description' => 'Employee regularized',
                'user' => 'HR Department',
                'changes' => null,
                'ip_address' => null,
                'user_agent' => null,
                'action_color' => 'green',
                'action_icon' => 'user-check',
            ]);
        }

        return response()->json([
            'timeline' => $timeline->sortByDesc('date')->values()
        ]);
    }
}
