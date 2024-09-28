<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;

Route::name('rooms.')->group(function () {
    Route::get('/rooms', [RoomController::class, 'index'])->name('showAdd'); // List all rooms
    Route::get('/rooms/{room}', [RoomController::class, 'show'])->name('show'); // Show a single room
    Route::post('/rooms', [RoomController::class, 'store'])->name('store'); // Create a new room
    Route::put('/rooms/{room}', [RoomController::class, 'update'])->name('update'); // Update a room
    Route::delete('/rooms/{room}', [RoomController::class, 'destroy'])->name('delete'); // Delete a room
});
