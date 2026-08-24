<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;


class GoogleController extends Controller
{
    public function redirectToGoogle() 
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Find existing user or create new one
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // Update avatar if user doesn't have one
                if (!$user->avatar) {
                    $user->update([
                        'avatar' => 'img/default-dp.jpg',
                    ]);
                }

                Auth::login($user);
            } else {
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    // Random password — OAuth users never sign in with it.
                    'password' => Hash::make(Str::random(40)),
                    'email_verified_at' => now(),
                    'bio' => null,
                    'avatar' => 'img/default-dp.jpg',
                    'auth_provider' => 'google',
                    'auth_provider_id' => $googleUser->getId(),
                ]);
                // usertype is set server-side only (never mass-assignable).
                $user->usertype = 'user';
                $user->save();

                Auth::login($user);
            }

            Log::info('OAuth login (google)', ['user_id' => $user->id]);
            return redirect('/dashboard');
            
        } catch (\Exception $e) {
            Log::error('Google OAuth error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect('/login')->with('error', 'Google login failed: ' . $e->getMessage());
        }
    }
}
