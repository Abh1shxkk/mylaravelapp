<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        // Ensure a fresh CSRF token on the settings page to avoid 419
        $request->session()->regenerateToken();
        return view('profile.settings');
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        // Normalize inputs to reduce false-positive uniqueness (e.g., trailing spaces)
        $normalizedPhone = trim((string) $request->input('phone'));
        if ($normalizedPhone === '') {
            $normalizedPhone = null;
        }
        $request->merge([
            'name' => trim((string) $request->input('name')),
            'email' => trim((string) $request->input('email')),
            'phone' => $normalizedPhone,
        ]);
        
        // Validate all fields including the new ones
        $userModel = new \App\Models\User();
        $table = $userModel->getTable();
        $keyName = $userModel->getKeyName();

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:15'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'role' => ['sometimes', 'string', 'in:user,manager,admin'],
        ];

        // Apply unique only if value actually changes (post-normalization)
        if ($request->input('email') !== $user->email) {
            $rules['email'][] = Rule::unique($table, 'email')->ignore($user->{$keyName}, $keyName);
        } else {
            // keep format checks but skip unique
        }

        if ($request->input('phone') !== $user->phone) {
            $rules['phone'][] = Rule::unique($table, 'phone')->ignore($user->{$keyName}, $keyName);
        }

        $validated = $request->validate($rules);

        // Only admins can change roles
        if (isset($validated['role']) && $user->role !== 'admin') {
            unset($validated['role']);
        }

        // Update user with all validated data
        $user->update($validated);
        try {
            \App\Models\ActivityNotification::create([
                'user_id' => $user->id,
                'type' => 'profile_updated',
                'title' => 'Profile updated',
                'body' => 'Your profile details were updated.',
                'data' => [ 'fields' => array_keys($validated) ],
            ]);
        } catch (\Throwable $e) {}

        // Refresh CSRF token to avoid 419 on subsequent POSTs
        $request->session()->regenerateToken();
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully!',
                'csrf' => csrf_token(),
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'bio' => $user->bio,
                    'role' => $user->role,
                ],
            ]);
        }

        return redirect()->route('profile.settings')->with('success', 'Profile updated successfully!');
    }

    public function uploadPicture(Request $request)
    {
        $request->validate([
            'profile_picture' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $user = Auth::user();

        // Delete old profile picture if exists
        if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
            Storage::disk('public')->delete($user->profile_picture);
        }

        // Store new profile picture
        $path = $request->file('profile_picture')->store('profile-pictures', 'public');
        
        // Update user's profile_picture field
        $user->update([
            'profile_picture' => $path
        ]);
        try {
            \App\Models\ActivityNotification::create([
                'user_id' => $user->id,
                'type' => 'profile_updated',
                'title' => 'Profile picture updated',
                'body' => 'Your profile picture was changed.',
            ]);
        } catch (\Throwable $e) {}

        // Refresh CSRF token to avoid 419 on subsequent POSTs
        $request->session()->regenerateToken();
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Profile picture updated successfully!',
                'csrf' => csrf_token(),
                'profile_picture_url' => asset('storage/' . $path),
            ]);
        }

        return redirect()->route('profile.settings')->with('success', 'Profile picture updated successfully!');
    }

    public function removePicture(Request $request)
    {
        $user = Auth::user();
        
        if ($user->profile_picture) {
            // Delete file from storage
            if (Storage::disk('public')->exists($user->profile_picture)) {
                Storage::disk('public')->delete($user->profile_picture);
            }
            
            // Remove from database
            $user->update([
                'profile_picture' => null
            ]);
            try {
                \App\Models\ActivityNotification::create([
                    'user_id' => $user->id,
                    'type' => 'profile_updated',
                    'title' => 'Profile picture removed',
                    'body' => 'Your profile picture was removed.',
                ]);
            } catch (\Throwable $e) {}
        }

        // Refresh CSRF token to avoid 419 on subsequent POSTs
        $request->session()->regenerateToken();
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Profile picture removed successfully!',
                'csrf' => csrf_token(),
                'profile_picture_url' => null,
            ]);
        }

        return redirect()->route('profile.settings')->with('success', 'Profile picture removed successfully!');
    }

    public function changePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user = Auth::user();

        // Check if current password is correct
        if (!Hash::check($validated['current_password'], $user->password)) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'The current password is incorrect.',
                    'errors' => ['current_password' => ['The current password is incorrect.']],
                ], 422);
            }
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        // Log out other devices using the CURRENT password BEFORE updating
        Auth::logoutOtherDevices($validated['current_password']);

        // Update password
        $user->update([
            'password' => Hash::make($validated['password'])
        ]);
        try {
            \App\Models\ActivityNotification::create([
                'user_id' => $user->id,
                'type' => 'profile_updated',
                'title' => 'Password changed',
                'body' => 'Your account password was changed.',
            ]);
        } catch (\Throwable $e) {}

        // Refresh current session/CSRF to avoid 419 after password change
        $request->session()->regenerate();
        $request->session()->regenerateToken();
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Password changed successfully!',
                'csrf' => csrf_token(),
            ]);
        }

        return redirect()->route('profile.settings')->with('success', 'Password changed successfully!');
    }
}