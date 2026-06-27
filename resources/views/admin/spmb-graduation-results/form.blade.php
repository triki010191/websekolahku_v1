@extends('layouts.admin')
@section('title', 'Form Hasil Seleksi SPMB')
@section('admin')
<h1 class="h4 mb-3">{{ $result->exists ? 'Edit' : 'Tambah' }} Siswa Diterima</h1>
<form method="post"
      action="{{ $result->exists ? route('admin.spmb-graduation-results.update', $result) : route('admin.spmb-graduation-results.store') }}"
      class="card border-0 shadow-sm p-4"
      style="max-width:720px">
    @csrf
    @if($result->exists) @method('put') @endif

    <div class="row g-2">
        <div class="col-md-4">
            <label class="form-label">No. Urut *</label>
            <input type="number" name="sort_order" class="form-control" min="0"
                   value="{{ old('sort_order', $result->sort_order ?? 0) }}" required>
        </div>
        <div class="col-md-8">
            <label class="form-label">No. Daftar</label>
            <input type="text" name="registration_number" class="form-control" maxlength="50"
                   value="{{ old('registration_number', $result->registration_number) }}">
        </div>
    </div>

    <div class="row g-2 mt-1">
        <div class="col-md-6">
            <label class="form-label">NISN *</label>
            <input type="text" name="nisn" class="form-control" maxlength="10" pattern="\d{10}" inputmode="numeric"
                   value="{{ old('nisn', $result->nisn) }}" required>
            @error('nisn')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-6">
            <label class="form-label">Jenis Kelamin *</label>
            <select name="gender" class="form-select" required>
                <option value="L" @selected(old('gender', $result->gender ?? 'L') === 'L')>Laki-laki (L)</option>
                <option value="P" @selected(old('gender', $result->gender) === 'P')>Perempuan (P)</option>
            </select>
        </div>
    </div>

    <div class="mt-2">
        <label class="form-label">Nama Lengkap *</label>
        <input type="text" name="full_name" class="form-control" maxlength="255"
               value="{{ old('full_name', $result->full_name) }}" required>
    </div>

    <div class="mt-2">
        <label class="form-label">Asal Sekolah</label>
        <input type="text" name="origin_school" class="form-control" maxlength="255"
               value="{{ old('origin_school', $result->origin_school) }}">
    </div>

    <div class="mt-2">
        <label class="form-label">Diterima Pada Jurusan *</label>
        <select name="accepted_major" class="form-select" required>
            <option value="">— Pilih jurusan —</option>
            @foreach($majors as $major)
            <option value="{{ $major }}" @selected(old('accepted_major', $result->accepted_major) === $major)>{{ $major }}</option>
            @endforeach
        </select>
        @error('accepted_major')<div class="text-danger small">{{ $message }}</div>@enderror
    </div>

    <div class="mt-3 d-flex gap-2">
        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.spmb-graduation-results.index') }}" class="btn btn-outline-secondary">Batal</a>
    </div>
</form>
@endsection
