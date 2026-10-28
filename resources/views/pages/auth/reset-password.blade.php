@extends('layout.auth')

@section('title', 'Password Baru')

@section('content')
    <h2 class="auth-title">Password Baru</h2>

    <form action="{{ route('password.update') }}" method="POST">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="form-group">
            <input type="email" name="email" class="form-input" value="{{ old('email', $email) }}" readonly>
        </div>
        <div class="form-group">
            <input type="password" name="password" class="form-input" placeholder="Password baru (min. 8 karakter)" required>
        </div>
        <div class="form-group">
            <input type="password" name="password_confirmation" class="form-input" placeholder="Ulangi password baru" required>
        </div>

        <button type="submit" class="btn-main">Simpan Password</button>
    </form>
@endsection