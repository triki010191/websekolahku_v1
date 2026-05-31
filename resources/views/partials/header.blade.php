@php
    $siteName = setting('site_short', 'SMKN 8 Pandeglang');
    $siteLogoPath = setting('site_logo');
    $siteLogoUrl = storage_file_exists($siteLogoPath) ? public_storage_url($siteLogoPath) : null;
@endphp
<nav class="navbar main-nav navbar-expand-lg bg-body border-bottom sticky-top shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="{{ route('home') }}">
            @if($siteLogoUrl)
                <img src="{{ $siteLogoUrl }}" alt="" class="rounded-2 border flex-shrink-0" style="width:40px;height:40px;object-fit:contain;background:#fff" width="40" height="40" loading="eager" decoding="async">
            @else
            <span class="d-inline-flex align-items-center justify-content-center text-white fw-bold rounded-2"
                  style="width:38px;height:38px;background:linear-gradient(135deg,#1d4ed8,#3b82f6);font-family:'Plus Jakarta Sans',sans-serif;">S8</span>
            @endif
            <span class="d-none d-sm-inline lh-sm">
                {{ $siteName }}<br>
                <span class="d-block fw-normal text-secondary" style="font-size:0.7rem;letter-spacing:.02em;">Digital Portal</span>
            </span>
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <i class="bi bi-list fs-3"></i>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav mx-auto gap-lg-1 main-nav__items">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active fw-semibold' : '' }}" href="{{ route('home') }}">Beranda</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('profil.*') ? 'active fw-semibold' : '' }}" data-bs-toggle="dropdown" data-bs-offset="0,4" href="#" role="button" aria-expanded="false">Profil</a>
                    <ul class="dropdown-menu main-nav__dropdown border-0">
                        <li><a class="dropdown-item" href="{{ route('profil.show','sejarah') }}">Sejarah Sekolah</a></li>
                        <li><a class="dropdown-item" href="{{ route('profil.show','sambutan') }}">Sambutan Kepala Sekolah</a></li>
                        <li><a class="dropdown-item" href="{{ route('profil.show','visi-misi') }}">Visi &amp; Misi</a></li>
                        <li><a class="dropdown-item" href="{{ route('profil.show','struktur') }}">Struktur Organisasi</a></li>
                        <li><a class="dropdown-item" href="{{ route('profil.show','prestasi') }}">Prestasi Sekolah</a></li>
                        <li><a class="dropdown-item" href="{{ route('profil.show','tata-tertib') }}">Tata Tertib</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('jurusan.*') ? 'active fw-semibold' : '' }}" data-bs-toggle="dropdown" data-bs-offset="0,4" href="#" role="button" aria-expanded="false">Jurusan</a>
                    <ul class="dropdown-menu main-nav__dropdown border-0">
                        <li><a class="dropdown-item" href="{{ route('jurusan.index') }}">Semua jurusan</a></li>
                        @foreach($navMajors ?? [] as $mj)
                        <li><a class="dropdown-item" href="{{ route('jurusan.show', $mj->slug) }}">{{ $mj->name }}</a></li>
                        @endforeach
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('guru.*') ? 'active fw-semibold' : '' }}" href="{{ route('guru.index') }}">Guru &amp; TU</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" data-bs-offset="0,4" href="#" role="button" aria-expanded="false">Info</a>
                    <ul class="dropdown-menu main-nav__dropdown border-0">
                        <li><a class="dropdown-item" href="{{ route('berita.index') }}">Berita</a></li>
                        <li><a class="dropdown-item" href="{{ route('pengumuman.index') }}">Pengumuman</a></li>
                        <li><a class="dropdown-item" href="{{ route('event.index') }}">Event &amp; Agenda</a></li>
                        <li><a class="dropdown-item" href="{{ route('kalender.index') }}">Kalender Akademik</a></li>
                        <li><a class="dropdown-item" href="{{ route('download.index') }}">Download</a></li>
                        <li><a class="dropdown-item" href="{{ route('galeri.index') }}">Galeri</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('ppdb.*','spmb.*') ? 'active fw-semibold' : '' }}" data-bs-toggle="dropdown" data-bs-offset="0,4" href="#" role="button" aria-expanded="false">Lainnya</a>
                    <ul class="dropdown-menu main-nav__dropdown border-0">
                        <li><a class="dropdown-item" href="{{ route('spmb.index') }}"><i class="bi bi-info-circle me-1 text-primary"></i> Info SPMB 2026</a></li>
                        <li><a class="dropdown-item" href="{{ route('ppdb.create') }}"><i class="bi bi-clipboard-data me-1 text-primary"></i> Formulir Daftar Ulang Dapodik</a></li>
                        <li><a class="dropdown-item" href="{{ route('fasilitas.index') }}">Fasilitas</a></li>
                        <li><a class="dropdown-item" href="{{ route('ekstrakurikuler.index') }}">Ekstrakurikuler</a></li>
                        <li><a class="dropdown-item" href="{{ route('alumni.index') }}">Alumni</a></li>
                        <li><a class="dropdown-item" href="{{ route('kerjasama.index') }}">Kerjasama (DU-DI)</a></li>
                        <li><a class="dropdown-item" href="{{ route('faq.index') }}">FAQ</a></li>
                        <li><a class="dropdown-item" href="{{ route('kontak.index') }}">Kontak</a></li>
                    </ul>
                </li>
            </ul>
            <div class="d-flex align-items-center flex-wrap gap-2">
                <button type="button" class="btn btn-outline-secondary btn-sm" id="themeToggle" title="Ganti tema">
                    <i class="bi bi-moon-stars" id="themeIcon"></i>
                </button>
                @include('partials.spmb-banten-button', ['variant' => 'sm'])
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-dark btn-sm text-nowrap">
                            <i class="bi bi-speedometer2 me-1"></i> Admin
                        </a>
                    @endif
                    @if(auth()->user()->hasRole(\App\Models\User::ROLE_ALUMNI))
                        <a href="{{ route('alumni.member.dashboard') }}" class="btn btn-outline-primary btn-sm text-nowrap">
                            <i class="bi bi-person-badge me-1"></i> Akun
                        </a>
                    @endif
                @else
                    <a href="{{ route('alumni.login') }}" class="btn btn-outline-primary btn-sm d-none d-md-inline-flex text-nowrap">
                        <i class="bi bi-people me-1"></i> Area Alumni
                    </a>
                    <a href="{{ route('admin.login') }}" class="btn btn-outline-dark btn-sm d-none d-md-inline-flex text-nowrap">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Admin
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>
