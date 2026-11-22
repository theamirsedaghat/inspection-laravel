<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Web\InspectionTypeController;
use App\Http\Controllers\Web\InspectionPlanController;
use App\Http\Controllers\Web\InspectionManagementController;

Route::get('/', [DashboardController::class, 'index'])
    ->name('dashboard');

Route::resource('inspection-types', InspectionTypeController::class);

Route::resource('inspection-plans', InspectionPlanController::class);

Route::resource('inspections', InspectionManagementController::class);

Route::post(
    '/inspections/{inspection}/items',
    [InspectionManagementController::class, 'storeItem']
)->name('inspections.items.store');

Route::put(
    '/inspection-items/{item}',
    [InspectionManagementController::class, 'updateItem']
)->name('inspection-items.update');

Route::post(
    '/inspections/{inspection}/findings',
    [InspectionManagementController::class, 'storeFinding']
)->name('inspections.findings.store');

Route::put(
    '/findings/{finding}',
    [InspectionManagementController::class, 'updateFinding']
)->name('findings.update');
Route::delete('/inspection-items/{item}', [InspectionManagementController::class, 'destroyItem'])
    ->name('inspection-items.destroy');

Route::delete('/findings/{finding}', [InspectionManagementController::class, 'destroyFinding'])
    ->name('findings.destroy');
    
Route::view('/api-tester', 'api-tester')->name('api-tester');
