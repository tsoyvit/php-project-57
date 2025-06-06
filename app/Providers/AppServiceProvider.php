<?php

namespace App\Providers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
    public function boot(UrlGenerator $url): void
    {
        if (app()->isProduction()) {
            $url->forceScheme('https');
        }

        Paginator::useBootstrapFive();
    }
}
