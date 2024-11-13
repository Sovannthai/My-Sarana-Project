<?php

namespace App\Providers;

use App\Models\Message;
use Laravel\Passport\Passport;
use Illuminate\Pagination\Paginator;
use App\Observers\PermissionObserver;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Schema;
use App\Observers\NotificationObserver;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Permission;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();
        Permission::observe(PermissionObserver::class);
        Message::observe(NotificationObserver::class);
        // Passport::enablePasswordGrant();
        Event::listen(function (\SocialiteProviders\Manager\SocialiteWasCalled $event) {
            $event->extendSocialite('telegram', \SocialiteProviders\Telegram\Provider::class);
        });
        $this->app->singleton(\App\Services\CurrencyService::class, function ($app) {
            return new \App\Services\CurrencyService();
        });
    }
}
