<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UtilityRateController;

Route::middleware('auth')
    ->name('utility_rates.')
    ->group(function(){
        Route::get('/utility_rates', [UtilityRateController::class, 'index'])->name('index')->withoutMiddleware('auth'); // Public access
        Route::get('/utility_rates/{room}', [UtilityRateController::class, 'show'])->name('show')->withoutMiddleware('auth'); // Public access
        Route::post('/utility_rates', [UtilityRateController::class, 'store'])->name('store')->withoutMiddleware('auth'); // Public access
        Route::patch('/utility_rates/{room}', [UtilityRateController::class, 'update'])->name('update')->withoutMiddleware('auth'); // Public access
        Route::delete('/utility_rates/{room}', [UtilityRateController::class, 'destroy'])->name('delete')->withoutMiddleware('auth'); // Public access
    });
