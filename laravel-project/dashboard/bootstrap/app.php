<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Auth\AuthenticationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Register route middleware aliases
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
        ]);

        // Redirect guests (unauthenticated) to the dashboard login route
        $middleware->redirectGuestsTo(fn () => route('dashboard.login'));
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Redirect unauthenticated users to dashboard login instead of default 'login' route
        $exceptions->render(function (AuthenticationException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }
            return redirect()->guest(route('dashboard.login'));
        });
    })->create();
