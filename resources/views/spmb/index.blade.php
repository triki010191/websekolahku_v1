@extends('layouts.app')

@section('title', 'Info SPMB '.setting('ppdb_year', '2026/2027').' — '.config('app.name'))

@section('content')
@php
    $yearLabel = setting('ppdb_year', date('Y').'/'.(date('Y')+1));
    $startDate = setting('ppdb_start');
    $endDate   = setting('ppdb_end');
    $announce  = setting('ppdb_announce');
    $fmt = fn ($d) => $d ? \Carbon\Carbon::parse($d)->translatedFormat('d F Y') : '—';
@endphp

<section class="text-white" style="background:linear-gradient(135deg,#0f172a,#1d4ed8)">
    <div class="container py-5">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-50">Beranda</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">SPMB {{ $yearLabel }}</li>
            </ol>
        </nav>
        <div class="row align-items-center g-4">
            <div class="col-lg-8">
                <span class="badge {{ $isOpen ? 'bg-success' : 'bg-secondary' }} mb-2">
                    {{ $isOpen ? 'Pendaftaran Dibuka' : 'Pendaftaran Ditutup' }}
                </span>
                <h1 class="display-5 fw-bold mb-2">SPMB {{ $yearLabel }}</h1>
                <p class="lead opacity-90 mb-0">Informasi resmi Penerimaan Peserta Didik Baru SMKN 8 Pandeglang — jadwal, kuota, pengumuman, dan alur pendaftaran.</p>
            </div>
            <div class="col-lg-4 d-flex flex-wrap gap-2 justify-content-lg-end">
                @if($isOpen)
                    <a href="{{ route('ppdb.create') }}" class="btn btn-light btn-lg"><i class="bi bi-clipboard-data me-1"></i> Isi Formulir Dapodik</a>
                @endif
                @include('partials.spmb-banten-button', ['variant' => 'sm'])
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-body-tertiary border-bottom">
    <div class="container">
        <h2 class="h5 fw-bold mb-4"><i class="bi bi-calendar-event text-primary me-2"></i>Jadwal Penting</h2>
        <div class="row g-3">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="text-primary small fw-semibold text-uppercase">Pembukaan</div>
                        <div class="fs-5 fw-bold">{{ $fmt($startDate) }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="text-danger small fw-semibold text-uppercase">Penutupan</div>
                        <div class="fs-5 fw-bold">{{ $fmt($endDate) }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="text-success small fw-semibold text-uppercase">Pengumuman Hasil</div>
                        <div class="fs-5 fw-bold">{{ $fmt($announce) }}</div>
                    </div>
                </div>
            </div>
        </div>
        <p class="small text-secondary mt-3 mb-0">Jadwal di atas dapat diubah dari Admin → <strong>Pengaturan</strong> (grup PPDB).</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-8">
                @if($page)
                <article class="card border-0 shadow-sm p-4 p-md-5 mb-4">
                    <h2 class="h4 fw-bold mb-3">{{ $page->title }}</h2>
                    <div class="prose">{!! $page->content !!}</div>
                </article>
                @else
                <div class="alert alert-warning">Konten halaman SPMB belum tersedia. Admin dapat menambahkannya di <strong>Halaman Konten</strong> dengan slug <code>spmb-2026</code>.</div>
                @endif

                <h2 class="h5 fw-bold mb-3"><i class="bi bi-mortarboard text-primary me-2"></i>Kuota per Jurusan</h2>
                <div class="row g-3 mb-2">
                    @foreach($majors as $m)
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="card border-0 shadow-sm text-center p-3 h-100">
                            <div class="fw-bold text-primary">{{ $m->code }}</div>
                            <div class="small text-secondary mb-1">{{ $m->name }}</div>
                            <div class="fs-3 fw-bold">{{ $m->quota ?? '—' }}</div>
                            <div class="small text-muted">kursi</div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <p class="small text-secondary">Kuota dapat diubah dari Admin → <strong>Jurusan</strong>.</p>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm sticky-top" style="top:5.5rem">
                    <div class="card-header bg-white fw-bold"><i class="bi bi-megaphone text-warning me-2"></i>Pengumuman SPMB</div>
                    <div class="list-group list-group-flush">
                        @forelse($announcements as $a)
                        <a href="{{ route('pengumuman.show', $a->slug) }}" class="list-group-item list-group-item-action">
                            <div class="d-flex justify-content-between gap-2 align-items-start">
                                <span class="fw-semibold small">{{ $a->title }}</span>
                                @if($a->priority === 'urgent')
                                    <span class="badge bg-danger">Penting</span>
                                @elseif($a->priority === 'important')
                                    <span class="badge bg-warning text-dark">Info</span>
                                @endif
                            </div>
                            <div class="small text-secondary">{{ $a->published_at?->translatedFormat('d M Y') }}</div>
                        </a>
                        @empty
                        <div class="list-group-item small text-secondary">Belum ada pengumuman SPMB. Tambahkan di Admin → Pengumuman (kategori PPDB).</div>
                        @endforelse
                    </div>
                    @if($announcements->isNotEmpty())
                    <div class="card-footer bg-white">
                        <a href="{{ route('pengumuman.index') }}" class="small">Lihat semua pengumuman →</a>
                    </div>
                    @endif
                </div>

                <div class="card border-0 shadow-sm mt-3">
                    <div class="card-body">
                        <h3 class="h6 fw-bold">Butuh bantuan?</h3>
                        <p class="small text-secondary mb-2">Hubungi panitia SPMB:</p>
                        <ul class="list-unstyled small mb-0">
                            @if(setting('contact_ppdb'))
                            <li class="mb-1"><i class="bi bi-envelope me-1"></i> {{ setting('contact_ppdb') }}</li>
                            @endif
                            @if(setting('contact_phone'))
                            <li class="mb-1"><i class="bi bi-telephone me-1"></i> {{ setting('contact_phone') }}</li>
                            @endif
                            @if(setting('contact_whatsapp'))
                            <li><i class="bi bi-whatsapp me-1"></i> {{ setting('contact_whatsapp') }}</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>.prose img{max-width:100%;height:auto;border-radius:.5rem}</style>
@endpush
