@extends('layouts.admin')
@section('title', $slide->exists ? 'Edit slide' : 'Slide baru')
@section('admin')
<h1 class="h4 mb-3">{{ $slide->exists ? 'Edit slide' : 'Slide baru' }}</h1>
<form method="post" action="{{ $slide->exists ? route('admin.hero-slides.update', $slide) : route('admin.hero-slides.store') }}" enctype="multipart/form-data" class="card border-0 shadow-sm p-4" style="max-width:700px">
    @csrf
    @if($slide->exists) @method('put') @endif
    <div class="mb-3">
        <label class="form-label">Judul *</label>
        <input class="form-control" name="title" value="{{ old('title', $slide->title) }}" required maxlength="255">
    </div>
    <div class="mb-3">
        <label class="form-label">Subjudul / deskripsi singkat</label>
        <textarea class="form-control" name="subtitle" rows="2" maxlength="500">{{ old('subtitle', $slide->subtitle) }}</textarea>
    </div>
    <div class="mb-3">
        <label class="form-label">Gambar * @if($slide->exists) <span class="text-secondary fw-normal">(kosongkan jika tidak diganti)</span> @endif</label>
        <input type="file" class="form-control" name="image" accept="image/*" {{ $slide->exists ? '' : 'required' }}>
        <div class="form-text">JPG, PNG, WebP. Maks. 15MB — tampilan di web otomatis menyesuaikan (crop center).</div>
        @if($slide->image)
            <div class="mt-2">
                <img src="{{ asset('storage/'.$slide->image) }}" alt="" class="rounded border" style="max-width:100%;max-height:200px;object-fit:contain">
            </div>
        @endif
    </div>
    <div class="row g-2 mb-3">
        <div class="col-md-6">
            <label class="form-label">Teks tombol (opsional)</label>
            <input class="form-control" name="button_text" value="{{ old('button_text', $slide->button_text) }}" placeholder="Baca selengkapnya">
        </div>
        <div class="col-md-6">
            <label class="form-label">Link tombol (opsional)</label>
            <input class="form-control" name="button_url" value="{{ old('button_url', $slide->button_url) }}" placeholder="https://...">
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label">Urutan</label>
        <input type="number" class="form-control" name="sort_order" value="{{ old('sort_order', $slide->sort_order) }}" min="0" max="9999" style="max-width:120px">
    </div>
    <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="act" @checked(old('is_active', $slide->is_active ?? true))>
        <label class="form-check-label" for="act">Tampilkan di beranda</label>
    </div>
    <button class="btn btn-primary">Simpan</button>
    <a href="{{ route('admin.hero-slides.index') }}" class="btn btn-outline-secondary">Batal</a>
</form>
@endsection
