<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Subscription;
use App\Models\Payment;
use App\Models\Plan;
use Carbon\Carbon;

class SubscriptionAdminController extends Controller
{
    // POST /admin/subscriptions/reconcile
    // Params: user_id (required), seconds (optional). If seconds not provided, auto-calc from last payment before current subscription start.
    public function reconcile(Request $request)
    {
        $request->validate([
            'user_id' => 'nullable|integer|exists:users,id',
            'seconds' => 'nullable|integer|min:0',
        ]);

        $userId = (int) ($request->input('user_id') ?? Auth::id());
        $seconds = (int) ($request->input('seconds') ?? 0);

        $sub = Subscription::where('user_id', $userId)->first();
        if (!$sub) {
            return response()->json(['success' => false, 'message' => 'Subscription not found for user.'], 404);
        }

        // If seconds not provided, try to auto-calc from the last payment before this subscription started
        if ($seconds <= 0) {
            try {
                $currentStart = $sub->started_at ? Carbon::parse($sub->started_at) : Carbon::now();
                $prevPayment = Payment::where('user_id', $userId)
                    ->where('paid_at', '<', $currentStart)
                    ->orderByDesc('paid_at')
                    ->first();
                if ($prevPayment && $prevPayment->plan_id) {
                    $prevPlan = Plan::where('slug', $prevPayment->plan_id)->first();
                    if ($prevPlan) {
                        // Find the subscription row that was active around that time to get exact start, else use payment time
                        $prevSubStart = Subscription::where('user_id', $userId)
                            ->where('started_at', '<=', $currentStart)
                            ->orderByDesc('started_at')
                            ->value('started_at');
                        $prevStart = Carbon::parse($prevSubStart ?: ($prevPayment->paid_at ?: $currentStart));
                        $calc = $prevStart->copy();
                        if ($prevPlan->billing_period === 'custom' && $prevPlan->duration_value && $prevPlan->duration_unit) {
                            switch ($prevPlan->duration_unit) {
                                case 'minutes': $calc->addMinutes($prevPlan->duration_value); break;
                                case 'hours': $calc->addHours($prevPlan->duration_value); break;
                                case 'days': $calc->addDays($prevPlan->duration_value); break;
                                case 'weeks': $calc->addWeeks($prevPlan->duration_value); break;
                                case 'months': $calc->addMonths($prevPlan->duration_value); break;
                                case 'years': $calc->addYears($prevPlan->duration_value); break;
                                default: $calc->addMonth(); break;
                            }
                        } else {
                            switch ($prevPlan->billing_period) {
                                case 'monthly': $calc->addMonth(); break;
                                case 'yearly': $calc->addYear(); break;
                                case 'weekly': $calc->addWeek(); break;
                                case 'daily': $calc->addDay(); break;
                                default:
                                    if ($prevPlan->duration_value && $prevPlan->duration_unit) {
                                        switch ($prevPlan->duration_unit) {
                                            case 'minutes': $calc->addMinutes($prevPlan->duration_value); break;
                                            case 'hours': $calc->addHours($prevPlan->duration_value); break;
                                            case 'days': $calc->addDays($prevPlan->duration_value); break;
                                            case 'weeks': $calc->addWeeks($prevPlan->duration_value); break;
                                            case 'months': $calc->addMonths($prevPlan->duration_value); break;
                                            case 'years': $calc->addYears($prevPlan->duration_value); break;
                                            default: $calc->addMonth(); break;
                                        }
                                    } else { $calc->addMonth(); }
                                    break;
                            }
                        }
                        // Carryover is time between new start and theoretical end of previous plan
                        if ($calc->greaterThan($currentStart)) {
                            $seconds = max(0, $calc->diffInSeconds($currentStart));
                        }
                    }
                }
            } catch (\Throwable $e) {
                // Fallback: keep seconds at 0 if any errors
            }
        }

        if ($seconds <= 0) {
            return response()->json(['success' => false, 'message' => 'No carryover seconds to apply. Provide seconds or ensure a previous payment exists.'], 400);
        }

        $endedAt = $sub->ended_at ? Carbon::parse($sub->ended_at) : Carbon::parse($sub->started_at ?: Carbon::now());
        $endedAt = $endedAt->copy()->addSeconds($seconds);

        $sub->ended_at = $endedAt;
        $sub->save();

        try {
            Log::info('Admin reconcile applied', [
                'admin_user_id' => Auth::id(),
                'target_user_id' => $userId,
                'seconds_added' => $seconds,
                'new_ended_at' => (string) $endedAt,
            ]);
        } catch (\Throwable $e) {}

        return response()->json([
            'success' => true,
            'seconds_added' => $seconds,
            'new_ended_at' => $endedAt->toIso8601String(),
        ]);
    }
}
