<?php

use App\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\Localization;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backends\MonthlyUsageController;
use App\Http\Controllers\Backends\RoleController;
use App\Http\Controllers\Backends\RoomController;
use App\Http\Controllers\Backends\UserController;
<<<<<<< HEAD
use App\Http\Controllers\Backends\InvoiceController;
use App\Http\Controllers\Auth\TelegramLoginController;
use App\Http\Controllers\Backends\ChatController;
use App\Http\Controllers\Backends\PermissionController;
use App\Http\Controllers\Backends\UserRequestController;
=======
use App\Http\Controllers\Backends\AmenityController;
use App\Http\Controllers\Auth\TelegramLoginController;
use App\Http\Controllers\Backends\UtilitiesController;
use App\Http\Controllers\Backends\PermissionController;
use App\Http\Controllers\Backends\UtilityTypeController;
use App\Http\Controllers\Backends\PriceAdjustmentController;
>>>>>>> pheakdey_branch

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
Route::middleware(['auth', Localization::class, SetLocale::class,])->group(function () {
    Route::resource('roles', RoleController::class);
    Route::resource('permission', PermissionController::class);
    Route::resource('users', UserController::class);
    Route::get('/user-profile/{id}', [UserController::class, 'view_profile'])->name('user.view_profile');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
<<<<<<< HEAD
    //send invoice

    Route::get('/send-invoice/{userId}', [InvoiceController::class, 'sendInvoiceToTelegram']);
    Route::post('/send-invoice/{userId}', [InvoiceController::class, 'sendInvoiceToTelegram'])->name('send-invoice');
    // Route::post('/send-invoice', [InvoiceController::class, 'sendInvoiceToTelegram'])->name('send-invoice');
    //chat
    Route::get('/fetch-messages', [ChatController::class, 'fetchMessages'])->name('get-chat-from-user');
    Route::get('/chat-index', [ChatController::class, 'chatIndex'])->name('chat-indext');

    //User Request
    Route::get('/user-request', [UserRequestController::class, 'index'])->name('user-request.index');
    // web.php
    Route::get('/messages/{userId}', [UserRequestController::class, 'getMessage'])->name('fetch.messages');
    Route::post('/send-message', [UserRequestController::class, 'sendMessage'])->name('send-message.send');




=======
    Route::resource('amenities', AmenityController::class);
    Route::resource('rooms', RoomController::class);
    Route::resource('price_adjustments', PriceAdjustmentController::class);


    Route::prefix('utilities')->group(function () {
        Route::get('/', [UtilitiesController::class, 'index'])->name('utilities.index');
        Route::get('create-type', [UtilitiesController::class, 'createType'])->name('utilities.createType');
        Route::post('store-type', [UtilitiesController::class, 'storeType'])->name('utilities.storeType');
        Route::get('edit-type/{utilityType}', [UtilitiesController::class, 'editType'])->name('utilities.editType');
        Route::put('update-type/{utilityType}', [UtilitiesController::class, 'updateType'])->name('utilities.updateType');
        Route::delete('destroy-type/{utilityType}', [UtilitiesController::class, 'destroyType'])->name('utilities.destroyType');

        Route::get('create-rate/{utilityType}', [UtilitiesController::class, 'createRate'])->name('utilities.createRate');
        Route::post('store-rate/{utilityType}', [UtilitiesController::class, 'storeRate'])->name('utilities.storeRate');
        Route::get('edit-rate/{utilityRate}', [UtilitiesController::class, 'editRate'])->name('utilities.editRate');
        Route::put('update-rate/{utilityRate}', [UtilitiesController::class, 'updateRate'])->name('utilities.updateRate');
        Route::delete('destroy-rate/{utilityRate}', [UtilitiesController::class, 'destroyRate'])->name('utilities.destroyRate');
    });

    Route::resource('monthly_usages', MonthlyUsageController::class);
>>>>>>> pheakdey_branch
});
Auth::routes();

foreach (glob(__DIR__ . '/view/*.php') as $filename) {
    include $filename;
}
