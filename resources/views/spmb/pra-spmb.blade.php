@extends('layouts.app')

@section('title', 'Pra SPMB Banten 2026 — '.config('app.name'))

@section('content')
@php
    $yearLabel = setting('ppdb_year', date('Y').'/'.(date('Y')+1));
    $bUrl = setting('spmb_banten_url', 'https://spmb.bantenprov.go.id/');
    if (is_string($bUrl) && $bUrl !== '' && str_contains(strtolower($bUrl), 'ppdb.bantenprov')) {
        $bUrl = 'https://spmb.bantenprov.go.id/';
    }
@endphp

<section class="page-hero">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-2">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-50">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('spmb.index') }}" class="text-white-50">SPMB {{ $yearLabel }}</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Pra SPMB</li>
            </ol>
        </nav>
        <h1 class="display-6 fw-bold">Pra SPMB Banten 2026</h1>
        <p class="mb-0 opacity-75">Tahap pra-pendaftaran wajib untuk SMA &amp; SMK Negeri di Provinsi Banten</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <article class="card border-0 shadow-sm p-4 p-md-5">
                    <p class="lead">Pra SPMB Banten 2026 adalah tahap pra-pendaftaran yang <strong>wajib</strong> dilakukan oleh calon siswa yang akan mendaftar ke SMA Negeri dan SMK Negeri di Provinsi Banten tahun ajaran 2026/2027. Tahap ini merupakan kebijakan baru dari Dinas Pendidikan dan Kebudayaan Provinsi Banten.</p>

                    <h2 class="h5 fw-bold mt-4 mb-3">Tujuan Pra SPMB</h2>
                    <ul>
                        <li>Validasi dan verifikasi data calon siswa.</li>
                        <li>Sinkronisasi data sebelum pendaftaran utama dibuka.</li>
                        <li>Mengurangi kesalahan data dan kendala teknis saat seleksi berlangsung.</li>
                    </ul>

                    <h2 class="h5 fw-bold mt-4 mb-3">Pada tahap ini calon siswa harus</h2>
                    <ul>
                        <li>Membuat akun.</li>
                        <li>Mengisi biodata.</li>
                        <li>Mengunggah dokumen pendukung (KK, rapor, dan dokumen lain sesuai jalur yang akan dipilih).</li>
                        <li>Menentukan titik koordinat alamat rumah sesuai domisili.</li>
                    </ul>

                    <h2 class="h5 fw-bold mt-4 mb-3"><i class="bi bi-calendar-event text-primary me-2"></i>Jadwal Pra SPMB Banten 2026</h2>
                    <div class="row g-3 mb-4">
                        <div class="col-sm-6">
                            <div class="border rounded-3 p-3 h-100 bg-body-tertiary">
                                <div class="text-primary small fw-semibold text-uppercase">Dibuka</div>
                                <div class="fs-5 fw-bold">20 April 2026</div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="border rounded-3 p-3 h-100 bg-body-tertiary">
                                <div class="text-danger small fw-semibold text-uppercase">Ditutup</div>
                                <div class="fs-5 fw-bold">31 Mei 2026</div>
                            </div>
                        </div>
                    </div>

                    <h2 class="h5 fw-bold mt-4 mb-3"><i class="bi bi-exclamation-triangle text-warning me-2"></i>Yang perlu diperhatikan</h2>
                    <ul>
                        <li>Jika calon siswa <strong>tidak mengikuti Pra SPMB</strong>, maka tidak akan mendapatkan PIN/nomor peserta untuk mengikuti pendaftaran SPMB utama.</li>
                        <li>Tahap ini berlaku untuk <strong>SMA dan SMK Negeri</strong>, sedangkan SKh (Sekolah Khusus) tidak melalui Pra SPMB.</li>
                    </ul>

                    <div class="alert alert-info d-flex flex-wrap align-items-center gap-3 mt-4 mb-0">
                        <div class="flex-grow-1">
                            <strong>Portal resmi yang digunakan:</strong> SPMB Banten
                        </div>
                        @include('partials.spmb-banten-button', ['variant' => 'sm'])
                    </div>
                </article>

                <div class="text-center mt-4">
                    <a href="{{ route('spmb.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Kembali ke Info SPMB
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
