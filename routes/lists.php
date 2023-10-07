<?php

use Illuminate\Support\Facades\Route;

Route::prefix('lists')->group(function(){
    Route::controller(App\Http\Controllers\ListController::class)->group(function () {
        Route::get('/','index');
        Route::get('/provinces/{code}', 'provinces');
        Route::get('/municipalities/{code}', 'municipalities');
        Route::get('/barangays/{code}', 'barangays');
        Route::get('/subcourses/{school}/{course}', 'subcourses');
        Route::get('/semester/{id}/{year}', 'semesteryear');

        Route::prefix('search')->group(function(){
            Route::post('/schools', 'schools');
            Route::post('/courses', 'courses');
            Route::post('/scholars', 'scholars');
            Route::post('/expenses', 'expenses');
        });
    });
});