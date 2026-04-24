@extends('layouts.app')
@section('title', 'Alumni — '.config('app.name'))
@section('content')
<section class="page-hero"><div class="container d-flex flex-wrap align-items-end justify-content-between gap-2">
    <h1 class="display-6 fw-bold mb-0">Komunitas Alumni</h1>
    <a href="{{ route('alumni.login') }}" class="btn btn-light btn-sm">Area Alumni (login)</a>
</div></section>
<section class="py-5"><div class="container">
    <h4 class="mb-3">Direktori (tersedia)</h4>
    <div class="row g-3">
        @forelse($profiles as $p)
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-3">
                <div class="fw-bold">{{ $p->user?->name }}</div>
                <div class="small text-secondary">{{ $p->major?->name }} — {{ $p->graduation_year }}</div>
                <p class="small mt-2 mb-0">{{ \Illuminate\Support\Str::limit($p->bio, 120) }}</p>
            </div>
        </div>
        @empty
        <p>Data alumni sedang dalam verifikasi.</p>
        @endforelse
    </div>
    <div class="mt-3">{{ $profiles->links() }}</div>
    <h4 class="mt-5 mb-3">Lowongan terbaru</h4>
    <ul class="list-group shadow-sm">
        @foreach($jobs as $j)
        <li class="list-group-item d-flex justify-content-between">
            <div><strong>{{ $j->title }}</strong> — {{ $j->company }} <span class="text-muted">({{ $j->location }})</span></div>
        </li>
        @endforeach
    </ul>
    <a href="{{ route('alumni.jobs') }}" class="btn btn-outline-primary mt-2">Semua lowongan</a>
</div></section>
@endsection
