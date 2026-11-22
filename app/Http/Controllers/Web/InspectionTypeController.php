<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\InspectionType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class InspectionTypeController extends Controller
{
    public function index()
    {
        $types = InspectionType::withCount('plans')
            ->latest()
            ->paginate(10);

        return view('inspection-types.index', compact('types'));
    }

    public function create()
    {
        return view('inspection-types.create', [
            'type' => new InspectionType(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255|unique:inspection_types,title',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active');

        InspectionType::create($data);

        return redirect()->route('inspection-types.index')
            ->with('success', 'Inspection type created successfully.');
    }

    public function edit(InspectionType $inspection_type)
    {
        return view('inspection-types.edit', [
            'type' => $inspection_type,
        ]);
    }

    public function update(Request $request, InspectionType $inspection_type)
    {
        $data = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('inspection_types', 'title')
                    ->ignore($inspection_type->id),
            ],
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active');

        $inspection_type->update($data);

        return redirect()->route('inspection-types.index')
            ->with('success', 'Inspection type updated successfully.');
    }

    public function destroy(InspectionType $inspection_type)
    {
        if ($inspection_type->plans()->exists()) {
            return back()->withErrors([
                'delete' => 'This type is used by existing inspection plans.',
            ]);
        }

        $inspection_type->delete();

        return redirect()->route('inspection-types.index')
            ->with('success', 'Inspection type deleted successfully.');
    }
}
