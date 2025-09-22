<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;

class GoogleController extends Controller
{
    /**
     * Redirect the user to Google's authentication page.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle the callback from Google.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password' => bcrypt(uniqid('oauth_', true)),
                    'is_active' => true,
                    'provider' => 'google',
                ]);

                // Send welcome email for new users synchronously
                try {
                    Mail::to($user->email)->send(new WelcomeMail($user));
                } catch (\Throwable $e) {
                    // Ignore mail failures
                }
            } else {
                // Keep user name updated and mark provider
                $user->update([
                    'name' => $googleUser->getName() ?: $user->name,
                    'provider' => $user->provider ?: 'google',
                ]);
            }

            Auth::login($user, true);

            return redirect('/dashboard/home');

        } catch (Exception $e) {
            return redirect('/dashboard/login')->with('error', 'Google login failed: ' . $e->getMessage());
        }
    }
}