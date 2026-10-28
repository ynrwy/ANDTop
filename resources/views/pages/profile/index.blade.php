@extends('layout.app')

@section('title', 'Profile')

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
            <h5 class="fw-bold text-dark mb-0">Profile</h5>
        </div>

        <div class="text-center mb-4">
            <img src="{{ asset('storage/' . (auth()->user()->photo ?: 'images/users/default.jpg')) }}" alt="Foto Profil"
                style="height: 100px; width: 100px; object-fit: cover; border-radius: 50%; border: 3px solid #fff; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            <h6 class="fw-bold mt-3 mb-0">{{ auth()->user()->name }}</h6>
            <p class="text-muted mb-1" style="font-size: 13px;">{{ auth()->user()->email }}</p>
                @if (auth()->user()->hasVerifiedEmail())
                    <span class="badge rounded-pill" style="background-color: #d1fae5; color: #059669; font-size: 12px;">
                        <i class="fa-solid fa-circle-check me-1"></i>Email terverifikasi
                    </span>
                @else
                    <span class="badge rounded-pill" style="background-color: #fee2e2; color: #dc2626; font-size: 12px;">
                        <i class="fa-solid fa-circle-exclamation me-1"></i>Email belum terverifikasi
                    </span>
                @endif
        </div>

        <div class="d-flex flex-column gap-2">
            @unless (auth()->user()->hasVerifiedEmail())
                <form action="{{ route('verification.send') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn menu-tab w-100 shadow-sm text-start">
                        <i class="fa-solid fa-envelope-circle-check me-2"></i>Verifikasi Email
                    </button>
                </form>
            @endunless
            <a href="{{ route('profile.edit') }}" class="btn menu-tab w-100 shadow-sm text-start">
                <i class="fa-solid fa-user-pen me-2"></i>Ubah Profil
            </a>
            <a href="{{ route('profile.change-password') }}" class="btn menu-tab w-100 shadow-sm text-start">
                <i class="fa-solid fa-key me-2"></i>Ubah Password
            </a>
        </div>

    </div>
</div>
@endsection