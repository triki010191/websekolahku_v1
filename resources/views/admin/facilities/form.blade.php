@extends('layouts.admin')
@section('title', 'Fasilitas')
@section('admin')
<h1 class="h4 mb-3">{{ $facility->exists ? 'Edit' : 'Fasilitas baru' }}</h1>
<form method="post" action="{{ $facility->exists ? route('admin.facilities.update', $facility) : route('admin.facilities.store') }}" enctype="multipart/form-data" class="card border-0 shadow-sm p-4" style="max-width:800px">
    @csrf @if($facility->exists) @method('put') @endif
    <div class="mb-2"><label class="form-label">Nama *</label>
        <input class="form-control" name="name" value="{{ old('name', $facility->name) }}" required maxlength="255"></div>
    <div class="row g-2">
        <div class="col-md-6"><label class="form-label">Slug (opsional)</label>
        <input class="form-control" name="slug" value="{{ old('slug', $facility->slug) }}" maxlength="255"></div>
        <div class="col-md-3"><label class="form-label">Icon (emoji/class)</label>
        <input class="form-control" name="icon" value="{{ old('icon', $facility->icon) }}" maxlength="50"></div>
        <div class="col-md-3"><label class="form-label">Urutan</label>
        <input type="number" class="form-control" name="sort_order" value="{{ old('sort_order', $facility->sort_order) }}"></div>
    </div>
    <div class="mb-2"><label class="form-label">Ringkasan</label>
        <textarea class="form-control" name="description" rows="2" maxlength="2000">{{ old('description', $facility->description) }}</textarea>
        <div class="form-text">Maks. 2000 karakter.</div></div>
    <div class="mb-2"><label class="form-label">Konten (HTML, seperti berita)</label>
        <textarea class="form-control" name="content" rows="10">{{ old('content', $facility->content) }}</textarea>
        <div class="form-text">Boleh tag HTML sederhana dari sumber tepercaya (admin).</div></div>
    <div class="mb-2"><label class="form-label">Gambar</label>
        <input type="file" class="form-control" name="cover" accept="image/*">
        @if($facility->cover)
        <img src="{{ asset('storage/'.$facility->cover) }}" class="img-thumbnail mt-1" style="max-height:120px" alt="">
        @endif
    </div>
    <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="a" @checked(old('is_active', $facility->is_active ?? true))>
        <label class="form-check-label" for="a">Aktif</label>
    </div>
    <button class="btn btn-primary">Simpan</button>
    <a href="{{ route('admin.facilities.index') }}" class="btn btn-outline-secondary">Batal</a>
</form>
@endsection
