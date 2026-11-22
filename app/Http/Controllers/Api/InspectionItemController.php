<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Inspection;
use App\Models\InspectionItem;
use Illuminate\Http\Request;

class InspectionItemController extends Controller
{
    public function store(Request $request, Inspection $inspection)
    {
        $data = $request->validate([
            'item_title' => 'required|string|max:255',
            'result' => 'sometimes|in:pass,fail,not_applicable,pending',
            'notes' => 'nullable|string',
        ]);

        $item = $inspection->items()->create($data);

        return response()->json($item, 201);
    }

    public function update(Request $request, InspectionItem $inspectionItem)
    {
        $data = $request->validate([
            'item_title' => 'sometimes|required|string|max:255',
            'result' => 'sometimes|required|in:pass,fail,not_applicable,pending',
            'notes' => 'nullable|string',
        ]);

        $inspectionItem->update($data);

        return response()->json($inspectionItem);
    }

    public function destroy(InspectionItem $inspectionItem)
    {
        $inspectionItem->delete();

        return response()->json([
            'message' => 'Inspection item deleted successfully.'
        ]);
    }
}
