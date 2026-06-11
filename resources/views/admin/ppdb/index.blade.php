@extends('layouts.admin')
@section('title', 'SPMB')
@section('admin')
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <h1 class="h4 mb-0">Data Formulir Dapodik</h1>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.ppdb.export.excel', request()->only('status')) }}" class="btn btn-sm btn-success"><i class="bi bi-file-earmark-excel"></i> Export Excel</a>
    </div>
</div>
<div class="row g-2 mb-3 small">
    <div class="col-auto"><div class="card p-2 border-0 shadow-sm">Terkirim: <strong>{{ $counts['total'] }}</strong></div></div>
    <div class="col-auto"><div class="card p-2 border-0 shadow-sm">Pending: <strong class="text-warning">{{ $counts['pending'] }}</strong></div></div>
    <div class="col-auto"><div class="card p-2 border-0 shadow-sm">Diterima: <strong class="text-success">{{ $counts['accepted'] }}</strong></div></div>
    @if($counts['drafts'] > 0)
    <div class="col-auto"><div class="card p-2 border-0 shadow-sm">Draft: <strong class="text-secondary">{{ $counts['drafts'] }}</strong></div></div>
    @endif
</div>
@if(($formStatus ?? 'submitted') === 'submitted' && $counts['total'] === 0 && $counts['drafts'] > 0)
<div class="alert alert-warning small">Ada {{ $counts['drafts'] }} draft belum dikirim. Data hanya masuk daftar ini setelah siswa menekan <strong>Kirim Formulir</strong>.
    <a href="{{ route('admin.ppdb.index', ['form_status' => 'draft']) }}">Lihat draft</a></div>
@endif
<form method="get" class="row g-2 mb-2">
    <div class="col-auto"><select name="form_status" class="form-select form-select-sm" onchange="this.form.submit()">
        <option value="submitted" @selected(($formStatus ?? 'submitted')==='submitted')>Sudah dikirim</option>
        <option value="draft" @selected(($formStatus ?? 'submitted')==='draft')>Draft</option>
    </select></div>
    <div class="col-auto"><select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
        <option value="">Status</option>
        @foreach(['pending','verified','accepted','rejected'] as $s)
        <option value="{{ $s }}" @selected(request('status')===$s)>{{ $s }}</option>
        @endforeach
    </select></div>
    <div class="col-auto"><select name="major_id" class="form-select form-select-sm" onchange="this.form.submit()">
        <option value="">Jurusan</option>
        @foreach($majors as $m)
        <option value="{{ $m->id }}" @selected(request('major_id')==$m->id)>{{ $m->code }}</option>
        @endforeach
    </select></div>
    <div class="col"><input class="form-control form-control-sm" name="search" placeholder="Cari..." value="{{ request('search') }}"></div>
    <div class="col-auto"><button class="btn btn-sm btn-primary">Cari</button></div>
</form>
<div class="table-responsive card border-0 shadow-sm">
    <table class="table table-hover small mb-0">
        <thead class="table-light"><tr><th>No Daftar</th><th>No SPMB Banten</th><th>Nama</th><th>NISN</th><th>Jurusan</th><th>Status</th><th></th></tr></thead>
        <tbody>
            @foreach($registrations as $r)
            <tr>
                <td class="text-muted">{{ $r->registration_number }}</td>
                <td>{{ $r->spmb_banten_number }}</td>
                <td>{{ $r->full_name }}</td>
                <td>{{ $r->nisn }}</td>
                <td>{{ $r->major?->code }}</td>
                <td><span class="badge bg-secondary">{{ $r->status }}</span></td>
                <td class="text-nowrap">
                    <a href="{{ route('admin.ppdb.show', $r) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                    <a href="{{ route('admin.ppdb.export.pdf', $r) }}" class="btn btn-sm btn-outline-secondary">PDF</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="mt-3 d-flex justify-content-center">{{ $registrations->withQueryString()->links() }}</div>
@endsection
