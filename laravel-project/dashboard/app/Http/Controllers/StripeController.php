<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Subscription;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\SubscriptionPurchased;
use Carbon\Carbon;
use Stripe\StripeClient;
use App\Models\ActivityNotification;
use App\Models\User;

class StripeController extends Controller
{
    public function createCheckoutSession(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|string',
        ]);

        $plan = Plan::where('slug', $request->plan_id)->firstOrFail();
        if (empty($plan->stripe_price_id)) {
            return response()->json(['success' => false, 'message' => 'Stripe price not configured for this plan.'], 422);
        }

        if (!config('services.stripe.secret')) {
            return response()->json(['success' => false, 'message' => 'Stripe secret key is not configured. Set STRIPE_SECRET in .env and clear config cache.'], 422);
        }

        try {
            // Capture carryover seconds from current active custom plan (if any)
            try {
                $currentActive = Auth::user()->subscriptions()
                    ->where('status', 'active')
                    ->latest('started_at')
                    ->first();
                $carryoverSeconds = 0;
                if ($currentActive && $currentActive->ended_at && now()->lt($currentActive->ended_at)) {
                    $currentPlan = Plan::where('slug', $currentActive->plan_id)->first();
                    if ($currentPlan && $currentPlan->billing_period === 'custom') {
                        $carryoverSeconds = max(0, $currentActive->ended_at->diffInSeconds(now()));
                    }
                }
                if ($carryoverSeconds > 0) {
                    session(['subscription_carryover' => $carryoverSeconds]);
                } else {
                    session()->forget('subscription_carryover');
                }
            } catch (\Throwable $e) {
                // ignore carryover errors
            }

            $stripe = new StripeClient(config('services.stripe.secret'));

            // Ensure Stripe customer exists for autopay (future off-session renewals)
            $user = Auth::user();
            if (!$user->stripe_customer_id) {
                try {
                    $customer = $stripe->customers->create([
                        'email' => $user->email,
                        'name' => $user->name,
                        'metadata' => [ 'app_user_id' => $user->id ],
                    ]);
                    $user->stripe_customer_id = $customer->id;
                    $user->save();
                } catch (\Throwable $e) {
                    Log::error('Failed to create Stripe customer: '.$e->getMessage());
                }
            }

            // Create a Checkout Session for subscription
            $session = $stripe->checkout->sessions->create([
                'mode' => 'subscription',
                'payment_method_types' => ['card'],
                'customer' => $user->stripe_customer_id ?: null,
                'line_items' => [[
                    'price' => $plan->stripe_price_id,
                    'quantity' => 1,
                ]],
                'success_url' => url('/stripe/success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => url('/stripe/cancel') . '?session_id={CHECKOUT_SESSION_ID}&plan=' . $plan->slug,
                'metadata' => [
                    'user_id' => Auth::id(),
                    'plan_slug' => $plan->slug,
                ],
            ]);
            
            // Cache session id for cancel flow
            try { 
                session(['last_checkout_session_id' => $session->id]); 
                session(['last_checkout_plan' => $plan->slug]);
            } catch (\Throwable $e) {}

            // Create pending payment record immediately
            try {
                Payment::create([
                    'user_id' => Auth::id(),
                    'plan_id' => $plan->slug,
                    'provider' => 'stripe',
                    'payment_id' => null,
                    'subscription_id' => null,
                    'amount' => (int) ($plan->price ?? 0),
                    'currency' => 'INR',
                    'status' => 'pending',
                    'paid_at' => null,
                    'meta' => [
                        'checkout_session_id' => $session->id,
                        'checkout_url' => $session->url,
                        'customer_email' => Auth::user()->email,
                    ],
                ]);
            } catch (\Throwable $e) {
                Log::error('Failed to create pending payment: ' . $e->getMessage());
            }

            return response()->json([
                'success' => true,
                'id' => $session->id,
                'url' => $session->url,
                'public_key' => config('services.stripe.public'),
            ]);
        } catch (\Stripe\Exception\ApiErrorException $e) {
            Log::error('Stripe Checkout error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        } catch (\Throwable $e) {
            Log::error('Stripe Checkout unexpected error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Unexpected error starting checkout.'], 500);
        }
    }

    public function success(Request $request)
    {
        $sessionId = $request->query('session_id');
        if (!$sessionId) {
            return redirect()->route('dashboard.home')->with('error', 'Missing session id');
        }

        $stripe = new StripeClient(config('services.stripe.secret'));
        $session = $stripe->checkout->sessions->retrieve($sessionId, ['expand' => ['subscription']]);

        $planSlug = $session->metadata['plan_slug'] ?? null;
        if (!$planSlug) {
            return redirect()->route('dashboard.home')->with('error', 'Invalid session metadata');
        }

        // Single-row model: upsert by user_id only
        // Determine ended_at for custom-duration plans
        $plan = Plan::where('slug', $planSlug)->first();
        $startedAt = now();
        $endedAt = null;
        if ($plan && ($plan->billing_period === 'custom') && $plan->duration_value && $plan->duration_unit) {
            $calc = Carbon::parse($startedAt)->copy();
            switch ($plan->duration_unit) {
                case 'minutes': $calc->addMinutes($plan->duration_value); break;
                case 'hours': $calc->addHours($plan->duration_value); break;
                case 'days': $calc->addDays($plan->duration_value); break;
                case 'weeks': $calc->addWeeks($plan->duration_value); break;
                case 'months': $calc->addMonths($plan->duration_value); break;
                case 'years': $calc->addYears($plan->duration_value); break;
            }
            $endedAt = $calc;
        }

        // Apply carryover seconds if present and target plan is custom
        try {
            $carry = (int) session('subscription_carryover', 0);
            if ($carry > 0 && $plan && $plan->billing_period === 'custom') {
                $endedAt = ($endedAt ?: Carbon::parse($startedAt)->copy())->addSeconds($carry);
            }
            session()->forget('subscription_carryover');
        } catch (\Throwable $e) {
            // ignore carryover
        }

        $subscription = Subscription::updateOrCreate(
            [ 'user_id' => Auth::id() ],
            [
                'plan_id' => $planSlug,
                'stripe_subscription_id' => is_object($session->subscription) ? $session->subscription->id : $session->subscription,
                'status' => 'active',
                'started_at' => $startedAt,
                'ended_at' => $endedAt,
            ]
        );

        // Update existing pending payment or create new one
        try {
            $existingPayment = Payment::where('user_id', Auth::id())
                ->where('provider', 'stripe')
                ->where('status', 'pending')
                ->where('meta->checkout_session_id', $sessionId)
                ->first();

            if ($existingPayment) {
                $existingPayment->update([
                    'payment_id' => $session->payment_intent ?? ($session->id ?? null),
                    'subscription_id' => is_object($session->subscription) ? $session->subscription->id : $session->subscription,
                    'status' => 'paid',
                    'paid_at' => now(),
                    'meta' => array_merge($existingPayment->meta ?? [], [
                        'customer_email' => Auth::user()->email ?? null,
                        'updated_at_success' => now()->toIso8601String(),
                    ]),
                ]);
            } else {
                Payment::create([
                    'user_id' => Auth::id(),
                    'plan_id' => $planSlug,
                    'provider' => 'stripe',
                    'payment_id' => $session->payment_intent ?? ($session->id ?? null),
                    'subscription_id' => is_object($session->subscription) ? $session->subscription->id : $session->subscription,
                    'amount' => (int) ($plan->price ?? 0),
                    'currency' => 'INR',
                    'status' => 'paid',
                    'paid_at' => now(),
                    'meta' => [
                        'checkout_session_id' => $session->id ?? null,
                        'customer_email' => Auth::user()->email ?? null,
                    ],
                ]);
            }
        } catch (\Throwable $e) {
            Log::error('Payment record update failed: ' . $e->getMessage());
        }

        // Send confirmation email to the user
        try {
            $user = Auth::user();
            $plan = $plan ?: Plan::where('slug', $planSlug)->first();
            if ($user && $user->email && $plan) {
                Mail::to($user->email)->send(new SubscriptionPurchased($user, $plan, $subscription));
            }
        } catch (\Throwable $e) {
            // Avoid breaking UX if email fails
            Log::error('Email sending failed in Stripe success: ' . $e->getMessage());
        }

        // Notify user about successful subscription purchase
        try {
            ActivityNotification::create([
                'user_id' => Auth::id(),
                'type' => 'subscription_created',
                'title' => 'Subscription purchased',
                'body' => 'Plan: '.$planSlug,
                'data' => [ 'stripe_subscription_id' => $subscription->stripe_subscription_id ],
            ]);
        } catch (\Throwable $e) {}

        // Redirect to success page with lightweight session info
        return redirect()->route('subscription.success.view')
            ->with('plan', $planSlug)
            ->with('amount', (int) ($plan->price ?? 0));

        // no further code
    }

    public function cancel(Request $request)
    {
        $sessionId = $request->query('session_id');
        $planSlug = $request->query('plan');

        // Update pending payment to cancelled
        try {
            if ($sessionId && Auth::check()) {
                $pendingPayment = Payment::where('user_id', Auth::id())
                    ->where('provider', 'stripe')
                    ->where('status', 'pending')
                    ->where('meta->checkout_session_id', $sessionId)
                    ->first();

                if ($pendingPayment) {
                    $pendingPayment->update([
                        'status' => 'cancelled',
                        'meta' => array_merge($pendingPayment->meta ?? [], [
                            'cancelled_at' => now()->toIso8601String(),
                        ]),
                    ]);
                } else {
                    // Create cancelled payment record if pending doesn't exist
                    Payment::create([
                        'user_id' => Auth::id(),
                        'plan_id' => $planSlug ?: session('last_checkout_plan'),
                        'provider' => 'stripe',
                        'payment_id' => null,
                        'subscription_id' => null,
                        'amount' => null,
                        'currency' => 'INR',
                        'status' => 'cancelled',
                        'paid_at' => null,
                        'meta' => [
                            'checkout_session_id' => $sessionId,
                            'cancelled_at' => now()->toIso8601String(),
                        ],
                    ]);
                }
            }
        } catch (\Throwable $e) {
            Log::error('Cancel payment update failed: ' . $e->getMessage());
        }

        // Also try to record failed transactions
        try {
            $lastSessionId = session('last_checkout_session_id');
            if ($lastSessionId && Auth::check()) {
                $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
                $session = $stripe->checkout->sessions->retrieve($lastSessionId, [ 'expand' => ['payment_intent', 'subscription', 'invoice'] ]);
                
                $pi = is_object($session->payment_intent ?? null) ? $session->payment_intent : null;
                $piStatus = $pi ? ($pi->status ?? null) : null;
                $lastError = $pi->last_payment_error->message ?? null;
                $failed = $pi && $piStatus !== 'succeeded';
                
                if ($failed) {
                    $exists = Payment::where('user_id', Auth::id())
                        ->where('provider', 'stripe')
                        ->whereIn('status', ['failed','paid'])
                        ->where(function($q) use ($lastSessionId){ 
                            $q->where('meta->checkout_session_id', $lastSessionId)
                              ->orWhere('payment_id', $lastSessionId); 
                        })
                        ->exists();
                        
                    if (!$exists) {
                        $invoiceId = is_object($session->invoice ?? null) ? $session->invoice->id : ($session->invoice ?? null);
                        $subId = is_object($session->subscription ?? null) ? $session->subscription->id : ($session->subscription ?? null);
                        $chargeId = null;
                        if ($pi && isset($pi->latest_charge)) {
                            $chargeId = is_object($pi->latest_charge) ? ($pi->latest_charge->id ?? null) : ($pi->latest_charge ?? null);
                        }
                        
                        Payment::create([
                            'user_id' => Auth::id(),
                            'plan_id' => $planSlug ?: session('last_checkout_plan'),
                            'provider' => 'stripe',
                            'payment_id' => $pi->id ?? null,
                            'subscription_id' => $subId,
                            'amount' => null,
                            'currency' => 'INR',
                            'status' => 'failed',
                            'paid_at' => null,
                            'meta' => [
                                'checkout_session_id' => $lastSessionId,
                                'invoice_id' => $invoiceId,
                                'charge_id' => $chargeId,
                                'failure_message' => $lastError,
                                'pi_status' => $piStatus,
                            ],
                        ]);
                    }
                }
            }
        } catch (\Throwable $e) {
            Log::error('Failed transaction logging error: ' . $e->getMessage());
        }
        
        // Notify user of cancellation/abandoned checkout
        try {
            ActivityNotification::create([
                'user_id' => Auth::id(),
                'type' => 'subscription_cancelled_checkout',
                'title' => 'Checkout cancelled',
                'body' => 'You cancelled the payment before completion.',
                'data' => [ 'session_id' => $sessionId, 'plan' => $planSlug ],
            ]);
        } catch (\Throwable $e) {}

        return redirect()->route('subscription.cancelled.view');
    }

    public function webhook(Request $request)
    {
        $signature = $request->header('Stripe-Signature');
        $secret = config('services.stripe.webhook_secret');
        $payload = $request->getContent();

        try {
            $event = \Stripe\Webhook::constructEvent($payload, $signature, $secret);
        } catch (\Throwable $e) {
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        switch ($event->type) {
            case 'customer.subscription.updated':
            case 'customer.subscription.created':
            case 'customer.subscription.deleted':
                $subscription = $event->data->object;
                $status = $subscription->status;
                $userId = $subscription->metadata->user_id ?? null;
                $planSlug = $subscription->metadata->plan_slug ?? null;

                if ($userId && $planSlug) {
                    Subscription::updateOrCreate(
                        [
                            'user_id' => $userId,
                            'plan_id' => $planSlug,
                        ],
                        [
                            'stripe_subscription_id' => $subscription->id,
                            'status' => $status === 'active' ? 'active' : ($status === 'canceled' ? 'cancelled' : 'created'),
                            'started_at' => $status === 'active' ? now() : null,
                            'ended_at' => $status === 'canceled' ? now() : null,
                        ]
                    );
                    try {
                        $title = $event->type === 'customer.subscription.deleted' ? 'Subscription cancelled' : 'Subscription updated';
                        ActivityNotification::create([
                            'user_id' => (int)$userId,
                            'type' => $event->type === 'customer.subscription.deleted' ? 'subscription_canceled' : 'subscription_updated',
                            'title' => $title,
                            'body' => 'Status: '.$status.', Plan: '.$planSlug,
                            'data' => [ 'stripe_subscription_id' => $subscription->id ],
                        ]);
                    } catch (\Throwable $e) {}
                }
                break;

            case 'invoice.payment_succeeded':
                $invoice = $event->data->object; // \Stripe\Invoice
                $customerId = $invoice->customer ?? null;
                if ($customerId) {
                    $user = User::where('stripe_customer_id', $customerId)->first();
                    if ($user) {
                        try {
                            ActivityNotification::create([
                                'user_id' => $user->id,
                                'type' => 'invoice_paid',
                                'title' => 'Subscription renewed',
                                'body' => 'Invoice '.$invoice->number.' paid successfully.',
                                'data' => [ 'invoice_id' => $invoice->id, 'total' => $invoice->total, 'currency' => $invoice->currency ],
                            ]);
                        } catch (\Throwable $e) {}
                    }
                }
                break;

            case 'invoice.payment_failed':
                $invoice = $event->data->object; // \Stripe\Invoice
                $customerId = $invoice->customer ?? null;
                if ($customerId) {
                    $user = User::where('stripe_customer_id', $customerId)->first();
                    if ($user) {
                        try {
                            ActivityNotification::create([
                                'user_id' => $user->id,
                                'type' => 'invoice_failed',
                                'title' => 'Payment failed for renewal',
                                'body' => ($invoice->last_finalization_error->message ?? 'Payment failed. Please update your payment method.'),
                                'data' => [ 'invoice_id' => $invoice->id ],
                            ]);
                        } catch (\Throwable $e) {}
                    }
                }
                break;
        }

        return response()->json(['received' => true]);
    }
}