@extends('layout.auth')

@section('title', 'Login')
@section('inline_errors', '1')

@section('content')
    <img class="auth-logo" src="{{ asset('storage/images/logo.png') }}" alt="AndTop Logo"
        onerror="this.onerror=null; this.src='{{ asset('images/duck-fallback.svg') }}'">

    <h2 class="auth-title">Login</h2>

    <form action="/login" method="POST"
        onsubmit="const b = document.getElementById('submitBtn'); b.disabled = true; b.innerText = 'LOADING...';">
        @csrf
        <div class="form-group">
            <input type="email" class="form-input @error('email') is-invalid @enderror" name="email"
                placeholder="Alamat email" required value="{{ old('email') }}">
            @error('email')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group password-wrap">
            <input type="password" id="loginPassword" class="form-input" name="password" placeholder="Password" required>
            <button type="button" class="toggle-pw" onclick="
                const i = document.getElementById('loginPassword');
                const show = i.type === 'password';
                i.type = show ? 'text' : 'password';
                this.innerText = show ? 'Sembunyi' : 'Lihat';">Lihat</button>
        </div>

        <label class="remember">
            <input type="checkbox" name="remember" value="1"> Ingat saya
        </label>

        <button id="submitBtn" type="submit" class="btn-main">Login</button>
    </form>

    <div class="divider">atau</div>
    <a href="{{ route('google.redirect') }}" class="btn-google" style="display:flex; align-items:center; justify-content:center; gap:10px;">
        <svg width="18" height="18" viewBox="0 0 48 48"><path fill="#EA4335" d="M24 9.5c3.5 0 6.6 1.2 9.1 3.6l6.8-6.8C35.8 2.4 30.3 0 24 0 14.6 0 6.5 5.4 2.6 13.2l7.9 6.1C12.4 13.6 17.7 9.5 24 9.5z"/><path fill="#4285F4" d="M46.1 24.6c0-1.6-.1-3.1-.4-4.6H24v9h12.4c-.5 2.9-2.2 5.4-4.6 7l7.3 5.7c4.3-4 6.7-9.9 6.7-17.1z"/><path fill="#FBBC05" d="M10.5 28.7c-.5-1.4-.8-2.9-.8-4.7s.3-3.2.8-4.7l-7.9-6.1C.9 16.4 0 20.1 0 24s.9 7.6 2.6 10.8l7.9-6.1z"/><path fill="#34A853" d="M24 48c6.5 0 11.9-2.1 15.9-5.8l-7.3-5.7c-2 1.4-4.7 2.3-8.6 2.3-6.3 0-11.6-4.1-13.5-9.8l-7.9 6.1C6.5 42.6 14.6 48 24 48z"/></svg>
        Masuk dengan Google
    </a>

    <div class="auth-links">
        <a href="{{ route('password.request') }}" class="auth-link">Lupa password?</a>
        <a href="/register" class="auth-link">Belum punya akun? <strong>Daftar di sini</strong></a>
    </div>
    <a href="https://wa.me/6285759416665?text={{ urlencode('Saya butuh bantuan') }}"
    target="_blank"
    class="wa-bubble"
    title="Hubungi Admin via WhatsApp">
        <i class="fa-brands fa-whatsapp"></i>
    </a>
    <style>
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