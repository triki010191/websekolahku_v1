@extends('layouts.app')
@section('title', $major->name.' — '.config('app.name'))
@section('content')
<section class="page-hero"><div class="container">
    <nav aria-label="breadcrumb" class="mb-2"><ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('jurusan.index') }}" class="text-white-50">Jurusan</a></li>
        <li class="breadcrumb-item active text-white">{{ $major->code }}</li>
    </ol></nav>
    <span class="badge bg-warning text-dark">{{ $major->code }}</span>
    <h1 class="display-6 fw-bold mt-2">{{ $major->name }}</h1>
    <p class="lead opacity-90 mb-0">{{ $major->tagline }}</p>
</div></section>
<section class="py-5"><div class="container">
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5>Deskripsi</h5>
                    <p class="text-secondary">{!! nl2br(e($major->description)) !!}</p>
                    @if($major->curriculum)
                    <h5 class="mt-4">Kurikulum</h5>
                    <div class="text-secondary small">{!! $major->curriculum !!}</div>
                    @endif
                    @if($major->career_prospects)
                    <h5 class="mt-4">Prospek Karir</h5>
                    <div class="text-secondary">{!! nl2br(e($major->career_prospects)) !!}</div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="text-uppercase text-muted small">Kaprog</h6>
                    <p class="fw-bold mb-3">{{ $major->head_teacher ?? '—' }}</p>
                    <h6 class="text-uppercase text-muted small">Siswa / Kuota</h6>
                    <p class="mb-0">{{ $major->student_count }} siswa · Kuota {{ $major->quota ?? '—' }}</p>
                </div>
            </div>
        </div>
    </div>
</div></section>
@endsection
