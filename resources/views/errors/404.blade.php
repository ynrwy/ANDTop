@extends('layout.auth')

@section('title', 'Halaman Tidak Ditemukan')

@section('content')
    <div style="font-size: 72px; line-height: 1;">🦆</div>
    <h2 class="auth-title" style="margin-top: 12px;">Entok-nya Nyasar</h2>
    <p class="auth-text">Maaf, halaman yang Anda cari tidak ada atau sudah pindah kolam.</p>
    <a href="{{ url('/') }}" class="btn-main">Balik ke Beranda</a>
@endsection