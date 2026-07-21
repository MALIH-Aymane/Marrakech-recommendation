<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;

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
    Paginator::useBootstrapFive();

    View::composer('*', function ($view) {

        if (Auth::check()) {

            $view->with(
                'notifications',
                Auth::user()->unreadNotifications()->latest()->take(5)->get()
            );

            $view->with(
                'notificationCount',
                Auth::user()->unreadNotifications()->count()
            );

        }

    });
}
}
