<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\InspectionPlan;
use App\Models\InspectionType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class InspectionPlanController extends Controller
{
    public function index()
    {
        $plans = InspectionPlan::with('type')
            ->withCount('inspections')
            ->latest()
            ->paginate(10);

        return view('inspection-plans.index', compact('plans'));
    }

    public function create()
    {
        return view('inspection-plans.create', [
            'plan' => new InspectionPlan(),
            'types' => InspectionType::where('is_active', true)
                ->orderBy('title')
                ->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'inspection_type_id' => [
                'required',
                'integer',
                Rule::exists('inspection_types', 'id')
                    ->where('is_active', true),
            ],
            'title' => 'required|string|max:255',
            'planned_date' => 'required|date',
            'frequency' => 'required|in:weekly,monthly,yearly',
            'end_date' => 'nullable|date|after_or_equal:planned_date',
            'status' => 'required|in:draft,active,completed,cancelled',
        ]);

        InspectionPlan::create($data);

        return redirect()
            ->route('inspection-plans.index')
            ->with('success', 'Inspection plan created successfully.');
    }

    public function show(InspectionPlan $inspection_plan)
    {
        $inspection_plan->load(['type', 'inspections.inspector']);

        return view('inspection-plans.show', [
            'plan' => $inspection_plan,
        ]);
    }

    public function edit(InspectionPlan $inspection_plan)
    {
        return view('inspection-plans.edit', [
            'plan' => $inspection_plan,
            'types' => InspectionType::orderBy('title')->get(),
        ]);
    }

    public function update(
        Request $request,
        InspectionPlan $inspection_plan
    ) {
        $data = $request->validate([
            'inspection_type_id' => 'required|integer|exists:inspection_types,id',
            'title' => 'required|string|max:255',
            'planned_date' => 'required|date',
            'frequency' => 'required|in:weekly,monthly,yearly',
            'end_date' => 'nullable|date|after_or_equal:planned_date',
            'status' => 'required|in:draft,active,completed,cancelled',
        ]);

        $inspection_plan->update($data);

        return redirect()
            ->route('inspection-plans.index')
            ->with('success', 'Inspection plan updated successfully.');
    }

    public function destroy(InspectionPlan $inspection_plan)
    {
        if ($inspection_plan->inspections()->exists()) {
            return back()->withErrors([
                'delete' => 'This plan has inspections and cannot be deleted.',
            ]);
        }

        $inspection_plan->delete();

        return redirect()
            ->route('inspection-plans.index')
            ->with('success', 'Inspection plan deleted successfully.');
    }
}
