<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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
        
        // Validate all fields including the new ones
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:dashboard_users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'max:15', 'unique:dashboard_users,phone,' . $user->id],
            'bio' => ['nullable', 'string', 'max:1000'],
            'role' => ['sometimes', 'string', 'in:user,manager,admin'],
        ]);

        // Only admins can change roles
        if (isset($validated['role']) && $user->role !== 'admin') {
            unset($validated['role']);
        }

        // Update user with all validated data
        $user->update($validated);

        // Refresh CSRF token to avoid 419 on subsequent POSTs
        $request->session()->regenerateToken();

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

        // Refresh CSRF token to avoid 419 on subsequent POSTs
        $request->session()->regenerateToken();

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
        }

        // Refresh CSRF token to avoid 419 on subsequent POSTs
        $request->session()->regenerateToken();

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
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        // Log out other devices using the CURRENT password BEFORE updating
        Auth::logoutOtherDevices($validated['current_password']);

        // Update password
        $user->update([
            'password' => Hash::make($validated['password'])
        ]);

        // Refresh current session/CSRF to avoid 419 after password change
        $request->session()->regenerate();
        $request->session()->regenerateToken();

        return redirect()->route('profile.settings')->with('success', 'Password changed successfully!');
    }
}