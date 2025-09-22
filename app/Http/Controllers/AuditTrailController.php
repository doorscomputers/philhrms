<?php

namespace App\Http\Controllers;

use App\Models\AuditTrail;
use Illuminate\Http\Request;

class AuditTrailController extends Controller
{
    public function index(Request $request)
    {
        $query = AuditTrail::query();

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

        $auditTrails = $query->orderBy('created_at', 'desc')->paginate(25);

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

        return view('audit-trails.index', compact('auditTrails', 'modelTypes', 'actions'));
    }

    public function show(Request $request, string $modelType, int $modelId)
    {
        // Decode the URL-encoded model type
        $decodedModelType = urldecode($modelType);

        $auditTrails = AuditTrail::where('model_type', $decodedModelType)
            ->where('model_id', $modelId)
            ->orderBy('created_at', 'desc')
            ->paginate(25);

        $modelName = class_basename($decodedModelType);

        return view('audit-trails.show', compact('auditTrails', 'modelType', 'modelId', 'modelName'));
    }
}
