@extends('layouts.admin')
@section('title', 'Lowongan')
@section('admin')
<h1 class="h4 mb-3">{{ $job->exists ? 'Edit' : 'Lowongan baru' }}</h1>
<form method="post" action="{{ $job->exists ? route('admin.alumni-jobs.update', $job) : route('admin.alumni-jobs.store') }}" class="card border-0 shadow-sm p-4" style="max-width:800px">
    @csrf @if($job->exists) @method('put') @endif
    <div class="mb-2"><label class="form-label">Judul *</label>
        <input class="form-control" name="title" value="{{ old('title', $job->title) }}" required maxlength="255"></div>
    <div class="row g-2">
        <div class="col-md-6"><label class="form-label">Perusahaan *</label>
        <input class="form-control" name="company" value="{{ old('company', $job->company) }}" required maxlength="255"></div>
        <div class="col-md-3"><label class="form-label">Lokasi</label>
        <input class="form-control" name="location" value="{{ old('location', $job->location) }}" maxlength="255"></div>
        <div class="col-md-3"><label class="form-label">Tipe *</label>
        <select class="form-select" name="type" required>
            @foreach(['fulltime'=>'Full time','parttime'=>'Part time','internship'=>'Magang','contract'=>'Kontrak'] as $k=>$l)
            <option value="{{ $k }}" @selected(old('type', $job->type)===$k)>{{ $l }}</option>
            @endforeach
        </select></div>
    </div>
    <div class="mb-2"><label class="form-label">Rentang gaji (opsional)</label>
        <input class="form-control" name="salary_range" value="{{ old('salary_range', $job->salary_range) }}"></div>
    <div class="mb-2"><label class="form-label">Deskripsi</label>
        <textarea class="form-control" name="description" rows="5">{{ old('description', $job->description) }}</textarea></div>
    <div class="mb-2"><label class="form-label">Persyaratan</label>
        <textarea class="form-control" name="requirements" rows="4">{{ old('requirements', $job->requirements) }}</textarea></div>
    <div class="row g-2 mb-2">
        <div class="col-md-4"><label class="form-label">Email kontak</label>
        <input class="form-control" type="email" name="contact_email" value="{{ old('contact_email', $job->contact_email) }}"></div>
        <div class="col-md-4"><label class="form-label">Link lamar (URL)</label>
        <input class="form-control" name="contact_link" value="{{ old('contact_link', $job->contact_link) }}"></div>
        <div class="col-md-4"><label class="form-label">Tutup pendaftaran</label>
        <input type="date" class="form-control" name="closes_at" value="{{ old('closes_at', $job->closes_at?->format('Y-m-d')) }}"></div>
    </div>
    <div class="mb-3"><label class="form-label">Status *</label>
        <select class="form-select" name="status" required>
            @foreach(['draft'=>'Draft','active'=>'Aktif','closed'=>'Ditutup'] as $k=>$l)
            <option value="{{ $k }}" @selected(old('status', $job->status ?? 'active')===$k)>{{ $l }}</option>
            @endforeach
        </select>
    </div>
    <button class="btn btn-primary">Simpan</button>
    <a href="{{ route('admin.alumni-jobs.index') }}" class="btn btn-outline-secondary">Batal</a>
</form>
@endsection
