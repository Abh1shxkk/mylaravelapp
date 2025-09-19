<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    */
    'guards' => [
        'dashboard' => [
            'driver' => 'session',
            'provider' => 'dashboard_users',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    */
    'providers' => [
        'dashboard_users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Reset Settings
    |--------------------------------------------------------------------------
    */
    'passwords' => [
        'dashboard_users' => [
            'provider' => 'dashboard_users',
            'table' => 'dashboard_password_resets',
            'expire' => 60, // minutes
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Route Settings
    |--------------------------------------------------------------------------
    */
    'routes' => [
        'prefix' => 'dashboard',
        'middleware' => ['web'],
        'name_prefix' => 'dashboard.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Security Settings
    |--------------------------------------------------------------------------
    */
    'security' => [
        'max_login_attempts' => 3,
        'lockout_duration' => 15, // minutes
        'password_expiry_days' => 90,
        'session_lifetime' => 120, // minutes
        'require_email_verification' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Rules
    |--------------------------------------------------------------------------
    */
    'password_rules' => [
        'min_length' => 8,
        'require_uppercase' => true,
        'require_lowercase' => true,
        'require_numbers' => true,
        'require_special_chars' => true,
    ],
];