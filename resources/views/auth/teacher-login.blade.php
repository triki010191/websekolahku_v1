@extends('layouts.app')

@section('title', 'Area Guru & TU — '.config('app.name'))

@section('content')
<div class="page-hero">
    <div class="container">
        <h1 class="h3 mb-0 fw-bold">Area Guru &amp; TU</h1>
        <p class="mb-0 opacity-90">Masuk untuk mengelola profil Anda di website sekolah</p>
    </div>
</div>
<div class="container py-5" style="max-width: 440px;">
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            @if(session('error'))
            <div class="alert alert-warning small py-2">{{ session('error') }}</div>
            @endif
            @if($errors->any())
            <div class="alert alert-danger small py-2">{{ $errors->first() }}</div>
            @endif
            <form method="post" action="{{ route('guru.login.post') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required autocomplete="current-password">
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="remember" id="r-guru">
                    <label class="form-check-label" for="r-guru">Ingat saya</label>
                </div>
                <button class="btn btn-primary w-100" type="submit">Masuk</button>
            </form>
            <p class="text-center small text-secondary mt-3 mb-0">
                <a href="{{ route('home') }}">← Kembali ke website</a>
                <span class="text-muted mx-1">·</span>
                <a href="{{ route('admin.login') }}">Panel admin sekolah</a>
            </p>
        </div>
    </div>
</div>
@endsection
