<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Subscription;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query()
            ->addSelect([
                'current_plan' => Subscription::select('plan_id')
                    ->whereColumn('user_id', 'dashboard_users.id')
                    ->whereIn('status', ['active', 'created', 'paused'])
                    ->latest('started_at')
                    ->limit(1)
            ]);
        if ($search = $request->get('q')) {
            $query->where(function($q) use ($search){
                $q->where('name','like',"%$search%")
                  ->orWhere('email','like',"%$search%");
            });
        }
        if ($role = $request->get('role')) {
            $query->where('role', $role);
        }
        // Enforce a maximum of 6 users per page
        $perPage = min(6, max(1, (int)($request->get('per_page', 6))));
        $users = $query->orderByDesc('id')->paginate($perPage)->withQueryString();

        if ($request->wantsJson()) {
            return response()->json($users);
        }
        $plans = Plan::orderBy('id','asc')->get(['slug','name']);
        return view('admin.users.index', compact('users','plans'));
    }

    public function show(User $user)
    {
        // Return a normalized payload to ensure required fields are present in JSON
        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'is_active' => (bool) $user->is_active,
            'phone' => $user->phone,
            'bio' => $user->bio,
            'profile_picture' => $user->profile_picture,
            'email_verified_at' => $user->email_verified_at,
            'last_login_at' => $user->last_login_at,
            'locked_until' => $user->locked_until,
            'failed_attempts' => $user->failed_attempts,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
        ]);
    }

    public function create()
    {
        return view('admin.users.form', ['user' => new User()]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255','unique:dashboard_users,email'],
            'phone' => ['nullable','string','max:20','unique:dashboard_users,phone'],
            'bio' => ['nullable','string','max:1000'],
            'profile_picture' => ['nullable','image','max:2048'],
            'password' => ['required','min:8','confirmed'],
            'role' => ['required','in:user,manager,admin'],
            'is_active' => ['required','boolean'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            $validated['profile_picture'] = $request->file('profile_picture')->store('profile_pictures', 'public');
        }

        $user = User::create($validated);

        if ($request->wantsJson()) {
            return response()->json(['message' => 'User created', 'user' => $user], 201);
        }
        return redirect()->route('admin.users.index')->with('success','User created');
    }

    public function edit(User $user)
    {
        return view('admin.users.form', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255','unique:dashboard_users,email,'.$user->id],
            'phone' => ['nullable','string','max:20','unique:dashboard_users,phone,'.$user->id],
            'bio' => ['nullable','string','max:1000'],
            'profile_picture' => ['nullable','image','max:2048'],
            'password' => ['nullable','min:8','confirmed'],
            'role' => ['required','in:user,manager,admin'],
            'is_active' => ['required','boolean'],
            'assign_plan' => ['nullable','string','exists:plans,slug'],
            'assign_status' => ['nullable','in:active,created,paused'],
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            $validated['profile_picture'] = $request->file('profile_picture')->store('profile_pictures', 'public');
        }

        $user->update($validated);

        // Optional: assign a subscription plan immediately
        if (!empty($validated['assign_plan'])) {
            Subscription::updateOrCreate(
                [ 'user_id' => $user->id ],
                [
                    'plan_id' => $validated['assign_plan'],
                    'status' => $validated['assign_status'] ?? 'active',
                    'started_at' => now(),
                    'ended_at' => null,
                ]
            );
        }

        if ($request->wantsJson()) {
            return response()->json(['message' => 'User updated', 'user' => $user]);
        }
        return redirect()->route('admin.users.index')->with('success','User updated');
    }

    public function destroy(User $user)
    {
        $user->delete();
        if (request()->wantsJson()) {
            return response()->json(['message' => 'User deleted']);
        }
        return back()->with('success','User deleted');
    }
}


