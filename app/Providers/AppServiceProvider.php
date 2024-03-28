<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Services\ClicksendService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ClicksendService::class, function ($app) {
            return new ClicksendService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //Paginator::useBootstrapFour();
        Paginator::defaultView('vendor.pagination.bootstrap-4');
    }
}
