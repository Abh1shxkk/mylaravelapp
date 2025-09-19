<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();
        
        // If no specific roles are required, just check if user is authenticated
        if (empty($roles)) {
            return $next($request);
        }

        // Check if user has any of the required roles
        if (!in_array($user->role, $roles)) {
            abort(403, 'Unauthorized. You do not have the required role to access this page.');
        }

        return $next($request);
    }
}

// Alternative approach with more granular permissions
class CheckPermission
{
    /**
     * Define role hierarchy and permissions
     */
    private static $roleHierarchy = [
        'admin' => 3,
        'manager' => 2,
        'user' => 1,
    ];

    private static $permissions = [
        'view_users' => ['admin', 'manager'],
        'edit_users' => ['admin'],
        'delete_users' => ['admin'],
        'view_reports' => ['admin', 'manager'],
        'edit_settings' => ['admin'],
        'view_profile' => ['admin', 'manager', 'user'],
        'edit_own_profile' => ['admin', 'manager', 'user'],
    ];

    public function handle(Request $request, Closure $next, $permission)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();
        
        // Check if user's role has the required permission
        if (!$this->hasPermission($user->role, $permission)) {
            abort(403, 'Unauthorized. You do not have permission to perform this action.');
        }

        return $next($request);
    }

    private function hasPermission($userRole, $permission)
    {
        return isset(self::$permissions[$permission]) && 
               in_array($userRole, self::$permissions[$permission]);
    }

    /**
     * Check if role has minimum level access
     */
    public static function hasMinimumRole($userRole, $minimumRole)
    {
        $userLevel = self::$roleHierarchy[$userRole] ?? 0;
        $minLevel = self::$roleHierarchy[$minimumRole] ?? 0;
        
        return $userLevel >= $minLevel;
    }
}