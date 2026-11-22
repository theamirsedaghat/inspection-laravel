<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Inspection;
use App\Models\Finding;
use Illuminate\Http\Request;

class FindingController extends Controller
{
    public function store(Request $request, Inspection $inspection)
    {
        $data = $request->validate([
            'finding_description' => 'required|string',
            'severity' => 'sometimes|in:low,medium,high,critical',
            'follow_up_status' => 'sometimes|in:open,in_progress,resolved',
            'correction_deadline' => 'nullable|date',
        ]);

        $finding = $inspection->findings()->create($data);

        return response()->json($finding, 201);
    }

    public function update(Request $request, Finding $finding)
    {
        $data = $request->validate([
            'finding_description' => 'sometimes|required|string',
            'severity' => 'sometimes|required|in:low,medium,high,critical',
            'follow_up_status' => 'sometimes|required|in:open,in_progress,resolved',
            'correction_deadline' => 'nullable|date',
        ]);

        $finding->update($data);

        return response()->json($finding);
    }

    public function destroy(Finding $finding)
    {
        $finding->delete();

        return response()->json([
            'message' => 'Finding deleted successfully.'
        ]);
    }
}
