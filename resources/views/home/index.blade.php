@extends('layouts.app')

@section('title', config('app.name').' — Beranda')

@section('content')
@php
    $principalPath = setting('hero_principal_image');
    $principalUrl  = $principalPath ? asset('storage/'.$principalPath) : asset('images/kepala-sekolah.png');
    $principalCap  = setting('hero_principal_caption', 'Kepala Sekolah');
@endphp

@if($heroSlides->isNotEmpty())
<section class="hero-slider position-relative p-0 border-bottom" aria-label="Sorotan">
    <div id="homeHeroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5500">
        <div class="carousel-indicators">
            @foreach($heroSlides as $i => $s)
            <button type="button" data-bs-target="#homeHeroCarousel" data-bs-slide-to="{{ $i }}" @if($i===0) class="active" aria-current="true" @endif aria-label="Slide {{ $i+1 }}"></button>
            @endforeach
        </div>
        <div class="carousel-inner">
            @foreach($heroSlides as $i => $s)
            <div class="carousel-item @if($i===0) active @endif">
                <div class="position-relative" style="max-height:min(58vh,500px); overflow:hidden; background:#0f172a;">
                    <img src="{{ asset('storage/'.$s->image) }}" class="d-block w-100 hero-slider__img" alt="{{ $s->title }}" loading="{{ $i===0 ? 'eager' : 'lazy' }}">
                </div>
                <div class="carousel-caption text-start d-none d-md-block pb-3 hero-slider__caption">
                    <div class="container py-2">
                        <h2 class="h4 fw-bold mb-1">{{ $s->title }}</h2>
                        @if($s->subtitle)<p class="small mb-2 opacity-90 text-wrap">{{ $s->subtitle }}</p>@endif
                        @if($s->button_url && $s->button_text)
                        <a href="{{ $s->button_url }}" class="btn btn-light btn-sm">{{ $s->button_text }}</a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#homeHeroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="visually-hidden">Sebelumnya</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#homeHeroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span><span class="visually-hidden">Berikutnya</span>
        </button>
    </div>
</section>
@endif

{{-- Hero --}}
<section class="hero-gradient position-relative overflow-hidden">
    <div class="container py-5 py-lg-6">
        <div class="row align-items-center min-vh-50">
            <div class="col-lg-7 py-4">
                <span class="badge bg-warning text-dark mb-3">Sekolah Pusat Keunggulan</span>
                <h1 class="display-5 fw-bold mb-3">{{ setting('site_tagline', 'Pusat Keunggulan & Prestasi Akademik') }}</h1>
                <p class="lead text-white-50 mb-4">Mencetak generasi vokasi yang berpendidikan, berkarakter, dan siap bersaing di dunia kerja maupun pendidikan tinggi.</p>
                <div class="d-flex flex-wrap gap-2 align-items-center">
                    @include('partials.spmb-banten-button', ['variant' => 'lg'])
                    <a href="{{ route('jurusan.index') }}" class="btn btn-outline-light btn-lg">Pelajari Jurusan</a>
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-block text-center">
                <div class="rounded-4 overflow-hidden shadow-lg mx-auto bg-white bg-opacity-10" style="max-width: 380px;">
                    <img src="{{ $principalUrl }}" class="w-100 d-block" style="object-fit: cover; object-position: top center; max-height: 420px; min-height: 300px" alt="{{ $principalCap }}">
                </div>
                <p class="small text-white-50 mt-2 mb-0">{{ $principalCap }}</p>
            </div>
        </div>
    </div>
</section>

{{-- Statistik --}}
<section class="bg-body border-bottom py-4">
    <div class="container">
        <div class="row row-cols-2 row-cols-lg-4 g-3 text-center">
            <div class="col">
                <div class="p-3 rounded-3 bg-primary bg-opacity-10">
                    <div class="fs-2 fw-bold text-primary">{{ number_format($stats['students'] ?? 0, 0, ',', '.') }}+</div>
                    <div class="small text-muted text-uppercase">Siswa Aktif</div>
                </div>
            </div>
            <div class="col">
                <div class="p-3 rounded-3 bg-success bg-opacity-10">
                    <div class="fs-2 fw-bold text-success">{{ $stats['teachers'] ?? 0 }}</div>
                    <div class="small text-muted text-uppercase">Tenaga Pendidik</div>
                </div>
            </div>
            <div class="col">
                <div class="p-3 rounded-3 bg-warning bg-opacity-10">
                    <div class="fs-2 fw-bold text-warning-emphasis">{{ $stats['majors'] ?? 0 }}</div>
                    <div class="small text-muted text-uppercase">Jurusan Unggulan</div>
                </div>
            </div>
            <div class="col">
                <div class="p-3 rounded-3 bg-info bg-opacity-10">
                    <div class="fs-2 fw-bold text-info-emphasis">{{ number_format($stats['alumni'] ?? 0, 0, ',', '.') }}+</div>
                    <div class="small text-muted text-uppercase">Alumni</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Sambutan (dari halaman CMS) --}}
<section class="py-5">
    <div class="container">
        <div class="row g-4 align-items-center">
            <div class="col-md-5 reveal">
                @php
                    $simg = setting('sambutan_section_image');
                @endphp
                <div class="rounded-4 overflow-hidden shadow-sm border bg-light" style="aspect-ratio:4/5;">
                    @if($simg)
                        <img src="{{ asset('storage/'.$simg) }}" alt="Sambutan Kepala Sekolah" class="w-100 h-100" style="object-fit:cover;object-position:top center" loading="lazy" width="500" height="625">
                    @else
                        <div class="w-100 h-100" style="min-height:240px;background:linear-gradient(135deg,#dbeafe,#93c5fd);"></div>
                    @endif
                </div>
            </div>
            <div class="col-md-7 reveal">
                <span class="badge bg-primary bg-opacity-10 text-primary mb-2">Sambutan Kepala Sekolah</span>
                <h2 class="fw-bold mb-3">Mewujudkan Pendidikan Vokasi Bermutu</h2>
                <p class="text-secondary">Kami berkomitmen memberikan pengalaman belajar yang relevan dengan industri, didukung fasilitas praktik dan tenaga pendidik yang kompeten.</p>
                <a href="{{ route('profil.show','sambutan') }}" class="btn btn-outline-primary">Baca sambutan lengkap</a>
            </div>
        </div>
    </div>
</section>

{{-- Jurusan --}}
<section class="py-5 bg-body-secondary">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <h2 class="fw-bold mb-1">Jurusan Unggulan</h2>
                <p class="text-secondary mb-0">Kompetensi keahlian yang selaras dengan kebutuhan DU-DI</p>
            </div>
            <a href="{{ route('jurusan.index') }}" class="btn btn-sm btn-primary d-none d-md-inline-flex">Semua Jurusan</a>
        </div>
        <div class="row g-3">
            @foreach($majors->take(5) as $m)
            <div class="col-md-6 col-lg-4 reveal">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <span class="badge bg-soft-primary mb-2">{{ $m->code }}</span>
                        <h5 class="card-title fw-bold">{{ $m->name }}</h5>
                        <p class="card-text small text-secondary line-clamp-3">{{ $m->tagline ?? $m->description }}</p>
                        <a href="{{ route('jurusan.show', $m) }}" class="stretched-link text-decoration-none small">Detail &rarr;</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Berita Terbaru (full width: 4 kiri + 4 kanan) --}}
<section class="py-5">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-4">
            <h3 class="fw-bold mb-0">Berita Terbaru</h3>
            <a href="{{ route('berita.index') }}" class="btn btn-outline-primary btn-sm">Arsip Berita</a>
        </div>
        <div class="row g-4">
            @forelse($posts->chunk(4) as $columnPosts)
            <div class="col-lg-6">
                <div class="d-flex flex-column gap-4">
                    @foreach($columnPosts as $post)
                    @include('partials.home-news-card', ['post' => $post])
                    @endforeach
                </div>
            </div>
            @empty
            <div class="col-12">
                <p class="text-secondary mb-0">Belum ada berita.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

{{-- Pengumuman (di bawah berita) --}}
<section class="py-5 bg-body-secondary">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-4">
            <h3 class="fw-bold mb-0">Pengumuman</h3>
            <a href="{{ route('pengumuman.index') }}" class="btn btn-outline-primary btn-sm">Semua Pengumuman</a>
        </div>
        <div class="row g-3">
            @forelse($announcements as $a)
            <div class="col-md-6 col-lg-4">
                <a href="{{ route('pengumuman.show', $a->slug) }}" class="text-decoration-none text-body d-block h-100">
                    <div class="card border-0 shadow-sm h-100 home-announce-card">
                        <div class="card-body d-flex gap-3 align-items-start">
                            <div class="home-announce-card__date text-center flex-shrink-0">
                                <div class="fs-3 fw-bold text-primary lh-1">{{ optional($a->published_at)->format('d') }}</div>
                                <small class="text-uppercase text-muted">{{ optional($a->published_at)->translatedFormat('M Y') }}</small>
                            </div>
                            <div class="min-w-0">
                                <div class="fw-semibold line-clamp-2">{{ $a->title }}</div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @empty
            <div class="col-12">
                <p class="text-secondary mb-0">Tidak ada pengumuman.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

{{-- Event --}}
@if($events->isNotEmpty())
<section class="py-4 bg-body-secondary">
    <div class="container">
        <h3 class="fw-bold mb-3">Event Mendatang</h3>
        <div class="row g-3">
            @foreach($events as $ev)
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <small class="text-primary">{{ $ev->start_at?->translatedFormat('d M Y, H:i') }}</small>
                        <h6 class="fw-bold mt-1">{{ $ev->title }}</h6>
                        <p class="small text-secondary line-clamp-2 mb-0">{{ $ev->description }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Testimoni alumni --}}
@if(isset($testimonials) && $testimonials->isNotEmpty())
<section class="py-5 text-white" style="background:linear-gradient(135deg,#0f172a,#1d4ed8);">
    <div class="container">
        <h2 class="fw-bold mb-4">Kisah Sukses Alumni</h2>
        <div class="row g-3">
            @foreach($testimonials as $t)
            <div class="col-md-4">
                <div class="p-4 rounded-4 bg-white bg-opacity-10 h-100">
                    <p class="mb-3 small">“{{ \Illuminate\Support\Str::limit($t->bio, 160) }}”</p>
                    <div class="fw-bold">{{ $t->user?->name }}</div>
                    <small class="text-white-50">{{ $t->position_or_major }} @ {{ $t->company_or_university }}</small>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Mitra --}}
<section class="py-5">
    <div class="container text-center">
        <h6 class="text-uppercase text-secondary mb-3">Bekerja Sama dengan Mitra Industri</h6>
        <div class="row row-cols-2 row-cols-md-4 g-3 align-items-center justify-content-center">
            @foreach($partners as $p)
            <div class="col">
                @if($p->logo)
                <img src="{{ asset('storage/'.$p->logo) }}" class="img-fluid opacity-75" style="max-height:48px" alt="{{ $p->name }}">
                @else
                <span class="fw-semibold text-secondary">{{ $p->name }}</span>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA SPMB --}}
<section class="py-5 bg-primary text-white">
    <div class="container text-center">
        <h2 class="fw-bold">SPMB {{ setting('ppdb_year', date('Y').'/'.(date('Y')+1)) }}</h2>
        <p class="mb-4 opacity-90">Pendaftaran calon peserta didik baru — cek jadwal &amp; alur, lalu isi formulir online.</p>
        <div class="d-flex flex-wrap justify-content-center align-items-center gap-2">
            <a href="{{ route('spmb.index') }}" class="btn btn-light btn-lg">Info SPMB Lengkap</a>
            @include('partials.spmb-banten-button', ['variant' => 'cta'])
        </div>
    </div>
</section>

@include('partials.youtube-section')
@include('partials.instagram-section')
@include('partials.maps-section')
@endsection

@push('styles')
<style>
.min-vh-50{min-height:45vh}
.hover-lift{transition:transform .2s, box-shadow .2s}
.hover-lift:hover{transform:translateY(-2px);box-shadow:0 12px 24px rgba(0,0,0,.1)!important}
</style>
@endpush
