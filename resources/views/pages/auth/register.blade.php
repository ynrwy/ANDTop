@extends('layout.auth')

@section('title', 'Register')
@section('inline_errors', '1')

@section('content')
    <img class="auth-logo" src="{{ asset('storage/images/logo.png') }}" alt="AndTop Logo"
        onerror="this.onerror=null; this.src='{{ asset('images/duck-fallback.svg') }}'">

    <h2 class="auth-title">Register</h2>

    <form action="/register" method="POST"
        onsubmit="const b = document.getElementById('submitBtn'); b.disabled = true; b.innerText = 'LOADING...';">
        @csrf

        <div class="form-group">
            <input type="text" class="form-input @error('name') is-invalid @enderror"
                name="name" placeholder="Nama lengkap" value="{{ old('name') }}">
            @error('name')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <input type="email" class="form-input @error('email') is-invalid @enderror"
                name="email" placeholder="Alamat email" value="{{ old('email') }}">
            @error('email')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <input type="password" class="form-input @error('password') is-invalid @enderror"
                name="password" placeholder="Password (min. 8 karakter)">
            @error('password')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <button id="submitBtn" type="submit" class="btn-main">Register</button>
    </form>

    <div class="auth-links">
        <a href="/" class="auth-link">Sudah punya akun? <strong>Login di sini</strong></a>
    </div>
@endsection