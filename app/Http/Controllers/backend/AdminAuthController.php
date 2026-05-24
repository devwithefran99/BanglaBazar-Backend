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
        // যেকোনো admin role এ login থাকলে dashboard এ
        if (Auth::check() && in_array(Auth::user()->role, $this->adminRoles)) {
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

        // প্রথমে email+password দিয়ে attempt করো (role check ছাড়া)
        if (Auth::attempt([
            'email'    => $request->email,
            'password' => $request->password,
        ], $request->boolean('remember'))) {

            // Login হলে role check করো
            if (in_array(Auth::user()->role, $this->adminRoles)) {
                $request->session()->regenerate();
                return redirect()->route('backend.dashboard');
            }

            // Admin role নেই → logout করে error দাও
            Auth::logout();
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'You do not have admin access.']);
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