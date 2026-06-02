<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Admin হলে admin panel এ
                if (in_array(Auth::user()->role, ['super_admin', 'admin', 'staff'])) {
    return redirect()->route('backend.dashboard');
}
return redirect()->route('userdashboard');
                // Customer হলে user dashboard এ
                return redirect()->route('userdashboard');
            }
        }

        return $next($request);
    }
}