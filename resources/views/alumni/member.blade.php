@extends('layouts.app')

@section('title', 'Akun Alumni — '.config('app.name'))

@section('content')
<div class="page-hero">
    <div class="container d-flex flex-wrap align-items-center justify-content-between gap-2">
        <div>
            <h1 class="h4 mb-0 fw-bold">Halo, {{ auth()->user()->name }}</h1>
            <p class="mb-0 small opacity-90">Data profil &amp; status verifikasi</p>
        </div>
        <form method="post" action="{{ route('logout') }}" class="m-0">@csrf
            <button class="btn btn-light btn-sm" type="submit">Keluar</button>
        </form>
    </div>
</div>
<div class="container py-5">
    @if($profile)
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h2 class="h6 text-uppercase text-secondary">Profil</h2>
                    <dl class="row mb-0 small">
                        <dt class="col-sm-3">Jurusan</dt>
                        <dd class="col-sm-9">{{ $profile->major?->name ?? '—' }}</dd>
                        <dt class="col-sm-3">Tahun lulus</dt>
                        <dd class="col-sm-9">{{ $profile->graduation_year ?? '—' }}</dd>
                        <dt class="col-sm-3">Status</dt>
                        <dd class="col-sm-9">{{ $profile->current_status ?? '—' }}</dd>
                        <dt class="col-sm-3">Kota</dt>
                        <dd class="col-sm-9">{{ $profile->city ?? '—' }}</dd>
                        <dt class="col-sm-3">Pekerjaan / kuliah</dt>
                        <dd class="col-sm-9">{{ $profile->company_or_university ?? '—' }}</dd>
                        <dt class="col-sm-3">Bio</dt>
                        <dd class="col-sm-9">{{ $profile->bio ?? '—' }}</dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h2 class="h6 text-uppercase text-secondary">Verifikasi</h2>
                    <p class="mb-0">
                        @if($profile->verification === 'verified')
                            <span class="badge bg-success">Terverifikasi</span>
                        @elseif($profile->verification === 'rejected')
                            <span class="badge bg-danger">Ditolak</span>
                        @else
                            <span class="badge bg-warning text-dark">Menunggu verifikasi</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="alert alert-info">Belum ada data profil alumni. Hubungi admin jika seharusnya sudah terdaftar.</div>
    @endif
</div>
@endsection
