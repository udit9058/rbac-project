<?php

// app/Http/Middleware/RoleMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        $user = Auth::user();

        // Check if the user has the required role
        if ($user && $user->role->name === $role) {
            return $next($request);
        }

        // If not, redirect them or abort with an error
        return redirect()->route('dashboard')->withErrors('You do not have permission to access this page.');
    }
}
