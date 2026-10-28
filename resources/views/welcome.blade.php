@extends('layout.app')

@section('title', 'Dashboard Customer')

@section('content')
<div class="container py-3">
    <div class="card main-card p-4 mb-4 shadow-sm">
        
        <div class="mb-4">
            <h5 class="fw-medium text-secondary mb-1" style="font-size: 1.1rem;">Saldo Anda :</h5>
            <div class="d-flex align-items-center gap-2 fs-4 fw-bold text-dark">
                <img src="{{ asset('storage/images/coin.png') }}" alt="Coin" style="height: 70px; width: auto; object-fit: contain;"> 
                <span>0</span>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <button class="btn w-100 menu-tab shadow-sm">Topup Saldo</button>
            </div>
            <div class="col-md-4">
                <button class="btn w-100 menu-tab shadow-sm">Topup Game</button>
            </div>
            <div class="col-md-4">
                <button class="btn w-100 menu-tab shadow-sm">Topup E-Wallet</button>
            </div>
        </div>

        <div class="rate-box p-4 d-flex justify-content-between align-items-center shadow-inner">
            <div class="d-flex align-items-center gap-2">
                <img src="{{ asset('storage/images/indo.png') }}" alt="Indonesia Flag" style="height: 40px; width: auto; object-fit: contain;"> 
                <span>IDR Rp 1.000</span>
            </div>
            <div class="fw-bold fs-4">=</div>
            <div class="d-flex align-items-center gap-2">
                <img src="{{ asset('storage/images/coin.png') }}" alt="Coin" style="height: 40px; width: auto; object-fit: contain;">
                <span>1 Coin</span>
            </div>
        </div>

    </div>

    {{-- Bagian Banner bisa diaktifkan kembali jika promonya sudah ada --}}
    {{-- <div class="banner-container shadow-sm mb-4">
        <img src="{{ asset('storage/images/promo.jpeg') }}" alt="Popup Banner">
    </div> --}}
</div>
@endsection