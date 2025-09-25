<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite; // Add this import
use Illuminate\Support\Facades\Hash;

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
            'identifier' => ['required', 'string'], // email or phone
            'password' => ['required', 'string', 'min:6'],
        ]);

        $identifier = $request->input('identifier');
        $remember = $request->boolean('remember');

        // Determine if identifier is an email or a phone number
        $credentials = [];
        if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
            $credentials = ['email' => $identifier, 'password' => $request->password];
        } else {
            // Normalize Indian phone: keep digits, ensure 10 digits, then prefix +91
            $digits = preg_replace('/\D+/', '', $identifier);
            if (strlen($digits) === 12 && str_starts_with($digits, '91')) {
                $digits = substr($digits, 2);
            }
            if (strlen($digits) === 11 && str_starts_with($digits, '0')) {
                $digits = substr($digits, 1);
            }
            if (strlen($digits) !== 10) {
                return back()->withErrors(['identifier' => 'Please enter a valid 10-digit Indian phone number or a valid email.'])->withInput();
            }
            $normalizedPhone = '+91' . $digits;
            $credentials = ['phone' => $normalizedPhone, 'password' => $request->password];
        }

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect('/dashboard/home')->with('success', 'Welcome back!');
        }

        return back()->withErrors(['identifier' => 'Invalid credentials'])->withInput();
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
            'phone' => ['required','string','regex:/^[0-9+\-\s()]{7,20}$/','unique:dashboard_users,phone'],
            'password' => 'required|min:8|confirmed',
        ], [
            'phone.regex' => 'Please enter a valid phone number.',
        ]);

        // Normalize Indian phone to E.164 (+91XXXXXXXXXX)
        $digits = preg_replace('/\D+/', '', $request->phone);
        if (strlen($digits) === 12 && str_starts_with($digits, '91')) {
            $digits = substr($digits, 2);
        }
        if (strlen($digits) === 11 && str_starts_with($digits, '0')) {
            $digits = substr($digits, 1);
        }
        if (strlen($digits) !== 10) {
            return back()->withErrors(['phone' => 'Phone must be a valid 10-digit Indian mobile number.'])->withInput();
        }
        $normalizedPhone = '+91' . $digits;

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $normalizedPhone,
            'password' => Hash::make($request->password),
            'is_active' => true,
        ]);

        Auth::login($user);
        return redirect('/dashboard/home')->with('success', 'Registration successful!');
    }

    // Dashboard home
    public function home()
    {
        $activeSubscription = Auth::user()->subscriptions()->where('status', 'active')->latest('started_at')->first();
        $currentPlan = $activeSubscription ? $activeSubscription->plan_id : null; // 'basic' | 'premium' | null
        
        // Get all available plans for the subscription modal
        $plans = \App\Models\Plan::all();

        return view('dashboard.home', compact('currentPlan', 'plans'));
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

    // Lookup email by phone for users who forgot their email
    public function forgotEmail(Request $request)
    {
        $request->validate([
            'phone' => ['required','string','regex:/^[0-9+\-\s()]{7,20}$/'],
        ], [
            'phone.regex' => 'Please enter a valid phone number.',
        ]);

        // Normalize Indian phone to E.164 (+91XXXXXXXXXX)
        $digits = preg_replace('/\D+/', '', $request->phone);
        if (strlen($digits) === 12 && str_starts_with($digits, '91')) {
            $digits = substr($digits, 2);
        }
        if (strlen($digits) === 11 && str_starts_with($digits, '0')) {
            $digits = substr($digits, 1);
        }
        if (strlen($digits) !== 10) {
            return response()->json([
                'success' => false,
                'message' => 'Phone must be a valid 10-digit Indian mobile number.'
            ], 422);
        }
        $normalizedPhone = '+91' . $digits;

        $user = User::where('phone', $normalizedPhone)->first();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'No account found with that phone number.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'email' => $user->email,
        ]);
    }
}