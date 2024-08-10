<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;

Route::middleware('auth')
    ->name('rooms.')
    ->group(function(){

        Route::get('/rooms', [RoomController::class, 'index'])->name('index')->withoutMiddleware('auth');
        Route::get('/rooms/{room}', [RoomController::class, 'show'])->name('show')->withoutMiddleware('auth');
        Route::post('/rooms', [RoomController::class, 'store'])->name('store')->withoutMiddleware('auth');
        Route::patch('/rooms/{room}', [RoomController::class, 'update'])->name('update')->withoutMiddleware('auth');
        Route::delete('/rooms/{room}', [RoomController::class, 'delete'])->name('delete')->withoutMiddleware('auth');

});
