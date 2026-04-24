@extends('layouts.admin')
@section('title', 'Guru')
@section('admin')
<h1 class="h4 mb-3">Data Guru / TU</h1>
<form method="post" action="{{ $teacher->exists ? route('admin.teachers.update', $teacher) : route('admin.teachers.store') }}" enctype="multipart/form-data" class="card border-0 shadow-sm p-4" style="max-width:700px">
    @csrf
    @if($teacher->exists) @method('put') @endif
    <div class="row g-2">
        <div class="col-md-6"><label class="form-label">Nama *</label><input class="form-control" name="name" value="{{ old('name', $teacher->name) }}" required></div>
        <div class="col-md-3"><label class="form-label">JK *</label>
            <select name="gender" class="form-select" required>
                <option value="L" @selected(old('gender', $teacher->gender)==='L')>L</option>
                <option value="P" @selected(old('gender', $teacher->gender)==='P')>P</option>
            </select>
        </div>
        <div class="col-md-3"><label class="form-label">NIP</label><input class="form-control" name="nip" value="{{ old('nip', $teacher->nip) }}"></div>
    </div>
    <div class="row g-2 mt-1">
        <div class="col-md-6"><label class="form-label">Posisi / Jabatan *</label><input class="form-control" name="position" value="{{ old('position', $teacher->position) }}" required></div>
        <div class="col-md-6"><label class="form-label">Mapel</label><input class="form-control" name="subject" value="{{ old('subject', $teacher->subject) }}"></div>
    </div>
    <div class="row g-2">
        <div class="col-md-4">
            <label class="form-label">Status *</label>
            <select name="employment_status" class="form-select" required>
                @foreach(['pns','pppk','honorer'] as $e)
                <option value="{{ $e }}" @selected(old('employment_status', $teacher->employment_status)===$e)>{{ strtoupper($e) }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4"><label class="form-label">Bidang</label><input class="form-control" name="field" value="{{ old('field', $teacher->field) }}"></div>
    </div>
    <div class="mb-2"><label class="form-label">Bio</label><textarea name="bio" class="form-control" rows="3">{{ old('bio', $teacher->bio) }}</textarea></div>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="ia" @checked(old('is_active', $teacher->is_active ?? true))>
        <label class="form-check-label" for="ia">Aktif</label>
    </div>
    <div class="mb-2"><label class="form-label">Foto</label><input type="file" name="photo" class="form-control" accept="image/*"></div>
    <button class="btn btn-primary">Simpan</button>
</form>
@endsection
