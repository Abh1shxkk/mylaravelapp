<?php
namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\SubscriptionHistory;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\SubscriptionPurchased;
use App\Models\Payment;
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

        // Capture carryover seconds from current active plan (if any)
        try {
            $currentActive = Auth::user()->subscriptions()
                ->where('status', 'active')
                ->latest('started_at')
                ->first();
            $carryoverSeconds = 0;
            if ($currentActive) {
                $now = Carbon::now();
                $currentEnd = null;
                if ($currentActive->ended_at) {
                    $currentEnd = Carbon::parse($currentActive->ended_at);
                } else {
                    // Derive theoretical end from started_at + plan duration
                    $currentPlan = Plan::where('slug', $currentActive->plan_id)->first();
                    if ($currentPlan) {
                        $calc = Carbon::parse($currentActive->started_at ?: $now)->copy();
                        if ($currentPlan->billing_period === 'custom' && $currentPlan->duration_value && $currentPlan->duration_unit) {
                            switch ($currentPlan->duration_unit) {
                                case 'minutes': $calc->addMinutes($currentPlan->duration_value); break;
                                case 'hours': $calc->addHours($currentPlan->duration_value); break;
                                case 'days': $calc->addDays($currentPlan->duration_value); break;
                                case 'weeks': $calc->addWeeks($currentPlan->duration_value); break;
                                case 'months': $calc->addMonths($currentPlan->duration_value); break;
                                case 'years': $calc->addYears($currentPlan->duration_value); break;
                                default: $calc->addMonth(); break;
                            }
                        } else {
                            switch ($currentPlan->billing_period) {
                                case 'monthly': $calc->addMonth(); break;
                                case 'yearly': $calc->addYear(); break;
                                case 'weekly': $calc->addWeek(); break;
                                case 'daily': $calc->addDay(); break;
                                default:
                                    if ($currentPlan->duration_value && $currentPlan->duration_unit) {
                                        switch ($currentPlan->duration_unit) {
                                            case 'minutes': $calc->addMinutes($currentPlan->duration_value); break;
                                            case 'hours': $calc->addHours($currentPlan->duration_value); break;
                                            case 'days': $calc->addDays($currentPlan->duration_value); break;
                                            case 'weeks': $calc->addWeeks($currentPlan->duration_value); break;
                                            case 'months': $calc->addMonths($currentPlan->duration_value); break;
                                            case 'years': $calc->addYears($currentPlan->duration_value); break;
                                            default: $calc->addMonth(); break;
                                        }
                                    } else {
                                        $calc->addMonth();
                                    }
                                    break;
                            }
                        }
                        $currentEnd = $calc;
                    }
                }
                if ($currentEnd && $now->lt($currentEnd)) {
                    $carryoverSeconds = max(0, $currentEnd->diffInSeconds($now));
                }

                // Archive current active subscription into history as 'switched'
                try {
                    SubscriptionHistory::create([
                        'user_id' => Auth::id(),
                        'plan_id' => $currentActive->plan_id,
                        'status' => 'switched',
                        'started_at' => $currentActive->started_at,
                        'ended_at' => $currentActive->ended_at ?: $currentEnd,
                        'cancelled_at' => Carbon::now(),
                        'provider' => 'razorpay',
                        'payment_id' => null,
                        'notes' => 'Archived on plan switch before subscribe()'
                    ]);
                } catch (\Throwable $e) { /* ignore history errors */ }
            }
            if ($carryoverSeconds > 0) {
                session(['subscription_carryover' => $carryoverSeconds]);
            } else {
                session()->forget('subscription_carryover');
            }
        } catch (\Throwable $e) {
            // Ignore carryover if any error occurs
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
            ['user_id' => Auth::id()],
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
            'carryover_seconds' => (int) session('subscription_carryover', 0),
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
        if ($plan && $plan->billing_period === 'custom' && $plan->duration_value && $plan->duration_unit) {
            $calc = Carbon::parse($startedAt)->copy();
            switch ($plan->duration_unit) {
                case 'minutes':
                    $calc->addMinutes($plan->duration_value);
                    break;
                case 'hours':
                    $calc->addHours($plan->duration_value);
                    break;
                case 'days':
                    $calc->addDays($plan->duration_value);
                    break;
                case 'weeks':
                    $calc->addWeeks($plan->duration_value);
                    break;
                case 'months':
                    $calc->addMonths($plan->duration_value);
                    break;
                case 'years':
                    $calc->addYears($plan->duration_value);
                    break;
            }
            $endedAt = $calc;
        } elseif ($plan) {
            // Default expiration for non-custom plans
            $calc = Carbon::parse($startedAt)->copy();
            $endedAt = match ($plan->billing_period) {
                'monthly' => $calc->addMonth(),
                'yearly' => $calc->addYear(),
                default => $calc->addMonth(), // Default to monthly if unknown
            };
        }

        // Apply carryover seconds if present (merge overlapping validity) - recompute fresh for second precision
        try {
            $carry = 0;
            $now = Carbon::now();
            // Prefer history records first (latest)
            $histories = SubscriptionHistory::where('user_id', Auth::id())
                ->orderByDesc('cancelled_at')
                ->orderByDesc('ended_at')
                ->orderByDesc('started_at')
                ->get();
            foreach ($histories as $prior) {
                $end = $prior->ended_at ? Carbon::parse($prior->ended_at) : null;
                if (!$end) {
                    $p = Plan::where('slug', $prior->plan_id)->first();
                    if ($p) {
                        $calc = Carbon::parse($prior->started_at ?: $now)->copy();
                        if ($p->billing_period === 'custom' && $p->duration_value && $p->duration_unit) {
                            switch ($p->duration_unit) {
                                case 'minutes': $calc->addMinutes($p->duration_value); break;
                                case 'hours': $calc->addHours($p->duration_value); break;
                                case 'days': $calc->addDays($p->duration_value); break;
                                case 'weeks': $calc->addWeeks($p->duration_value); break;
                                case 'months': $calc->addMonths($p->duration_value); break;
                                case 'years': $calc->addYears($p->duration_value); break;
                                default: $calc->addMonth(); break;
                            }
                        } else {
                            switch ($p->billing_period) {
                                case 'monthly': $calc->addMonth(); break;
                                case 'yearly': $calc->addYear(); break;
                                case 'weekly': $calc->addWeek(); break;
                                case 'daily': $calc->addDay(); break;
                                default:
                                    if ($p->duration_value && $p->duration_unit) {
                                        switch ($p->duration_unit) {
                                            case 'minutes': $calc->addMinutes($p->duration_value); break;
                                            case 'hours': $calc->addHours($p->duration_value); break;
                                            case 'days': $calc->addDays($p->duration_value); break;
                                            case 'weeks': $calc->addWeeks($p->duration_value); break;
                                            case 'months': $calc->addMonths($p->duration_value); break;
                                            case 'years': $calc->addYears($p->duration_value); break;
                                            default: $calc->addMonth(); break;
                                        }
                                    } else { $calc->addMonth(); }
                                    break;
                            }
                        }
                        $end = $calc;
                    }
                }
                if ($end && $now->lt($end)) {
                    $carry = max(0, $end->diffInSeconds($now));
                    break;
                }
            }

            // Fallback: scan any prior Subscription rows if present
            if ($carry <= 0) {
                $priorSubs = Subscription::where('user_id', Auth::id())
                ->where('status', '!=', 'created')
                ->orderByDesc('started_at')
                ->get();
                foreach ($priorSubs as $prior) {
                // Compute end from ended_at or theoretical end
                $end = $prior->ended_at ? Carbon::parse($prior->ended_at) : null;
                if (!$end) {
                    $p = Plan::where('slug', $prior->plan_id)->first();
                    if ($p) {
                        $calc = Carbon::parse($prior->started_at ?: $now)->copy();
                        if ($p->billing_period === 'custom' && $p->duration_value && $p->duration_unit) {
                            switch ($p->duration_unit) {
                                case 'minutes': $calc->addMinutes($p->duration_value); break;
                                case 'hours': $calc->addHours($p->duration_value); break;
                                case 'days': $calc->addDays($p->duration_value); break;
                                case 'weeks': $calc->addWeeks($p->duration_value); break;
                                case 'months': $calc->addMonths($p->duration_value); break;
                                case 'years': $calc->addYears($p->duration_value); break;
                                default: $calc->addMonth(); break;
                            }
                        } else {
                            switch ($p->billing_period) {
                                case 'monthly': $calc->addMonth(); break;
                                case 'yearly': $calc->addYear(); break;
                                case 'weekly': $calc->addWeek(); break;
                                case 'daily': $calc->addDay(); break;
                                default:
                                    if ($p->duration_value && $p->duration_unit) {
                                        switch ($p->duration_unit) {
                                            case 'minutes': $calc->addMinutes($p->duration_value); break;
                                            case 'hours': $calc->addHours($p->duration_value); break;
                                            case 'days': $calc->addDays($p->duration_value); break;
                                            case 'weeks': $calc->addWeeks($p->duration_value); break;
                                            case 'months': $calc->addMonths($p->duration_value); break;
                                            case 'years': $calc->addYears($p->duration_value); break;
                                            default: $calc->addMonth(); break;
                                        }
                                    } else { $calc->addMonth(); }
                                    break;
                            }
                        }
                        $end = $calc;
                    }
                }
                if ($end && $now->lt($end)) {
                    $carry = max(0, $end->diffInSeconds($now));
                    break; // take the most recent valid one
                }
                }
            }
            // Also accept carryover from client (passed back from subscribe response)
            $carryFromClient = (int) $request->input('carryover_seconds', 0);
            // Fallback to session-based carryover if recomputation fails
            if ($carry <= 0) {
                $carry = (int) session('subscription_carryover', 0);
            }
            $carry = max($carry, $carryFromClient);
            if ($carry > 0) {
                $endedAt = ($endedAt ?: Carbon::parse($startedAt)->copy())->addSeconds($carry);
            }
            session()->forget('subscription_carryover');
        } catch (\Throwable $e) {
            // Ignore carryover errors
        }

        $subscription->update([
            'status' => 'active',
            'razorpay_payment_id' => $request->razorpay_payment_id,
            'started_at' => $startedAt,
            'ended_at' => $endedAt,
        ]);

        try {
            \Log::info('Razorpay verify carryover applied', [
                'user_id' => Auth::id(),
                'plan' => $subscription->plan_id,
                'started_at' => (string) $startedAt,
                'ended_at' => (string) $endedAt,
            ]);
        } catch (\Throwable $e) {}

        // Record payment for transaction history (Razorpay)
        try {
            Payment::create([
                'user_id' => Auth::id(),
                'plan_id' => $subscription->plan_id,
                'provider' => 'razorpay',
                'payment_id' => $request->razorpay_payment_id,
                'subscription_id' => $request->razorpay_subscription_id,
                'amount' => (int) (($plan->price ?? 0)),
                'currency' => 'INR',
                'status' => 'paid',
                'paid_at' => now(),
                'meta' => [
                    'signature' => $request->razorpay_signature,
                ],
            ]);
        } catch (\Throwable $e) {
            // Ignore logging errors
        }

        // Send confirmation email to the user
        try {
            $user = Auth::user();
            if ($user && $user->email && $plan) {
                Mail::to($user->email)->send(new SubscriptionPurchased($user, $plan, $subscription));
            }
        } catch (\Throwable $e) {
            // Silently fail email sending to avoid breaking the payment flow
        }

        return response()->json(['success' => true]);
    }

    public function cancel(Request $request)
    {
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
                    // Proceed; we'll still cancel locally
                }
            }
        }
        // Stripe
        if (!empty($subscription->stripe_subscription_id) && config('services.stripe.secret')) {
            try {
                $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
                $stripe->subscriptions->cancel($subscription->stripe_subscription_id, []);
            } catch (\Throwable $e) {
                // Proceed; we'll still cancel locally
            }
        }

        $subscription->update(['status' => 'cancelled', 'ended_at' => now()]);
        // If request is AJAX/JSON, return JSON; otherwise redirect to cancelled view page
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['success' => true]);
        }
        return redirect()->route('subscription.cancelled.view');
    }
}