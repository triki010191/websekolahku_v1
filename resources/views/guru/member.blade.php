@extends('layouts.app')
@section('title', 'Profil Saya — Guru & TU')
@section('content')
<section class="page-hero"><div class="container">
    <h1 class="display-6 fw-bold">Profil Saya</h1>
    <p class="mb-0 opacity-75">Kelola data profil yang tampil di halaman Guru &amp; TU</p>
</div></section>

<section class="py-5"><div class="container" style="max-width:760px">
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0 small">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if(!$teacher)
    <div class="alert alert-warning">
        Akun login Anda belum terhubung ke data guru/TU. Hubungi administrator untuk menghubungkan profil.
    </div>
    @else
    <div class="d-flex flex-wrap gap-2 mb-3">
        @if($teacher->slug)
        <a href="{{ route('guru.show', $teacher) }}" class="btn btn-outline-primary btn-sm" target="_blank">
            <i class="bi bi-eye me-1"></i> Lihat profil publik
        </a>
        @endif
        <form method="post" action="{{ route('logout') }}" class="d-inline">
            @csrf
            <button class="btn btn-outline-secondary btn-sm">Keluar</button>
        </form>
    </div>

    <form method="post" action="{{ route('guru.member.profile.update') }}" enctype="multipart/form-data" class="card border-0 shadow-sm p-4">
        @csrf

        <div class="text-center mb-4">
            <img src="{{ $teacher->photo_url }}" alt="" class="guru-profile-photo rounded-circle border border-3 border-white shadow mb-2" width="120" height="120">
        </div>

        <div class="row g-2">
            <div class="col-md-8">
                <label class="form-label">Nama Lengkap &amp; Gelar *</label>
                <input class="form-control" name="name" value="{{ old('name', $teacher->name) }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">NIP / NUPTK</label>
                <input class="form-control" name="nip" value="{{ old('nip', $teacher->nip) }}">
            </div>
        </div>
        <div class="row g-2 mt-1">
            <div class="col-md-6">
                <label class="form-label">Jabatan *</label>
                <input class="form-control" name="position" value="{{ old('position', $teacher->position) }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Mata Pelajaran</label>
                <input class="form-control" name="subject" value="{{ old('subject', $teacher->subject) }}">
            </div>
        </div>
        <div class="row g-2 mt-1">
            <div class="col-md-6">
                <label class="form-label">Pendidikan Terakhir</label>
                <input class="form-control" name="education" value="{{ old('education', $teacher->education) }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Email Sekolah</label>
                <input type="email" class="form-control" name="email" value="{{ old('email', $teacher->email) }}">
            </div>
        </div>
        <div class="row g-2 mt-1">
            <div class="col-md-6">
                <label class="form-label">No. HP</label>
                <input class="form-control" name="phone" value="{{ old('phone', $teacher->phone) }}">
            </div>
        </div>
        <div class="mb-2 mt-1">
            <label class="form-label">Moto Hidup / Quote</label>
            <textarea name="motto" class="form-control" rows="2" maxlength="500">{{ old('motto', $teacher->motto) }}</textarea>
        </div>
        <div class="mb-2">
            <label class="form-label">Bio tambahan</label>
            <textarea name="bio" class="form-control" rows="3">{{ old('bio', $teacher->bio) }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Foto Profil</label>
            <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror" accept="image/jpeg,image/png,image/webp">
            <div class="form-text">JPG, PNG, WEBP — maks. 5 MB. Ukuran disarankan <strong>400×400 px</strong> (persegi).</div>
            @error('photo')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
        </div>

        <button class="btn btn-primary">Simpan Perubahan</button>
    </form>
    @endif
</div></section>
@endsection
