<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class RateLimitServiceProvider extends ServiceProvider
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
        // Define the 'api' rate limiter
        RateLimiter::for('api', function (Request $request) {
            // Adjust these values as needed for your application
            // Example: 120 requests per minute, identified by IP address
            return Limit::perMinute(120)->by($request->ip());
        });

        // If you need other rate limiters, define them here too
        // RateLimiter::for('uploads', function (Request $request) {
        //     return Limit::perMinute(5)->by($request->user()?->id ?: $request->ip());
        // });
    }
}
