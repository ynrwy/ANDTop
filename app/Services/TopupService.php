<?php

namespace App\Services;

use App\Models\TopupOrder;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class TopupService
{
    public const RATE = 1000; // 1 coin = Rp 1.000

    public static function isBypass(): bool
    {
        return config('services.payment.mode') === 'bypass' && !app()->isProduction();
    }

    public static function snapBase(): string
    {
        return config('services.midtrans.is_production')
            ? 'https://app.midtrans.com'
            : 'https://app.sandbox.midtrans.com';
    }

    public static function apiBase(): string
    {
        return config('services.midtrans.is_production')
            ? 'https://api.midtrans.com'
            : 'https://api.sandbox.midtrans.com';
    }

    public static function paymentLabel(?string $type): string
    {
        return match ($type) {
            'credit_card'  => 'Kartu kredit/debit',
            'bank_transfer' => 'Transfer bank (VA)',
            'echannel'     => 'Mandiri Bill',
            'qris'         => 'QRIS',
            'gopay'        => 'GoPay',
            'shopeepay'    => 'ShopeePay',
            'dana'         => 'DANA',
            'cstore'       => 'Minimarket',
            'bypass'       => 'Uji coba (tanpa bayar)',
            null, ''       => 'Tidak diketahui',
            default        => ucfirst(str_replace('_', ' ', $type)),
        };
    }

    // Ambil detail singkat dari balasan Midtrans. Hanya data yang memang dikirim.
    public static function extractDetail(array $d): ?string
    {
        $type = $d['payment_type'] ?? null;

        $detail = match ($type) {
            'credit_card' => !empty($d['masked_card'])
                ? 'Kartu ' . $d['masked_card']
                : null,
            'bank_transfer' => isset($d['va_numbers'][0]['va_number'])
                ? strtoupper($d['va_numbers'][0]['bank'] ?? 'VA') . ' ' . $d['va_numbers'][0]['va_number']
                : (!empty($d['permata_va_number']) ? 'PERMATA ' . $d['permata_va_number'] : null),
            'qris' => !empty($d['issuer'])
                ? 'Penerbit: ' . $d['issuer']
                : (!empty($d['acquirer']) ? 'Acquirer: ' . $d['acquirer'] : null),
            default => null,
        };

        return $detail ? mb_substr($detail, 0, 100) : null;
    }

    // Menambah coin. Aman dipanggil berkali-kali: order yang sudah paid diabaikan.
    public static function markPaid(string $orderId, ?string $paymentType = null, array $data = []): bool
    {
        return DB::transaction(function () use ($orderId, $paymentType, $data) {
            $order = TopupOrder::where('order_id', $orderId)->lockForUpdate()->first();

            if (!$order || $order->status === 'paid') {
                return false;
            }

            $user = User::whereKey($order->user_id)->lockForUpdate()->first();
            $user->saldo += $order->coin;
            $user->save();

            $detail = self::extractDetail($data + ['payment_type' => $paymentType]);

            $order->update([
                'status' => 'paid',
                'payment_type' => $paymentType,
                'payment_detail' => $detail,
                'paid_at' => now(),
            ]);

            Transaction::create([
                'user_id' => $user->id,
                'jenis' => 'saldo',
                'nama_item' => 'Topup Saldo',
                'nama_paket' => 'via ' . self::paymentLabel($paymentType),
                'target_id' => $detail,
                'jumlah_coin' => $order->coin,
                'tipe' => 'masuk',
            ]);

            return true;
        });
    }

    // Dipakai oleh webhook dan halaman selesai. $data = balasan atau notifikasi Midtrans.
    public static function applyStatus(TopupOrder $order, array $data): void
    {
        $status = (string) ($data['transaction_status'] ?? '');
        $fraud = $data['fraud_status'] ?? null;
        $type = $data['payment_type'] ?? null;

        if ($status === 'settlement' || ($status === 'capture' && $fraud === 'accept')) {
            self::markPaid($order->order_id, $type, $data);
        } elseif (in_array($status, ['expire', 'cancel', 'deny']) && $order->status === 'pending') {
            $order->update(['status' => $status === 'expire' ? 'expired' : 'failed']);
        }
    }
}
