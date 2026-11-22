<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Inspector;
use Illuminate\Http\Request;

class InspectorController extends Controller
{
    public function index()
    {
        return response()->json(Inspector::latest()->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'personnel_code' => 'required|string|max:100|unique:inspectors,personnel_code',
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'specialty' => 'nullable|string|max:255',
            'is_active' => 'sometimes|boolean',
        ]);

        $inspector = Inspector::create($data);

        return response()->json($inspector, 201);
    }

    public function show(Inspector $inspector)
    {
        return response()->json($inspector);
    }
}
