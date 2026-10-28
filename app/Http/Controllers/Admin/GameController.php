<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\GamePackage;


class GameController extends Controller
{
    public function index()
    {
        $games = Game::latest()->get();

        return view('pages.admin.game.index', compact('games'));
    }

    public function create()
    {
        return view('pages.admin.game.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_game' => 'required',
            'deskripsi' => 'nullable',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'icon' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'nama_game.required' => 'Nama game harus diisi',
            'photo.image' => 'Photo harus berupa gambar',
            'icon.image' => 'Icon harus berupa gambar',
        ]);

        $game = new Game();
        $game->nama_game = $request->nama_game;
        $game->deskripsi = $request->deskripsi;

        if ($request->hasFile('photo')) {
            $game->photo = $request->file('photo')->store('images/games', 'public');
        }

        if ($request->hasFile('icon')) {
            $game->icon = $request->file('icon')->store('images/games/icons', 'public');
        }

        $game->save();

        return redirect()->route('admin.game.index')->with('success', 'Game berhasil ditambahkan.');
    }

    public function edit(Game $game)
    {
        return view('pages.admin.game.edit', compact('game'));
    }

    public function update(Request $request, Game $game)
    {
        $request->validate([
            'nama_game' => 'required',
            'deskripsi' => 'nullable',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'icon' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'nama_game.required' => 'Nama game harus diisi',
            'photo.image' => 'Photo harus berupa gambar',
            'icon.image' => 'Icon harus berupa gambar',
        ]);

        $game->nama_game = $request->nama_game;
        $game->deskripsi = $request->deskripsi;

        if ($request->hasFile('photo')) {
            if ($game->photo !== 'images/games/default.png' && Storage::disk('public')->exists($game->photo)) {
                Storage::disk('public')->delete($game->photo);
            }
            $game->photo = $request->file('photo')->store('images/games', 'public');
        }

        if ($request->hasFile('icon')) {
            if ($game->icon !== 'images/games/icons/default.png' && Storage::disk('public')->exists($game->icon)) {
                Storage::disk('public')->delete($game->icon);
            }
            $game->icon = $request->file('icon')->store('images/games/icons', 'public');
        }

        $game->save();

        return redirect()->route('admin.game.index')->with('success', 'Game berhasil diperbarui.');
    }

    public function destroy(Game $game)
    {
        if ($game->photo !== 'images/games/default.png' && Storage::disk('public')->exists($game->photo)) {
            Storage::disk('public')->delete($game->photo);
        }
        if ($game->icon !== 'images/games/icons/default.png' && Storage::disk('public')->exists($game->icon)) {
            Storage::disk('public')->delete($game->icon);
        }

        $game->delete();

        return redirect()->route('admin.game.index')->with('success', 'Game berhasil dihapus.');
    }

    //PACKAGE
    public function package(Game $game)
    {
        $packages = $game->packages;

        return view('pages.admin.game.package', compact('game', 'packages'));
    }

    public function packageStore(Request $request, Game $game)
    {
        $request->validate([
            'nama_paket' => 'required',
            'jumlah' => 'required|numeric|min:1',
            'harga_coin' => 'required|numeric|min:1',
        ], [
            'nama_paket.required' => 'Nama paket harus diisi',
            'jumlah.required' => 'Jumlah harus diisi',
            'harga_coin.required' => 'Harga coin harus diisi',
        ]);

        GamePackage::create([
            'id_game' => $game->id_game,
            'nama_paket' => $request->nama_paket,
            'jumlah' => $request->jumlah,
            'harga_coin' => $request->harga_coin,
        ]);

        return redirect()->route('admin.game.package', $game->id_game)->with('success', 'Paket berhasil ditambahkan.');
    }

    public function packageUpdate(Request $request, Game $game, GamePackage $package)
    {
        $request->validate([
            'nama_paket' => 'required',
            'jumlah' => 'required|numeric|min:1',
            'harga_coin' => 'required|numeric|min:1',
        ], [
            'nama_paket.required' => 'Nama paket harus diisi',
            'jumlah.required' => 'Jumlah harus diisi',
            'harga_coin.required' => 'Harga coin harus diisi',
        ]);

        $package->nama_paket = $request->nama_paket;
        $package->jumlah = $request->jumlah;
        $package->harga_coin = $request->harga_coin;
        $package->save();

        return redirect()->route('admin.game.package', $game->id_game)->with('success', 'Paket berhasil diperbarui.');
    }

    public function packageDestroy(Game $game, GamePackage $package)
    {
        $package->delete();

        return redirect()->route('admin.game.package', $game->id_game)->with('success', 'Paket berhasil dihapus.');
    }
}
