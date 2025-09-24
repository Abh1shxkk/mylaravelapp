<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Stripe\StripeClient;

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
            $stripe = new StripeClient(config('services.stripe.secret'));

            // Create a Checkout Session for subscription
            $session = $stripe->checkout->sessions->create([
                'mode' => 'subscription',
                'payment_method_types' => ['card'],
                'customer_email' => Auth::user()->email,
                'line_items' => [[
                    'price' => $plan->stripe_price_id,
                    'quantity' => 1,
                ]],
                'success_url' => url('/stripe/success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => url('/stripe/cancel'),
                'metadata' => [
                    'user_id' => Auth::id(),
                    'plan_slug' => $plan->slug,
                ],
            ]);

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
        $subscription = Subscription::updateOrCreate(
            [ 'user_id' => Auth::id() ],
            [
                'plan_id' => $planSlug,
                'stripe_subscription_id' => is_object($session->subscription) ? $session->subscription->id : $session->subscription,
                'status' => 'active',
                'started_at' => now(),
                'ended_at' => null,
            ]
        );

        return redirect()->route('dashboard.home')->with('success', 'Subscription activated.');
    }

    public function cancel()
    {
        return redirect()->route('dashboard.home')->with('error', 'Payment cancelled.');
    }

    public function webhook(Request $request)
    {
        $signature = $request->header('Stripe-Signature');
        $payload = $request->getContent();
        $secret = config('services.stripe.webhook_secret');

        try {
            $event = \Stripe\Webhook::constructEvent($payload, $signature, $secret);
        } catch (\Throwable $e) {
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        switch ($event->type) {
            case 'customer.subscription.updated':
            case 'customer.subscription.created':
            case 'customer.subscription.deleted':
                $subscription = $event->data->object; // \Stripe\Subscription
                $status = $subscription->status; // active, canceled, past_due, etc.
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
                }
                break;
        }

        return response()->json(['received' => true]);
    }
}


