@extends('layouts.app')

@section('title', 'Daftar Ulang SPMB — '.config('app.name'))

@section('content')
@php
    $yearLabel = setting('ppdb_year', date('Y').'/'.(date('Y')+1));
@endphp

<section class="page-hero">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-2">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-50">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('spmb.index') }}" class="text-white-50">SPMB {{ $yearLabel }}</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Daftar Ulang</li>
            </ol>
        </nav>
        <h1 class="display-6 fw-bold">Daftar Ulang SPMB {{ $yearLabel }}</h1>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm text-center p-5">
                    <div class="text-secondary mb-3">
                        <i class="bi bi-info-circle display-1"></i>
                    </div>
                    <h2 class="h4 fw-bold mb-3">Informasi Belum Tersedia</h2>
                    <p class="text-secondary mb-4">Informasi daftar ulang SPMB {{ $yearLabel }} belum diumumkan. Silakan pantau halaman ini atau bagian <strong>Pengumuman SPMB</strong> untuk pembaruan resmi dari panitia.</p>
                    <div class="d-flex flex-wrap gap-2 justify-content-center">
                        <a href="{{ route('spmb.index') }}" class="btn btn-primary">
                            <i class="bi bi-arrow-left me-1"></i> Kembali ke Info SPMB
                        </a>
                        <a href="{{ route('spmb.index') }}#pengumuman-spmb" class="btn btn-outline-primary">
                            <i class="bi bi-megaphone me-1"></i> Lihat Pengumuman SPMB
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
