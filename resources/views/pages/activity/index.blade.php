@extends('layout.app')

@section('title', 'Aktivitas')

@section('content')
<div class="container py-3">
    <div class="card main-card p-4 mb-4 shadow-sm">

        <div class="d-flex align-items-center mb-4">
            <h5 class="fw-bold text-dark mb-0">Aktivitas</h5>
        </div>
        <form method="GET" class="mb-3">
            <select name="jenis" class="filter-select" onchange="this.form.submit()">
                <option value="semua" {{ request('jenis', 'semua') === 'semua' ? 'selected' : '' }}>Semua Aktivitas</option>
                <option value="saldo" {{ request('jenis') === 'saldo' ? 'selected' : '' }}>Topup Saldo</option>
                <option value="game" {{ request('jenis') === 'game' ? 'selected' : '' }}>Topup Game</option>
                <option value="ewallet" {{ request('jenis') === 'ewallet' ? 'selected' : '' }}>Topup E-Wallet</option>
            </select>
        </form>
                @forelse ($transactions as $trx)
            @php
                $struk = [
                    'item'   => $trx->nama_item,
                    'paket'  => $trx->nama_paket,
                    'target' => $trx->target_id,
                    'coin'   => number_format($trx->jumlah_coin, 0, ',', '.'),
                    'tipe'   => $trx->tipe === 'masuk' ? 'Coin masuk' : 'Coin keluar',
                    'waktu'  => $trx->created_at->format('d M Y, H:i'),
                    'no'     => 'AT-' . str_pad($trx->id, 6, '0', STR_PAD_LEFT),
                    'jenis' => $trx->jenis,
                ];
            @endphp
            <div class="activity-item shadow-sm mb-2 p-3 d-flex justify-content-between align-items-center btn-struk"
                role="button" tabindex="0"
                data-struk="{{ json_encode($struk) }}">
                <div class="d-flex align-items-center gap-3">
                    <div class="activity-icon">
                        @if ($trx->jenis === 'saldo')
                            <i class="fa-solid fa-wallet"></i>
                        @elseif ($trx->jenis === 'game')
                            <i class="fa-solid fa-gamepad"></i>
                        @else
                            <i class="fa-solid fa-money-bill-transfer"></i>
                        @endif
                    </div>
                    <div>
                        <div class="fw-semibold">
                            {{ $trx->nama_item }}
                            @if ($trx->nama_paket && $trx->jenis !== 'saldo')
                                - {{ $trx->nama_paket }}
                            @endif
                        </div>
                        @if ($trx->target_id)
                            <div class="text-muted" style="font-size: 12px;">
                                {{ $trx->jenis === 'saldo' ? 'Detail bayar:' : 'ID/No:' }} {{ $trx->target_id }}
                            </div>
                        @endif
                        <div class="text-muted" style="font-size: 12px;">
                            Pembayaran:
                            @if ($trx->jenis === 'saldo')
                                {{ $trx->nama_paket ?: 'Tidak tercatat' }}
                            @else
                                Saldo Coin
                            @endif
                        </div>
                        <div class="text-muted" style="font-size: 12px;">{{ $trx->created_at->format('d M Y, H:i') }}</div>
                    </div>
                </div>
                <div class="fw-bold {{ $trx->tipe === 'masuk' ? 'text-success' : 'text-danger' }}">
                    {{ $trx->tipe === 'masuk' ? '+' : '-' }}{{ number_format($trx->jumlah_coin, 0, ',', '.') }} Coin
                </div>
            </div>
        @empty
            <div class="text-center text-muted py-4">
                <div style="font-size:56px; line-height:1;">🦆</div>
                <div class="mt-2">Belum ada aktivitas. Yuk mulai topup pertamamu!</div>
            </div>
        @endforelse

        <div class="d-flex justify-content-center mt-4">
            {{ $transactions->links() }}
        </div>

    </div>
</div>

<style>
    .btn-struk { 
        cursor: pointer; 
    }
    .activity-item {
        background-color: #fff;
        border-radius: 12px;
    }
    .activity-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background-color: #fff3cd;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #FFB703;
        font-size: 18px;
    }
    .filter-select {
        padding: 10px 16px;
        border: none;
        border-radius: 12px;
        background-color: #ffffff;
        color: #555;
        font-size: 14px;
        font-weight: 600;
        outline: none;
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);
        cursor: pointer;
        max-width: 220px;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23999' stroke-width='3'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 14px center;
        padding-right: 36px;
    }
    .filter-select:focus {
        box-shadow: inset 0 0 0 1px #FFB703;
    }
</style>
<script>
    function tampilkanStruk(el) {
        const d = JSON.parse(el.dataset.struk);
        const esc = s => String(s ?? '').replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
        Swal.fire({
            title: 'Struk Transaksi',
            html: `
                <div class="text-start" style="font-size:14px; line-height:1.9;">
                    <b>No:</b> ${esc(d.no)}<br>
                    <b>Item:</b> ${esc(d.item)}<br>
                    ${d.paket ? `<b>${d.jenis === 'saldo' ? 'Metode' : 'Paket'}:</b> ${esc(d.paket)}<br>` : ''}
                    ${d.target ? `<b>${d.jenis === 'saldo' ? 'Detail pembayaran' : 'ID/No tujuan'}:</b> ${esc(d.target)}<br>` : ''}
                    <b>${esc(d.tipe)}:</b> ${esc(d.coin)} Coin<br>
                    <b>Waktu:</b> ${esc(d.waktu)}<br>
                    ${d.jenis !== 'saldo' ? '<b>Dibayar dengan:</b> Saldo Coin<br>' : ''}
                    <b>Status:</b> Berhasil
                </div>
                <p style="font-size:12px; margin-top:12px; color:#777;">Terima kasih sudah memakai AndTop.</p>`,
            confirmButtonText: 'Tutup',
            confirmButtonColor: '#ffcc29'
        });
    }
    document.querySelectorAll('.btn-struk').forEach(el => {
        el.addEventListener('click', () => tampilkanStruk(el));
        el.addEventListener('keydown', e => { if (e.key === 'Enter') tampilkanStruk(el); });
    });
</script>
@endsection