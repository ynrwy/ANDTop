@extends('layout.app')

@section('title', 'Dashboard Customer')

@section('content')
@if (session('success'))
    <script>
        Swal.fire({
            title: "Berhasil!",
            text: "{{ session('success') }}",
            icon: "success",
            confirmButtonColor: '#ffcc29'
        });
    </script>
@endif
<div class="container py-3">
    <div class="card main-card p-4 mb-4 shadow-sm">
        <div class="mb-3">
            <h5 class="fw-bold text-dark mb-1">Halo, {{ auth()->user()->name }}!</h5>
            <p class="text-muted mb-0" style="font-size: 13px;">Selamat datang kembali di AndTop!</p>
        </div>

        @if (auth()->user()->role_id == 1)
            {{-- ===== BODY ADMIN ===== --}}
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="stat-card shadow-sm">
                        <div class="stat-icon" style="background-color: #fff3cd; color: #FFB703;">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        <div>
                            <div class="stat-value">{{ $totalUser }}</div>
                            <div class="stat-label">Total Customer</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card shadow-sm">
                        <div class="stat-icon" style="background-color: #d1fae5; color: #10b981;">
                            <i class="fa-solid fa-receipt"></i>
                        </div>
                        <div>
                            <div class="stat-value">{{ $totalTransaksi }}</div>
                            <div class="stat-label">Total Transaksi</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card shadow-sm">
                        <div class="stat-icon" style="background-color: #dbeafe; color: #3b82f6;">
                            <i class="fa-solid fa-coins"></i>
                        </div>
                        <div>
                            <div class="stat-value">{{ number_format($totalCoinMasuk ?? 0, 0, ',', '.') }}</div>
                            <div class="stat-label">Coin Masuk</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Transaksi Terbaru --}}
            @if (isset($latestTransactions) && $latestTransactions->count() > 0)
                <div>
                    <h6 class="fw-bold text-dark mb-3"><i class="fa-solid fa-clock-rotate-left me-2" style="color: #FFB703;"></i>Transaksi Terbaru</h6>
                    @foreach ($latestTransactions as $trx)
                        <div class="activity-item shadow-sm mb-2 p-3 d-flex justify-content-between align-items-center">
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
                                    <div class="fw-semibold" style="font-size: 14px;">
                                        {{ $trx->user->name }} - {{ $trx->nama_item }}
                                        @if ($trx->nama_paket)
                                            ({{ $trx->nama_paket }})
                                        @endif
                                    </div>
                                    <div class="text-muted" style="font-size: 12px;">{{ $trx->created_at->format('d M Y, H:i') }}</div>
                                </div>
                            </div>
                            <div class="fw-bold {{ $trx->tipe === 'masuk' ? 'text-success' : 'text-danger' }}" style="font-size: 14px;">
                                {{ $trx->tipe === 'masuk' ? '+' : '-' }}{{ number_format($trx->jumlah_coin, 0, ',', '.') }} Coin
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        @else
            {{-- ===== BODY CUSTOMER ===== --}}
            @unless (auth()->user()->hasVerifiedEmail())
                <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap mb-4 p-3"
                    style="background-color: #fff3cd; border: 1px solid #FFB703; border-radius: 14px;">
                    <div class="d-flex align-items-center gap-3">
                        <i class="fa-solid fa-triangle-exclamation" style="font-size: 22px; color: #e08e00;"></i>
                        <div>
                            <div class="fw-bold" style="font-size: 14px; color: #5d4037;">Email Anda belum terverifikasi</div>
                            <div style="font-size: 12px; color: #5d4037;">Verifikasi email untuk bisa melakukan top-up</div>
                        </div>
                    </div>
                    <a href="{{ route('verification.notice') }}" class="btn btn-sm fw-bold"
                        style="background-color: #FFB703; color: #000; border-radius: 10px;">
                        Verifikasi
                    </a>
                </div>
            @endunless
            <div class="mb-4">
                <h6 class="fw-medium text-secondary mb-1" style="font-size: 1rem;">Saldo Anda :</h6>
                <div class="d-flex align-items-center gap-2 fs-4 fw-bold text-dark">
                    <img src="{{ asset('storage/images/coin.png') }}" alt="Coin" style="height: 70px; width: auto; object-fit: contain;">
                    <span>{{ number_format(auth()->user()->saldo, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <a href="{{ route('topup.index') }}" class="btn w-100 menu-tab shadow-sm">
                        <i class="fa-solid fa-coins d-block mb-1" style="font-size: 20px;"></i>
                        Top-Up Saldo
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="{{ route('topup.game') }}" class="btn w-100 menu-tab shadow-sm">
                        <i class="fa-solid fa-gamepad d-block mb-1" style="font-size: 20px;"></i>
                        Top-Up Game
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="{{ route('topup.ewallet') }}" class="btn w-100 menu-tab shadow-sm">
                        <i class="fa-solid fa-wallet d-block mb-1" style="font-size: 20px;"></i>
                        Top-Up E-Wallet
                    </a>
                </div>
            </div>

            <div class="rate-box p-4 d-flex justify-content-between align-items-center shadow-inner mb-4">
                <div class="d-flex align-items-center gap-2">
                    <img src="{{ asset('storage/images/coin.png') }}" alt="Coin" style="height: 40px; width: auto; object-fit: contain;">
                    <span>1 Coin</span>
                </div>
                <div class="fw-bold fs-4">=</div>
                <div class="d-flex align-items-center gap-2">
                    <img src="{{ asset('storage/images/indo.png') }}" alt="Indonesia Flag" style="height: 40px; width: auto; object-fit: contain;">
                    <span>IDR Rp 1.000</span>
                </div>
            </div>

            {{-- Game Populer --}}
            @if ($games->count() > 0)
                <div class="mb-4">
                    <h6 class="fw-bold text-dark mb-3"><i class="fa-solid fa-fire me-2" style="color: #FFB703;"></i>Game Populer</h6>
                    <div class="row g-3">
                        @foreach ($games as $game)
                            <div class="col-md-4 col-6">
                                <div class="game-card shadow-sm">
                                    <img src="{{ asset('storage/' . $game->photo) }}" alt="{{ $game->nama_game }}" class="game-img">
                                    <div class="game-name">{{ $game->nama_game }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Aktivitas Terakhir --}}
            @if ($lastTransactions->count() > 0)
                <div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold text-dark mb-0"><i class="fa-solid fa-clock-rotate-left me-2" style="color: #FFB703;"></i>Aktivitas Terakhir</h6>
                    </div>
                    @foreach ($lastTransactions as $trx)
                        <div class="activity-item shadow-sm mb-2 p-3 d-flex justify-content-between align-items-center">
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
                                    <div class="fw-semibold" style="font-size: 14px;">
                                        {{ $trx->nama_item }}
                                        @if ($trx->nama_paket)
                                            - {{ $trx->nama_paket }}
                                        @endif
                                    </div>
                                    <div class="text-muted" style="font-size: 12px;">{{ $trx->created_at->format('d M Y, H:i') }}</div>
                                </div>
                            </div>
                            <div class="fw-bold {{ $trx->tipe === 'masuk' ? 'text-success' : 'text-danger' }}" style="font-size: 14px;">
                                {{ $trx->tipe === 'masuk' ? '+' : '-' }}{{ number_format($trx->jumlah_coin, 0, ',', '.') }} Coin
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        @endif
    </div>
</div>
@if (auth()->user()->role_id != 1)
    {{-- WhatsApp Bubble --}}
    <a href="https://wa.me/6285759416665?text={{ urlencode('Saya butuh bantuan') }}"
    target="_blank"
    class="wa-bubble"
    title="Hubungi Admin via WhatsApp">
        <i class="fa-brands fa-whatsapp"></i>
    </a>
@endif
<style>
    .game-card {
        background-color: #fff;
        border-radius: 16px;
        overflow: hidden;
        text-align: center;
        transition: transform 0.2s ease;
    }
    .game-card:hover {
        transform: translateY(-5px);
    }
    .game-img {
        width: 100%;
        height: 150px;
        object-fit: cover;
        background-color: #f5f5f5;
    }
    .game-name {
        padding: 10px 8px;
        font-weight: 600;
        font-size: 14px;
        color: #333;
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
    .stat-card {
        background-color: #fff;
        border-radius: 16px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 16px;
    }
    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
    }
    .stat-value {
        font-size: 22px;
        font-weight: 700;
        color: #333;
    }
    .stat-label {
        font-size: 13px;
        color: #888;
    }
    .wa-bubble {
        position: fixed;
        bottom: 24px;
        right: 24px;
        width: 56px;
        height: 56px;
        background-color: #25D366;
        color: #fff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        box-shadow: 0 4px 12px rgba(37, 211, 102, 0.5);
        text-decoration: none;
        z-index: 9999;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .wa-bubble:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 18px rgba(37, 211, 102, 0.6);
        color: #fff;
    }
</style>
@endsection