<?php

use Illuminate\Support\Facades\Route;

Route::get('/installation', function () {  return inertia('Installation/Index'); });
Route::prefix('sync')->group(function(){
    Route::get('/addresses/{type}/{category}', [App\Http\Controllers\SyncController::class, 'addresses']);
    Route::get('/lists/{type}/{category}', [App\Http\Controllers\SyncController::class, 'lists']);
    Route::get('/schools/{type}/{category}/{agency?}', [App\Http\Controllers\SyncController::class, 'schools']);
    Route::get('/schools/count', [App\Http\Controllers\SyncController::class, 'schoolcount']);
    Route::get('/scholars', [App\Http\Controllers\SyncController::class, 'scholars']);
    Route::get('/qualifiers', [App\Http\Controllers\SyncController::class, 'qualifiers']);
    Route::get('/settings', [App\Http\Controllers\SyncController::class, 'settings']);
});