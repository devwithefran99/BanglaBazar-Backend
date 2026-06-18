<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $socialUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('signin')->with('error', 'Google login failed.');
        }

        $user = User::where('email', $socialUser->getEmail())->first();

        if (!$user) {
            $user = User::create([
                'name'              => $socialUser->getName(),
                'email'             => $socialUser->getEmail(),
                'password'          => bcrypt(str()->random(16)),
                'role'              => 'customer',
                'email_verified_at' => now(),
            ]);
        }

        Auth::login($user, true);
        return redirect()->route('userdashboard');
    }

    public function redirectToFacebook()
{
    return Socialite::driver('facebook')->setScopes(['public_profile'])->redirect();
}

   public function handleFacebookCallback()
{
    try {
        $socialUser = Socialite::driver('facebook')->user();
        dd($socialUser);
    } catch (\Exception $e) {
        dd('ERROR: ' . $e->getMessage());
    }
}
}