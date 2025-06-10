<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;

class TimezoneServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Set Carbon locale to Indonesian
        Carbon::setLocale('id');

        // Set default timezone for PHP
        date_default_timezone_set(config('app.timezone'));
    }
}
