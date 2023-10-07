<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {return inertia('Index'); });
Route::middleware(['auth'])->group(function () {
    Route::resource('/home', App\Http\Controllers\HomeController::class);
    Route::resource('/staffs', App\Http\Controllers\StaffController::class);
    Route::resource('/settings', App\Http\Controllers\SettingController::class);

    Route::resource('/monitoring', App\Http\Controllers\MonitoringController::class);
    Route::resource('/schools', App\Http\Controllers\SchoolController::class);
    Route::resource('/scholars', App\Http\Controllers\Scholar\IndexController::class);
    Route::resource('/enrollments', App\Http\Controllers\Scholar\EnrollmentController::class);
    Route::resource('/financial-benefits', App\Http\Controllers\Scholar\FinancialBenefitController::class);
    Route::resource('/reimbursements', App\Http\Controllers\Scholar\ReimbursementController::class);
    Route::resource('/qualifiers', App\Http\Controllers\QualifierController::class);
    Route::resource('/insights', App\Http\Controllers\InsightController::class);
    Route::resource('/accounting', App\Http\Controllers\AccountingController::class);
    Route::resource('/monitoring', App\Http\Controllers\MonitoringController::class);
});

require __DIR__.'/auth.php';
require __DIR__.'/lists.php';
require __DIR__.'/landing.php';
require __DIR__.'/installation.php';