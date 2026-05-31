@extends('layouts.app')
@section('title', $teacher->name.' — Guru & TU')
@section('content')
<section class="page-hero"><div class="container">
    <nav aria-label="breadcrumb" class="mb-2">
        <ol class="breadcrumb mb-0 small">
            <li class="breadcrumb-item"><a href="{{ route('guru.index') }}" class="text-white-50">Guru &amp; TU</a></li>
            <li class="breadcrumb-item active text-white" aria-current="page">Profil</li>
        </ol>
    </nav>
    <h1 class="display-6 fw-bold mb-0">{{ $teacher->name }}</h1>
    <p class="mb-0 opacity-75">{{ $teacher->position }}</p>
</div></section>

<section class="py-5"><div class="container" style="max-width:900px">
    <div class="card border-0 shadow-sm overflow-hidden">
        <div class="row g-0">
            <div class="col-md-4 guru-photo-panel text-center p-4 d-flex flex-column align-items-center justify-content-center">
                <img src="{{ $teacher->photo_url }}" alt="{{ $teacher->name }}"
                     class="rounded-circle border border-3 border-white shadow-lg mb-3"
                     style="width:180px;height:180px;object-fit:cover" width="180" height="180" loading="eager">
                <span class="badge text-bg-primary">{{ $teacher->position }}</span>
                @if($teacher->field)
                <span class="badge text-bg-light text-secondary mt-2">{{ strtoupper($teacher->field) }}</span>
                @endif
            </div>
            <div class="col-md-8 p-4 p-md-5">
                <h2 class="h4 fw-bold text-primary mb-4">Informasi Utama</h2>
                <dl class="row mb-0 guru-profile">
                    <dt class="col-sm-4 text-secondary">Nama Lengkap</dt>
                    <dd class="col-sm-8 fw-semibold">{{ $teacher->name }}</dd>

                    @if($teacher->nip)
                    <dt class="col-sm-4 text-secondary">NIP / NUPTK</dt>
                    <dd class="col-sm-8">{{ $teacher->nip }}</dd>
                    @endif

                    <dt class="col-sm-4 text-secondary">Jabatan</dt>
                    <dd class="col-sm-8">{{ $teacher->position }}</dd>

                    @if($teacher->subject)
                    <dt class="col-sm-4 text-secondary">Mata Pelajaran</dt>
                    <dd class="col-sm-8">{{ $teacher->subject }}</dd>
                    @endif

                    @if($teacher->education)
                    <dt class="col-sm-4 text-secondary">Pendidikan Terakhir</dt>
                    <dd class="col-sm-8">{{ $teacher->education }}</dd>
                    @endif

                    @if($teacher->email)
                    <dt class="col-sm-4 text-secondary">Email Sekolah</dt>
                    <dd class="col-sm-8"><a href="mailto:{{ $teacher->email }}">{{ $teacher->email }}</a></dd>
                    @endif

                    <dt class="col-sm-4 text-secondary">Status Kepegawaian</dt>
                    <dd class="col-sm-8">{{ $teacher->employment_status_label }}</dd>
                </dl>

                @if($teacher->motto)
                <blockquote class="border-start border-4 border-primary ps-3 mt-4 mb-0 fst-italic text-secondary">
                    <i class="bi bi-quote text-primary me-1"></i>{{ $teacher->motto }}
                </blockquote>
                @endif

                @if($teacher->bio)
                <div class="mt-4 pt-4 border-top">
                    <h3 class="h6 fw-bold text-secondary mb-2">Tentang</h3>
                    <div class="text-secondary" style="white-space:pre-line">{{ $teacher->bio }}</div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('guru.index') }}" class="btn btn-outline-primary"><i class="bi bi-arrow-left me-1"></i> Kembali ke daftar</a>
    </div>
</div></section>
@endsection
