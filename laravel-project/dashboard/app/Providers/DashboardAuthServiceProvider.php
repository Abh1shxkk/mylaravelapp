<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Services\AuthService;

class DashboardAuthServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Merge config
        $this->mergeConfigFrom(
            __DIR__.'/../../config/dashboard-auth.php',
            'dashboard-auth'
        );

        // Register services
        $this->app->singleton(AuthService::class);
    }

    public function boot()
    {
        // Load views
        $this->loadViewsFrom(resource_path('views/auth'), 'dashboard-auth');
        
        // Publish config
        $this->publishes([
            __DIR__.'/../../config/dashboard-auth.php' => config_path('dashboard-auth.php'),
        ], 'dashboard-auth-config');

        // Register auth guard
        $this->registerAuthGuard();
    }

    protected function registerAuthGuard()
    {
        Auth::extend('dashboard', function ($app, $name, array $config) {
            return Auth::createSessionDriver($name, $config);
        });

        // Add to config
        config(['auth.guards.dashboard' => config('dashboard-auth.guards.dashboard')]);
        config(['auth.providers.dashboard_users' => config('dashboard-auth.providers.dashboard_users')]);
        config(['auth.passwords.dashboard_users' => config('dashboard-auth.passwords.dashboard_users')]);
    }
}