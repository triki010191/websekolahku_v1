@extends('layouts.app')

@section('title', 'Info SPMB '.setting('ppdb_year', '2026/2027').' — '.config('app.name'))

@section('content')
@php
    $yearLabel = setting('ppdb_year', date('Y').'/'.(date('Y')+1));
    $endDate   = setting('ppdb_end');
    $announce  = setting('ppdb_announce');
    $fmt = fn ($d) => $d ? \Carbon\Carbon::parse($d)->translatedFormat('d F Y') : '—';
    $spmbBanner = public_asset_url('images/banner-spmb-sekolah.jpg') ?? asset('images/banner-spmb-sekolah.jpg');
@endphp

<section class="spmb-hero text-white position-relative overflow-hidden">
    <div class="spmb-hero__bg" style="background-image:url('{{ $spmbBanner }}')" aria-hidden="true"></div>
    <div class="spmb-hero__overlay" aria-hidden="true"></div>
    <div class="container py-5 position-relative">
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
                @include('partials.spmb-banten-button', ['variant' => 'sm'])
            </div>
        </div>
    </div>
</section>

@if(session('error'))
<section class="py-0">
    <div class="container pt-4">
        <div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
            <i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
</section>
@endif

<section class="py-4 border-bottom bg-white">
    <div class="container text-center">
        @if($isOpen)
        <a href="{{ route('ppdb.create') }}" class="btn btn-primary btn-lg px-5 py-3 shadow-sm spmb-cta-dapodik">
            <i class="bi bi-clipboard-data me-2"></i> Isi Formulir Dapodik
        </a>
        <p class="small text-secondary mt-2 mb-2">Klik tombol di atas untuk mengisi formulir Dapodik secara online.</p>
        @else
        <p class="text-secondary mb-2">Pengisian formulir Dapodik saat ini ditutup. Pantau jadwal di bawah untuk pembukaan berikutnya.</p>
        @endif
        <a href="{{ spmb_route('spmb.panduan-dapodik', '/spmb-2026/panduan-dapodik') }}" class="btn btn-outline-success btn-sm">
            <i class="bi bi-book me-1"></i> Baca Panduan Pengisian Dapodik
        </a>
    </div>
</section>

<section class="py-5 bg-body-tertiary border-bottom">
    <div class="container">
        <h2 class="h5 fw-bold mb-4"><i class="bi bi-calendar-event text-primary me-2"></i>Jadwal Penting</h2>
        <div class="row g-3">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="text-primary small fw-semibold text-uppercase">Pendaftaran</div>
                        <div class="fs-5 fw-bold">16 s.d 20 Juni 2026</div>
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
        <p class="small text-secondary mt-3 mb-0">Jadwal penutupan dan pengumuman dapat diubah dari Admin → <strong>Pengaturan</strong> (grup PPDB).</p>
    </div>
</section>

<section class="py-5 bg-white border-bottom">
    <div class="container">
        <h2 class="h5 fw-bold mb-4"><i class="bi bi-grid-3x3-gap text-primary me-2"></i>Informasi SPMB</h2>
        @include('partials.spmb-quick-nav')
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-8">
                @if($page)
                <article id="persyaratan-spmb" class="card border-0 shadow-sm p-4 p-md-5 mb-4 scroll-margin-top">
                    <h2 class="h4 fw-bold mb-3">{{ $page->title }}</h2>
                    <div class="prose">{!! $page->content !!}</div>
                </article>
                @else
                <div id="persyaratan-spmb" class="alert alert-warning scroll-margin-top">Konten halaman SPMB belum tersedia. Admin dapat menambahkannya di <strong>Halaman Konten</strong> dengan slug <code>spmb-2026</code>.</div>
                @endif

                <h2 id="kuota-spmb" class="h5 fw-bold mb-3 scroll-margin-top"><i class="bi bi-mortarboard text-primary me-2"></i>Kuota Penerimaan Kelas X — SPMB {{ $yearLabel }}</h2>
                <div class="card border-0 shadow-sm mb-2">
                    <div class="card-header bg-white fw-semibold small text-uppercase text-secondary">
                        Kuota Rombel &amp; Siswa SPMB {{ $yearLabel }} — SMKN 8 Pandeglang
                    </div>
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span><span class="badge bg-success me-2">AK</span>Akuntansi</span>
                            <span class="fw-semibold">2 Rombel <span class="text-secondary fw-normal">(72 Siswa)</span></span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span><span class="badge bg-info me-2">DKV</span>Desain Komunikasi Visual</span>
                            <span class="fw-semibold">1 Rombel <span class="text-secondary fw-normal">(36 Siswa)</span></span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span><span class="badge bg-primary me-2">RPL</span>Rekayasa Perangkat Lunak</span>
                            <span class="fw-semibold">2 Rombel <span class="text-secondary fw-normal">(72 Siswa)</span></span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span><span class="badge bg-warning text-dark me-2">TITL</span>Teknik Instalasi Tenaga Listrik</span>
                            <span class="fw-semibold">2 Rombel <span class="text-secondary fw-normal">(72 Siswa)</span></span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span><span class="badge bg-danger me-2">TSM</span>Teknik Sepeda Motor</span>
                            <span class="fw-semibold">1 Rombel <span class="text-secondary fw-normal">(36 Siswa)</span></span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center bg-body-tertiary">
                            <span class="fw-bold">Total</span>
                            <span class="fw-bold text-primary">8 Rombel <span class="text-dark">(288 Siswa)</span></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div id="cek-formulir-spmb" class="card border-0 shadow-sm mb-3 scroll-margin-top">
                    <div class="card-header bg-primary text-white fw-bold">
                        <i class="bi bi-search me-2"></i>Cek Formulir Pendaftaran
                    </div>
                    <div class="card-body">
                        <p class="small text-secondary mb-2"><strong>Hanya untuk cek formulir yang sudah dikirim.</strong> Masukkan NISN dan tanggal lahir untuk melihat atau mengunduh PDF.</p>
                        @if($isOpen)
                        <p class="small text-secondary mb-2">Belum pernah mengisi / mendaftarkan siswa baru? Gunakan tombol <a href="{{ route('ppdb.create') }}">Isi Formulir Dapodik</a> di atas — <em>bukan</em> form ini.</p>
                        @endif
                        <form method="post" action="{{ route('ppdb.lookup') }}" class="vstack gap-2">
                            @csrf
                            <div>
                                <label class="form-label small fw-semibold mb-1">NISN</label>
                                <input type="text" name="nisn" class="form-control form-control-sm @error('lookup') is-invalid @enderror @error('nisn') is-invalid @enderror" value="{{ old('nisn') }}" placeholder="10 digit NISN" maxlength="10" inputmode="numeric" pattern="[0-9]{10}" required>
                                @error('nisn')<div class="text-danger small">{{ $message }}</div>@enderror
                            </div>
                            <div>
                                <label class="form-label small fw-semibold mb-1">Tanggal Lahir</label>
                                <input type="date" name="birth_date" class="form-control form-control-sm @error('lookup') is-invalid @enderror @error('birth_date') is-invalid @enderror" value="{{ old('birth_date') }}" required>
                                @error('birth_date')<div class="text-danger small">{{ $message }}</div>@enderror
                            </div>
                            @error('lookup')
                            <div class="alert alert-danger small py-2 mb-0">{{ $message }}</div>
                            @enderror
                            <button type="submit" class="btn btn-primary btn-sm w-100 mt-1"><i class="bi bi-file-earmark-pdf me-1"></i> Cek &amp; Unduh Formulir</button>
                        </form>
                    </div>
                </div>

                <div id="pengumuman-spmb" class="card border-0 shadow-sm sticky-top scroll-margin-top" style="top:5.5rem">
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
                        <p class="small text-secondary mb-2">Baca <a href="{{ spmb_route('spmb.panduan-dapodik', '/spmb-2026/panduan-dapodik', '#masalah') }}">panduan troubleshooting</a> atau hubungi panitia SPMB:</p>
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
<style>
.prose img{max-width:100%;height:auto;border-radius:.5rem}
.spmb-hero{min-height:min(52vw,320px)}
.spmb-hero__bg{position:absolute;inset:0;background-size:cover;background-position:center;background-repeat:no-repeat}
.spmb-hero__overlay{position:absolute;inset:0;background:linear-gradient(105deg,rgba(15,23,42,.92) 0%,rgba(15,23,42,.72) 38%,rgba(29,78,216,.35) 68%,rgba(29,78,216,.12) 100%)}
.spmb-hero .breadcrumb-item+.breadcrumb-item::before{color:rgba(255,255,255,.45)}
.spmb-cta-dapodik{font-size:1.2rem;font-weight:600}
.scroll-margin-top{scroll-margin-top:5.5rem}
.spmb-quick-nav__btn{transition:transform .15s ease,box-shadow .15s ease;border-width:1.5px}
.spmb-quick-nav__btn:hover{transform:translateY(-2px);box-shadow:0 .35rem 1rem rgba(15,23,42,.1)}
@media (max-width:767.98px){
    .spmb-hero{min-height:360px}
    .spmb-hero__bg{background-position:70% center}
    .spmb-hero__overlay{background:linear-gradient(180deg,rgba(15,23,42,.88) 0%,rgba(15,23,42,.78) 55%,rgba(15,23,42,.55) 100%)}
    .spmb-cta-dapodik{width:100%;font-size:1.1rem}
}
</style>
@endpush
