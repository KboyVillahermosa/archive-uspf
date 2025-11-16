<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            abort(403, 'Access denied. Authentication required.');
        }

        $user = auth()->user();
        
        // Check Spatie role first, fallback to legacy role column
        $isAdmin = $user->hasRole('admin') || ($user->role === 'admin');
        
        if (!$isAdmin) {
            abort(403, 'Access denied. Admin privileges required.');
        }

        return $next($request);
    }
}
