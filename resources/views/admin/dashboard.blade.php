@extends('layouts.admin')
@section('title', 'Dashboard')
@section('admin')
<h1 class="h4 mb-4">Ringkasan</h1>
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3"><div class="card border-0 shadow-sm p-3"><div class="text-secondary small">Siswa (jumlah)</div><div class="fs-3 fw-bold text-primary">{{ number_format($stats['students'] ?? 0) }}</div></div></div>
    <div class="col-6 col-lg-3"><div class="card border-0 shadow-sm p-3"><div class="text-secondary small">Guru</div><div class="fs-3 fw-bold">{{ $stats['teachers'] ?? 0 }}</div></div></div>
    <div class="col-6 col-lg-3"><div class="card border-0 shadow-sm p-3"><div class="text-secondary small">SPMB (pending)</div><div class="fs-3 fw-bold text-warning">{{ $stats['ppdb_pending'] ?? 0 }} / {{ $stats['ppdb_total'] ?? 0 }}</div></div></div>
    <div class="col-6 col-lg-3"><div class="card border-0 shadow-sm p-3"><div class="text-secondary small">Pesan baru</div><div class="fs-3 fw-bold">{{ $stats['messages_new'] ?? 0 }}</div></div></div>
</div>
<div class="row g-3">
    <div class="col-lg-6">
        <h6 class="fw-bold">Berita terbaru</h6>
        <ul class="list-group list-group-flush small">
            @foreach($latest['posts'] as $p)
            <li class="list-group-item d-flex justify-content-between"><a href="{{ route('admin.posts.edit', $p) }}">{{ $p->title }}</a><span class="text-muted">{{ $p->created_at?->diffForHumans() }}</span></li>
            @endforeach
        </ul>
    </div>
    <div class="col-lg-6">
        <h6 class="fw-bold">Pendaftar SPMB</h6>
        <ul class="list-group list-group-flush small">
            @foreach($latest['ppdb'] as $r)
            <li class="list-group-item d-flex justify-content-between">
                <a href="{{ route('admin.ppdb.show', $r) }}">{{ $r->full_name }}</a>
                <span class="badge bg-secondary">{{ $r->status }}</span>
            </li>
            @endforeach
        </ul>
    </div>
</div>
<div class="mt-4">
    <h6 class="fw-bold">SPMB per Jurusan</h6>
    <div class="table-responsive">
        <table class="table table-sm table-bordered bg-white">
            <thead><tr><th>Jurusan</th><th>Pendaftar</th><th>Kuota</th></tr></thead>
            <tbody>
            @foreach($ppdbByMajor as $m)
            <tr><td>{{ $m['label'] }}</td><td>{{ $m['value'] }}</td><td>{{ $m['quota'] ?? '—' }}</td></tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
