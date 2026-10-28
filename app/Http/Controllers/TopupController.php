<?php

namespace App\Http\Controllers;

use App\Models\TopupOrder;
use App\Services\TopupService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class TopupController extends Controller
{
    public function index()
    {
        return view('pages.topup.coin');
    }

    public function store(Request $request)
    {
        $request->validate([
            'coin' => ['required', 'integer', 'min:1', 'max:1000'],
        ], [
            'coin.required' => 'Jumlah coin harus diisi',
            'coin.integer' => 'Jumlah coin harus berupa bilangan bulat',
            'coin.min' => 'Minimal topup 1 coin',
            'coin.max' => 'Maksimal topup 1.000 coin sekali isi',
        ]);

        $user = Auth::user();
        $coin = (int) $request->coin;
        $amount = $coin * TopupService::RATE;

        $order = TopupOrder::create([
            'order_id' => 'ATP-' . $user->id . '-' . now()->format('ymdHis') . '-' . Str::upper(Str::random(4)),
            'user_id' => $user->id,
            'coin' => $coin,
            'amount' => $amount,
            'status' => 'pending',
        ]);

        // Mode uji coba: langsung lunas tanpa bayar
        if (TopupService::isBypass()) {
            TopupService::markPaid($order->order_id, 'bypass');

            return redirect()->route('dashboard')
                ->with('success', 'Mode uji coba: saldo bertambah ' . $coin . ' coin tanpa pembayaran.');
        }

        $response = Http::withBasicAuth(config('services.midtrans.server_key'), '')
            ->acceptJson()
            ->post(TopupService::snapBase() . '/snap/v1/transactions', [
                'transaction_details' => [
                    'order_id' => $order->order_id,
                    'gross_amount' => $amount,
                ],
                'item_details' => [[
                    'id' => 'COIN',
                    'price' => TopupService::RATE,
                    'quantity' => $coin,
                    'name' => 'Topup Coin AndTop',
                ]],
                'customer_details' => [
                    'first_name' => $user->name,
                    'email' => $user->email,
                ],
                'callbacks' => ['finish' => route('topup.finish')],
            ]);

        if (!$response->successful() || !$response->json('redirect_url')) {
            Log::warning('Midtrans gagal', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            $order->update(['status' => 'failed']);

            return back()->with('error', 'Gagal membuat pembayaran. Silakan coba lagi.');
        }

        // Arahkan user ke halaman pembayaran Midtrans
        return redirect()->away($response->json('redirect_url'));
    }

    public function finish(Request $request)
    {
        $order = TopupOrder::where('order_id', $request->query('order_id'))
            ->where('user_id', Auth::id())
            ->first();

        if (!$order) {
            return redirect()->route('dashboard');
        }

        // Cek langsung ke Midtrans, jadi saldo tetap terisi walau webhook belum sampai (misalnya di localhost)
        if ($order->status === 'pending') {
            $res = Http::withBasicAuth(config('services.midtrans.server_key'), '')
                ->acceptJson()
                ->get(TopupService::apiBase() . '/v2/' . $order->order_id . '/status');

            if ($res->successful()) {
                TopupService::applyStatus($order, $res->json());
                $order->refresh();
            }
        }

        $pesan = $order->status === 'paid'
            ? 'Pembayaran berhasil! Saldo bertambah ' . $order->coin . ' coin.'
            : 'Pembayaran sedang diproses. Saldo akan bertambah otomatis setelah pembayaran terkonfirmasi.';

        return redirect()->route('dashboard')->with('success', $pesan);
    }
}
