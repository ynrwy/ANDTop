@extends('layout.app')

@section('title', $ewallet->nama_ewallet)

@section('content')
<div class="container py-3">
    <div class="card main-card p-4 mb-4 shadow-sm" style="max-width: 600px; margin: 0 auto;">

        <div class="d-flex align-items-center mb-4">
            <a href="{{ route('topup.ewallet') }}" class="btn btn-sm btn-light shadow-sm me-3" style="border-radius: 10px;">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <h5 class="fw-bold text-dark mb-0">{{ $ewallet->nama_ewallet }}</h5>
        </div>

        <div class="text-center mb-3" style="background-color: #fff; border-radius: 12px; padding: 10px;">
            <img src="{{ asset('storage/' . $ewallet->photo) }}" alt="{{ $ewallet->nama_ewallet }}"
                style="width: 100%; max-height: 250px; object-fit: contain; border-radius: 12px;">
        </div>

        <p class="text-secondary mb-4" style="font-size: 14px;">{{ $ewallet->deskripsi }}</p>

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form id="formTopup" action="{{ route('topup.ewallet.process') }}" method="POST" >
            @csrf
            <input type="hidden" name="id_ewallet" value="{{ $ewallet->id_ewallet }}">

            <div class="form-group mb-3">
                <label class="form-label fw-semibold text-secondary">Nomor HP / Akun {{ $ewallet->nama_ewallet }}</label>
                <input type="text" name="target_id" id="target_id" class="form-input @error('target_id') is-invalid @enderror"
                    placeholder="Masukkan nomor HP Anda" value="{{ old('target_id') }}">
                @error('target_id')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <label class="form-label fw-semibold text-secondary mb-2">Pilih Nominal</label>
            <div class="row g-2 mb-4">
                @foreach ($packages as $package)
                    <div class="col-6 col-md-4">
                        <label class="package-card w-100 shadow-sm">
                            <input type="radio" name="id_package" value="{{ $package->id_package }}" {{ $loop->first ? 'checked' : '' }}>
                            <div class="fw-semibold mb-1">{{ $package->nama_paket }}</div>
                            <div class="text-muted" style="font-size: 12px;">
                                <i class="fa-solid fa-coins"></i> {{ number_format($package->harga_coin, 0, ',', '.') }} Coin
                            </div>
                        </label>
                    </div>
                @endforeach
            </div>

            <button type="button" id="btnTopup" class="btn menu-tab w-100 shadow-sm">
                <i class="fa-solid fa-bolt me-2"></i>Topup Sekarang
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
    .form-input.is-invalid {
        box-shadow: inset 0 0 0 1px #dc3545;
    }
    .invalid-feedback {
        display: block;
        font-size: 12px;
        color: #dc3545;
        margin-top: 4px;
    }
    .package-card {
        display: block;
        background-color: #fff;
        border-radius: 12px;
        padding: 10px 12px;
        cursor: pointer;
        border: 2px solid transparent;
        transition: border-color 0.2s ease;
    }
    .package-card input[type="radio"] {
        display: none;
    }
    .package-card:has(input:checked) {
        border-color: #FFB703;
        background-color: #fff8e1;
    }
</style>

<script>
    document.getElementById('btnTopup').addEventListener('click', function () {
        const targetId = document.getElementById('target_id').value;
        const selectedPackage = document.querySelector('input[name="id_package"]:checked');

        if (!targetId) {
            Swal.fire({
                title: "Perhatian",
                text: "Nomor HP / akun e-wallet wajib diisi.",
                icon: "warning",
                confirmButtonColor: '#ffcc29'
            });
            return;
        }

        if (!selectedPackage) {
            Swal.fire({
                title: "Perhatian",
                text: "Pilih nominal terlebih dahulu.",
                icon: "warning",
                confirmButtonColor: '#ffcc29'
            });
            return;
        }

        const namaPaket = selectedPackage.closest('.package-card').querySelector('.fw-semibold').innerText;
        const hargaCoin = selectedPackage.closest('.package-card').querySelector('.text-muted').innerText;
        const aman = targetId.replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));

        Swal.fire({
            title: "Konfirmasi Topup",
            html: `
                <div class="text-start">
                    <b>E-Wallet:</b> {{ $ewallet->nama_ewallet }}<br>
                    <b>Nomor Tujuan:</b> ${aman}<br>
                    <b>Nominal:</b> ${namaPaket}<br>
                    <b>Harga:</b> ${hargaCoin}
                </div>
            `,
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Ya, Topup",
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