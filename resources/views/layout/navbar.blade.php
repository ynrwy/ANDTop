@php
    $menus = [
        1 => [ // Admin
            (object)['title' => 'Dashboard', 'path' => 'dashboard', 'icon' => 'fas fa-tachometer-alt'],
            (object)['title' => 'Kelola Game', 'path' => 'admin/game', 'icon' => 'fas fa-gamepad'],
            (object)['title' => 'Kelola E-Wallet', 'path' => 'admin/ewallet', 'icon' => 'fas fa-wallet'],
            (object)['title' => 'Transaksi', 'path' => 'admin/transaksi', 'icon' => 'fas fa-receipt'],
            (object)['title' => 'Data User', 'path' => 'admin/user', 'icon' => 'fas fa-users'],
            (object)['title' => 'Profile', 'path' => 'profile', 'icon' => 'fas fa-user'],
        ],
        2 => [ // Customer
            (object)['title' => 'Beranda', 'path' => 'dashboard', 'icon' => 'fas fa-home'],
            (object)['title' => 'Aktivitas', 'path' => 'aktivitas', 'icon' => 'fas fa-list'],
            (object)['title' => 'Profile', 'path' => 'profile', 'icon' => 'fas fa-user'],
        ],
    ];
@endphp

<nav class="navbar navbar-expand-lg navbar-custom px-4 py-3 mb-4">
    <div class="container-fluid p-0">
        <a class="navbar-brand d-flex align-items-center gap-2 fw-bold text-dark fs-4" href="{{ route('dashboard') }}">
            <img src="{{ asset('storage/images/logo.png') }}" alt="AndTop" height="40" class="d-inline-block align-text-top">
            AndTop
        </a>

        <div class="ms-auto d-flex gap-2 align-items-center">
            @auth
                @foreach ($menus[auth()->user()->role_id] as $menu)
                    <a href="/{{ $menu->path }}" class="btn nav-btn-custom shadow-sm position-relative {{ Request::is($menu->path . '*') ? 'active' : '' }}">
                        <i class="{{ $menu->icon }} me-1"></i>{{ $menu->title }}
                        @if ($menu->path === 'profile' && auth()->user()->role_id == 2 && !auth()->user()->hasVerifiedEmail())
                            <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle">
                                <span class="visually-hidden">Email belum terverifikasi</span>
                            </span>
                        @endif
                    </a>
                @endforeach
            @endauth

            <a href="#" class="btn btn-logout shadow-sm ms-2" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt me-1"></i>Logout
            </a>
            <form id="logout-form" action="/logout" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </div>
</nav>