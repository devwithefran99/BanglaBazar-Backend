<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    private array $adminRoles = ['admin', 'super_admin', 'staff'];

    // Admin login page
   public function showLogin()
{
    if (Auth::check() && in_array(Auth::user()->role, ['super_admin', 'admin', 'staff'])) {
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

    if (Auth::attempt([
        'email'    => $request->email,
        'password' => $request->password,
    ], $request->boolean('remember'))) {

        $user = Auth::user();

        // super_admin, admin, staff — সবাই ঢুকতে পারবে
        if (in_array($user->role, ['super_admin', 'admin', 'staff'])) {
            $request->session()->regenerate();
            return redirect()->route('backend.dashboard');
        }

        // admin role না হলে logout করে ফেরত
        Auth::logout();
    }

    return back()
        ->withInput($request->only('email'))
        ->withErrors(['email' => 'Invalid email or password.']);
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