@extends('layouts.app')
@section('title', 'SPMB — '.config('app.name'))
@section('content')
<section class="text-white" style="background:linear-gradient(135deg,#0f172a,#1d4ed8)"><div class="container py-5">
    <h1 class="display-5 fw-bold">Penerimaan Peserta Didik Baru</h1>
    <p class="lead opacity-90">Tahun ajaran {{ setting('ppdb_year', date('Y').'/'.(date('Y')+1)) }}</p>
    <a href="{{ route('ppdb.create') }}" class="btn btn-light btn-lg">Mulai Pendaftaran</a>
</div></section>
<section class="py-5"><div class="container">
    <h4 class="mb-3">Jadwal (informasi)</h4>
    <ul class="list-unstyled">
        <li><strong>Mulai:</strong> {{ setting('ppdb_start') }}</li>
        <li><strong>Selesai:</strong> {{ setting('ppdb_end') }}</li>
    </ul>
    <h4 class="mb-3 mt-4">Kuota per Jurusan</h4>
    <div class="row g-3">
        @foreach($majors as $m)
        <div class="col-6 col-md-4 col-lg-2">
            <div class="card border-0 shadow-sm text-center p-3">
                <div class="fw-bold">{{ $m->code }}</div>
                <div class="fs-4 text-primary">{{ $m->quota ?? '—' }}</div>
            </div>
        </div>
        @endforeach
    </div>
</div></section>
@endsection
