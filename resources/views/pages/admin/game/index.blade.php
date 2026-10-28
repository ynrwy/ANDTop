@extends('layout.app')

@section('title', 'Kelola Game')

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
    <div class="card main-card p-4 mb-4 shadow-sm">

        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="d-flex align-items-center">
                <h5 class="fw-bold text-dark mb-0">Kelola Game</h5>
            </div>
            <a href="{{ route('admin.game.create') }}" class="btn menu-tab shadow-sm">
                <i class="fa-solid fa-plus me-2"></i>Tambah Game
            </a>
        </div>

        <div class="table-responsive">
            <table class="table-custom w-100">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Photo</th>
                        <th>Icon</th>
                        <th>Nama Game</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($games as $index => $game)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <img src="{{ asset('storage/' . $game->photo) }}" alt="{{ $game->nama_game }}"
                                    style="height: 50px; width: 70px; object-fit: contain; border-radius: 8px; background-color: #f5f5f5;">
                            </td>
                            <td>
                                <img src="{{ asset('storage/' . $game->icon) }}" alt="icon"
                                    style="height: 35px; width: 35px; object-fit: contain;">
                            </td>
                            <td class="fw-semibold">{{ $game->nama_game }}</td>
                            <td class="text-muted" style="font-size: 13px; max-width: 200px;">{{ Str::limit($game->deskripsi, 60) }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.game.edit', $game->id_game) }}" class="btn-aksi btn-edit">
                                        <i class="fa-solid fa-pen"></i> Edit
                                    </a>
                                    <a href="{{ route('admin.game.package', $game->id_game) }}" class="btn-aksi btn-package">
                                        <i class="fa-solid fa-box"></i> Paket
                                    </a>
                                    <form action="{{ route('admin.game.destroy', $game->id_game) }}" method="POST" class="form-delete">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn-aksi btn-delete btn-delete-trigger" data-name="{{ $game->nama_game }}">
                                            <i class="fa-solid fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Belum ada game.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
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
    .table-custom thead tr th:first-child {
        border-radius: 12px 0 0 12px;
    }
    .table-custom thead tr th:last-child {
        border-radius: 0 12px 12px 0;
    }
    .table-custom tbody tr td {
        background-color: #fff;
        padding: 12px 16px;
        font-size: 14px;
        vertical-align: middle;
    }
    .table-custom tbody tr td:first-child {
        border-radius: 12px 0 0 12px;
    }
    .table-custom tbody tr td:last-child {
        border-radius: 0 12px 12px 0;
    }
    .btn-aksi {
        padding: 6px 14px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
    }
    .btn-edit {
        background-color: #fef08a;
        color: #92660a;
    }
    .btn-edit:hover {
        background-color: #facc15;
        color: #92660a;
    }
    .btn-delete {
        background-color: #fee2e2;
        color: #ef4444;
    }
    .btn-delete:hover {
        background-color: #fecaca;
        color: #ef4444;
    }
    .btn-package {
    background-color: #dbeafe;
    color: #3b82f6;
    }
    .btn-package:hover {
        background-color: #bfdbfe;
        color: #3b82f6;
    }
</style>

<script>
    document.querySelectorAll('.btn-delete-trigger').forEach(btn => {
        btn.addEventListener('click', function () {
            const name = this.dataset.name;
            const form = this.closest('form');

            Swal.fire({
                title: "Hapus Game?",
                text: `Apakah Anda yakin ingin menghapus ${name}?`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Ya, Hapus",
                cancelButtonText: "Batal",
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#FFB703'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endsection