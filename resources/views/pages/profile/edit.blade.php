@extends('layout.app')

@section('title', 'Ubah Profil')

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
    <div class="card main-card p-4 mb-4 shadow-sm" style="max-width: 500px; margin: 0 auto;">

        <div class="d-flex align-items-center mb-4">
            <a href="{{ route('profile.index') }}" class="btn btn-sm btn-light shadow-sm me-3" style="border-radius: 10px;">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <h5 class="fw-bold text-dark mb-0">Ubah Profil</h5>
        </div>

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="text-center mb-4">
                <img id="previewPhoto" src="{{ auth()->user()->photo_url }}" alt="Foto Profil"
                    style="height: 100px; width: 100px; object-fit: cover; border-radius: 50%; border: 3px solid #fff; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">

                <div class="mt-3">
                    <label for="photo" class="btn btn-sm btn-light shadow-sm" style="border-radius: 50px; cursor: pointer;">
                        <i class="fa-solid fa-camera me-1"></i> Ganti Foto
                    </label>
                    <input type="file" name="photo" id="photo" accept="image/png, image/jpeg, image/jpg" class="d-none">
                </div>
                @error('photo')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label class="form-label fw-semibold text-secondary">Email</label>
                <input type="email" class="form-input" value="{{ auth()->user()->email }}" disabled>
                <small class="text-muted">Email tidak dapat diubah.</small>
            </div>

            <div class="form-group mb-4">
                <label class="form-label fw-semibold text-secondary">Nama Lengkap</label>
                <input type="text" name="name" class="form-input @error('name') is-invalid @enderror"
                    value="{{ old('name', auth()->user()->name) }}" placeholder="Masukkan nama lengkap">
                @error('name')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn menu-tab w-100 shadow-sm">
                <i class="fa-solid fa-floppy-disk me-2"></i>Simpan Perubahan
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
    .form-input:disabled {
        background-color: #f0f0f0;
        color: #999;
        cursor: not-allowed;
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

<script>
    document.getElementById('photo').addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (event) {
                document.getElementById('previewPhoto').src = event.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection