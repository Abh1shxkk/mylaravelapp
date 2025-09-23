<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:dashboard_users,email'],
        ], [
            'email.exists' => 'We could not find an account with that email address.'
        ]);

        $email = $request->input('email');

        $token = Str::random(64);

        DB::table('dashboard_password_resets')->updateOrInsert(
            ['email' => $email],
            ['token' => Hash::make($token), 'created_at' => Carbon::now()]
        );

        $resetUrl = url('/dashboard/password/reset').'?token='.$token.'&email='.urlencode($email);

        try {
            Mail::to($email)->send(new ResetPasswordMail($resetUrl));
        } catch (\Throwable $e) {
            return back()->with('error', 'Failed to send reset email. Please try again.');
        }

        return back()->with('success', 'Password reset link has been sent to your email.');
    }

    public function showResetForm(Request $request)
    {
        $token = $request->query('token');
        $email = $request->query('email');

        if (!$token || !$email) {
            return redirect()->route('dashboard.login')->with('error', 'Invalid reset link.');
        }

        return view('auth.password-reset', [
            'token' => $token,
            'email' => $email,
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:dashboard_users,email'],
            'token' => ['required', 'string'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $email = $request->input('email');
        $plainToken = $request->input('token');

        $record = DB::table('dashboard_password_resets')->where('email', $email)->first();
        if (!$record) {
            return back()->withErrors(['email' => 'This reset link is invalid or has already been used.']);
        }

        // Check expiration (60 minutes)
        if (Carbon::parse($record->created_at)->addMinutes(60)->isPast()) {
            DB::table('dashboard_password_resets')->where('email', $email)->delete();
            return back()->withErrors(['email' => 'This reset link has expired. Please request a new one.']);
        }

        // Verify token
        if (!Hash::check($plainToken, $record->token)) {
            return back()->withErrors(['email' => 'Invalid token.']);
        }

        $user = User::where('email', $email)->firstOrFail();
        $user->update([
            'password' => Hash::make($request->input('password')),
        ]);

        // Delete the reset record
        DB::table('dashboard_password_resets')->where('email', $email)->delete();

        return redirect()->route('dashboard.login')->with('success', 'Your password has been reset. Please log in.');
    }
}






