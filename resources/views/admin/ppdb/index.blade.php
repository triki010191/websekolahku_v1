@extends('layouts.admin')
@section('title', 'SPMB')
@section('admin')
<div class="row g-2 mb-3 small">
    <div class="col-auto"><div class="card p-2 border-0 shadow-sm">Total: <strong>{{ $counts['total'] }}</strong></div></div>
    <div class="col-auto"><div class="card p-2 border-0 shadow-sm">Pending: <strong class="text-warning">{{ $counts['pending'] }}</strong></div></div>
    <div class="col-auto"><div class="card p-2 border-0 shadow-sm">Diterima: <strong class="text-success">{{ $counts['accepted'] }}</strong></div></div>
</div>
<form method="get" class="row g-2 mb-2">
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
        <thead class="table-light"><tr><th>No</th><th>Nama</th><th>NISN</th><th>Jurusan</th><th>Status</th><th></th></tr></thead>
        <tbody>
            @foreach($registrations as $r)
            <tr>
                <td class="text-muted">{{ $r->registration_number }}</td>
                <td>{{ $r->full_name }}</td>
                <td>{{ $r->nisn }}</td>
                <td>{{ $r->major?->code }}</td>
                <td><span class="badge bg-secondary">{{ $r->status }}</span></td>
                <td><a href="{{ route('admin.ppdb.show', $r) }}" class="btn btn-sm btn-outline-primary">Detail</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{ $registrations->withQueryString()->links() }}
@endsection
