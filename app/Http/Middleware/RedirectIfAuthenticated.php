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
                if (Auth::user()->role === 'admin') {
                    return redirect()->route('backend.dashboard');
                }
                // Customer হলে user dashboard এ
                return redirect()->route('userdashboard');
            }
        }

        return $next($request);
    }
}