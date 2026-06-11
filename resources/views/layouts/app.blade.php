<!doctype html>
<html lang="id" data-bs-theme="{{ $theme ?? 'light' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', setting('seo_title', config('app.name')))</title>
    <meta name="description" content="@yield('description', setting('seo_description'))">
    <meta name="keywords" content="{{ setting('seo_keywords') }}">

    <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'%3E%3Crect width='32' height='32' rx='8' fill='%231d4ed8'/%3E%3Ctext x='16' y='22' font-family='Arial' font-size='16' font-weight='bold' fill='white' text-anchor='middle'%3ES8%3C/text%3E%3C/svg%3E">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ @filemtime(public_path('css/app.css')) ?: '1' }}">
    @include('partials.major-card-styles')
    @stack('styles')
</head>
<body class="d-flex flex-column min-vh-100">
    @include('partials.header')

    <main class="flex-grow-1">
        @if (session('success'))
            <div class="container mt-3">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif
        @if (session('error'))
            <div class="container mt-3">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif
        @if ($errors->any() && !session('success'))
            <div class="container mt-3">
                @include('partials.validation-errors')
            </div>
        @endif

        @yield('content')
    </main>

    @hasSection('hideFooter')
    @else
        @include('partials.footer')
    @endif

    <a href="https://wa.me/{{ str_replace(['+', ' '], '', setting('contact_whatsapp', '6281234567890')) }}"
       class="btn btn-success position-fixed rounded-circle shadow d-flex align-items-center justify-content-center"
       style="bottom:24px; right:24px; width:56px; height:56px; z-index:1080;" target="_blank" rel="noopener">
        <i class="bi bi-whatsapp fs-4"></i>
    </a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>
