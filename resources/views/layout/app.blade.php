<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AndTop - @yield('title', 'Dashboard Customer')</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --duck-yellow: #FFB703;
            --duck-cream:  #ffe485;
            --duck-brown:  #5d4037;
            --duck-water:  #4fc3f7;
        }
        .btn:focus-visible, a:focus-visible, button:focus-visible {
            outline: 3px solid var(--duck-water);
            outline-offset: 2px;
        }
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #ffde59; /* Latar belakang kuning utama */
            color: #333333;

            /* FIX FOOTER DI BAWAH */
            display: flex;
            flex-direction: column;
            min-height: 100vh; /* Memaksa tinggi body minimal seukuran layar monitor */
            margin: 0;
        }
        
        /* Navbar Styling */
        .navbar-custom {
            background-color: #fef08a; /* Kuning soft */
            border-bottom: 2px solid #eab308; /* Garis pembatas bawah agar lebih tegas */
            border-radius: 0; /* Memastikan ujungnya benar-benar kotak */
        }
        .nav-btn-custom {
            background-color: #ffffff;
            color: #333333;
            border-radius: 50px;
            font-weight: 500;
            padding: 6px 20px;
            border: none;
        }
        .nav-btn-custom.active {
            background-color: #facc15;
            font-weight: 600;
        }
        .btn-logout {
            background-color: #ef4444;
            color: white;
            border-radius: 50px;
            padding: 6px 20px;
            font-weight: 500;
        }
        .btn-logout:hover {
            background-color: #dc2626;
            color: white;
        }

        /* Main Container Card */
        .main-card {
            background-color: #fef08a; /* Kuning pastel container */
            border-radius: 24px;
            border: none;
        }

        /* Topup Menu Tabs */
        .menu-tab {
            background-color: #fef9c3;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            color: #4b5563;
            transition: all 0.2s;
            padding: 15px 10px;
        }
        .menu-tab:hover {
            background-color: #fef08a;
            transform: scale(1.02);
        }

        /* Rate Info Box */
        .rate-box {
            background-color: #eab308; /* Kuning gelap tengah */
            border-radius: 16px;
            color: #1f2937;
            font-weight: 500;
        }

        /* Banner Container */
        .banner-container {
            border-radius: 24px;
            overflow: hidden;
            background-color: #ffffff;
        }
        .banner-container img {
            width: 100%;
            height: auto;
            display: block;
        }
        
        /* Footer Styling */
        footer {
            background-color: #fef08a;
            border-top: 2px solid #eab308;
            color: #4b5563;
            margin-top: auto; /* Memaksa footer tetap di paling bawah browser */
            width: 100%;
        }
        .pagination {
            gap: 6px;
            flex-wrap: wrap;
            justify-content: center;
        }
        nav[role="navigation"] > div {
            flex-direction: column;
            align-items: center;
            gap: 12px;
        }
        nav[role="navigation"] {
            justify-content: center !important;
        }
        .pagination .page-link {
            border: none;
            border-radius: 10px;
            color: #555;
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            font-weight: 600;
            font-size: 14px;
            line-height: 1.5;
            padding: 8px 14px;
        }
        .pagination .page-item.active .page-link {
            background-color: #FFB703;
            color: #fff;
        }
        .pagination .page-item.disabled .page-link {
            background-color: #f5f5f5;
            color: #ccc;
        }
        .pagination .page-link:hover {
            background-color: #fff3cd;
        }
    </style>
</head>
<body>  

    @include('layout.navbar')

    <main class="flex-grow-1">
        @auth
            @if (auth()->user()->role_id != 1 && !auth()->user()->hasVerifiedEmail() && !request()->routeIs('dashboard'))
                <div class="text-center py-2 px-3" style="background-color:#fff3cd; border-bottom:1px solid #FFB703; font-size:13px; color:#5d4037; font-weight:600;">
                    <i class="fa-solid fa-triangle-exclamation me-1"></i>
                    Email Anda belum terverifikasi.
                    <a href="{{ route('verification.notice') }}" style="color:#5d4037; text-decoration:underline;">Verifikasi sekarang</a>
                </div>
            @endif
        @endauth

        @yield('content')
    </main>

    @include('layout.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>