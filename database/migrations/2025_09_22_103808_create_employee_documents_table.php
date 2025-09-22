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
        Schema::create('employee_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->string('document_type'); // 'resume', 'id_card', 'contract', 'certificate', 'medical', etc.
            $table->string('document_name'); // User-friendly name
            $table->string('file_name'); // Actual file name
            $table->string('file_path'); // Storage path
            $table->string('file_size')->nullable(); // File size in bytes
            $table->string('mime_type')->nullable(); // File MIME type
            $table->date('expiry_date')->nullable(); // For documents that expire
            $table->boolean('is_required')->default(false); // Whether this document type is mandatory
            $table->boolean('is_verified')->default(false); // HR verification status
            $table->text('notes')->nullable(); // Additional notes
            $table->foreignId('uploaded_by')->constrained('users')->onDelete('cascade'); // Who uploaded
            $table->timestamp('verified_at')->nullable(); // When verified
            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null'); // Who verified
            $table->timestamps();

            // Indexes for better performance
            $table->index(['employee_id', 'document_type']);
            $table->index(['expiry_date']);
            $table->index(['is_required', 'is_verified']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_documents');
    }
};
