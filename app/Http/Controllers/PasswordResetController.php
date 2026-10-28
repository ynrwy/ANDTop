<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    public function request()
    {
        return view('pages.auth.forgot-password');
    }

    public function email(Request $request)
    {
        $request->validate(['email' => ['required', 'email']], [
            'email.required' => 'Email harus diisi',
            'email.email' => 'Email tidak valid',
        ]);

        Password::sendResetLink($request->only('email'));

        // Pesan sama baik email terdaftar atau tidak (supaya email orang tidak bisa ditebak)
        return back()->with('success', 'Jika email terdaftar, link reset password sudah dikirim. Cek inbox Anda.');
    }

    public function reset(Request $request, string $token)
    {
        $email = $request->query('email');
        $user = $email ? Password::getUser(['email' => $email]) : null;

        if (!$user || !Password::tokenExists($user, $token)) {
            return redirect()->route('password.request')
                ->withErrors(['email' => 'Link reset tidak valid atau sudah kedaluwarsa. Silakan minta link baru.']);
        }

        return view('pages.auth.reset-password', [
            'token' => $token,
            'email' => $email,
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8', 'confirmed'],
        ], [
            'password.required' => 'Password baru harus diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => $password, // di-hash otomatis oleh cast di model
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect('/')->with('success', 'Password berhasil diubah. Silakan masuk.');
        }

        return back()->withErrors(['email' => 'Link reset tidak valid atau sudah kedaluwarsa. Silakan minta link baru.']);
    }
}
