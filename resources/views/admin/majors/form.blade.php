@extends('layouts.admin')
@section('title', 'Jurusan')
@section('admin')
<h1 class="h4 mb-3">Jurusan</h1>
<form method="post" action="{{ $major->exists ? route('admin.majors.update', $major) : route('admin.majors.store') }}" enctype="multipart/form-data" class="card border-0 shadow-sm p-4" style="max-width:800px">
    @csrf
    @if($major->exists) @method('put') @endif
    <div class="row g-2">
        <div class="col-md-2"><label class="form-label">Kode *</label><input class="form-control" name="code" value="{{ old('code', $major->code) }}" required maxlength="10"></div>
        <div class="col-md-5"><label class="form-label">Nama *</label><input class="form-control" name="name" value="{{ old('name', $major->name) }}" required maxlength="255"></div>
        <div class="col-md-5"><label class="form-label">Slug</label><input class="form-control" name="slug" value="{{ old('slug', $major->slug) }}" maxlength="255"></div>
    </div>
    <div class="mb-2"><label class="form-label">Tagline</label><input class="form-control" name="tagline" value="{{ old('tagline', $major->tagline) }}" maxlength="500"><div class="form-text">Maks. 500 karakter.</div></div>
    <div class="mb-2"><label class="form-label">Deskripsi</label><textarea name="description" class="form-control" rows="3">{{ old('description', $major->description) }}</textarea></div>
    <div class="mb-2"><label class="form-label">Kurikulum (HTML ok)</label><textarea name="curriculum" class="form-control" rows="4">{{ old('curriculum', $major->curriculum) }}</textarea></div>
    <div class="row g-2">
        <div class="col-md-4"><label class="form-label">Kaprog</label><input class="form-control" name="head_teacher" value="{{ old('head_teacher', $major->head_teacher) }}" maxlength="255"></div>
        <div class="col-md-2"><label class="form-label">Siswa aktif</label><input type="number" class="form-control" name="student_count" value="{{ old('student_count', $major->student_count) }}"></div>
        <div class="col-md-2"><label class="form-label">Kapasitas jurusan</label><input type="number" class="form-control" name="quota" value="{{ old('quota', $major->quota) }}"><div class="form-text">Total siswa di jurusan (bukan SPMB)</div></div>
        <div class="col-md-2"><label class="form-label">Kuota SPMB Kelas X *</label><input type="number" class="form-control" name="spmb_quota" value="{{ old('spmb_quota', $major->spmb_quota) }}" min="0"><div class="form-text">Penerimaan siswa baru di halaman SPMB</div></div>
        <div class="col-md-2"><label class="form-label">Urut</label><input type="number" class="form-control" name="sort_order" value="{{ old('sort_order', $major->sort_order) }}"></div>
    </div>
    <div class="form-check mt-2">
        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="act" @checked(old('is_active', $major->is_active ?? true))>
        <label class="form-check-label" for="act">Aktif (tampil di web)</label>
    </div>
    <div class="mb-2 mt-2"><label class="form-label">Cover</label><input type="file" name="cover" class="form-control" accept="image/*"></div>
    <button class="btn btn-primary">Simpan</button>
</form>
@endsection
