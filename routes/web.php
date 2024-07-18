<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backends\RoleController;
use App\Http\Controllers\Backends\PermissionController;

Route::get('/', function () {
    return view('auth.login');
});
Route::middleware(['auth',])->group(function () {
    Route::resource('roles', RoleController::class);
    Route::resource('permission', PermissionController::class);
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
