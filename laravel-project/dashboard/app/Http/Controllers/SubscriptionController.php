<?php
namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\SubscriptionPurchased;
use Carbon\Carbon;
use Razorpay\Api\Api;

class SubscriptionController extends Controller
{
    public function subscribe(Request $request)
    {
        // Get all valid plan slugs from database
        $validPlans = Plan::pluck('slug')->toArray();
        $request->validate(['plan_id' => 'required|in:' . implode(',', $validPlans)]);

        // Fetch plan from DB by slug and ensure Razorpay plan ID is present
        $plan = Plan::where('slug', $request->plan_id)->first();
        if (!$plan) {
            return response()->json(['success' => false, 'message' => 'Invalid plan selected'], 422);
        }
        if (empty($plan->razorpay_plan_id)) {
            return response()->json([
                'success' => false,
                'message' => 'Razorpay plan ID not configured for the selected plan. Please set it in the plans table.'
            ], 422);
        }

        $keyId = env('RAZORPAY_KEY_ID');
        $keySecret = env('RAZORPAY_KEY_SECRET');
        if (empty($keyId) || empty($keySecret)) {
            return response()->json([
                'success' => false,
                'message' => 'Razorpay credentials are missing. Please set RAZORPAY_KEY_ID and RAZORPAY_KEY_SECRET in .env.'
            ], 500);
        }

        $api = new Api($keyId, $keySecret);

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
            // ignore carryover if any error occurs
        }

        try {
            // Create subscription on Razorpay
            $subscription = $api->subscription->create([
                'plan_id' => $plan->razorpay_plan_id,
                'customer_notify' => 1,
                'total_count' => 1,
                'notes' => ['user_id' => Auth::id(), 'plan_slug' => $plan->slug],
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create subscription: ' . $e->getMessage(),
            ], 500);
        }

        // Upsert single row per user (overwrite previous subscription row for the user)
        Subscription::updateOrCreate(
            [ 'user_id' => Auth::id() ],
            [
                'plan_id' => $request->plan_id,
                'razorpay_subscription_id' => $subscription->id,
                'status' => 'created',
                'started_at' => now(),
                'ended_at' => null,
            ]
        );

        return response()->json([
            'success' => true,
            'razorpay_key' => $keyId,
            'subscription_id' => $subscription->id,
            'plan' => $request->plan_id,
        ]);
    }

    public function verify(Request $request)
    {
        $request->validate([
            'razorpay_payment_id' => 'required|string',
            'razorpay_subscription_id' => 'required|string',
            'razorpay_signature' => 'required|string',
        ]);

        $keySecret = env('RAZORPAY_KEY_SECRET');
        if (empty($keySecret)) {
            return response()->json([
                'success' => false,
                'message' => 'Razorpay credentials are missing.'
            ], 500);
        }

        $generatedSignature = hash_hmac(
            'sha256',
            $request->razorpay_payment_id . '|' . $request->razorpay_subscription_id,
            $keySecret
        );

        if (!hash_equals($generatedSignature, $request->razorpay_signature)) {
            return response()->json([
                'success' => false,
                'message' => 'Payment signature verification failed.'
            ], 400);
        }

        // Update this user's single subscription row
        $subscription = Subscription::where('user_id', Auth::id())->first();

        if (!$subscription) {
            return response()->json([
                'success' => false,
                'message' => 'Subscription not found.'
            ], 404);
        }

        // Determine started_at and possible ended_at based on plan duration
        $plan = Plan::where('slug', $subscription->plan_id)->first();
        $startedAt = $subscription->started_at ?: now();
        $endedAt = null;
        if ($plan && ($plan->billing_period === 'custom') && $plan->duration_value && $plan->duration_unit) {
            $calc = Carbon::parse($startedAt)->copy();
            switch ($plan->duration_unit) {
                case 'minutes':
                    $calc->addMinutes($plan->duration_value); break;
                case 'hours':
                    $calc->addHours($plan->duration_value); break;
                case 'days':
                    $calc->addDays($plan->duration_value); break;
                case 'weeks':
                    $calc->addWeeks($plan->duration_value); break;
                case 'months':
                    $calc->addMonths($plan->duration_value); break;
                case 'years':
                    $calc->addYears($plan->duration_value); break;
            }
            $endedAt = $calc;
        }

        // Apply carryover seconds if present and target plan is custom
        try {
            $carry = (int) session('subscription_carryover', 0);
            if ($carry > 0 && $plan && $plan->billing_period === 'custom') {
                $endedAt = ($endedAt ?: Carbon::parse($startedAt)->copy())->addSeconds($carry);
            }
            // Clear carryover after use
            session()->forget('subscription_carryover');
        } catch (\Throwable $e) {
            // ignore carryover errors
        }

        $subscription->update([
            'status' => 'active',
            'razorpay_payment_id' => $request->razorpay_payment_id,
            'started_at' => $startedAt,
            'ended_at' => $endedAt,
        ]);

        // Send confirmation email to the user
        try {
            $user = Auth::user();
            $plan = $plan ?: Plan::where('slug', $subscription->plan_id)->first();
            if ($user && $user->email && $plan) {
                Mail::to($user->email)->send(new SubscriptionPurchased($user, $plan, $subscription));
            }
        } catch (\Throwable $e) {
            // Silently fail email sending to avoid breaking the payment flow
        }

        return response()->json(['success' => true]);
    }

    // Cancel method remains the same
    public function cancel(Request $request)
    {
        // Prefer the most recently created ACTIVE subscription, then created/paused
        $subscription = Auth::user()->subscriptions()
            ->whereIn('status', ['created', 'active', 'paused'])
            ->orderByRaw("CASE WHEN status='active' THEN 0 ELSE 1 END")
            ->orderByDesc('created_at')
            ->first();

        if (!$subscription) {
            return response()->json(['success' => false, 'message' => 'No cancellable subscription found'], 400);
        }

        // Attempt to cancel on provider(s) if IDs exist
        // Razorpay
        if (!empty($subscription->razorpay_subscription_id)) {
            $keyId = env('RAZORPAY_KEY_ID');
            $keySecret = env('RAZORPAY_KEY_SECRET');
            if (!empty($keyId) && !empty($keySecret)) {
                try {
                    $api = new Api($keyId, $keySecret);
                    $api->subscription->fetch($subscription->razorpay_subscription_id)->cancel();
                } catch (\Throwable $e) {
                    // proceed; we'll still cancel locally
                }
            }
        }
        // Stripe
        if (!empty($subscription->stripe_subscription_id) && config('services.stripe.secret')) {
            try {
                $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
                $stripe->subscriptions->cancel($subscription->stripe_subscription_id, []);
            } catch (\Throwable $e) {
                // proceed; we'll still cancel locally
            }
        }

        $subscription->update(['status' => 'cancelled', 'ended_at' => now()]);
        return response()->json(['success' => true]);
    }
}