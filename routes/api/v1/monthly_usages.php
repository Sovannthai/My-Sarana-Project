<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MonthlyUsageController;

Route::middleware('auth')
    ->name('monthly_usages.')
    ->group(function () {

        Route::get('monthly_usages', [MonthlyUsageController::class, 'index'])->name('index')->withoutMiddleware('auth');
        Route::get('monthly_usages/{monthly_usage}', [MonthlyUsageController::class, 'show'])->name('show')->withoutMiddleware('auth');
        Route::post('monthly_usages', [MonthlyUsageController::class, 'store'])->name('store')->withoutMiddleware('auth');
        Route::patch('monthly_usages/{monthly_usage}', [MonthlyUsageController::class, 'update'])->name('update')->withoutMiddleware('auth');
        Route::delete('monthly_usages/{monthly_usage}', [MonthlyUsageController::class, 'destroy'])->name('delete')->withoutMiddleware('auth');

});
