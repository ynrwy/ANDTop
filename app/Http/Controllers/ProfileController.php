<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        return view('pages.profile.index');
    }

    public function edit()
    {
        return view('pages.profile.edit');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ], [
            'name.required' => 'Nama lengkap harus diisi',
            'photo.image' => 'File harus berupa gambar',
            'photo.mimes' => 'Format gambar harus jpg, jpeg, atau png',
            'photo.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        $user = Auth::user();
        $user->name = $request->name;

        if ($request->hasFile('photo')) {
            // Hapus foto lama jika bukan default
            if (
                $user->photo
                && $user->photo !== 'images/users/default.jpg'
                && Storage::disk('public')->exists($user->photo)
            ) {
                Storage::disk('public')->delete($user->photo);
            }

            $user->photo = $request->file('photo')->store('images/users', 'public');
        }

        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui.');
    }
    public function changePassword()
    {
        return view('pages.profile.change-password');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        $hasPassword = $user->password !== null;

        $rules = [
            'password' => ['required', 'confirmed', 'min:8'],
        ];
        $messages = [
            'password.required' => 'Password baru harus diisi',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'password.min' => 'Password baru minimal 8 karakter',
        ];

        // Password lama hanya diminta kalau user sudah punya password
        if ($hasPassword) {
            $rules['current_password'] = ['required'];
            $messages['current_password.required'] = 'Password lama harus diisi';
        }

        $request->validate($rules, $messages);

        if ($hasPassword && !Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Password lama tidak sesuai.',
            ]);
        }

        $user->password = $request->password; // otomatis di-hash via cast di Model
        $user->save();

        return redirect()->route('profile.index')->with(
            'success',
            $hasPassword
                ? 'Password berhasil diubah.'
                : 'Password berhasil dibuat. Sekarang Anda bisa login dengan email dan password.'
        );
    }
}
