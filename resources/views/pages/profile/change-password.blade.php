@extends('layout.app')

@section('title', 'Ubah Password')

@section('content')
<div class="container py-3">
    <div class="card main-card p-4 mb-4 shadow-sm" style="max-width: 500px; margin: 0 auto;">

        <div class="d-flex align-items-center mb-4">
            <a href="{{ route('profile.index') }}" class="btn btn-sm btn-light shadow-sm me-3" style="border-radius: 10px;">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <h5 class="fw-bold text-dark mb-0">
                {{ auth()->user()->password !== null ? 'Ubah Password' : 'Buat Password' }}
            </h5>       
        </div>

        @if ($errors->any())
            <script>
                Swal.fire({
                    title: "Terjadi Kesalahan",
                    text: "@foreach($errors->all() as $error){{ $error }}{{ $loop->last ? '.' : ', ' }}@endforeach",
                    icon: "error",
                    confirmButtonColor: '#ffcc29'
                });
            </script>
        @endif

        <form action="{{ route('profile.update-password') }}" method="POST">
            @csrf

            @if (auth()->user()->password !== null)
                <div class="form-group mb-3">
                    <label class="form-label fw-semibold text-secondary">Password Lama</label>
                    <input type="password" name="current_password" class="form-input @error('current_password') is-invalid @enderror"
                        placeholder="Masukkan password lama" required>
                    @error('current_password')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            @else
                <div class="alert alert-info" style="font-size: 13px; border-radius: 12px;">
                    Anda masuk dengan Google dan belum punya password. Buat password di bawah agar Anda juga bisa login dengan email dan password.
                </div>
            @endif

            <div class="form-group mb-3">
                <label class="form-label fw-semibold text-secondary">Password Baru</label>
                <input type="password" name="password" class="form-input @error('password') is-invalid @enderror"
                    placeholder="Masukkan password baru">
                @error('password')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label class="form-label fw-semibold text-secondary">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" class="form-input"
                    placeholder="Ulangi password baru">
            </div>

            <button type="submit" class="btn menu-tab w-100 shadow-sm">
                <i class="fa-solid fa-key me-2"></i>{{ auth()->user()->password !== null ? 'Simpan Password' : 'Buat Password' }}
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
</style>
@endsection