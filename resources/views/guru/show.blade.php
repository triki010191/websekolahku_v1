@extends('layouts.app')
@section('title', $teacher->name.' — Guru & TU')
@section('content')
<section class="page-hero"><div class="container">
    <nav aria-label="breadcrumb" class="mb-0">
        <ol class="breadcrumb mb-0 small">
            <li class="breadcrumb-item"><a href="{{ route('guru.index') }}" class="text-white-50">Guru &amp; TU</a></li>
            <li class="breadcrumb-item active text-white" aria-current="page">Profil</li>
        </ol>
    </nav>
</div></section>

<section class="py-5"><div class="container" style="max-width:960px">
    <div class="card border-0 shadow-sm overflow-hidden guru-profile-card">
        <div class="row g-0">
            <div class="col-md-4 guru-profile-photo-col">
                <div class="guru-profile-photo-wrap">
                    <img src="{{ $teacher->photo_url }}" alt="{{ $teacher->name }}"
                         class="guru-profile-photo-wrap__img" loading="eager">
                    <div class="guru-profile-photo-wrap__overlay"></div>
                    <div class="guru-profile-photo-wrap__caption">
                        <p class="guru-profile-photo-wrap__name mb-0">{{ $teacher->name }}</p>
                        <p class="guru-profile-photo-wrap__role mb-1">{{ $teacher->position }}</p>
                        @if($teacher->field)
                        <span class="badge guru-profile-photo-wrap__field">{{ strtoupper($teacher->field) }}</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-8 p-4 p-md-5">
                <h2 class="h4 fw-bold text-primary mb-4">Informasi Utama</h2>
                <dl class="row mb-0 guru-profile">
                    @if($teacher->nip)
                    <dt class="col-sm-5 text-secondary">NIP / NUPTK</dt>
                    <dd class="col-sm-7">{{ $teacher->nip }}</dd>
                    @endif

                    @if($teacher->subject)
                    <dt class="col-sm-5 text-secondary">Mata Pelajaran</dt>
                    <dd class="col-sm-7">{{ $teacher->subject }}</dd>
                    @endif

                    @if($teacher->education)
                    <dt class="col-sm-5 text-secondary">Pendidikan Terakhir</dt>
                    <dd class="col-sm-7">{{ $teacher->education }}</dd>
                    @endif

                    @if($teacher->email)
                    <dt class="col-sm-5 text-secondary">Email Sekolah</dt>
                    <dd class="col-sm-7"><a href="mailto:{{ $teacher->email }}">{{ $teacher->email }}</a></dd>
                    @endif

                    <dt class="col-sm-5 text-secondary">Status Kepegawaian</dt>
                    <dd class="col-sm-7">{{ $teacher->employment_status_label }}</dd>
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

@push('styles')
<style>
.guru-profile-card .row {
    align-items: stretch;
}
.guru-profile-photo-col {
    background: #f8fafc;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 1.25rem;
}
.guru-profile-photo-wrap {
    position: relative;
    width: 100%;
    max-width: 330px;
    aspect-ratio: 4 / 5;
    max-height: 420px;
    background: #e2e8f0;
    border-radius: 1rem;
    overflow: hidden;
    box-shadow: 0 0.5rem 1.25rem rgba(15, 23, 42, 0.12);
}
.guru-profile-photo-wrap__img {
    width: 100%;
    height: 100%;
    display: block;
    object-fit: cover;
    object-position: center top;
    border-radius: 1rem;
}
.guru-profile-photo-wrap__overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, rgba(15, 23, 42, 0) 68%, rgba(15, 23, 42, 0.72) 100%);
    pointer-events: none;
    border-radius: 1rem;
}
.guru-profile-photo-wrap__caption {
    position: absolute;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 1;
    padding: 0.65rem 0.75rem 0.75rem;
    color: #fff;
}
.guru-profile-photo-wrap__name {
    font-size: 0.95rem;
    font-weight: 700;
    line-height: 1.3;
    text-shadow: 0 1px 4px rgba(0, 0, 0, 0.35);
}
.guru-profile-photo-wrap__role {
    font-size: 0.78rem;
    opacity: 0.92;
    line-height: 1.35;
    margin-top: 0.15rem;
}
.guru-profile-photo-wrap__field {
    font-size: 0.68rem;
    background: rgba(255, 255, 255, 0.92);
    color: #1d4ed8;
    font-weight: 700;
    letter-spacing: 0.03em;
    padding: 0.25rem 0.45rem;
}
@media (min-width: 768px) {
    .guru-profile-photo-col {
        padding: 1.5rem 1.25rem;
    }
    .guru-profile-photo-wrap {
        max-width: none;
        width: 96%;
        max-height: 440px;
    }
    .guru-profile-photo-wrap__caption {
        padding: 0.7rem 0.85rem 0.85rem;
    }
    .guru-profile-photo-wrap__name {
        font-size: 1rem;
    }
}
@media (max-width: 767.98px) {
    .guru-profile-photo-wrap {
        max-width: 310px;
        max-height: 390px;
    }
}
</style>
@endpush
