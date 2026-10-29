<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\IsLoggedIn;
use App\Http\Middleware\AdminValidation;
use App\Http\Middleware\SellerValidation;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {

        // Route Middleware Aliases
        $middleware->alias([
            // Your custom middlewares
            'IsLoggedIn'       => IsLoggedIn::class,
            'AdminValidation'  => AdminValidation::class,
            'SellerValidation' => SellerValidation::class,

            // JWT middleware (REQUIRED FOR TOKEN AUTH)
            'jwt.auth'    => \Tymon\JWTAuth\Http\Middleware\Authenticate::class,
            'jwt.verify'  => \Tymon\JWTAuth\Http\Middleware\VerifyToken::class,
            'jwt.refresh' => \Tymon\JWTAuth\Http\Middleware\RefreshToken::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // You can add custom exception handling here if needed
    })
    ->create();
