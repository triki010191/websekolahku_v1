@extends('layouts.app')

@section('title', 'Pengumuman Hasil Seleksi SPMB — '.config('app.name'))

@push('styles')
<style>
.spmb-result-table { font-size: .875rem; }
.spmb-result-table th { white-space: nowrap; vertical-align: middle; }
.spmb-result-table td { vertical-align: middle; }
</style>
@endpush

@section('content')
@php
    $yearLabel = setting('ppdb_year', '2026/2027');
    $schoolName = config('app.name', 'SMKN 8 Pandeglang');
@endphp

<section class="page-hero">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-2">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-50">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('spmb.index') }}" class="text-white-50">SPMB {{ $yearLabel }}</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Pengumuman Kelulusan</li>
            </ol>
        </nav>
        <h1 class="display-6 fw-bold">Pengumuman Kelulusan SPMB</h1>
        <p class="mb-0 opacity-75">Hasil seleksi penerimaan siswa baru tahun pelajaran {{ $yearLabel }}</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        @if(!$isPublished)
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm text-center p-5">
                    <div class="text-secondary mb-3">
                        <i class="bi bi-megaphone display-1"></i>
                    </div>
                    <h2 class="h4 fw-bold mb-3">Pengumuman Belum Tersedia</h2>
                    <p class="text-secondary mb-4">
                        Daftar hasil seleksi SPMB {{ $yearLabel }} belum dipublikasikan.
                        Silakan pantau halaman ini untuk pembaruan resmi dari panitia SPMB.
                    </p>
                    <a href="{{ route('spmb.index') }}" class="btn btn-primary">
                        <i class="bi bi-arrow-left me-1"></i> Kembali ke Info SPMB
                    </a>
                </div>
            </div>
        </div>
        @else
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <form method="get" action="{{ route('spmb.pengumuman-kelulusan') }}" class="row g-3 align-items-end">
                    <div class="col-lg-5">
                        <label for="q" class="form-label small fw-semibold">Cari Nama / NISN / No. Daftar / Sekolah</label>
                        <input type="search" id="q" name="q" class="form-control" value="{{ $filters['q'] }}" placeholder="Contoh: 00654321 atau Ahmad">
                    </div>
                    <div class="col-md-4 col-lg-3">
                        <label for="jurusan" class="form-label small fw-semibold">Filter Jurusan</label>
                        <select id="jurusan" name="jurusan" class="form-select">
                            <option value="">Semua Jurusan</option>
                            @foreach($acceptedMajors as $major)
                            <option value="{{ $major }}" @selected($filters['jurusan'] === $major)>{{ $major }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 col-lg-2">
                        <label for="jk" class="form-label small fw-semibold">Jenis Kelamin</label>
                        <select id="jk" name="jk" class="form-select">
                            <option value="">Semua</option>
                            <option value="L" @selected($filters['jk'] === 'L')>Laki-laki</option>
                            <option value="P" @selected($filters['jk'] === 'P')>Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-4 col-lg-2 d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search me-1"></i> Cari
                        </button>
                        @if(array_filter($filters))
                        <a href="{{ route('spmb.pengumuman-kelulusan') }}" class="btn btn-outline-secondary btn-sm">Reset Filter</a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <div class="card border-0 shadow-sm overflow-hidden">
            <div class="card-header bg-primary text-white text-center py-4">
                <h2 class="h5 fw-bold mb-1 text-uppercase">
                    Pengumuman Hasil Seleksi SPMB SMKN 8 Pandeglang<br>
                    Tahun Pelajaran {{ $yearLabel }}
                </h2>
                <p class="mb-0 small opacity-75">
                    Berikut daftar calon peserta didik yang dinyatakan <strong>DITERIMA</strong>
                    @if(array_filter($filters))
                    sesuai filter pencarian.
                    @endif
                </p>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover spmb-result-table mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-center" style="width:4rem">NO. URUT</th>
                                <th>NO. DAFTAR</th>
                                <th>NISN</th>
                                <th>NAMA LENGKAP</th>
                                <th class="text-center" style="width:3rem">JK</th>
                                <th>ASAL SEKOLAH</th>
                                <th>DITERIMA PADA JURUSAN</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($results as $index => $r)
                            <tr>
                                <td class="text-center">{{ $r->sort_order ?: ($index + 1) }}</td>
                                <td>{{ $r->registration_number ?? '—' }}</td>
                                <td>{{ $r->nisn }}</td>
                                <td class="fw-semibold">{{ $r->full_name }}</td>
                                <td class="text-center">{{ $r->gender }}</td>
                                <td>{{ $r->origin_school ?? '—' }}</td>
                                <td><span class="badge text-bg-success">{{ $r->accepted_major }}</span></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-secondary py-5">
                                    @if(array_filter($filters))
                                        Data tidak ditemukan. Coba gunakan kata kunci atau filter lain.
                                    @else
                                        Belum ada data siswa diterima.
                                    @endif
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($results->isNotEmpty())
            <div class="card-footer bg-light small text-secondary">
                Total tampil: <strong>{{ $results->count() }}</strong> siswa diterima.
                @if(array_filter($filters))
                    <span class="ms-1">(berdasarkan filter)</span>
                @endif
            </div>
            @endif
        </div>

        <div class="d-flex flex-wrap gap-2 justify-content-center mt-4">
            <a href="{{ route('spmb.index') }}" class="btn btn-outline-primary">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Info SPMB
            </a>
        </div>
        @endif
    </div>
</section>
@endsection
