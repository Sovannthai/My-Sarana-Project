<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use App\Observers\PermissionObserver;
use Illuminate\Support\Facades\Schema;
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
    }
}
