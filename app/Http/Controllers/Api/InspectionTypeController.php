<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\InspectionType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class InspectionTypeController extends Controller
{
    /**
     * Display all inspection types.
     */
    public function index()
    {
        $types = InspectionType::withCount('plans')
            ->latest()
            ->paginate(10);

        return response()->json($types);
    }

    /**
     * Store a new inspection type.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
                'unique:inspection_types,title',
            ],
            'description' => ['nullable', 'string'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $type = InspectionType::create($data);

        return response()->json([
            'message' => 'Inspection type created successfully.',
            'data' => $type,
        ], 201);
    }

    /**
     * Display a single inspection type.
     */
    public function show(InspectionType $inspection_type)
    {
        $inspection_type->load('plans');

        return response()->json([
            'data' => $inspection_type,
        ]);
    }

    /**
     * Update an inspection type.
     */
    public function update(
        Request $request,
        InspectionType $inspection_type
    ) {
        $data = $request->validate([
            'title' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('inspection_types', 'title')
                    ->ignore($inspection_type->id),
            ],
            'description' => ['sometimes', 'nullable', 'string'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $inspection_type->update($data);

        return response()->json([
            'message' => 'Inspection type updated successfully.',
            'data' => $inspection_type->fresh(),
        ]);
    }

    /**
     * Delete an inspection type.
     */
    public function destroy(InspectionType $inspection_type)
    {
        if ($inspection_type->plans()->exists()) {
            return response()->json([
                'message' => 'This type cannot be deleted because inspection plans use it.',
            ], 409);
        }

        $inspection_type->delete();

        return response()->json([
            'message' => 'Inspection type deleted successfully.',
        ]);
    }
}
