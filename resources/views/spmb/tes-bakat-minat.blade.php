@extends('layouts.app')

@section('title', 'Tes Seleksi SPMB — '.config('app.name'))

@section('content')
@php
    $yearLabel = setting('ppdb_year', date('Y').'/'.(date('Y')+1));
    $schoolName = 'SMK NEGERI 8 PANDEGLANG';
@endphp

<section class="page-hero">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-2">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-50">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('spmb.index') }}" class="text-white-50">SPMB {{ $yearLabel }}</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Tes Seleksi</li>
            </ol>
        </nav>
        <h1 class="display-6 fw-bold">Tes Seleksi SPMB {{ $yearLabel }}</h1>
        <p class="mb-0 opacity-75">Pengumuman pelaksanaan tes seleksi penerimaan murid baru</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <article class="card border-0 shadow-sm p-4 p-md-5">
                    <div class="text-center mb-4 pb-3 border-bottom">
                        <p class="text-uppercase fw-bold text-primary mb-1 small letter-spacing-wide">Pengumuman</p>
                        <h2 class="h4 fw-bold mb-2">Tentang Pelaksanaan Tes Seleksi Penerimaan Murid Baru (SPMB)</h2>
                        <p class="fw-semibold mb-1">{{ $schoolName }}</p>
                        <p class="text-secondary mb-0">Tahun Ajaran {{ $yearLabel }}</p>
                    </div>

                    <p class="lead">Diberitahukan kepada seluruh Calon Murid Baru {{ $schoolName }} Tahun Ajaran {{ $yearLabel }} bahwa pelaksanaan Tes Seleksi SPMB akan dilaksanakan sesuai jadwal berikut:</p>

                    <div class="row g-4 my-4">
                        <div class="col-md-6">
                            <div class="tes-jadwal-card tes-jadwal-card--day1 rounded-3 p-4 h-100">
                                <span class="tes-jadwal-card__badge tes-jadwal-card__badge--day1">Hari Pertama</span>
                                <div class="d-flex align-items-center gap-2 mb-3 mt-1">
                                    <span class="tes-jadwal-card__icon tes-jadwal-card__icon--day1">
                                        <i class="bi bi-calendar-event"></i>
                                    </span>
                                    <span class="fw-semibold tes-jadwal-card__date">Selasa, 23 Juni 2026</span>
                                </div>
                                <p class="small tes-jadwal-card__label mb-2">Jurusan yang mengikuti tes:</p>
                                <ol class="mb-0 ps-3 tes-jadwal-card__list">
                                    <li>Akuntansi (AKL)</li>
                                    <li>Teknik Instalasi Tenaga Listrik (TITL)</li>
                                    <li>Desain Komunikasi Visual (DKV)</li>
                                </ol>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="tes-jadwal-card tes-jadwal-card--day2 rounded-3 p-4 h-100">
                                <span class="tes-jadwal-card__badge tes-jadwal-card__badge--day2">Hari Kedua</span>
                                <div class="d-flex align-items-center gap-2 mb-3 mt-1">
                                    <span class="tes-jadwal-card__icon tes-jadwal-card__icon--day2">
                                        <i class="bi bi-calendar-event"></i>
                                    </span>
                                    <span class="fw-semibold tes-jadwal-card__date">Rabu, 24 Juni 2026</span>
                                </div>
                                <p class="small tes-jadwal-card__label mb-2">Jurusan yang mengikuti tes:</p>
                                <ol class="mb-0 ps-3 tes-jadwal-card__list">
                                    <li>Rekayasa Perangkat Lunak (RPL)</li>
                                    <li>Teknik Sepeda Motor (TSM)</li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    <h3 class="h5 fw-bold mt-4 mb-3"><i class="bi bi-list-check text-primary me-2"></i>Ketentuan Peserta</h3>
                    <ol class="mb-4">
                        <li class="mb-2">Hadir paling lambat pukul <strong>07.30 WIB</strong>.</li>
                        <li class="mb-2">Tes dimulai pukul <strong>08.00 WIB</strong> sampai selesai.</li>
                        <li class="mb-2">Membawa bukti pendaftaran SPMB.</li>
                        <li class="mb-2">Membawa alat tulis pribadi.</li>
                        <li class="mb-2">Menggunakan seragam sekolah asal yang rapi dan sopan.</li>
                        <li class="mb-2">Mematuhi seluruh tata tertib yang berlaku selama pelaksanaan tes.</li>
                    </ol>

                    <div class="alert alert-warning mb-4">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Peserta yang tidak hadir sesuai jadwal yang telah ditentukan tanpa alasan yang dapat dipertanggungjawabkan dianggap <strong>mengundurkan diri</strong> dari proses seleksi SPMB {{ $schoolName }} Tahun Ajaran {{ $yearLabel }}.
                    </div>

                    <p class="mb-4">Demikian pengumuman ini disampaikan untuk menjadi perhatian dan dilaksanakan sebagaimana mestinya.</p>

                    <div class="text-end border-top pt-4">
                        <p class="mb-1">Pandeglang, Juni 2026</p>
                        <p class="fw-semibold mb-1">Panitia SPMB Tahun 2026</p>
                        <p class="fw-bold text-uppercase mb-1">{{ $schoolName }}</p>
                        <p class="text-secondary small mb-0">Jl. Raya Pandeglang – Pari Km. 14, Desa Cikoneng, Kecamatan Mandalawangi, Kabupaten Pandeglang</p>
                    </div>
                </article>

                <div class="d-flex flex-wrap gap-2 justify-content-center mt-4">
                    <a href="{{ route('spmb.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Kembali ke Info SPMB
                    </a>
                    <a href="{{ route('spmb.pengumuman-kelulusan') }}" class="btn btn-outline-primary">
                        <i class="bi bi-megaphone me-1"></i> Lihat Pengumuman SPMB
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
