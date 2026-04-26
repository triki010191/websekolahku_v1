@extends('layouts.admin')
@section('title', 'File download')
@section('admin')
<h1 class="h4 mb-3">{{ $download->exists ? 'Edit' : 'Upload' }} file</h1>
<form method="post" action="{{ $download->exists ? route('admin.downloads.update', $download) : route('admin.downloads.store') }}" enctype="multipart/form-data" class="card border-0 shadow-sm p-4" style="max-width:700px">
    @csrf @if($download->exists) @method('put') @endif
    <div class="mb-2"><label class="form-label">Judul *</label>
        <input class="form-control" name="title" value="{{ old('title', $download->title) }}" required></div>
    <div class="mb-2"><label class="form-label">Kategori</label>
        <select name="category_id" class="form-select">
            <option value="">—</option>
            @foreach($categories as $c)
            <option value="{{ $c->id }}" @selected(old('category_id', $download->category_id)==$c->id)>{{ $c->name }}</option>
            @endforeach
        </select></div>
    <div class="mb-2"><label class="form-label">Deskripsi</label>
        <textarea class="form-control" name="description" rows="2">{{ old('description', $download->description) }}</textarea></div>
    <div class="mb-2"><label class="form-label">Berkas * @if($download->exists)<span class="text-secondary">(opsional ganti file)</span>@endif</label>
        <input type="file" name="file" class="form-control" @if(!$download->exists) required @endif>
        @if($download->file_path)
        <div class="form-text">
            Saat ini: {{ $download->file_path }} ({{ $download->size_human }})
            @if($download->is_public)
            <span class="d-block mt-1"><a href="{{ route('download.file', $download) }}" target="_blank" rel="noopener" class="small">Buka uji unduhan (publik)</a></span>
            @endif
        </div>
        @endif
    </div>
    <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" name="is_public" value="1" id="p" @checked(old('is_public', $download->is_public ?? true))>
        <label class="form-check-label" for="p">Tampil di halaman publik</label>
    </div>
    <button class="btn btn-primary">Simpan</button>
    <a href="{{ route('admin.downloads.index') }}" class="btn btn-outline-secondary">Batal</a>
</form>
@endsection
