<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    // Admin login page
    public function showLogin()
    {
        // Already logged in admin হলে dashboard এ
        if (Auth::check() && Auth::user()->role === 'admin') {
            return redirect()->route('backend.dashboard');
        }
        return view('backend.auth.login');
    }

    // Admin login process
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // শুধু admin role এর user login করতে পারবে
        if (Auth::attempt([
            'email'    => $request->email,
            'password' => $request->password,
            'role'     => 'admin',
        ], $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->route('backend.dashboard');
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'Invalid credentials or you are not an admin.']);
    }

    // Admin logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}