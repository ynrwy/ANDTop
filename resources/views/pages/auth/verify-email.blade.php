@extends('layout.auth')

@section('title', 'Verifikasi Email')

@section('content')
    <h2 class="auth-title">Verifikasi Email</h2>
    <p class="auth-text">Kami sudah mengirim link verifikasi ke <b>{{ auth()->user()->email }}</b>. Klik link tersebut untuk mengaktifkan fitur topup.</p>

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="btn-main">Kirim Ulang Email</button>
    </form>

    @unless (session('baru_daftar'))
        <a href="{{ route('dashboard') }}" class="btn-back">Ke Beranda</a>
    @endunless

    <form method="POST" action="/logout">
        @csrf
        <button type="submit" class="btn-outline">Keluar</button>
    </form>

    <p class="auth-hint">Halaman ini otomatis berpindah setelah email Anda terverifikasi.</p>
@endsection

@push('scripts')
<script>
    setInterval(async () => {
        try {
            const res = await fetch('{{ route('verification.status') }}', { headers: { 'Accept': 'application/json' } });
            const data = await res.json();
            if (data.verified) window.location.href = '{{ route('dashboard') }}';
        } catch (e) {}
    }, 5000);
</script>
@endpush