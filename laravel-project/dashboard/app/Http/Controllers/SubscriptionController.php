<?php
namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Razorpay\Api\Api;

class SubscriptionController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate(['plan_id' => 'required|in:basic,premium']);

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

        // Save in database
        Auth::user()->subscriptions()->create([
            'plan_id' => $request->plan_id,
            'razorpay_subscription_id' => $subscription->id,
            'status' => 'created',
            'started_at' => now(),
        ]);

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

        // Update user's latest created subscription for this subscription_id to active
        $subscription = Subscription::where('user_id', Auth::id())
            ->where('razorpay_subscription_id', $request->razorpay_subscription_id)
            ->latest('created_at')
            ->first();

        if (!$subscription) {
            return response()->json([
                'success' => false,
                'message' => 'Subscription not found.'
            ], 404);
        }

        $subscription->update([
            'status' => 'active',
            'razorpay_payment_id' => $request->razorpay_payment_id,
            'started_at' => $subscription->started_at ?: now(),
        ]);

        return response()->json(['success' => true]);
    }

    // Cancel method remains the same
    public function cancel(Request $request)
    {
        // Find the latest non-cancelled subscription (created/active/paused)
        $subscription = Auth::user()->subscriptions()
            ->whereIn('status', ['created', 'active', 'paused'])
            ->latest('started_at')
            ->first();

        if (!$subscription) {
            return response()->json(['success' => false, 'message' => 'No cancellable subscription found'], 400);
        }

        $keyId = env('RAZORPAY_KEY_ID');
        $keySecret = env('RAZORPAY_KEY_SECRET');
        if (empty($keyId) || empty($keySecret)) {
            return response()->json([
                'success' => false,
                'message' => 'Razorpay credentials are missing.'
            ], 500);
        }

        // Attempt to cancel on Razorpay if we have a remote subscription id
        if (!empty($subscription->razorpay_subscription_id)) {
            try {
                $api = new Api($keyId, $keySecret);
                $api->subscription->fetch($subscription->razorpay_subscription_id)->cancel();
            } catch (\Throwable $e) {
                // Continue to mark local as cancelled to unblock user; include message
                $subscription->update(['status' => 'cancelled', 'ended_at' => now()]);
                return response()->json([
                    'success' => true,
                    'warning' => 'Local subscription cancelled. Razorpay cancel failed: ' . $e->getMessage()
                ]);
            }
        }

        $subscription->update(['status' => 'cancelled', 'ended_at' => now()]);
        return response()->json(['success' => true]);
    }
}