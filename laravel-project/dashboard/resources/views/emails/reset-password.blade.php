<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        body { font-family: Arial, sans-serif; color: #1f2937; }
        .container { max-width: 560px; margin: 0 auto; padding: 24px; }
        .btn { display: inline-block; padding: 10px 16px; background: #2563eb; color: #fff; text-decoration: none; border-radius: 6px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Reset your password</h2>
        <p>We received a request to reset your Dashboard password. Click the button below to set a new one. This link will expire in 60 minutes.</p>
        <p>
            <a href="{{ $resetUrl }}" class="btn">Reset Password</a>
        </p>
        <p>If you did not request a password reset, you can safely ignore this email.</p>
        <p>Thanks,<br>The Dashboard Team</p>
    </div>
</body>
</html>


