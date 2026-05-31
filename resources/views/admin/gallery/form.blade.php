@extends('layouts.admin')
@section('title', 'Album Galeri')
@section('admin')
<h1 class="h4 mb-3">{{ $album->exists ? 'Edit' : 'Album Baru' }}</h1>
<form method="post" action="{{ $album->exists ? route('admin.gallery.update', $album) : route('admin.gallery.store') }}" enctype="multipart/form-data" class="card border-0 shadow-sm p-4 mb-3" style="max-width:700px">
    @csrf
    @if($album->exists) @method('put') @endif
    <div class="mb-2"><label class="form-label">Judul *</label><input class="form-control" name="title" value="{{ old('title', $album->title) }}" required maxlength="255"></div>
    <div class="mb-2"><label class="form-label">Deskripsi</label><textarea name="description" class="form-control" rows="2" maxlength="2000">{{ old('description', $album->description) }}</textarea><div class="form-text">Maks. 2000 karakter.</div></div>
    <div class="form-check mb-2">
        <input class="form-check-input" type="checkbox" name="is_published" value="1" id="ip" @checked(old('is_published', $album->is_published ?? true))>
        <label class="form-check-label" for="ip">Publik</label>
    </div>
    <div class="mb-2"><label class="form-label">Cover</label><input type="file" name="cover" class="form-control" accept="image/*"></div>
    <button class="btn btn-primary">Simpan</button>
    <a href="{{ route('admin.gallery.index') }}" class="btn btn-outline-secondary">Kembali</a>
</form>

@if($album->exists)
<div class="card border-0 shadow-sm p-4">
    <h6 class="mb-2">Tambah foto (multi)</h6>
    <form method="post" action="{{ route('admin.gallery.items.store', $album) }}" enctype="multipart/form-data" class="d-flex gap-2 flex-wrap">
        @csrf
        <input type="file" name="images[]" class="form-control" accept="image/*" multiple required>
        <button class="btn btn-outline-primary">Upload</button>
    </form>
    <p class="small text-secondary mb-0 mt-1">Beberapa file sekaligus. Maks. 15MB per gambar. Publik: jenis <code>object-fit: cover</code>.</p>
    <div class="row g-2 mt-3">
        @foreach($album->items ?? [] as $item)
        <div class="col-3">
            <div class="position-relative">
                <img src="{{ asset('storage/'.$item->url) }}" class="w-100 rounded" style="aspect-ratio:1;object-fit:cover" alt="">
                <form method="post" action="{{ route('admin.gallery.items.destroy', $item) }}" class="position-absolute top-0 end-0" onsubmit="return confirm('Hapus?')">@csrf @method('delete')
                    <button class="btn btn-sm btn-danger">×</button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif
@endsection
