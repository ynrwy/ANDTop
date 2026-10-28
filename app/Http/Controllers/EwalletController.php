<?php

namespace App\Http\Controllers;

use App\Models\Ewallet;
use App\Models\EwalletPackage;
use App\Models\EwalletTransaction;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class EwalletController extends Controller
{
    public function index()
    {
        $ewallets = Ewallet::all();

        return view('pages.topup.ewallet', compact('ewallets'));
    }

    public function detail(Ewallet $ewallet)
    {
        $packages = $ewallet->packages;

        return view('pages.topup.ewallet-detail', compact('ewallet', 'packages'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'id_ewallet' => 'required|exists:ewallets,id_ewallet',
            'id_package' => 'required|exists:ewallet_packages,id_package',
            'target_id' => 'required',
        ], [
            'target_id.required' => 'Nomor HP / akun e-wallet wajib diisi',
        ]);

        $ewallet = Ewallet::findOrFail($request->id_ewallet);
        $package = EwalletPackage::where('id_package', $request->id_package)
            ->where('id_ewallet', $ewallet->id_ewallet)
            ->firstOrFail();

        $berhasil = DB::transaction(function () use ($ewallet, $package, $request) {
            $user = User::whereKey(Auth::id())->lockForUpdate()->first();

            if ($user->saldo < $package->harga_coin) {
                return false;
            }

            $user->saldo -= $package->harga_coin;
            $user->save();

            Transaction::create([
                'user_id' => $user->id,
                'jenis' => 'ewallet',
                'nama_item' => $ewallet->nama_ewallet,
                'nama_paket' => $package->nama_paket,
                'target_id' => $request->target_id,
                'jumlah_coin' => $package->harga_coin,
                'tipe' => 'keluar',
            ]);

            return true;
        });

        if (!$berhasil) {
            return back()->with('error', 'Saldo Anda tidak cukup. Silakan topup saldo terlebih dahulu.');
        }

        return redirect()->route('dashboard')->with('success', 'Topup ' . $package->nama_paket . ' berhasil! Saldo terpotong ' . $package->harga_coin . ' coin.');
    }
}
