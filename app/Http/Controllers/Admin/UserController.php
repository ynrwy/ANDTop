<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role_id', 2)->latest()->paginate(10);

        return view('pages.admin.user.index', compact('users'));
    }

    public function toggleStatus(User $user)
    {
        $user->status = $user->status === 'aktif' ? 'nonaktif' : 'aktif';
        $user->save();

        $pesan = $user->status === 'aktif'
            ? 'Akun berhasil diaktifkan.'
            : 'Akun berhasil dinonaktifkan.';

        return back()->with('success', $pesan);
    }

    public function destroy(User $user)
    {
        // Hanya user nonaktif yang bisa dihapus
        if ($user->status !== 'nonaktif') {
            return back()->with('error', 'Hanya akun nonaktif yang dapat dihapus.');
        }

        $user->delete();

        return back()->with('success', 'User berhasil dihapus.');
    }
}
