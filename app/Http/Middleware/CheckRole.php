<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();
        $allowedRoles = explode(',', $role);

        // Trim whitespace from roles
        $allowedRoles = array_map('trim', $allowedRoles);

        // Check if user role is in allowed roles
        $userRole = trim($user->role);

        if (!in_array($userRole, $allowedRoles)) {
            abort(403, 'Access denied. Required roles: ' . implode(', ', $allowedRoles) . '. Your role: ' . $userRole);
        }

        return $next($request);
    }
}
