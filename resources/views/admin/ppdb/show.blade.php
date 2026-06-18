@extends('layouts.admin')
@section('title', 'SPMB #'.$reg->registration_number)
@section('admin')
@php $listQuery = request()->only(['form_status', 'status', 'major_id', 'search', 'page']); @endphp
<nav class="mb-2"><a href="{{ route('admin.ppdb.index', $listQuery) }}">← Kembali</a></nav>
<div class="card border-0 shadow-sm p-4">
    <h1 class="h4">{{ $reg->full_name }} <span class="badge bg-primary">{{ $reg->registration_number }}</span></h1>
    <p class="small text-secondary">No SPMB Banten: <strong>{{ $reg->spmb_banten_number }}</strong></p>
    <div class="row small">
        <div class="col-md-6">
            <p><strong>NISN / NIK:</strong> {{ $reg->nisn }} / {{ $reg->nik }}</p>
            <p><strong>Jurusan:</strong> {{ $reg->major?->name }}</p>
            <p><strong>Jenis Pendaftaran:</strong> {{ $reg->registration_type }}</p>
            <p><strong>Status:</strong> <span class="badge {{ $reg->statusBadgeClass() }}">{{ $reg->statusLabel() }}</span></p>
        </div>
        <div class="col-md-6">
            <p><strong>Asal sekolah:</strong> {{ $reg->previous_school }}</p>
            <p><strong>HP:</strong> {{ $reg->phone }} | <strong>Email:</strong> {{ $reg->email }}</p>
            <p><strong>Ayah:</strong> {{ $reg->father_name }} | <strong>Ibu:</strong> {{ $reg->mother_name }}</p>
        </div>
    </div>
    <div class="mt-2 d-flex flex-wrap gap-2">
        <a href="{{ route('admin.ppdb.export.pdf', $reg) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-file-earmark-pdf"></i> Export PDF Dapodik</a>
        @if($reg->allowsKartuTes())
        <a href="{{ route('admin.ppdb.kartu-tes', $reg) }}" class="btn btn-sm btn-primary"><i class="bi bi-printer"></i> Cetak Bukti Validasi</a>
        @endif
    </div>
    <p class="small text-secondary mb-0 mt-3"><i class="bi bi-info-circle me-1"></i>Status <strong>Perlu Revisi</strong> mengizinkan siswa memperbaiki data yang sudah dikirim tanpa menghapus isian lama. Siswa masuk lewat <em>Cek Formulir Pendaftaran</em> (NISN + tanggal lahir), lalu kirim ulang. Setelah dikirim ulang, status otomatis kembali ke <strong>Menunggu Review</strong>.</p>
    <p class="small text-secondary mb-0 mt-2"><i class="bi bi-info-circle me-1"></i>Status <strong>Data Sudah Valid</strong> berarti data formulir Dapodik sudah diverifikasi. Admin dapat mencetak <strong>Bukti Validasi</strong> untuk pendaftar.</p>
    <form method="post" action="{{ route('admin.ppdb.status', $reg) }}" class="row g-2 align-items-end mt-2 p-3 bg-body-secondary rounded">@csrf @method('put')
        <div class="col-md-4">
            <label class="form-label">Ubah status</label>
            <select name="status" class="form-select" required>
                @foreach(\App\Models\PpdbRegistration::statusLabels() as $value => $label)
                <option value="{{ $value }}" @selected($reg->status===$value)>{{ $label }}</option>
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
        @foreach($listQuery as $key => $value)
            @if($value !== null && $value !== '')
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endif
        @endforeach
        <button class="btn btn-sm btn-outline-danger">Hapus data</button>
    </form>
</div>
@endsection
