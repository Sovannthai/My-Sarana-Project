<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PriceAdjustmentController;

Route::middleware('auth')
    ->name('price_adjustments.')
    ->group(function(){
        Route::get('/price_adjustments', [PriceAdjustmentController::class, 'index'])->name('index')->withoutMiddleware('auth'); // Public access
        Route::get('/price_adjustments/{price_adjustment}', [PriceAdjustmentController::class, 'show'])->name('show')->withoutMiddleware('auth'); // Public access
        Route::post('/price_adjustments', [PriceAdjustmentController::class, 'store'])->name('store')->withoutMiddleware('auth'); // Public access
        Route::patch('/price_adjustments/{price_adjustment}', [PriceAdjustmentController::class, 'update'])->name('update')->withoutMiddleware('auth'); // Public access
        Route::delete('/price_adjustments/{price_adjustment}', [PriceAdjustmentController::class, 'destroy'])->name('delete')->withoutMiddleware('auth'); // Public access
    });
