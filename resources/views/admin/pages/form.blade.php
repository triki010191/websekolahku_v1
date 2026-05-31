@extends('layouts.admin')
@section('title', $page->exists ? 'Edit Halaman' : 'Halaman Baru')
@section('admin')
<h1 class="h4 mb-3">{{ $page->exists ? 'Edit Halaman' : 'Halaman Baru' }}</h1>
<form method="post" action="{{ $page->exists ? route('admin.pages.update', $page) : route('admin.pages.store') }}" class="card border-0 shadow-sm p-4" style="max-width:900px">
    @csrf
    @if($page->exists) @method('put') @endif
    <div class="mb-2">
        <label class="form-label">Judul *</label>
        <input class="form-control" name="title" value="{{ old('title', $page->title) }}" required>
    </div>
    <div class="mb-2">
        <label class="form-label">Slug (URL) *</label>
        <input class="form-control" name="slug" value="{{ old('slug', $page->slug) }}" required placeholder="contoh: spmb-2026">
        <div class="form-text">Halaman SPMB menggunakan slug <code>spmb-2026</code> → URL <code>/spmb-2026</code>. Halaman profil → <code>/profil/{slug}</code>.</div>
    </div>
    <div class="mb-2">
        <label class="form-label">Isi konten *</label>
        <textarea name="content" class="form-control font-monospace" rows="16" required>{{ old('content', $page->content) }}</textarea>
        <div class="form-text">HTML diperbolehkan: &lt;h4&gt;, &lt;p&gt;, &lt;ul&gt;, &lt;ol&gt;, &lt;strong&gt;, dll.</div>
    </div>
    <div class="row g-2">
        <div class="col-md-6">
            <label class="form-label">Meta title (SEO)</label>
            <input class="form-control" name="meta_title" value="{{ old('meta_title', $page->meta_title) }}">
        </div>
        <div class="col-md-6">
            <label class="form-label">Meta description (SEO)</label>
            <input class="form-control" name="meta_description" value="{{ old('meta_description', $page->meta_description) }}">
        </div>
    </div>
    <div class="form-check mt-3">
        <input class="form-check-input" type="checkbox" name="is_published" value="1" id="isPublished" @checked(old('is_published', $page->is_published ?? true))>
        <label class="form-check-label" for="isPublished">Tampilkan di website (publik)</label>
    </div>
    <div class="mt-3">
        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.pages.index') }}" class="btn btn-outline-secondary">Batal</a>
    </div>
</form>
@endsection
