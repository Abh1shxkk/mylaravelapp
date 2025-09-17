<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Log facade को इम्पोर्ट करें

class Userauthcontroller extends Controller
{
    function login(Request $request)
    {
        return $request->all();
    }

    function signup(Request $request)
    {
        try {
            // इनपुट डेटा डिबग के लिए लॉग करें
            $input = $request->all();
            Log::info('Signup Input Data: ', $input);

            // वैलिडेशन जोड़ें ताकि गलत डेटा से त्रुटि न आए
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|string|min:6',
                'phone' => 'required|string', // अगर phone फील्ड है
            ]);

            // पासवर्ड को bcrypt के साथ एन्क्रिप्ट करें
            $input['password'] = bcrypt($input['password']);

            // यूजर क्रिएट करें
            $user = User::create($input);
            Log::info('User Created: ', ['user_id' => $user->id]);

            // टोकन जनरेट करें
            $success['token'] = $user->createToken('MyApp')->plainTextToken;
            $success['name'] = $user->name;

            // सफल रिस्पॉन्स
            return response()->json([
                'success' => true,
                'result' => $success,
                'msg' => 'user registered successfully'
            ], 200);

        } catch (\Exception $e) {
            // त्रुटि को लॉग करें और रिस्पॉन्स में वापस करें
            Log::error('Signup Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'msg' => 'An error occurred during signup'
            ], 500);
        }
    }
}