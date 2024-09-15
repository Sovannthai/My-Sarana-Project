<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AmenityController;

Route::middleware('auth::')
    ->name('amenity.')
    ->group(function () {

        Route::get('amenities', [AmenityController::class, 'index'])->name('index')->withoutMiddleware('auth');
        Route::get('amenities/{amenity}', [AmenityController::class, 'show'])->name('show')->withoutMiddleware('auth');
        Route::post('amenities', [AmenityController::class, 'store'])->name('store')->withoutMiddleware('auth');
        Route::patch('amenities/{amenity}', [AmenityController::class, 'update'])->name('update')->withoutMiddleware('auth');
        Route::delete('amenities/{amenity}', [AmenityController::class, 'delete'])->name('delete')->withoutMiddleware('auth');

});
