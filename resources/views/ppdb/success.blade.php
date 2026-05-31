@extends('layouts.app')
@section('title', 'Formulir Dapodik berhasil dikirim')
@section('content')
<section class="py-5 text-center">
    <div class="container" style="max-width:640px">
        <div class="text-success display-1 mb-3"><i class="bi bi-check-circle"></i></div>
        <h1 class="h3 fw-bold">Formulir Daftar Ulang Berhasil Dikirim</h1>
        <p class="text-secondary">Terima kasih, data Dapodik Anda telah kami terima.</p>

        <div class="card border-0 shadow-sm text-start p-4 my-4">
            <div class="row g-2 small">
                <div class="col-sm-6"><span class="text-secondary">No. Daftar Ulang</span><div class="fw-bold fs-5 text-primary">{{ $reg->registration_number }}</div></div>
                <div class="col-sm-6"><span class="text-secondary">No. SPMB Banten</span><div class="fw-bold">{{ $reg->spmb_banten_number }}</div></div>
                <div class="col-sm-6"><span class="text-secondary">Nama</span><div class="fw-semibold">{{ $reg->full_name }}</div></div>
                <div class="col-sm-6"><span class="text-secondary">Jurusan</span><div class="fw-semibold">{{ $reg->major?->name }}</div></div>
            </div>
        </div>

        <div class="d-flex flex-wrap justify-content-center gap-2">
            <a href="{{ route('ppdb.pdf', $reg->registration_number) }}" class="btn btn-primary"><i class="bi bi-file-earmark-pdf"></i> Cetak Bukti PDF</a>
            <a href="{{ route('spmb.index') }}" class="btn btn-outline-primary">Info SPMB</a>
            <a href="{{ route('home') }}" class="btn btn-outline-secondary">Beranda</a>
        </div>
    </div>
</section>
@endsection
