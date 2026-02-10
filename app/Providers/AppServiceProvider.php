<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Notifications\Channels\ArrayChannel;
use Illuminate\Support\Facades\Notification;

class AppServiceProvider extends ServiceProvider
{
      /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    public function boot()
    {
        // Registrar manualmente el canal 'array'
        Notification::extend('array', function ($app) {
            return new ArrayChannel();
        });
    }
}