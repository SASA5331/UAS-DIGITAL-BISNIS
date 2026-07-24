<?php

// FILE: app/Http/Controllers/SocialiteController.php
// BARU — handles Google OAuth login untuk pembeli/pengunjung

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;

class SocialiteController extends Controller
{
    /**
     * Redirect ke halaman login Google.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle callback dari Google setelah user login.
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Cari user yang sudah pernah login dengan Google ini
            $user = User::where('google_id', $googleUser->getId())->first();

            if (!$user) {
                // Cek apakah email sudah terdaftar (akun biasa, bukan SSO)
                $existingUser = User::where('email', $googleUser->getEmail())->first();

                if ($existingUser) {
                    // Update akun lama dengan google_id
                    $existingUser->update([
                        'google_id' => $googleUser->getId(),
                        'avatar'    => $googleUser->getAvatar(),
                    ]);
                    $user = $existingUser;
                } else {
                    // Buat akun baru dari data Google
                    $user = User::create([
                        'name'      => $googleUser->getName(),
                        'email'     => $googleUser->getEmail(),
                        'google_id' => $googleUser->getId(),
                        'avatar'    => $googleUser->getAvatar(),
                        'password'  => null, // SSO user tidak butuh password
                        'role'      => 'user',
                    ]);
                }
            }

            // Login sebagai user ini (bukan admin)
            Auth::login($user, true); // true = remember me

            // Jika ada intended URL (misal mau checkout dulu), redirect ke sana
            return redirect()->intended(route('home'))
                ->with('success', 'Selamat datang, ' . $user->name . '!');

        } catch (\Exception $e) {
            return redirect()->route('home')
                ->with('error', 'Login dengan Google gagal. Silakan coba lagi.');
        }
    }

    /**
     * Logout untuk user SSO (bukan admin).
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}