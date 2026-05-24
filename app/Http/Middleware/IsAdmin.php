<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Login নেই → login page এ
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Please login to access admin panel.');
        }

        // admin, super_admin, staff — তিনটা role ই access পাবে
        $allowedRoles = ['admin', 'super_admin', 'staff'];

        if (!in_array(Auth::user()->role, $allowedRoles)) {
            abort(403, 'Unauthorized. Admin access only.');
        }

        return $next($request);
    }
}