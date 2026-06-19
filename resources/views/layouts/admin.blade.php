<!doctype html>
<html lang="id" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — {{ config('app.name') }}</title>
    @include('partials.favicon')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ @filemtime(public_path('css/app.css')) ?: '1' }}">
    @stack('styles')
</head>
<body class="bg-body-tertiary">
    <div class="admin-shell">
        <aside class="admin-sidebar" id="adminSidebar">
            <div class="d-flex align-items-center gap-2 mb-4 pb-3 border-bottom border-secondary">
                <span class="d-inline-flex align-items-center justify-content-center text-white fw-bold rounded-2" style="width:38px;height:38px;background:#1d4ed8;">S8</span>
                <div>
                    <div class="fw-bold text-white small">SMKN 8 Pandeglang</div>
                    <div style="font-size:11px;color:#94a3b8">Admin</div>
                </div>
            </div>
            @php
                $u = auth()->user();
                $isSuper = $u->isSuperAdmin();
                $isBerita = $u->hasRole(\App\Models\User::ROLE_ADMIN_BERITA);
                $isAlumniAdmin = $u->hasRole(\App\Models\User::ROLE_ADMIN_ALUMNI);
            @endphp
            @if($isSuper)
            <a href="{{ route('admin.dashboard') }}" class="@if(request()->routeIs('admin.dashboard')) active @endif"><i class="bi bi-grid"></i> Dashboard</a>
            @endif
            @if($isSuper || $isBerita)
            <a href="{{ route('admin.posts.index') }}" class="@if(request()->routeIs('admin.posts.*')) active @endif"><i class="bi bi-newspaper"></i> Berita</a>
            @endif
            @if($isSuper)
            <a href="{{ route('admin.announcements.index') }}" class="@if(request()->routeIs('admin.announcements.*')) active @endif"><i class="bi bi-megaphone"></i> Pengumuman</a>
            <a href="{{ route('admin.pages.index') }}" class="@if(request()->routeIs('admin.pages.*')) active @endif"><i class="bi bi-file-earmark-text"></i> Halaman Konten</a>
            <a href="{{ route('admin.majors.index') }}" class="@if(request()->routeIs('admin.majors.*')) active @endif"><i class="bi bi-mortarboard"></i> Jurusan</a>
            <a href="{{ route('admin.teachers.index') }}" class="@if(request()->routeIs('admin.teachers.*')) active @endif"><i class="bi bi-people"></i> Guru &amp; TU</a>
            <a href="{{ route('admin.ppdb.index') }}" class="@if(request()->routeIs('admin.ppdb.*')) active @endif"><i class="bi bi-person-check"></i> SPMB</a>
            <a href="{{ route('admin.gallery.index') }}" class="@if(request()->routeIs('admin.gallery.*')) active @endif"><i class="bi bi-images"></i> Galeri</a>
            <a href="{{ route('admin.hero-slides.index') }}" class="@if(request()->routeIs('admin.hero-slides.*')) active @endif"><i class="bi bi-collection-play"></i> Slider beranda</a>
            <a href="{{ route('admin.downloads.index') }}" class="@if(request()->routeIs('admin.downloads.*')) active @endif"><i class="bi bi-cloud-arrow-down"></i> Download</a>
            <a href="{{ route('admin.facilities.index') }}" class="@if(request()->routeIs('admin.facilities.*')) active @endif"><i class="bi bi-building"></i> Fasilitas</a>
            <a href="{{ route('admin.extracurriculars.index') }}" class="@if(request()->routeIs('admin.extracurriculars.*')) active @endif"><i class="bi bi-trophy"></i> Ekstrakurikuler</a>
            <a href="{{ route('admin.partners.index') }}" class="@if(request()->routeIs('admin.partners.*')) active @endif"><i class="bi bi-handshake"></i> Kerjasama DU-DI</a>
            <a href="{{ route('admin.alumni-jobs.index') }}" class="@if(request()->routeIs('admin.alumni-jobs.*')) active @endif"><i class="bi bi-briefcase"></i> Lowongan alumni</a>
            <a href="{{ route('admin.contact-messages.index') }}" class="@if(request()->routeIs('admin.contact-messages.*')) active @endif"><i class="bi bi-envelope-open"></i> Pesan hubungi kami</a>
            @endif
            @if($isSuper || $isAlumniAdmin)
            <a href="{{ route('admin.alumni-profiles.index') }}" class="@if(request()->routeIs('admin.alumni-profiles.*')) active @endif"><i class="bi bi-mortarboard-fill"></i> Data alumni</a>
            @endif
            @if($isSuper)
            <div class="label">Sistem</div>
            <a href="{{ route('admin.users.index') }}" class="@if(request()->routeIs('admin.users.*')) active @endif"><i class="bi bi-person-gear"></i> User</a>
            <a href="{{ route('admin.settings.index') }}" class="@if(request()->routeIs('admin.settings.*')) active @endif"><i class="bi bi-sliders"></i> Pengaturan</a>
            @endif
            <div class="mt-4 pt-3 border-top border-secondary">
                <a href="{{ route('home') }}" target="_blank"><i class="bi bi-box-arrow-up-right"></i> Buka website</a>
            </div>
        </aside>
        <div class="flex-grow-1 d-flex flex-column min-vh-100">
            <header class="admin-topbar d-flex flex-wrap align-items-center gap-2">
                <button class="btn btn-outline-secondary d-lg-none" type="button" id="adminSidebarToggle"><i class="bi bi-list"></i></button>
                <div class="ms-auto d-flex align-items-center gap-2 small">
                    <span class="text-secondary">{{ auth()->user()->name }}</span>
                    <span class="badge bg-primary">{{ auth()->user()->role }}</span>
                    <form method="post" action="{{ route('logout') }}" class="d-inline">@csrf
                        <button class="btn btn-sm btn-outline-danger">Logout</button>
                    </form>
                </div>
            </header>
            <main class="p-3 p-md-4 flex-grow-1">
                @if(session('success'))<div class="alert alert-success py-2">{{ session('success') }}</div>@endif
                @if(session('error'))<div class="alert alert-danger py-2">{{ session('error') }}</div>@endif
                @include('partials.validation-errors')
                @yield('admin')
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>
