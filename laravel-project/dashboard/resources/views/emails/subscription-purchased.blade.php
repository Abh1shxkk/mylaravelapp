<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Subscription Confirmation</title>
    <style>
        body { font-family: Arial, sans-serif; color: #111827; }
        .container { max-width: 640px; margin: 0 auto; padding: 24px; }
        .card { border: 1px solid #e5e7eb; border-radius: 12px; overflow: hidden; }
        .card-header { background: #111827; color: #fff; padding: 16px 20px; }
        .card-body { padding: 20px; background: #ffffff; }
        .muted { color: #6b7280; }
        .btn { display: inline-block; padding: 10px 16px; background: #10b981; color: #fff; text-decoration: none; border-radius: 8px; }
        .footer { margin-top: 24px; font-size: 12px; color: #6b7280; }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2 style="margin:0;">Subscription Successful</h2>
            </div>
            <div class="card-body">
                <p>Hi {{ $user->name }},</p>
                <p>Thank you for your purchase! Your subscription has been activated successfully.</p>

                <h3 style="margin-bottom: 8px;">Plan Details</h3>
                <ul class="muted" style="line-height: 1.7;">
                    <li><strong>Plan</strong>: {{ $plan->name ?? ucfirst($plan->slug) }}</li>
                    <li><strong>Price</strong>: ₹{{ number_format((int)($plan->price ?? 0)) }} / {{ $plan->billing_period ?? 'month' }}</li>
                    @if(!empty($plan->description))
                    <li><strong>Description</strong>: {{ $plan->description }}</li>
                    @endif
                    <li><strong>Status</strong>: {{ ucfirst($subscription->status) }}</li>
                    <li><strong>Started At</strong>: {{ optional($subscription->started_at)->format('d M Y, h:i A') }}</li>
                </ul>

                <p style="margin-top:16px;">You can manage your plan anytime from your dashboard.</p>

                <p style="margin: 20px 0;">
                    <a class="btn" href="{{ url('/dashboard/home') }}">Go to Dashboard</a>
                </p>

                <p class="muted">If you did not make this purchase or have any questions, please contact support.</p>
            </div>
        </div>

        <div class="footer">
            <p>This is an automated message. Please do not reply to this email.</p>
        </div>
    </div>
</body>
</html>
