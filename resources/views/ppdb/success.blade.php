@extends('layouts.app')
@section('title', 'Pendaftaran SPMB berhasil')
@section('content')
<section class="py-5 text-center">
    <div class="container" style="max-width:600px">
        <div class="text-success display-1 mb-3"><i class="bi bi-check-circle"></i></div>
        <h1 class="h3 fw-bold">Pendaftaran Diterima</h1>
        <p class="text-secondary">Nomor pendaftaran:</p>
        <p class="fs-2 fw-mono fw-bold text-primary">{{ $reg->registration_number }}</p>
        <p class="small">Nama: {{ $reg->full_name }} — Jurusan: {{ $reg->major?->name }}</p>
        <a href="{{ route('ppdb.index') }}" class="btn btn-outline-primary">Kembali</a>
    </div>
</section>
@endsection
