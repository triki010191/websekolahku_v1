@extends('layouts.admin')
@section('title', 'SPMB #'.$reg->registration_number)
@section('admin')
<nav class="mb-2"><a href="{{ route('admin.ppdb.index') }}">← Kembali</a></nav>
<div class="card border-0 shadow-sm p-4">
    <h1 class="h4">{{ $reg->full_name }} <span class="badge bg-primary">{{ $reg->registration_number }}</span></h1>
    <p class="small text-secondary">No SPMB Banten: <strong>{{ $reg->spmb_banten_number }}</strong></p>
    <div class="row small">
        <div class="col-md-6">
            <p><strong>NISN / NIK:</strong> {{ $reg->nisn }} / {{ $reg->nik }}</p>
            <p><strong>Jurusan:</strong> {{ $reg->major?->name }}</p>
            <p><strong>Jenis Pendaftaran:</strong> {{ $reg->registration_type }}</p>
            <p><strong>Status:</strong> {{ $reg->status }}</p>
        </div>
        <div class="col-md-6">
            <p><strong>Asal sekolah:</strong> {{ $reg->previous_school }}</p>
            <p><strong>HP:</strong> {{ $reg->phone }} | <strong>Email:</strong> {{ $reg->email }}</p>
            <p><strong>Ayah:</strong> {{ $reg->father_name }} | <strong>Ibu:</strong> {{ $reg->mother_name }}</p>
        </div>
    </div>
    <div class="mt-2">
        <a href="{{ route('admin.ppdb.export.pdf', $reg) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-file-earmark-pdf"></i> Export PDF</a>
    </div>
    <form method="post" action="{{ route('admin.ppdb.status', $reg) }}" class="row g-2 align-items-end mt-3 p-3 bg-body-secondary rounded">@csrf @method('put')
        <div class="col-md-4">
            <label class="form-label">Ubah status</label>
            <select name="status" class="form-select" required>
                @foreach(['pending','verified','accepted','rejected'] as $s)
                <option value="{{ $s }}" @selected($reg->status===$s)>{{ $s }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-5">
            <label class="form-label">Catatan</label>
            <input name="note" class="form-control" value="{{ old('note', $reg->note) }}">
        </div>
        <div class="col-md-2"><button class="btn btn-primary w-100">Simpan</button></div>
    </form>
    <form method="post" action="{{ route('admin.ppdb.destroy', $reg) }}" class="mt-2" onsubmit="return confirm('Hapus pendaftar?')">@csrf @method('delete')
        <button class="btn btn-sm btn-outline-danger">Hapus data</button>
    </form>
</div>
@endsection
