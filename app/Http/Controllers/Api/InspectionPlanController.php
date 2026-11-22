<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\InspectionPlan;
use Illuminate\Http\Request;

class InspectionPlanController extends Controller
{
    public function index()
    {
        return response()->json(
            InspectionPlan::with(['type', 'inspections'])
                ->latest()
                ->paginate(10)
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'inspection_type_id' => 'required|exists:inspection_types,id',
            'title' => 'required|string|max:255',
            'planned_date' => 'required|date',
            'frequency' => 'required|in:weekly,monthly,yearly',
            'end_date' => 'nullable|date|after_or_equal:planned_date',
            'status' => 'sometimes|in:draft,active,completed,cancelled',
        ]);

        $plan = InspectionPlan::create($data);

        return response()->json(
            $plan->load('type'),
            201
        );
    }

    public function show(InspectionPlan $inspectionPlan)
    {
        return response()->json(
            $inspectionPlan->load(['type', 'inspections.inspector'])
        );
    }

    public function update(Request $request, InspectionPlan $inspectionPlan)
    {
        $data = $request->validate([
            'inspection_type_id' => 'sometimes|required|exists:inspection_types,id',
            'title' => 'sometimes|required|string|max:255',
            'planned_date' => 'sometimes|required|date',
            'frequency' => 'sometimes|required|in:weekly,monthly,yearly',
            'end_date' => 'nullable|date',
            'status' => 'sometimes|in:draft,active,completed,cancelled',
        ]);

        $inspectionPlan->update($data);

        return response()->json($inspectionPlan->load('type'));
    }

    public function destroy(InspectionPlan $inspectionPlan)
    {
        if ($inspectionPlan->inspections()->exists()) {
            return response()->json([
                'message' => 'This plan has inspections and cannot be deleted.'
            ], 409);
        }

        $inspectionPlan->delete();

        return response()->json([
            'message' => 'Inspection plan deleted successfully.'
        ]);
    }
}
