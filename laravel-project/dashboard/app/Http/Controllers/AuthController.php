<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite; // Add this import
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;

class AuthController extends Controller
{
    // Show login form
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect('/dashboard/home');
        }
        return view('auth.login');
    }

    // Handle login
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:dashboard_users,email'],
            'password' => ['required', 'string', 'min:6'],
        ], [
            'email.exists' => 'These credentials do not match our records.',
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->has('remember'))) {
            $request->session()->regenerate();
            return redirect('/dashboard/home')->with('success', 'Welcome back!');
        }

        return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }

    // Show register form
    public function showRegister()
    {
        if (Auth::check()) {
            return redirect('/dashboard/home');
        }
        return view('auth.register');
    }

    // Handle registration
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:dashboard_users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_active' => true,
        ]);

        // Send welcome email synchronously
        try {
            Mail::to($user->email)->send(new WelcomeMail($user));
        } catch (\Throwable $e) {
            // Silently ignore mail failures to not block registration
        }

        Auth::login($user);
        return redirect('/dashboard/home')->with('success', 'Registration successful!');
    }

    // Dashboard home
    public function home()
    {
        return view('dashboard.home');
    }

    // Handle logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/dashboard/login')->with('success', 'Logged out successfully!');
    }

    // Redirect to Google OAuth
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Handle Google callback
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect('/dashboard/login')->with('error', 'Google authentication failed.');
        }

        // Find or create user based on Google email
        $user = User::where('email', $googleUser->getEmail())->first();

        if (!$user) {
            // Create new user with Google data
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'provider' => 'google',
                'is_active' => true,
                'role' => 'user', // Default role; adjust based on your logic
                // No password for social users
            ]);
        } else {
            // Update existing user if not already linked to Google
            if ($user->provider !== 'google') {
                $user->update(['provider' => 'google']);
            }
            $user->update(['name' => $googleUser->getName()]);
        }

        // Log in the user
        Auth::login($user);

        // Regenerate session for security
        request()->session()->regenerate();

        return redirect('/dashboard/home')->with('success', 'Welcome back via Google!');
    }
}