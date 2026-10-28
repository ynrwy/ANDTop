@extends('layout.app')

@section('title', 'Paket ' . $game->nama_game)

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

<div class="container py-3">
    <div class="card main-card p-4 mb-4 shadow-sm">

        <div class="d-flex align-items-center mb-4">
            <a href="{{ route('admin.game.index') }}" class="btn btn-sm btn-light shadow-sm me-3" style="border-radius: 10px;">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h5 class="fw-bold text-dark mb-0">Paket {{ $game->nama_game }}</h5>
                <small class="text-muted">Kelola paket harga untuk game ini</small>
            </div>
        </div>

        {{-- Tabel Paket --}}
        <div class="table-responsive mb-4">
            <table class="table-custom w-100">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Paket</th>
                        <th>Jumlah</th>
                        <th>Harga Coin</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($packages as $index => $package)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="fw-semibold">{{ $package->nama_paket }}</td>
                            <td>{{ number_format($package->jumlah, 0, ',', '.') }}</td>
                            <td><i class="fa-solid fa-coins me-1" style="color: #FFB703;"></i>{{ number_format($package->harga_coin, 0, ',', '.') }} Coin</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn-aksi btn-edit btn-edit-trigger"
                                        data-id="{{ $package->id_package }}"
                                        data-nama="{{ $package->nama_paket }}"
                                        data-jumlah="{{ $package->jumlah }}"
                                        data-harga="{{ $package->harga_coin }}">
                                        <i class="fa-solid fa-pen"></i> Edit
                                    </button>
                                    <form action="{{ route('admin.game.package.destroy', [$game->id_game, $package->id_package]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn-aksi btn-delete btn-delete-trigger" data-name="{{ $package->nama_paket }}">
                                            <i class="fa-solid fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Belum ada paket. Tambahkan paket di bawah.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <hr style="border-color: #eab308; opacity: 0.3;">

        {{-- Form Tambah / Edit Paket --}}
        <h6 class="fw-bold text-dark mb-3" id="formTitle"><i class="fa-solid fa-plus me-2" style="color: #FFB703;"></i>Tambah Paket</h6>

        <form id="packageForm" action="{{ route('admin.game.package.store', $game->id_game) }}" method="POST">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">

            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-secondary">Nama Paket</label>
                    <input type="text" name="nama_paket" id="nama_paket" class="form-input" placeholder="Contoh: 86 Diamond">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-secondary">Jumlah</label>
                    <input type="number" name="jumlah" id="jumlah" class="form-input" placeholder="Contoh: 86" min="1">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-secondary">Harga Coin</label>
                    <input type="number" name="harga_coin" id="harga_coin" class="form-input" placeholder="Contoh: 20" min="1">
                </div>
            </div>

            <div class="d-flex gap-2 mt-3">
                <button type="submit" id="btnSubmit" class="btn menu-tab shadow-sm px-4">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Simpan Paket
                </button>
                <button type="button" id="btnCancel" class="btn btn-light shadow-sm px-4 d-none" style="border-radius: 12px;">
                    <i class="fa-solid fa-xmark me-2"></i>Batal
                </button>
            </div>
        </form>

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
    .table-custom thead tr th:last-child { border-radius: 0 12px 12px 0; }
    .table-custom tbody tr td {
        background-color: #fff;
        padding: 12px 16px;
        font-size: 14px;
        vertical-align: middle;
    }
    .table-custom tbody tr td:first-child { border-radius: 12px 0 0 12px; }
    .table-custom tbody tr td:last-child { border-radius: 0 12px 12px 0; }
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
    .btn-edit { background-color: #fef08a; color: #92660a; }
    .btn-edit:hover { background-color: #facc15; color: #92660a; }
    .btn-delete { background-color: #fee2e2; color: #ef4444; }
    .btn-delete:hover { background-color: #fecaca; color: #ef4444; }
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
</style>

<script>
    // Edit paket — isi form dengan data existing
    document.querySelectorAll('.btn-edit-trigger').forEach(btn => {
        btn.addEventListener('click', function () {
            const id = this.dataset.id;
            const nama = this.dataset.nama;
            const jumlah = this.dataset.jumlah;
            const harga = this.dataset.harga;

            document.getElementById('nama_paket').value = nama;
            document.getElementById('jumlah').value = jumlah;
            document.getElementById('harga_coin').value = harga;
            document.getElementById('formTitle').innerHTML = '<i class="fa-solid fa-pen me-2" style="color: #FFB703;"></i>Edit Paket';
            document.getElementById('btnCancel').classList.remove('d-none');

            // Ubah action form ke route update
            const form = document.getElementById('packageForm');
            form.action = `/admin/game/{{ $game->id_game }}/package/${id}`;
            document.getElementById('formMethod').value = 'POST';

            // Scroll ke form
            form.scrollIntoView({ behavior: 'smooth' });
        });
    });

    // Batal edit
    document.getElementById('btnCancel').addEventListener('click', function () {
        document.getElementById('packageForm').reset();
        document.getElementById('packageForm').action = "{{ route('admin.game.package.store', $game->id_game) }}";
        document.getElementById('formMethod').value = 'POST';
        document.getElementById('formTitle').innerHTML = '<i class="fa-solid fa-plus me-2" style="color: #FFB703;"></i>Tambah Paket';
        this.classList.add('d-none');
    });

    // Hapus paket
    document.querySelectorAll('.btn-delete-trigger').forEach(btn => {
        btn.addEventListener('click', function () {
            const name = this.dataset.name;
            const form = this.closest('form');

            Swal.fire({
                title: "Hapus Paket?",
                html: `Apakah Anda yakin ingin menghapus paket <b>${name}</b>?`,
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