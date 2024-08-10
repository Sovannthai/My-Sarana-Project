<?php

use App\Helpers\Routes\RouteHelper;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')
    ->group(function () {
        RouteHelper::includeRouteFiles(__DIR__ . '/api/v1');
});

