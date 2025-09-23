<?php

namespace App\Http\Controllers;

use App\Models\AuditTrail;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AuditTrailController extends Controller
{
    public function index(Request $request)
    {
        $query = AuditTrail::with('user');

        // Filter by model type
        if ($request->filled('model_type')) {
            $query->where('model_type', $request->model_type);
        }

        // Filter by model ID
        if ($request->filled('model_id')) {
            $query->where('model_id', $request->model_id);
        }

        // Filter by action
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        // Filter by user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Search in description
        if ($request->filled('search')) {
            $query->where('description', 'like', '%'.$request->search.'%');
        }

        $auditTrails = $query->orderBy('created_at', 'desc')->paginate(25)->withQueryString();

        // Get unique model types for filter
        $modelTypes = AuditTrail::select('model_type')
            ->distinct()
            ->orderBy('model_type')
            ->pluck('model_type')
            ->map(function ($type) {
                return [
                    'value' => $type,
                    'label' => class_basename($type),
                ];
            });

        // Get unique actions for filter
        $actions = AuditTrail::select('action')
            ->distinct()
            ->orderBy('action')
            ->pluck('action');

        // Get users for filter
        $users = User::select('id', 'first_name', 'last_name', 'preferred_name')->orderBy('first_name')->get();

        return Inertia::render('Organization/AuditTrailIndex', [
            'auditTrails' => $auditTrails,
            'modelTypes' => $modelTypes,
            'actions' => $actions,
            'users' => $users,
            'filters' => $request->only(['model_type', 'model_id', 'action', 'user_id', 'date_from', 'date_to', 'search']),
        ]);
    }

    public function show(Request $request, string $modelType, int $modelId)
    {
        // Decode the URL-encoded model type
        $decodedModelType = urldecode($modelType);

        $auditTrails = AuditTrail::with('user')
            ->where('model_type', $decodedModelType)
            ->where('model_id', $modelId)
            ->orderBy('created_at', 'desc')
            ->paginate(25);

        $modelName = class_basename($decodedModelType);

        return Inertia::render('Organization/AuditTrailShow', [
            'auditTrails' => $auditTrails,
            'modelType' => $modelType,
            'modelId' => $modelId,
            'modelName' => $modelName,
        ]);
    }

    public function employeeAuditTrail(Request $request, Employee $employee)
    {
        $auditTrails = AuditTrail::where('model_type', Employee::class)
            ->where('model_id', $employee->id)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(25)
            ->withQueryString();

        return Inertia::render('Employee/EmployeeAuditTrail', [
            'employee' => $employee,
            'auditTrails' => $auditTrails,
        ]);
    }
}
