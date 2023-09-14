<?php

use Illuminate\Support\Facades\Route;

Route::prefix('search')->group(function(){
    Route::controller(App\Http\Controllers\LandingController::class)->group(function () {
        Route::get('/schools','schools');
        Route::get('/courses','courses');
    });
});