<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AndTop - @yield('title')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700,800" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
    @if ($errors->any() && !View::hasSection('inline_errors'))
        <script>
            Swal.fire({ title: "Punten, ada yang perlu diperbaiki", text: @json($errors->first()), icon: "error", confirmButtonColor: '#ffcc29' });
        </script>
    @endif

    @if (session('success'))
        <script>
            Swal.fire({ title: "Berhasil!", text: @json(session('success')), icon: "success", confirmButtonColor: '#ffcc29' });
        </script>
    @endif

    @if (session('suspended'))
        <script>
            Swal.fire({ icon: 'error', title: 'Akun Dinonaktifkan', text: 'Akun Anda telah disuspend/dinonaktifkan. Silakan hubungi admin untuk informasi lebih lanjut.', confirmButtonColor: '#FFB703' });
        </script>
    @endif

    <div class="auth-card">
        @yield('content')
    </div>

    @stack('scripts')
</body>
</html>