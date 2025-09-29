<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\SubscriptionController; // Add this line
use App\Http\Controllers\StripeController;
use App\Http\Controllers\TransactionsController;
use Illuminate\Support\Facades\Auth;use App\Http\Controllers\StripeWebhookController;

use App\Models\Subscription as SubscriptionModel;
use App\Http\Controllers\NotificationsController;

Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

// Home redirect
Route::get('/', function () {
    return redirect('/dashboard/login');
});

// Simple auth routes
Route::get('/dashboard/login', [AuthController::class, 'showLogin'])->name('dashboard.login');
Route::post('/dashboard/login', [AuthController::class, 'login']);
Route::post('/dashboard/forgot-email', [AuthController::class, 'forgotEmail'])->name('dashboard.forgot-email');

Route::get('/dashboard/register', [AuthController::class, 'showRegister'])->name('dashboard.register');
Route::post('/dashboard/register', [AuthController::class, 'register']);

// Password reset routes
use App\Http\Controllers\PasswordResetController;
Route::post('/dashboard/password/email', [PasswordResetController::class, 'sendResetLink'])->name('dashboard.password.email');
Route::get('/dashboard/password/reset', [PasswordResetController::class, 'showResetForm'])->name('dashboard.password.request');
Route::post('/dashboard/password/reset', [PasswordResetController::class, 'resetPassword'])->name('dashboard.password.update');
Route::get('/dashboard/password/forgot', function () {
    return view('auth.forgot-password');
})->name('dashboard.password.forgot');

// Protected routes
Route::middleware(['auth'])->group(function () {
    // Dashboard home
    Route::get('/dashboard/home', [AuthController::class, 'home'])->name('dashboard.home');
    Route::get('/dashboard', [AuthController::class, 'home'])->name('dashboard'); // Alternative route
    Route::post('/dashboard/logout', [AuthController::class, 'logout'])->name('dashboard.logout');
    
    // Profile management routes
    Route::get('/profile/settings', [ProfileController::class, 'show'])->name('profile.settings');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/upload-picture', [ProfileController::class, 'uploadPicture'])->name('profile.upload-picture');
    Route::delete('/profile/remove-picture', [ProfileController::class, 'removePicture'])->name('profile.remove-picture');
    Route::patch('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');


    // Subscription routes
    Route::post('/subscribe', [SubscriptionController::class, 'subscribe'])->name('subscription.subscribe');
    Route::post('/subscribe/verify', [SubscriptionController::class, 'verify'])->name('subscription.verify');
    Route::post('/cancel-subscription', [SubscriptionController::class, 'cancel'])->name('subscription.cancel');

    // Subscription result pages
    Route::get('/subscription/success', function() { return view('subscription.success'); })->name('subscription.success.view');
    Route::get('/subscription/cancelled', function() { return view('subscription.cancelled'); })->name('subscription.cancelled.view');

    // Live subscription status endpoint
    Route::get('/subscription/status', function() {
        $user = Auth::user();
        $sub = $user ? $user->subscriptions()->where('status','active')->latest('started_at')->first() : null;
        return response()->json([
            'active' => (bool) $sub,
            'plan_id' => $sub->plan_id ?? null,
            'started_at' => optional($sub->started_at)->toIso8601String(),
            'ended_at' => optional($sub->ended_at)->toIso8601String(),
            'status' => $sub->status ?? null,
        ]);
    })->name('subscription.status');

    // Weather API proxy
    Route::get('/weather/current', [WeatherController::class, 'current'])->name('weather.current');

    // Transactions
    Route::get('/transactions', [TransactionsController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/{payment}/invoice', [TransactionsController::class, 'invoice'])->name('transactions.invoice');
    Route::get('/transactions/{payment}/invoice/partial', [TransactionsController::class, 'invoicePartial'])->name('transactions.invoice.partial');
    Route::delete('/transactions/{payment}', [TransactionsController::class, 'destroy'])->name('transactions.destroy');

    // Stripe routes
    Route::post('/stripe/checkout', [StripeController::class, 'createCheckoutSession'])->name('stripe.checkout');
    Route::get('/stripe/success', [StripeController::class, 'success'])->name('stripe.success');
    Route::get('/stripe/cancel', [StripeController::class, 'cancel'])->name('stripe.cancel');

    // Notifications
    Route::get('/notifications', [NotificationsController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/unread-count', [NotificationsController::class, 'unreadCount'])->name('notifications.unread');
    Route::post('/notifications/read-all', [NotificationsController::class, 'markAllRead'])->name('notifications.read_all');
    Route::post('/notifications/{notification}/read', [NotificationsController::class, 'markRead'])->name('notifications.read');
    // Admin: Users CRUD
    Route::middleware(['role:admin'])->prefix('dashboard/admin')->as('admin.')->group(function () {
        Route::get('/users', [\App\Http\Controllers\Admin\AdminUserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [\App\Http\Controllers\Admin\AdminUserController::class, 'create'])->name('users.create');
        Route::post('/users', [\App\Http\Controllers\Admin\AdminUserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}', [\App\Http\Controllers\Admin\AdminUserController::class, 'show'])->name('users.show');
        Route::get('/users/{user}/edit', [\App\Http\Controllers\Admin\AdminUserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [\App\Http\Controllers\Admin\AdminUserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [\App\Http\Controllers\Admin\AdminUserController::class, 'destroy'])->name('users.destroy');
        
        // Admin: Payment Management
        Route::prefix('payment')->as('payment.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\PaymentController::class, 'index'])->name('index');
            Route::post('/gateways', [\App\Http\Controllers\Admin\PaymentController::class, 'updateGateways'])->name('gateways.update');
            Route::get('/plans', [\App\Http\Controllers\Admin\PaymentController::class, 'plans'])->name('plans');
            Route::get('/plans.json', [\App\Http\Controllers\Admin\PaymentController::class, 'plansJson'])->name('plans.json');
            Route::get('/plans/create', [\App\Http\Controllers\Admin\PaymentController::class, 'createPlan'])->name('plans.create');
            Route::post('/plans', [\App\Http\Controllers\Admin\PaymentController::class, 'storePlan'])->name('plans.store');
            Route::get('/plans/{plan}/edit', [\App\Http\Controllers\Admin\PaymentController::class, 'editPlan'])->name('plans.edit');
            Route::put('/plans/{plan}', [\App\Http\Controllers\Admin\PaymentController::class, 'updatePlan'])->name('plans.update');
            Route::delete('/plans/{plan}', [\App\Http\Controllers\Admin\PaymentController::class, 'destroyPlan'])->name('plans.destroy');
            Route::get('/subscribers', [\App\Http\Controllers\Admin\PaymentController::class, 'subscribers'])->name('subscribers');
            Route::put('/subscriptions/{subscription}', [\App\Http\Controllers\Admin\PaymentController::class, 'updateSubscription'])->name('subscriptions.update');
            Route::get('/revenue', [\App\Http\Controllers\Admin\PaymentController::class, 'revenue'])->name('revenue');
        });

        // Admin: Subscription reconcile (carryover fix)
        Route::post('/subscriptions/reconcile', [\App\Http\Controllers\Admin\SubscriptionAdminController::class, 'reconcile'])->name('subscriptions.reconcile');
    });
});

// Stripe webhook (no auth)
Route::post('/stripe/webhook', [StripeController::class, 'webhook'])->name('stripe.webhook');

// Role-based routes (optional - add these if you want role-based access)

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/users', function () {
        return view('admin.users');
    })->name('admin.users');
    
    Route::get('/admin/settings', function () {
        return view('admin.settings');
    })->name('admin.settings');
});

Route::middleware(['auth', 'role:admin,manager'])->group(function () {
    Route::get('/reports', function () {
        return view('reports.index');
    })->name('reports.index');
});

Route::post('/stripe/webhook', [StripeWebhookController::class, 'handle']);


// Removed duplicate Google OAuth routes that conflicted with Auth\GoogleController
