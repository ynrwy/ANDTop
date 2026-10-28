<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\GamePackage;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class GameController extends Controller
{
    public function index()
    {
        $games = Game::all();

        return view('pages.topup.game', compact('games'));
    }

    public function detail(Game $game)
    {
        $packages = $game->packages;

        return view('pages.topup.detail', compact('game', 'packages'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'id_game' => 'required|exists:games,id_game',
            'id_package' => 'required|exists:game_packages,id_package',
            'target_id' => 'required',
        ], [
            'target_id.required' => 'ID/Username game wajib diisi',
        ]);

        $game = Game::findOrFail($request->id_game);
        // Paket harus milik game yang dipilih
        $package = GamePackage::where('id_package', $request->id_package)
            ->where('id_game', $game->id_game)
            ->firstOrFail();

        $berhasil = DB::transaction(function () use ($game, $package, $request) {
            // Kunci baris user: request lain harus menunggu sampai transaksi ini selesai
            $user = User::whereKey(Auth::id())->lockForUpdate()->first();

            if ($user->saldo < $package->harga_coin) {
                return false;
            }

            $user->saldo -= $package->harga_coin;
            $user->save();

            Transaction::create([
                'user_id' => $user->id,
                'jenis' => 'game',
                'nama_item' => $game->nama_game,
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
