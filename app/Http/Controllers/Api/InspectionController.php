<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Inspection;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class InspectionController extends Controller
{
    public function index()
    {
        return response()->json(
            Inspection::with(['plan.type', 'inspector', 'items', 'findings'])
                ->latest()
                ->paginate(10)
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'inspection_plan_id' => 'required|exists:inspection_plans,id',
            'inspector_id' => 'required|exists:inspectors,id',
            'target_type' => 'nullable|string|max:100',
            'target_external_id' => 'nullable|string|max:255',
            'target_name' => 'nullable|string|max:255',
            'inspection_date' => 'required|date',
            'result' => 'nullable|string',
            'status' => 'sometimes|in:scheduled,in_progress,completed,cancelled',
        ]);

        $inspection = Inspection::create($data);

        return response()->json(
            $inspection->load(['plan.type', 'inspector']),
            201
        );
    }

    public function show(Inspection $inspection)
    {
        return response()->json(
            $inspection->load([
                'plan.type',
                'inspector',
                'items',
                'findings',
            ])
        );
    }

    public function update(Request $request, Inspection $inspection)
    {
        $data = $request->validate([
            'inspection_plan_id' => 'sometimes|required|exists:inspection_plans,id',
            'inspector_id' => 'sometimes|required|exists:inspectors,id',
            'target_type' => 'nullable|string|max:100',
            'target_external_id' => 'nullable|string|max:255',
            'target_name' => 'nullable|string|max:255',
            'inspection_date' => 'sometimes|required|date',
            'result' => 'nullable|string',
            'status' => 'sometimes|in:scheduled,in_progress,completed,cancelled',
        ]);

        $inspection->update($data);

        return response()->json(
            $inspection->load(['plan.type', 'inspector'])
        );
    }

    public function destroy(Inspection $inspection)
    {
        if (in_array($inspection->status, ['completed', 'in_progress'], true)) {
            return response()->json([
                'message' => 'Completed or in-progress inspections cannot be deleted.'
            ], 409);
        }

        $inspection->delete();

        return response()->json([
            'message' => 'Inspection deleted successfully.'
        ]);
    }

    public function complete(Inspection $inspection)
    {
        if ($inspection->status === 'cancelled') {
            return response()->json([
                'message' => 'A cancelled inspection cannot be completed.'
            ], 409);
        }

        $inspection->update(['status' => 'completed']);

        return response()->json([
            'message' => 'Inspection completed successfully.',
            'inspection' => $inspection->fresh(),
        ]);
    }
}
