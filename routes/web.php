<?php

use App\Http\Controllers\Auth\TelegramLoginController;
use App\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\Localization;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backends\RoleController;
use App\Http\Controllers\Backends\UserController;
use App\Http\Controllers\Backends\PermissionController;

Route::get('/', function () {
    return view('auth.login');
});
Route::get('language/{locale}', function ($locale) {
    app()->setLocale($locale);
    session()->put('locale', $locale);
    $language = \App\Models\BusinessSetting::first()->language;
    session()->put('language_settings', $language);
    return redirect()->back();
})->name('change_language');
Route::post('/api/telegram-login', [TelegramLoginController::class, 'telegramLogin'])->name('store_user.telegram');
Route::get('/telegram_callback', [TelegramLoginController::class, 'telegramAuthCallback'])->name('telegram_callback');
Route::middleware(['auth',Localization::class,SetLocale::class,])->group(function () {
    Route::resource('roles', RoleController::class);
    Route::resource('permission', PermissionController::class);
    Route::resource('users', UserController::class);
    Route::get('/user-profile/{id}',[UserController::class,'view_profile'])->name('user.view_profile');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});
Auth::routes();

foreach (glob(__DIR__ . '/view/*.php') as $filename) {
    include $filename;
}
