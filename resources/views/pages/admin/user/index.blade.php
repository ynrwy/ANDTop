@extends('layout.app')

@section('title', 'Data User')

@section('content')
<div class="container py-3">

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-circle-xmark me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card main-card p-4 mb-4 shadow-sm">

        <div class="d-flex align-items-center mb-4">
            <h5 class="fw-bold text-dark mb-0">Data User</h5>
        </div>

        <div class="table-responsive">
            <table class="table-custom w-100">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Saldo</th>
                        <th>Status</th>
                        <th>Verifikasi</th>
                        <th>Bergabung</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $index => $user)
                        <tr>
                            <td>{{ ($users->currentPage() - 1) * $users->perPage() + $index + 1 }}</td>
                            <td>
                                <img src="{{ $user->photo_url }}" alt="{{ $user->name }}"
                                    style="height: 40px; width: 40px; object-fit: cover; border-radius: 50%;">
                            </td>
                            <td class="fw-semibold">{{ $user->name }}</td>
                            
                            <td class="text-muted">{{ $user->email }}</td>
                            <td>
                                <span class="badge-coin">
                                    <i class="fa-solid fa-coins me-1" style="color: #FFB703;"></i>
                                    {{ number_format($user->saldo, 0, ',', '.') }} Coin
                                </span>
                            </td>
                            <td>
                                @if($user->status === 'aktif')
                                    <span class="badge-status aktif">
                                        <i class="fa-solid fa-circle-check me-1"></i>Aktif
                                    </span>
                                @else
                                    <span class="badge-status nonaktif">
                                        <i class="fa-solid fa-circle-xmark me-1"></i>Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($user->hasVerifiedEmail())
                                    <span class="badge-status aktif" title="Diverifikasi pada {{ $user->email_verified_at->format('d M Y, H:i') }}">
                                        <i class="fa-solid fa-envelope-circle-check me-1"></i>Terverifikasi
                                    </span>
                                @else
                                    <span class="badge-status belum-verif">
                                        <i class="fa-solid fa-envelope me-1"></i>Belum
                                    </span>
                                @endif
                            </td>
                            <td class="text-muted" style="font-size: 13px;">{{ $user->created_at->format('d M Y') }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    {{-- Tombol Aktifkan / Nonaktifkan --}}
                                    <form action="{{ route('admin.user.toggleStatus', $user->id) }}" method="POST"
                                        class="js-confirm"
                                        data-pesan="{{ $user->status === 'aktif' ? 'Nonaktifkan akun ' . $user->name . '?' : 'Aktifkan kembali akun ' . $user->name . '?' }}">
                                        @csrf
                                        @method('PATCH')
                                        @if($user->status === 'aktif')
                                            <button type="submit" class="btn-aksi nonaktifkan"><i class="fa-solid fa-ban"></i></button>
                                        @else
                                            <button type="submit" class="btn-aksi aktifkan"><i class="fa-solid fa-circle-check"></i></button>
                                        @endif
                                    </form>

                                    {{-- Tombol Hapus (hanya muncul jika nonaktif) --}}
                                    @if($user->status === 'nonaktif')
                                        <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST"
                                            class="js-confirm"
                                            data-pesan="Hapus permanen akun {{ $user->name }}? Tindakan ini tidak dapat dibatalkan.">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-aksi hapus"><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">Belum ada user terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $users->links() }}
        </div>

    </div>
</div>

<style>
    .table-custom {
        border-collapse: separate;
        border-spacing: 0 8px;
    }
    .table-custom thead tr th {
        background-color: #FFB703;
        color: #fff;
        font-weight: 600;
        font-size: 13px;
        padding: 12px 16px;
    }
    .table-custom thead tr th:first-child { border-radius: 12px 0 0 12px; }
    .table-custom thead tr th:last-child  { border-radius: 0 12px 12px 0; }
    .table-custom tbody tr td {
        background-color: #fff;
        padding: 12px 16px;
        font-size: 14px;
        vertical-align: middle;
    }
    .table-custom tbody tr td:first-child { border-radius: 12px 0 0 12px; }
    .table-custom tbody tr td:last-child  { border-radius: 0 12px 12px 0; }

    /* Row redup jika nonaktif */
    .table-custom tbody tr:has(.badge-status.nonaktif) td {
        background-color: #f8f9fa;
        opacity: 0.8;
    }

    .badge-coin {
        background-color: #fff3cd;
        padding: 4px 10px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        color: #92660a;
    }
    .badge-status {
        padding: 4px 10px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
    }
    .badge-status.aktif {
        background-color: #d1fae5;
        color: #065f46;
    }
    .badge-status.nonaktif {
        background-color: #fee2e2;
        color: #991b1b;
    }
    .badge-status.belum-verif {
        background-color: #fff3cd;
        color: #92660a;
    }
    /* Tombol aksi */
    .btn-aksi {
        border: none;
        border-radius: 8px;
        padding: 6px 10px;
        font-size: 13px;
        cursor: pointer;
        transition: opacity 0.2s;
        min-width: 40px; 
        min-height: 40px;
    }
    .btn-aksi:hover { opacity: 0.8; }
    .btn-aksi.nonaktifkan { background-color: #fef3c7; color: #92400e; }
    .btn-aksi.aktifkan   { background-color: #d1fae5; color: #065f46; }
    .btn-aksi.hapus      { background-color: #fee2e2; color: #991b1b; }
</style>
<script>
    document.querySelectorAll('form.js-confirm').forEach(form => {
        form.addEventListener('submit', e => {
            e.preventDefault();
            Swal.fire({
                title: 'Konfirmasi',
                text: form.dataset.pesan,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, lanjutkan',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#ffcc29'
            }).then(r => { if (r.isConfirmed) form.submit(); });
        });
    });
</script>
@endsection