@extends('layout.auth')

@section('title', 'Lupa Password')

@section('content')
    <h2 class="auth-title">Lupa Password</h2>
    <p class="auth-text">Masukkan email akun Anda. Kami akan mengirim link untuk membuat password baru.</p>

    <form action="{{ route('password.email') }}" method="POST">
        @csrf
        <div class="form-group">
            <input type="email" name="email" class="form-input" placeholder="Alamat email" value="{{ old('email') }}" required>
        </div>
        <button type="submit" class="btn-main">Kirim Link Reset</button>
    </form>

    <div class="auth-links">
        <a href="/" class="auth-link">Kembali ke Login</a>
    </div>
@endsection