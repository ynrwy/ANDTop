<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ewallet;
use App\Models\EwalletPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EwalletController extends Controller
{
    public function index()
    {
        $ewallets = Ewallet::latest()->get();

        return view('pages.admin.ewallet.index', compact('ewallets'));
    }

    public function create()
    {
        return view('pages.admin.ewallet.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_ewallet' => 'required',
            'deskripsi' => 'nullable',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'nama_ewallet.required' => 'Nama e-wallet harus diisi',
            'photo.image' => 'Photo harus berupa gambar',
        ]);

        $ewallet = new Ewallet();
        $ewallet->nama_ewallet = $request->nama_ewallet;
        $ewallet->deskripsi = $request->deskripsi;

        if ($request->hasFile('photo')) {
            $ewallet->photo = $request->file('photo')->store('images/ewallets', 'public');
        }

        $ewallet->save();

        return redirect()->route('admin.ewallet.index')->with('success', 'E-Wallet berhasil ditambahkan.');
    }

    public function edit(Ewallet $ewallet)
    {
        return view('pages.admin.ewallet.edit', compact('ewallet'));
    }

    public function update(Request $request, Ewallet $ewallet)
    {
        $request->validate([
            'nama_ewallet' => 'required',
            'deskripsi' => 'nullable',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'nama_ewallet.required' => 'Nama e-wallet harus diisi',
            'photo.image' => 'Photo harus berupa gambar',
        ]);

        $ewallet->nama_ewallet = $request->nama_ewallet;
        $ewallet->deskripsi = $request->deskripsi;

        if ($request->hasFile('photo')) {
            if ($ewallet->photo !== 'images/ewallets/default.png' && Storage::disk('public')->exists($ewallet->photo)) {
                Storage::disk('public')->delete($ewallet->photo);
            }
            $ewallet->photo = $request->file('photo')->store('images/ewallets', 'public');
        }

        $ewallet->save();

        return redirect()->route('admin.ewallet.index')->with('success', 'E-Wallet berhasil diperbarui.');
    }

    public function destroy(Ewallet $ewallet)
    {
        if ($ewallet->photo !== 'images/ewallets/default.png' && Storage::disk('public')->exists($ewallet->photo)) {
            Storage::disk('public')->delete($ewallet->photo);
        }

        $ewallet->delete();

        return redirect()->route('admin.ewallet.index')->with('success', 'E-Wallet berhasil dihapus.');
    }

    public function package(Ewallet $ewallet)
    {
        $packages = $ewallet->packages;

        return view('pages.admin.ewallet.package', compact('ewallet', 'packages'));
    }

    public function packageStore(Request $request, Ewallet $ewallet)
    {
        $request->validate([
            'nama_paket' => 'required',
            'nominal' => 'required|numeric|min:1',
            'harga_coin' => 'required|numeric|min:1',
        ], [
            'nama_paket.required' => 'Nama paket harus diisi',
            'nominal.required' => 'Nominal harus diisi',
            'harga_coin.required' => 'Harga coin harus diisi',
        ]);

        EwalletPackage::create([
            'id_ewallet' => $ewallet->id_ewallet,
            'nama_paket' => $request->nama_paket,
            'nominal' => $request->nominal,
            'harga_coin' => $request->harga_coin,
        ]);

        return redirect()->route('admin.ewallet.package', $ewallet->id_ewallet)->with('success', 'Paket berhasil ditambahkan.');
    }

    public function packageUpdate(Request $request, Ewallet $ewallet, EwalletPackage $package)
    {
        $request->validate([
            'nama_paket' => 'required',
            'nominal' => 'required|numeric|min:1',
            'harga_coin' => 'required|numeric|min:1',
        ], [
            'nama_paket.required' => 'Nama paket harus diisi',
            'nominal.required' => 'Nominal harus diisi',
            'harga_coin.required' => 'Harga coin harus diisi',
        ]);

        $package->nama_paket = $request->nama_paket;
        $package->nominal = $request->nominal;
        $package->harga_coin = $request->harga_coin;
        $package->save();

        return redirect()->route('admin.ewallet.package', $ewallet->id_ewallet)->with('success', 'Paket berhasil diperbarui.');
    }

    public function packageDestroy(Ewallet $ewallet, EwalletPackage $package)
    {
        $package->delete();

        return redirect()->route('admin.ewallet.package', $ewallet->id_ewallet)->with('success', 'Paket berhasil dihapus.');
    }
}
