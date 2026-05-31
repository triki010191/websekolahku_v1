@extends('layouts.admin')
@section('title', $teacher->exists ? 'Edit Guru' : 'Tambah Guru')
@section('admin')
<h1 class="h4 mb-3">{{ $teacher->exists ? 'Edit' : 'Tambah' }} Guru / TU</h1>
@if($teacher->exists && $teacher->slug)
<p class="small text-secondary mb-3">Profil publik: <a href="{{ route('guru.show', $teacher) }}" target="_blank">{{ route('guru.show', $teacher) }}</a></p>
@endif
<form method="post" action="{{ $teacher->exists ? route('admin.teachers.update', $teacher) : route('admin.teachers.store') }}" enctype="multipart/form-data" class="card border-0 shadow-sm p-4" style="max-width:760px">
    @csrf
    @if($teacher->exists) @method('put') @endif

    <h6 class="fw-bold text-primary mb-3">Informasi Utama (tampil di profil publik)</h6>
    <div class="row g-2">
        <div class="col-md-8">
            <label class="form-label">Nama Lengkap &amp; Gelar *</label>
            <input class="form-control" name="name" value="{{ old('name', $teacher->name) }}" placeholder="Contoh: Drs. Ahmad Fauzi, M.Pd." required>
        </div>
        <div class="col-md-4">
            <label class="form-label">NIP / NUPTK</label>
            <input class="form-control" name="nip" value="{{ old('nip', $teacher->nip) }}" placeholder="Opsional">
        </div>
    </div>
    <div class="row g-2 mt-1">
        <div class="col-md-6">
            <label class="form-label">Jabatan *</label>
            <input class="form-control" name="position" value="{{ old('position', $teacher->position) }}" placeholder="Contoh: Guru Produktif, Waka Kurikulum" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Mata Pelajaran yang Diampu</label>
            <input class="form-control" name="subject" value="{{ old('subject', $teacher->subject) }}" placeholder="Contoh: Matematika, Pemrograman Web">
        </div>
    </div>
    <div class="row g-2 mt-1">
        <div class="col-md-6">
            <label class="form-label">Pendidikan Terakhir</label>
            <input class="form-control" name="education" value="{{ old('education', $teacher->education) }}" placeholder="Contoh: S1 Pendidikan Matematika — UNJ">
        </div>
        <div class="col-md-6">
            <label class="form-label">Email Sekolah</label>
            <input type="email" class="form-control" name="email" value="{{ old('email', $teacher->email) }}" placeholder="nama@smkn8pandeglang.sch.id">
        </div>
    </div>
    <div class="mb-2 mt-1">
        <label class="form-label">Moto Hidup / Quote Pribadi</label>
        <textarea name="motto" class="form-control" rows="2" maxlength="500" placeholder="Kutipan singkat yang ditampilkan di profil">{{ old('motto', $teacher->motto) }}</textarea>
    </div>
    <div class="mb-3">
        <label class="form-label">Foto Guru</label>
        <input type="file" name="photo" class="form-control" accept="image/*">
        @if($teacher->photo)
        <img src="{{ asset('storage/'.$teacher->photo) }}" class="img-thumbnail mt-2" style="max-height:120px" alt="">
        @endif
    </div>

    <hr class="my-4">
    <h6 class="fw-bold text-secondary mb-3">Data Tambahan</h6>
    <div class="row g-2">
        <div class="col-md-3">
            <label class="form-label">Jenis Kelamin *</label>
            <select name="gender" class="form-select" required>
                <option value="L" @selected(old('gender', $teacher->gender)==='L')>Laki-laki</option>
                <option value="P" @selected(old('gender', $teacher->gender)==='P')>Perempuan</option>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Status Kepegawaian *</label>
            <select name="employment_status" class="form-select" required>
                @foreach(['pns'=>'PNS','pppk'=>'PPPK','honorer'=>'Honorer'] as $val => $label)
                <option value="{{ $val }}" @selected(old('employment_status', $teacher->employment_status)===$val)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Bidang / Jurusan</label>
            <input class="form-control" name="field" value="{{ old('field', $teacher->field) }}" placeholder="rpl, akl, tu, ...">
        </div>
        <div class="col-md-3">
            <label class="form-label">No. HP</label>
            <input class="form-control" name="phone" value="{{ old('phone', $teacher->phone) }}">
        </div>
    </div>
    <div class="row g-2 mt-1">
        <div class="col-md-3">
            <label class="form-label">Urutan tampil</label>
            <input type="number" class="form-control" name="sort_order" value="{{ old('sort_order', $teacher->sort_order ?? 0) }}" min="0">
        </div>
    </div>
    <div class="mb-2 mt-1">
        <label class="form-label">Bio / Keterangan tambahan</label>
        <textarea name="bio" class="form-control" rows="3" placeholder="Opsional — ditampilkan di bawah profil">{{ old('bio', $teacher->bio) }}</textarea>
    </div>
    <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="ia" @checked(old('is_active', $teacher->is_active ?? true))>
        <label class="form-check-label" for="ia">Tampilkan di website</label>
    </div>

    <div class="d-flex gap-2">
        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.teachers.index') }}" class="btn btn-outline-secondary">Batal</a>
    </div>
</form>
@endsection
