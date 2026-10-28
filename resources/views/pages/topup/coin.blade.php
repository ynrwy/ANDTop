@extends('layout.app')
@section('title', 'Topup Saldo')
@section('content')
<div class="container py-3">
    <div class="card main-card p-4 mb-4 shadow-sm" style="max-width: 500px; margin: 0 auto;">
        <div class="d-flex align-items-center mb-4">
            <a href="{{ route('dashboard') }}" class="btn btn-sm btn-light shadow-sm me-3" style="border-radius: 10px;">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <h5 class="fw-bold text-dark mb-0">Topup Saldo</h5>
        </div>
        <div class="text-center mb-4">
            <img src="{{ asset('storage/images/coin.png') }}" alt="Coin" style="height: 80px; width: auto; object-fit: contain;">
        </div>
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <form id="formTopup" action="{{ route('topup.store') }}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label for="coin" class="form-label fw-semibold text-secondary">Jumlah Coin</label>
                <input type="number" name="coin" id="coin"
                    class="form-input @error('coin') is-invalid @enderror"
                    placeholder="Masukkan jumlah coin, contoh: 10"
                    min="1" max="1000" step="1" value="{{ old('coin') }}">
                @error('coin')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="rate-box p-3 d-flex justify-content-between align-items-center shadow-inner mb-4">
                <div class="d-flex align-items-center gap-2">
                    <img src="{{ asset('storage/images/coin.png') }}" alt="Coin" style="height: 30px; width: auto; object-fit: contain;">
                    <span class="fw-semibold">1 Coin</span>
                </div>
                <div class="fw-bold fs-5">=</div>
                <div class="d-flex align-items-center gap-2">
                    <img src="{{ asset('storage/images/indo.png') }}" alt="Indonesia Flag" style="height: 30px; width: auto; object-fit: contain;">
                    <span class="fw-semibold">Rp 1.000</span>
                </div>
            </div>

            <button type="button" id="btnTopup" class="btn menu-tab w-100 shadow-sm">
                <i class="fa-solid fa-coins me-2"></i>Topup Sekarang
            </button>
        </form>
    </div>
</div>

<style>
    .form-input {
        width: 100%;
        padding: 14px 20px;
        border: none;
        border-radius: 12px;
        font-size: 14px;
        color: #555;
        outline: none;
        background-color: #ffffff;
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);
    }
    .form-input::placeholder {
        color: #aaa;
    }
    .form-input.is-invalid {
        box-shadow: inset 0 0 0 1px #dc3545;
    }
    .invalid-feedback {
        display: block;
        font-size: 12px;
        color: #dc3545;
        margin-top: 4px;
    }
    .rate-box {
        background-color: #eab308;
        border-radius: 12px;
    }
</style>

<script>
    document.getElementById('btnTopup').addEventListener('click', function () {
        const coin = document.getElementById('coin').value;

        if (!coin || coin < 1) {
            Swal.fire({
                title: "Perhatian",
                text: "Masukkan jumlah coin yang valid.",
                icon: "warning",
                confirmButtonColor: '#ffcc29'
            });
            return;
        }

        const total = (Number(coin) * 1000).toLocaleString('id-ID');

        Swal.fire({
            title: "Konfirmasi Topup",
            html: `Anda akan membeli <b>${Number(coin)} Coin</b> seharga <b>Rp ${total}</b>.<br>Lanjutkan?`,
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Ya, Lanjutkan",
            cancelButtonText: "Batal",
            confirmButtonColor: '#ffcc29'
        }).then((result) => {
            if (result.isConfirmed) {
                const btn = document.getElementById('btnTopup');
                btn.disabled = true;
                btn.innerHTML = 'MEMPROSES...';
                document.getElementById('formTopup').submit();
            }
        });
    });
</script>
@endsection