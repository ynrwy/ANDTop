<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('pages.auth.login');
    }

    // Memproses data login (Autentikasi)
    public function authenticate(Request $request)
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Email harus diisi',
            'email.email' => 'Email tidak valid.',
            'password.required' => 'Password harus diisi',
        ]);

        // Kunci pembatas: email + IP, supaya satu orang tidak mengunci akun orang lain
        $key = Str::lower($request->input('email')) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $detik = RateLimiter::availableIn($key);
            $menit = (int) ceil($detik / 60);

            return back()->withErrors([
                'email' => "Terlalu banyak percobaan login. Coba lagi dalam {$menit} menit.",
            ])->onlyInput('email');
        }

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            RateLimiter::clear($key); // berhasil: reset hitungan

            $request->session()->regenerate();
            if (Auth::user()->role_id == 1) {
                \Illuminate\Support\Facades\DB::table('sessions')
                    ->where('user_id', Auth::id())
                    ->where('id', '!=', $request->session()->getId())
                    ->delete();
            }
            $request->session()->forget('baru_daftar');

            // Cek status akun setelah berhasil login
            if (Auth::user()->status === 'nonaktif') {
                $this->_logout($request);
                return back()->with('suspended', true);
            }

            return redirect()->intended('dashboard')
                ->with('success', 'Selamat datang kembali, ' . Auth::user()->name . '!');
        }

        RateLimiter::hit($key, 300); // gagal: catat, hitungan hilang setelah 5 menit

        return back()->withErrors([
            'email' => 'Terjadi kesalahan periksa kembali email atau password anda.',
        ])->onlyInput('email');
    }

    // Menampilkan halaman registrasi akun baru
    public function registerView()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('pages.auth.register');
    }

    // Memproses registrasi user baru
    public function register(Request $request)
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'], // unique agar email tidak kembar
            'password' => ['required', 'min:8'],
        ], [
            'name.required' => 'Nama lengkap harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email ini sudah terdaftar',
            'password.required' => 'Password harus diisi',
        ]);

        $user = new User();
        $user->name = $request['name'];
        $user->email = $request['email'];
        // Tanpa Hash::make karena dicasting otomatis di Model User.php
        $user->password = $request['password'];
        $user->role_id = 2; // Otomatis sebagai Customer / User biasa
        $user->saveOrFail();

        event(new Registered($user)); // mengirim email verifikasi
        Auth::login($user);
        session(['baru_daftar' => true]); // tandai: belum pernah masuk ke AndTop

        return redirect()->route('verification.notice');
    }

    // Fungsi internal untuk menghapus session auth
    public function _logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }

    // Memproses log out user
    public function logout(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/');
        }

        $this->_logout($request);
        return redirect('/')->with('success', 'Sampai jumpa! Anda telah berhasil keluar dari AndTop.');
    }
}
