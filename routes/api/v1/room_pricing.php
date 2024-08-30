<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomPricingController;

Route::middleware('auth')
    ->name('room_pricing.')
    ->group(function () {

        Route::get('room_pricing', [RoomPricingController::class, 'index'])->name('index')->withoutMiddleware('auth');
        Route::get('room_pricing/{RoomPricing}', [RoomPricingController::class, 'show'])->name('show')->withoutMiddleware('auth');
        Route::post('room_pricing', [RoomPricingController::class, 'store'])->name('store')->withoutMiddleware('auth');
        Route::patch('room_pricing/{RoomPricing}', [RoomPricingController::class, 'update'])->name('update')->withoutMiddleware('auth');
        Route::delete('room_pricing/{RoomPricing}', [RoomPricingController::class, 'delete'])->name('delete')->withoutMiddleware('auth');

});
