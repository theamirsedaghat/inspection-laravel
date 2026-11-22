<?php

namespace App\Http\Controllers;

use App\Models\Inspection;
use App\Models\InspectionPlan;
use App\Models\InspectionType;
use App\Models\Inspector;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'inspectionCount' => Inspection::count(),
            'scheduledCount' => Inspection::where('status', 'scheduled')->count(),
            'completedCount' => Inspection::where('status', 'completed')->count(),
            'findingCount' => \App\Models\Finding::where('follow_up_status', 'open')->count(),
            'planCount' => InspectionPlan::count(),
            'typeCount' => InspectionType::count(),
            'inspectorCount' => Inspector::count(),
            'inspections' => Inspection::with(['plan.type', 'inspector'])
                ->latest()
                ->take(8)
                ->get(),
        ]);
    }
}
