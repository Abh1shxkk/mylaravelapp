<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <style>
        body { font-family: Arial, sans-serif; color: #1f2937; }
        .container { max-width: 560px; margin: 0 auto; padding: 24px; }
        .btn { display: inline-block; padding: 10px 16px; background: #ffffffff; color: #000000ff; text-decoration: none; border-radius: 6px; }
    </style>
    </head>
<body>
    <div class="container">
        <h2>Welcome aboard, {{ $user->name }} 🎉</h2>
        <p>We’re excited to have you on the Dashboard. Your account is ready, and you can start exploring your personalized home right away.</p>
        <p>Here are a few things you can do next:</p>
        <ul>
            <li>Visit your dashboard to get an overview</li>
            <li>Complete your profile to personalize your experience</li>
            <li>Enable notifications to stay updated</li>
        </ul>
        <p>
            <a href="{{ url('/dashboard/home') }}" class="btn">Go to Dashboard</a>
        </p>
        <p>If you did not create this account, please ignore this email.</p>
        <p>Cheers,<br>The Dashboard Team</p>
    </div>
</body>
</html>


