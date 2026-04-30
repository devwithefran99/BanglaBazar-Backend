<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Sign In page — সবসময় দেখাবে, redirect নেই
    public function showSignIn()
    {
        return view('frontend.signIn');
    }

    // Sign In process
    public function signIn(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt(
            ['email' => $request->email, 'password' => $request->password],
            $request->boolean('remember')
        )) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'admin') {
                return response()->json([
                    'success'  => true,
                    'message'  => 'Welcome Admin!',
                    'redirect' => route('backend.dashboard'),
                ]);
            }

            return response()->json([
                'success'  => true,
                'message'  => 'Login successful! Welcome back.',
                'redirect' => route('userdashboard'),
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Email or password is incorrect.',
        ], 401);
    }

    // Register page — সবসময় দেখাবে, redirect নেই
    public function showRegister()
    {
        return view('frontend.createAccount');
    }

    // Register process
    public function register(Request $request)
    {
        $request->validate([
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ], [
            'email.unique'       => 'This email is already registered.',
            'password.confirmed' => 'Passwords do not match.',
        ]);

        $user = User::create([
            'name'     => explode('@', $request->email)[0],
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'customer',
        ]);

        Auth::login($user);

        return response()->json([
            'success'  => true,
            'message'  => 'Account created! Welcome to BanglaBazar!',
            'redirect' => route('userdashboard'),
        ]);
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('signin');
    }
}