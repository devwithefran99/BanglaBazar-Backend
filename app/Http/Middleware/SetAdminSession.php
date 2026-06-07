<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetAdminSession
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->is('login') || $request->is('dashboard') ||
            $request->is('dashboard/*') || $request->is('admin/*') ||
            $request->is('orders') || $request->is('orders/*') ||
            $request->is('messages') || $request->is('messages/*') ||
            $request->is('profile') || $request->is('profile/*')) {

            config(['session.cookie' => 'admin_session']);
        }

        return $next($request);
    }
}