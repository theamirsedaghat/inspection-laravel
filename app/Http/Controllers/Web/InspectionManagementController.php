<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Inspection;
use App\Models\InspectionPlan;
use App\Models\Inspector;
use App\Models\InspectionItem;
use App\Models\Finding;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class InspectionManagementController extends Controller
{
    // Display all inspections
    public function index()
    {
        $inspections = Inspection::with(['plan', 'inspector'])
            ->latest('inspection_date')
            ->paginate(10);

        return view('inspections.index', compact('inspections'));
    }

    // Show the create form
    public function create()
    {
        return view('inspections.create', [
            'inspection' => new Inspection(),
            'plans' => InspectionPlan::orderBy('title')->get(),
            'inspectors' => Inspector::where('is_active', true)
                ->orderBy('last_name')
                ->get(),
        ]);
    }

    // Store a new inspection
    public function store(Request $request)
    {
        $data = $request->validate([
            'inspection_plan_id' => 'required|exists:inspection_plans,id',
            'inspector_id' => [
                'required',
                Rule::exists('inspectors', 'id')
                    ->where('is_active', true),
            ],
            'target_type' => 'nullable|string|max:100',
            'target_external_id' => 'nullable|integer|min:1',
            'target_name' => 'nullable|string|max:255',
            'inspection_date' => 'required|date',
            'result' => 'nullable|string|max:5000',
            'status' => 'required|in:scheduled,in_progress,completed,cancelled',
        ]);

        Inspection::create($data);

        return redirect()
            ->route('inspections.index')
            ->with('success', 'Inspection created successfully.');
    }

    // Display one inspection and its related records
    public function show(Inspection $inspection)
    {
        $inspection->load([
            'plan.type',
            'inspector',
            'items',
            'findings',
        ]);

        return view('inspections.show', compact('inspection'));
    }

    // Show the edit form
    public function edit(Inspection $inspection)
    {
        return view('inspections.edit', [
            'inspection' => $inspection,
            'plans' => InspectionPlan::orderBy('title')->get(),
            'inspectors' => Inspector::orderBy('last_name')->get(),
        ]);
    }

    // Update an inspection
    public function update(Request $request, Inspection $inspection)
    {
        $data = $request->validate([
            'inspection_plan_id' => 'required|exists:inspection_plans,id',
            'inspector_id' => 'required|exists:inspectors,id',
            'target_type' => 'nullable|string|max:100',
            'target_external_id' => 'nullable|integer|min:1',
            'target_name' => 'nullable|string|max:255',
            'inspection_date' => 'required|date',
            'result' => 'nullable|string|max:5000',
            'status' => 'required|in:scheduled,in_progress,completed,cancelled',
        ]);

        $inspection->update($data);

        return redirect()
            ->route('inspections.show', $inspection)
            ->with('success', 'Inspection updated successfully.');
    }

    // Delete an inspection
    public function destroy(Inspection $inspection)
    {
        $inspection->delete();

        return redirect()
            ->route('inspections.index')
            ->with('success', 'Inspection deleted successfully.');
    }

    // Add an item to an inspection
    public function storeItem(Request $request, Inspection $inspection)
    {
        $data = $request->validate([
            'item_title' => 'required|string|max:255',
            'result' => 'required|in:pass,fail,not_applicable,pending',
            'notes' => 'nullable|string|max:5000',
        ]);

        $inspection->items()->create($data);

        return redirect()
            ->route('inspections.show', $inspection)
            ->with('success', 'Inspection item added successfully.');
    }

    // Update an inspection item
    public function updateItem(Request $request, InspectionItem $item)
    {
        $data = $request->validate([
            'item_title' => 'required|string|max:255',
            'result' => 'required|in:pass,fail,not_applicable,pending',
            'notes' => 'nullable|string|max:5000',
        ]);

        $item->update($data);

        return redirect()
            ->route('inspections.show', $item->inspection_id)
            ->with('success', 'Inspection item updated successfully.');
    }

    // Delete an inspection item
    public function destroyItem(InspectionItem $item)
    {
        $inspectionId = $item->inspection_id;
        $item->delete();

        return redirect()
            ->route('inspections.show', $inspectionId)
            ->with('success', 'Inspection item deleted successfully.');
    }

    // Add a finding to an inspection
    public function storeFinding(Request $request, Inspection $inspection)
    {
        $data = $request->validate([
            'finding_description' => 'required|string|max:5000',
            'severity' => 'required|in:low,medium,high,critical',
            'follow_up_status' => 'required|in:open,in_progress,resolved',
            'correction_deadline' => 'nullable|date',
        ]);

        $inspection->findings()->create($data);

        return redirect()
            ->route('inspections.show', $inspection)
            ->with('success', 'Finding added successfully.');
    }

    // Update a finding
    public function updateFinding(Request $request, Finding $finding)
    {
        $data = $request->validate([
            'finding_description' => 'required|string|max:5000',
            'severity' => 'required|in:low,medium,high,critical',
            'follow_up_status' => 'required|in:open,in_progress,resolved',
            'correction_deadline' => 'nullable|date',
        ]);

        $finding->update($data);

        return redirect()
            ->route('inspections.show', $finding->inspection_id)
            ->with('success', 'Finding updated successfully.');
    }

    // Delete a finding
    public function destroyFinding(Finding $finding)
    {
        $inspectionId = $finding->inspection_id;
        $finding->delete();

        return redirect()
            ->route('inspections.show', $inspectionId)
            ->with('success', 'Finding deleted successfully.');
    }
}
