<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class EmployeeDocument extends Model
{
    use Auditable, HasFactory, SoftDeletes;

    protected $fillable = [
        'employee_id',
        'document_type',
        'document_name',
        'file_name',
        'file_path',
        'file_size',
        'mime_type',
        'expiry_date',
        'is_required',
        'is_verified',
        'notes',
        'uploaded_by',
        'verified_at',
        'verified_by',
    ];

    protected function casts(): array
    {
        return [
            'expiry_date' => 'date',
            'is_required' => 'boolean',
            'is_verified' => 'boolean',
            'verified_at' => 'datetime',
        ];
    }

    /**
     * Get the employee that owns this document
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Get the user who uploaded this document
     */
    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Get the user who verified this document
     */
    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * Check if document is expired
     */
    public function isExpired(): bool
    {
        return $this->expiry_date && $this->expiry_date->isPast();
    }

    /**
     * Check if document is expiring soon (within 30 days)
     */
    public function isExpiringSoon(): bool
    {
        return $this->expiry_date &&
               $this->expiry_date->isFuture() &&
               $this->expiry_date->diffInDays() <= 30;
    }

    /**
     * Get the file URL for downloading
     */
    public function getFileUrlAttribute(): string
    {
        return Storage::url($this->file_path);
    }

    /**
     * Get human readable file size
     */
    public function getFormattedFileSizeAttribute(): string
    {
        if (!$this->file_size) return 'Unknown';

        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Common document types for HRMS
     */
    public static function getDocumentTypes(): array
    {
        return [
            'resume' => 'Resume/CV',
            'id_card' => 'Government ID',
            'birth_certificate' => 'Birth Certificate',
            'marriage_certificate' => 'Marriage Certificate',
            'diploma' => 'Diploma/Certificate',
            'tor' => 'Transcript of Records',
            'medical_certificate' => 'Medical Certificate',
            'contract' => 'Employment Contract',
            'nbi_clearance' => 'NBI Clearance',
            'police_clearance' => 'Police Clearance',
            'sss_id' => 'SSS ID',
            'philhealth_id' => 'PhilHealth ID',
            'pagibig_id' => 'Pag-IBIG ID',
            'tin_id' => 'TIN ID',
            'passport' => 'Passport',
            'drivers_license' => 'Driver\'s License',
            'voters_id' => 'Voter\'s ID',
            'training_certificate' => 'Training Certificate',
            'performance_evaluation' => 'Performance Evaluation',
            'other' => 'Other Document',
        ];
    }
}
