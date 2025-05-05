<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\RateLimiter; // Use the facade
use Illuminate\Cache\RateLimiting\Limit; // Import Limit


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
        //
           // Define the rate limiter for API routes
        RateLimiter::for('api', function ($request) {
            return Limit::perMinute(60);  // Allow 60 requests per minute
        });
    
        
    }
}
