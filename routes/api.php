<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\InspectionTypeController;
use App\Http\Controllers\Api\InspectionPlanController;
use App\Http\Controllers\Api\InspectionController;
use App\Http\Controllers\Api\InspectorController;
use App\Http\Controllers\Api\InspectionItemController;
use App\Http\Controllers\Api\FindingController;


Route::prefix('v1')->group(function () {

    Route::apiResource('inspection-types', InspectionTypeController::class);
    Route::apiResource('inspection-plans', InspectionPlanController::class);
    Route::apiResource('inspections', InspectionController::class);
    Route::apiResource('inspectors', InspectorController::class)
        ->only(['index', 'store', 'show']);
    Route::post(
        'inspections/{inspection}/items',
        [InspectionItemController::class, 'store']
    );

    Route::put(
        'inspection-items/{inspectionItem}',
        [InspectionItemController::class, 'update']
    );

    Route::delete(
        'inspection-items/{inspectionItem}',
        [InspectionItemController::class, 'destroy']
    );

    Route::post(
        'inspections/{inspection}/findings',
        [FindingController::class, 'store']
    );

    Route::put(
        'findings/{finding}',
        [FindingController::class, 'update']
    );

    Route::delete(
        'findings/{finding}',
        [FindingController::class, 'destroy']
    );

    Route::patch(
        'inspections/{inspection}/complete',
        [InspectionController::class, 'complete']
    );

});
