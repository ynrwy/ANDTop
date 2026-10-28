@extends('layout.app')

@section('title', 'Tambah E-Wallet')

@section('content')
<div class="container py-3">
    <div class="card main-card p-4 mb-4 shadow-sm" style="max-width: 500px; margin: 0 auto;">

        <div class="d-flex align-items-center mb-4">
            <a href="{{ route('admin.ewallet.index') }}" class="btn btn-sm btn-light shadow-sm me-3" style="border-radius: 10px;">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <h5 class="fw-bold text-dark mb-0">Tambah E-Wallet</h5>
        </div>

        <form action="{{ route('admin.ewallet.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group mb-3">
                <label class="form-label fw-semibold text-secondary">Nama E-Wallet</label>
                <input type="text" name="nama_ewallet" class="form-input @error('nama_ewallet') is-invalid @enderror"
                    placeholder="Contoh: DANA" value="{{ old('nama_ewallet') }}">
                @error('nama_ewallet')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label class="form-label fw-semibold text-secondary">Deskripsi</label>
                <textarea name="deskripsi" rows="3" class="form-input">{{ old('deskripsi') }}</textarea>
            </div>

            <div class="form-group mb-4">
                <label class="form-label fw-semibold text-secondary">Photo E-Wallet</label>
                <input type="file" name="photo" accept="image/png, image/jpeg, image/jpg" class="form-input @error('photo') is-invalid @enderror">
                @error('photo')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
                <small class="text-muted">Kosongkan jika ingin pakai foto default.</small>
            </div>

            <button type="submit" class="btn menu-tab w-100 shadow-sm">
                <i class="fa-solid fa-floppy-disk me-2"></i>Simpan E-Wallet
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
