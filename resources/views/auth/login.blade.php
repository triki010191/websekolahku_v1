<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin — {{ config('app.name') }}</title>
    @include('partials.favicon')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-body-tertiary d-flex min-vh-100 align-items-center justify-content-center p-3">
    <div class="card border-0 shadow" style="max-width:400px;width:100%;">
        <div class="card-body p-4">
            <div class="text-center mb-4">
                <span class="d-inline-flex align-items-center justify-content-center text-white fw-bold rounded-2 mb-2" style="width:48px;height:48px;background:linear-gradient(135deg,#1d4ed8,#3b82f6);">S8</span>
                <h1 class="h4 fw-bold">Panel Admin</h1>
                <p class="small text-secondary mb-0">SMKN 8 Pandeglang</p>
            </div>
            @if($errors->any())
            <div class="alert alert-danger small py-2">{{ $errors->first() }}</div>
            @endif
            <form method="post" action="{{ route('admin.login.post') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus placeholder="admin@smkn8pandeglang.sch.id">
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required autocomplete="current-password" placeholder="••••••••">
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="remember" id="r">
                    <label class="form-check-label" for="r">Ingat saya</label>
                </div>
                <button class="btn btn-primary w-100">Masuk</button>
            </form>
            <p class="text-center small text-secondary mt-3 mb-1"><a href="{{ route('alumni.login') }}">Area Alumni (login terpisah)</a></p>
            <p class="text-center small text-secondary mt-0 mb-0"><a href="{{ route('home') }}">← Kembali ke website</a></p>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
