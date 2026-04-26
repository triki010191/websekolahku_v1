@extends('layouts.admin')
@section('title', 'Ekstrakurikuler')
@section('admin')
<h1 class="h4 mb-3">{{ $x->exists ? 'Edit' : 'Eskul baru' }}</h1>
<form method="post" action="{{ $x->exists ? route('admin.extracurriculars.update', $x) : route('admin.extracurriculars.store') }}" enctype="multipart/form-data" class="card border-0 shadow-sm p-4" style="max-width:800px">
    @csrf @if($x->exists) @method('put') @endif
    <div class="mb-2"><label class="form-label">Nama *</label>
        <input class="form-control" name="name" value="{{ old('name', $x->name) }}" required></div>
    <div class="row g-2">
        <div class="col-md-6"><label class="form-label">Slug</label>
        <input class="form-control" name="slug" value="{{ old('slug', $x->slug) }}"></div>
        <div class="col-md-3"><label class="form-label">Kategori</label>
        <input class="form-control" name="category" value="{{ old('category', $x->category) }}"></div>
        <div class="col-md-3"><label class="form-label">Urutan</label>
        <input type="number" class="form-control" name="sort_order" value="{{ old('sort_order', $x->sort_order) }}"></div>
    </div>
    <div class="mb-2"><label class="form-label">Deskripsi singkat</label>
        <textarea class="form-control" name="description" rows="2">{{ old('description', $x->description) }}</textarea></div>
    <div class="mb-2"><label class="form-label">Konten (HTML)</label>
        <textarea class="form-control" name="content" rows="10">{{ old('content', $x->content) }}</textarea></div>
    <div class="row g-2 mb-2">
        <div class="col-md-6"><label class="form-label">Pembina</label>
        <input class="form-control" name="coach" value="{{ old('coach', $x->coach) }}"></div>
        <div class="col-md-3"><label class="form-label">Jadwal</label>
        <input class="form-control" name="schedule" value="{{ old('schedule', $x->schedule) }}"></div>
        <div class="col-md-3"><label class="form-label">Jumlah anggota</label>
        <input type="number" class="form-control" name="member_count" value="{{ old('member_count', $x->member_count) }}"></div>
    </div>
    <div class="mb-2"><label class="form-label">Gambar</label>
        <input type="file" class="form-control" name="cover" accept="image/*">
        @if($x->cover)
        <img src="{{ asset('storage/'.$x->cover) }}" class="img-thumbnail mt-1" style="max-height:100px" alt="">
        @endif
    </div>
    <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="act" @checked(old('is_active', $x->is_active ?? true))>
        <label class="form-check-label" for="act">Aktif</label>
    </div>
    <button class="btn btn-primary">Simpan</button>
    <a href="{{ route('admin.extracurriculars.index') }}" class="btn btn-outline-secondary">Batal</a>
</form>
@endsection
