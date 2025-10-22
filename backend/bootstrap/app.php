<?php

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
      
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Register your custom middleware here
        $middleware->alias([
            'api.key' => \App\Http\Middleware\CheckApiKey::class,
            'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class, // Ensure this alias is present
        ]);


        // You can apply 'throttle:api' to your API routes group explicitly if needed,
        // but it's often included in the default 'api' middleware stack implicitly.
        // For example, if you wanted to define a custom API group:
        // $middleware->api(prepend: [], append: ['throttle:api']);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->withProviders([ // ADD YOUR SERVICE PROVIDER HERE
        \App\Providers\RateLimitServiceProvider::class,
        // ... other service providers
    ])->create();
