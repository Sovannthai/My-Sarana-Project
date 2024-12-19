<?php

use App\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\Localization;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\SetSessionData;
use App\Http\Controllers\UtilityRateController;
use App\Http\Controllers\Backends\ChatController;
use App\Http\Controllers\Backends\RoleController;
use App\Http\Controllers\Backends\RoomController;
use App\Http\Controllers\Backends\UserController;
use App\Http\Middleware\UnreadMessagesMiddleware;
use App\Http\Controllers\Backends\AmenityController;
use App\Http\Controllers\Backends\InvoiceController;
use App\Http\Controllers\Backends\PaymentController;
use App\Http\Controllers\Auth\TelegramLoginController;
use App\Http\Controllers\Backends\UtilitiesController;
use App\Http\Controllers\Backends\PermissionController;
use App\Http\Controllers\Backends\RoomPricingController;
use App\Http\Controllers\Backends\UserRequestController;
use App\Http\Controllers\Backends\UtilityTypeController;
use App\Http\Controllers\Backends\MonthlyUsageController;
use App\Http\Controllers\Backends\UserContractController;
use App\Http\Controllers\Backends\BusinessSettingController;
use App\Http\Controllers\Backends\ExpenseCategoryController;
use App\Http\Controllers\Backends\PriceAdjustmentController;
use App\Http\Controllers\Backends\ExpenseTransactionController;

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

//Login with telegram
Route::post('/api/telegram-login', [TelegramLoginController::class, 'telegramLogin'])->name('store_user.telegram');
Route::get('/telegram_callback', [TelegramLoginController::class, 'telegramAuthCallback'])->name('telegram_callback');

Route::middleware(['auth',SetSessionData::class, Localization::class, SetLocale::class,UnreadMessagesMiddleware::class])->group(function () {
    Route::resource('roles', RoleController::class);
    Route::resource('permission', PermissionController::class);
    Route::resource('users', UserController::class);
    Route::get('/user-profile/{id}', [UserController::class, 'view_profile'])->name('user.view_profile');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    //send invoice
    Route::get('/send-invoice/{userId}', [InvoiceController::class, 'sendInvoiceToTelegram']);
    Route::post('/send-invoice/{userId}', [InvoiceController::class, 'sendInvoiceToTelegram'])->name('send-invoice');
    Route::get('/invoice/download/{userId}', [InvoiceController::class, 'downloadInvoice'])->name('invoice.download');

    //chat
    Route::get('/fetch-messages', [ChatController::class, 'fetchMessages'])->name('get-chat-from-user');
    Route::get('/chat-index', [ChatController::class, 'chatIndex'])->name('chat-indext');

    //User Request
    Route::get('/user-request', [UserRequestController::class, 'index'])->name('user-request.index');
    // Get and Sent Message
    Route::get('/messages/{userId}', [UserRequestController::class, 'getMessage'])->name('fetch.messages');
    Route::post('/send-message', [UserRequestController::class, 'sendMessage'])->name('send-message.send');

    //Room Pricing
    Route::resource('room-prices',RoomPricingController::class);
    //Business Settings
    Route::get('business-setting', [BusinessSettingController::class, 'index'])->name('business_setting.index');
    Route::put('update-business-setting', [BusinessSettingController::class, 'update'])->name('business_setting.update');




    Route::resource('amenities', AmenityController::class);
    Route::post('/update-status', [AmenityController::class, 'updateStatus'])->name('amenity.update_status');
    Route::resource('rooms', RoomController::class);
    Route::resource('price_adjustments', PriceAdjustmentController::class);


    Route::prefix('utilities')->group(function () {
        Route::get('/', [UtilitiesController::class, 'index'])->name('utilities.index');

        Route::post('store-rate/{utilityType}', [UtilitiesController::class, 'storeRate'])->name('utilities.storeRate');
        // Route::match(['get', 'post'], '/utilities/store-rate/{utilityType}', [UtilitiesController::class, 'storeRate'])
        //     ->name('utilities.storeRate');

        Route::put('update-rate/{utilityRate}', [UtilitiesController::class, 'updateRate'])->name('utilities.updateRate');
        Route::delete('destroy-rate/{utilityRate}', [UtilitiesController::class, 'destroyRate'])->name('utilities.destroyRate');
        Route::post('update-status-utilities-rate', [UtilitiesController::class, 'updateStatus'])->name('update-status-utilities');

        Route::get('/utilities_type', [UtilityTypeController::class, 'index'])->name('utilities_type.index');
        Route::post('store-type', [UtilityTypeController::class, 'store'])->name('utilities.storeType');
        Route::put('update-type/{id}', [UtilityTypeController::class, 'update'])->name('utilities.updateType');
        Route::delete('destroy/{id}', [UtilityTypeController::class, 'destroy'])->name('utilities.destroyType');
        Route::get('get-rate-by-utility/{id}', [UtilitiesController::class, 'getRate'])->name('get-rate-by-utilities_type');

    });

    Route::resource('payments', PaymentController::class);
    Route::resource('user_contracts', UserContractController::class);
    Route::resource('expense_categories', ExpenseCategoryController::class);
    Route::resource('expense_transactions', ExpenseTransactionController::class);
    Route::get('dashboard', [ExpenseTransactionController::class, 'dashboard'])->name('expense_dashboard.dashboard');

    Route::resource('monthly_usages', MonthlyUsageController::class);
    Route::get('payments/get-room-price/{contractId}', [PaymentController::class, 'getRoomPrice'])->name('payments.getRoomPrice');
    Route::get('/get-total-room-price/{id}', [PaymentController::class, 'getTotalRoomPrice'])->name('payments.getTotalRoomPrice');

    Route::get('/monthly_usages/{room}', [MonthlyUsageController::class, 'show'])->name('monthly_usages.show');
});
Auth::routes();

foreach (glob(__DIR__ . '/view/*.php') as $filename) {
    include $filename;
}
