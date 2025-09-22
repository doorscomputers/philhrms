<?php

namespace App\Http\Controllers;

use App\Models\EmployeeDocument;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EmployeeDocumentController extends Controller
{
    /**
     * Get document types for dropdown
     */
    public function getDocumentTypes()
    {
        return response()->json(EmployeeDocument::getDocumentTypes());
    }

    /**
     * Display documents for an employee
     */
    public function index(Request $request)
    {
        $employeeId = $request->get('employee_id');

        if (!$employeeId) {
            return response()->json(['error' => 'Employee ID required'], 400);
        }

        $documents = EmployeeDocument::where('employee_id', $employeeId)
            ->with(['uploader:id,name', 'verifier:id,name'])
            ->orderBy('document_type')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($documents);
    }

    /**
     * Store a newly uploaded document
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'document_type' => 'required|string|max:255',
            'document_name' => 'required|string|max:255',
            'file' => 'required|file|max:10240', // 10MB max
            'expiry_date' => 'nullable|date|after:today',
            'notes' => 'nullable|string|max:1000',
            'is_required' => 'nullable|boolean',
        ]);

        $file = $request->file('file');

        // Generate unique filename
        $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();

        // Store file in employee documents folder
        $filePath = $file->storeAs(
            'employee-documents/' . $validated['employee_id'],
            $fileName,
            'public'
        );

        // Create document record
        $document = EmployeeDocument::create([
            'employee_id' => $validated['employee_id'],
            'document_type' => $validated['document_type'],
            'document_name' => $validated['document_name'],
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $filePath,
            'file_size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
            'expiry_date' => $validated['expiry_date'] ?? null,
            'notes' => $validated['notes'] ?? null,
            'is_required' => $validated['is_required'] ?? false,
            'uploaded_by' => auth()->id(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Document uploaded successfully',
            'document' => $document->load(['uploader:id,name'])
        ], 201);
    }

    /**
     * Download a document
     */
    public function download(EmployeeDocument $document)
    {
        if (!Storage::disk('public')->exists($document->file_path)) {
            return response()->json(['error' => 'File not found'], 404);
        }

        return Storage::disk('public')->download(
            $document->file_path,
            $document->file_name
        );
    }

    /**
     * Update document metadata (not the file)
     */
    public function update(Request $request, EmployeeDocument $document)
    {
        $validated = $request->validate([
            'document_name' => 'required|string|max:255',
            'expiry_date' => 'nullable|date|after:today',
            'notes' => 'nullable|string|max:1000',
            'is_required' => 'nullable|boolean',
            'is_verified' => 'nullable|boolean',
        ]);

        if (isset($validated['is_verified']) && $validated['is_verified']) {
            $validated['verified_at'] = now();
            $validated['verified_by'] = auth()->id();
        } elseif (isset($validated['is_verified']) && !$validated['is_verified']) {
            $validated['verified_at'] = null;
            $validated['verified_by'] = null;
        }

        $document->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Document updated successfully',
            'document' => $document->fresh()->load(['uploader:id,name', 'verifier:id,name'])
        ]);
    }

    /**
     * Delete a document
     */
    public function destroy(EmployeeDocument $document)
    {
        // Delete file from storage
        if (Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return response()->json([
            'success' => true,
            'message' => 'Document deleted successfully'
        ]);
    }

    /**
     * Get documents expiring soon (for dashboard alerts)
     */
    public function getExpiringSoon()
    {
        $documents = EmployeeDocument::whereNotNull('expiry_date')
            ->where('expiry_date', '<=', now()->addDays(30))
            ->where('expiry_date', '>=', now())
            ->with(['employee:id,first_name,last_name', 'uploader:id,name'])
            ->orderBy('expiry_date')
            ->get();

        return response()->json($documents);
    }
}
