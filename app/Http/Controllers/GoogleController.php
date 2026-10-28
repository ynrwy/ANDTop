<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirect()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return Socialite::driver('google')->redirect();
    }

    public function callback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Throwable $e) {
            return redirect('/')->withErrors(['email' => 'Login dengan Google gagal. Silakan coba lagi.']);
        }

        $email = $googleUser->getEmail();
        $emailVerified = (bool) data_get($googleUser->user, 'email_verified', false);

        if (!$email || !$emailVerified) {
            return redirect('/')->withErrors(['email' => 'Email Google Anda belum terverifikasi.']);
        }

        $user = User::where('google_id', $googleUser->getId())->first();

        if (!$user) {
            $user = User::where('email', $email)->first();

            if ($user) {
                // Akun lama dengan email sama: gabungkan
                if (!$user->hasVerifiedEmail()) {
                    // Cegah pre-hijacking: email belum pernah diverifikasi,
                    // jadi password yang didaftarkan orang lain dihapus.
                    $user->password = null;
                    $user->email_verified_at = now();
                }
                $user->google_id = $googleUser->getId();
                $user->save();
            } else {
                $user = new User();
                $user->forceFill([
                    'name' => $googleUser->getName() ?: $email,
                    'email' => $email,
                    'google_id' => $googleUser->getId(),
                    'password' => null,
                    'role_id' => 2,
                    'status' => 'aktif',
                    'email_verified_at' => now(),
                ])->save();
            }
        }

        if ($user->status === 'nonaktif') {
            return redirect('/')->with('suspended', true);
        }

        Auth::login($user, true);
        $request->session()->regenerate();

        return redirect()->intended('dashboard')
            ->with('success', 'Berhasil masuk dengan Google. Selamat datang, ' . $user->name . '!');;
    }
}
