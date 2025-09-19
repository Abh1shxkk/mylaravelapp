<?php

namespace YourName\DashboardAuth\Middleware;

use Closure;
use Illuminate\Support\Facades\RateLimiter;

class RateLimitLogin
{
    public function handle($request, Closure $next)
    {
        $key = 'login_attempts:' . $request->ip();
        
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->withErrors([
                'email' => "Too many login attempts. Please try again in {$seconds} seconds."
            ]);
        }

        $response = $next($request);

        // If login failed, increment rate limiter
        if ($response->isRedirect() && $response->getSession()->has('errors')) {
            RateLimiter::hit($key, 300); // 5 minutes lockout
        } else {
            RateLimiter::clear($key);
        }

        return $response;
    }
}
