<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;

// Room view routes
Route::middleware('auth')->name('rooms.')->group(function () {
    Route::get('/rooms', [RoomController::class, 'ViewAll'])->name('index');
    Route::get('/rooms/create', [RoomController::class, 'ViewCreate'])->name('create');
    Route::get('/rooms/edit/{room}', [RoomController::class, 'ViewEdit'])->name('edit');
});
