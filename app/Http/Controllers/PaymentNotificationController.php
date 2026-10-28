<?php

namespace App\Http\Controllers;

use App\Models\TopupOrder;
use App\Services\TopupService;
use Illuminate\Http\Request;

class PaymentNotificationController extends Controller
{
    public function handle(Request $request)
    {
        $serverKey = (string) config('services.midtrans.server_key');

        // Pastikan request benar-benar dari Midtrans
        $expected = hash(
            'sha512',
            $request->order_id . $request->status_code . $request->gross_amount . $serverKey
        );

        if (!hash_equals($expected, (string) $request->signature_key)) {
            abort(403);
        }

        $order = TopupOrder::where('order_id', $request->order_id)->first();

        if (!$order) {
            return response()->json(['ok' => true]);
        }

        // Nominal harus sama dengan order
        if ((int) round((float) $request->gross_amount) !== (int) $order->amount) {
            abort(422);
        }

        TopupService::applyStatus($order, $request->all());

        return response()->json(['ok' => true]);
    }
}
