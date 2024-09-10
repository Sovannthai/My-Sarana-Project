<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomPricingController;

Route::middleware('auth')
    ->name('room_pricing.')
    ->group(function () {

        Route::get('room_pricings', [RoomPricingController::class, 'index'])->name('index')->withoutMiddleware('auth');
        Route::get('room_pricings/{RoomPricing}', [RoomPricingController::class, 'show'])->name('show')->withoutMiddleware('auth');
        Route::post('room_pricings', [RoomPricingController::class, 'store'])->name('store')->withoutMiddleware('auth');
        Route::patch('room_pricings/{RoomPricing}', [RoomPricingController::class, 'update'])->name('update')->withoutMiddleware('auth');
        Route::delete('room_pricings/{RoomPricing}', [RoomPricingController::class, 'destroy'])->name('delete')->withoutMiddleware('auth');

});
