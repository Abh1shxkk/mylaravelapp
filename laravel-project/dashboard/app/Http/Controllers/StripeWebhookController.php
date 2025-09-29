<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StripeWebhookController extends Controller
{
    public function handle(Request $request)
{
    $event = $request->all();

    switch ($event['type']) {
        case 'checkout.session.completed':
            $session = $event['data']['object'];
            $subscriptionId = $session['subscription']; // sub_xxx
            $userId = $session['metadata']['user_id'];

            Subscription::updateOrCreate(
                ['user_id' => $userId],
                [
                    'stripe_subscription_id' => $subscriptionId,
                    'status' => 'active',
                    'started_at' => now(),
                ]
            );
            break;

        case 'invoice.payment_succeeded':
            $subscriptionId = $event['data']['object']['subscription'];
            Subscription::where('stripe_subscription_id', $subscriptionId)
                ->update(['status' => 'active']);
            break;

        case 'invoice.payment_failed':
            $subscriptionId = $event['data']['object']['subscription'];
            Subscription::where('stripe_subscription_id', $subscriptionId)
                ->update(['status' => 'past_due']);
            break;
    }

    return response()->json(['status' => 'ok']);
}

}
