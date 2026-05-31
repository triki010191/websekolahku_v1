@extends('layouts.admin')
@section('title', $post->exists ? 'Edit Berita' : 'Berita Baru')
@section('admin')
<h1 class="h4 mb-3">{{ $post->exists ? 'Edit' : 'Buat' }} Berita</h1>
<form method="post" action="{{ $post->exists ? route('admin.posts.update', $post) : route('admin.posts.store') }}" enctype="multipart/form-data" class="card border-0 shadow-sm p-4" style="max-width:900px">
    @csrf
    @if($post->exists) @method('put') @endif
    <div class="mb-2"><label class="form-label">Judul *</label><input class="form-control" name="title" value="{{ old('title', $post->title) }}" required maxlength="255"></div>
    <div class="row g-2">
        <div class="col-md-6">
            <label class="form-label">Kategori</label>
            <select name="category_id" class="form-select">
                <option value="">—</option>
                @foreach($categories as $c)
                <option value="{{ $c->id }}" @selected(old('category_id', $post->category_id)==$c->id)>{{ $c->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Status *</label>
            <select name="status" class="form-select" required>
                @foreach(['draft','published','scheduled'] as $s)
                <option value="{{ $s }}" @selected(old('status', $post->status)===$s)>{{ $s }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Terbit</label>
            <input type="datetime-local" name="published_at" class="form-control" value="{{ old('published_at', $post->published_at?->format('Y-m-d\TH:i')) }}">
        </div>
    </div>
    <div class="mb-2 mt-2"><label class="form-label">Ringkasan</label><textarea name="excerpt" class="form-control" rows="2" maxlength="500">{{ old('excerpt', $post->excerpt) }}</textarea><div class="form-text">Maks. 500 karakter — tampil di daftar berita.</div></div>
    <div class="mb-2"><label class="form-label">Konten *</label><textarea name="content" class="form-control" rows="12" required>{{ old('content', $post->content) }}</textarea></div>
    <div class="mb-2"><label class="form-label">Tags (koma)</label><input class="form-control" name="tags" value="{{ old('tags', $post->tags) }}" maxlength="255"><div class="form-text">Maks. 255 karakter.</div></div>
    <div class="mb-2">
        <label class="form-label">Sampul</label>
        <input type="file" name="cover" class="form-control" accept="image/*">
        <div class="form-text">JPG, PNG, WebP. Maks. 15MB — tampil di artikel memakai <em>object-fit: cover</em> agar rapi di semua lebar layar.</div>
    </div>
    <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="f" @checked(old('is_featured', $post->is_featured))>
        <label class="form-check-label" for="f">Featured (beranda)</label>
    </div>
    <button class="btn btn-primary">Simpan</button>
    <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-secondary">Batal</a>
</form>
@endsection
