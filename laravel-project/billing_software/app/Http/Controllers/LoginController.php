<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Carbon;
use App\Models\User;
use App\Mail\VerifyUser;
use App\Helpers\EmailHelper;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login'    => 'required', 
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->route('login')->withInput()->withErrors($validator);
        }

        $loginInput = $request->input('login');
        $password = $request->input('password');

        $user = User::where('email', $loginInput)
            ->orWhere('username', $loginInput)
            ->first();

        if (!$user || $user->active == 0) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'error' => 'Account does not exist.'], 401);
            }
            return redirect()->back()->with('error', 'Account does not exist.');
        }

        if ($user->role === 'admin') {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'error' => 'Access denied.'], 403);
            }
            return redirect()->back()->with('error', 'Access denied.');
        }

        $allowedRoles = ['user', 'manager'];
        if (!in_array($user->role, $allowedRoles)) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'error' => 'Unauthorized role.'], 403);
            }
            return redirect()->back()->with('error', 'Unauthorized role.');
        }

        $guard = $user->role;
        $credentials = [
            filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'username' => $loginInput,
            'password' => $password,
        ];

        if (Auth::guard($guard)->attempt($credentials)) {
            $request->session()->regenerate();
            if ($request->ajax()) {
                return response()->json(['success' => true]);
            }

            return redirect()->route('' . $user->role . '.dashboard');
        }

        if ($request->ajax()) {
            return response()->json(['success' => false, 'error' => 'Either email or password is incorrect.'], 401);
        }
        return redirect()->back()->with('error', 'Either email or password is incorrect.');
    }




    public function managerLogout(){
        Auth::guard('manager')->logout();
        return redirect()->route('login');
    }

    public function userLogout(){
        Auth::guard('user')->logout();
        return redirect()->route('login');
    }
}