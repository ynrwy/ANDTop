@extends('layout.app')

@section('title', 'Topup Game')

@section('content')
<div class="container py-3">
    <div class="card main-card p-4 mb-4 shadow-sm">

        <div class="d-flex align-items-center mb-4">
            <a href="{{ route('dashboard') }}" class="btn btn-sm btn-light shadow-sm me-3" style="border-radius: 10px;">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <h5 class="fw-bold text-dark mb-0">Topup Game</h5>
        </div>

        <div class="row g-3">
            @forelse ($games as $game)
                <div class="col-md-4 col-6">
                    <a href="{{ route('topup.game.detail', $game->id_game) }}" class="text-decoration-none">
                        <div class="game-card shadow-sm">
                            <img src="{{ asset('storage/' . $game->photo) }}"
                                alt="{{ $game->nama_game }}" class="game-img">
                            <div class="game-name">{{ $game->nama_game }}</div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12 text-center text-muted py-4">
                    Belum ada game yang tersedia.
                </div>
            @endforelse
        </div>

    </div>
</div>

<style>
    .game-card {
        background-color: #fff;
        border-radius: 16px;
        overflow: hidden;
        text-align: center;
        transition: transform 0.2s ease;
    }
    .game-card:hover {
        transform: translateY(-5px);
    }
    .game-img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        
    }
    .game-name {
        padding: 10px 8px;
        font-weight: 600;
        font-size: 14px;
        color: #333;
    }
</style>
@endsection