<?php

// ===========================================
// LOCATION: app/Services/AuthService.php
// NAMESPACE: App\Services\AuthService
// ===========================================

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthService
{
    public function register(array $data)
    {
        // Validate password strength
        if (!$this->isPasswordStrong($data['password'])) {
            throw new \Exception('Password must be at least 8 characters with uppercase, lowercase, number and special character.');
        }

        // Create user
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'], // Will be hashed automatically
            'is_active' => true,
        ]);

        // Send verification email
        $this->sendVerificationEmail($user);

        return $user;
    }

    public function login(array $credentials, $remember = false)
    {
        $user = User::where('email', $credentials['email'])->first();

        // Check if user exists
        if (!$user) {
            throw new \Exception('Invalid credentials.');
        }

        // Check if account is locked
        if ($user->isLocked()) {
            $minutes = $user->locked_until->diffInMinutes(now());
            throw new \Exception("Account locked. Try again in {$minutes} minutes.");
        }

        // Check if account is active
        if (!$user->is_active) {
            throw new \Exception('Account is deactivated. Contact support.');
        }

        // Attempt login
        if (Hash::check($credentials['password'], $user->password)) {
            // Success - reset failed attempts and login
            $user->resetFailedAttempts();
            Auth::guard('dashboard')->login($user, $remember);
            
            // Update last login
            $user->update(['last_login_at' => now()]);
            
            return $user;
        } else {
            // Failed - increment attempts
            $user->incrementFailedAttempts();
            throw new \Exception('Invalid credentials.');
        }
    }

    public function logout()
    {
        Auth::guard('dashboard')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
    }

    public function sendPasswordReset($email)
    {
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            // Don't reveal if email exists - security best practice
            return true;
        }

        $token = Str::random(60);
        
        // Store reset token (you'll need a password_resets table)
        \DB::table('dashboard_password_resets')->updateOrInsert(
            ['email' => $email],
            [
                'token' => Hash::make($token),
                'created_at' => now()
            ]
        );

        // Send email (implement this based on your mail setup)
        // Mail::to($user)->send(new PasswordResetMail($token));

        return true;
    }

    public function resetPassword($token, $email, $password)
    {
        // Validate password strength
        if (!$this->isPasswordStrong($password)) {
            throw new \Exception('Password must be at least 8 characters with uppercase, lowercase, number and special character.');
        }

        $resetRecord = \DB::table('dashboard_password_resets')
            ->where('email', $email)
            ->first();

        if (!$resetRecord || !Hash::check($token, $resetRecord->token)) {
            throw new \Exception('Invalid or expired reset token.');
        }

        // Check if token is not older than 1 hour
        if (now()->diffInMinutes($resetRecord->created_at) > 60) {
            throw new \Exception('Reset token has expired.');
        }

        // Update password
        $user = User::where('email', $email)->first();
        $user->update(['password' => $password]);

        // Delete reset token
        \DB::table('dashboard_password_resets')->where('email', $email)->delete();

        return $user;
    }

    public function verifyEmail($userId, $hash)
    {
        $user = User::find($userId);
        
        if (!$user || sha1($user->email) !== $hash) {
            throw new \Exception('Invalid verification link.');
        }

        if ($user->email_verified_at) {
            throw new \Exception('Email already verified.');
        }

        $user->update(['email_verified_at' => now()]);
        return $user;
    }

    private function isPasswordStrong($password)
    {
        return strlen($password) >= 8 &&
               preg_match('/[A-Z]/', $password) &&
               preg_match('/[a-z]/', $password) &&
               preg_match('/[0-9]/', $password) &&
               preg_match('/[^A-Za-z0-9]/', $password);
    }

    private function sendVerificationEmail($user)
    {
        $hash = sha1($user->email);
        $verificationUrl = url("/dashboard/verify-email/{$user->id}/{$hash}");
        
        // Send email (implement based on your mail setup)
        // Mail::to($user)->send(new EmailVerificationMail($verificationUrl));
    }
}