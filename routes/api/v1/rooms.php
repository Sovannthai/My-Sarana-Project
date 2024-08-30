<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;

Route::middleware('auth')
    ->name('rooms.')
    ->group(function(){
        Route::get('/rooms', [RoomController::class, 'index'])->name('index')->withoutMiddleware('auth'); // Public access
        Route::get('/rooms/{room}', [RoomController::class, 'show'])->name('show')->withoutMiddleware('auth'); // Public access
        Route::post('/rooms', [RoomController::class, 'store'])->name('store')->withoutMiddleware('auth'); // Public access
        Route::patch('/rooms/{room}', [RoomController::class, 'update'])->name('update')->withoutMiddleware('auth'); // Public access
        Route::delete('/rooms/{room}', [RoomController::class, 'destroy'])->name('delete')->withoutMiddleware('auth'); // Public access
    });
