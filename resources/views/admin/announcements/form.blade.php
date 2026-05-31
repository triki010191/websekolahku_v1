@extends('layouts.admin')
@section('title', 'Form Pengumuman')
@section('admin')
<h1 class="h4 mb-3">Pengumuman</h1>
<form method="post" action="{{ $announcement->exists ? route('admin.announcements.update', $announcement) : route('admin.announcements.store') }}" class="card border-0 shadow-sm p-4" style="max-width:800px">
    @csrf
    @if($announcement->exists) @method('put') @endif
    <div class="mb-2"><label class="form-label">Judul *</label><input class="form-control" name="title" value="{{ old('title', $announcement->title) }}" required maxlength="255"></div>
    <div class="row g-2">
        <div class="col-md-6">
            <label class="form-label">Kategori</label>
            <select name="category_id" class="form-select">
                <option value="">—</option>
                @foreach($categories as $c)
                <option value="{{ $c->id }}" @selected(old('category_id', $announcement->category_id)==$c->id)>{{ $c->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Prioritas *</label>
            <select name="priority" class="form-select" required>
                @foreach(['normal','important','urgent'] as $p)
                <option value="{{ $p }}" @selected(old('priority', $announcement->priority)===$p)>{{ $p }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Status *</label>
            <select name="status" class="form-select" required>
                @foreach(['draft','active','archived'] as $s)
                <option value="{{ $s }}" @selected(old('status', $announcement->status)===$s)>{{ $s }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row g-2 mt-1">
        <div class="col-md-6"><label class="form-label">Terbit *</label><input type="date" name="published_at" class="form-control" value="{{ old('published_at', $announcement->published_at?->format('Y-m-d')) }}" required></div>
        <div class="col-md-6"><label class="form-label">Berlaku s/d</label><input type="date" name="expires_at" class="form-control" value="{{ old('expires_at', $announcement->expires_at?->format('Y-m-d')) }}"></div>
    </div>
    <div class="mb-2 mt-2"><label class="form-label">Isi *</label><textarea name="content" class="form-control" rows="8" required>{{ old('content', $announcement->content) }}</textarea></div>
    <button class="btn btn-primary">Simpan</button>
    <a href="{{ route('admin.announcements.index') }}" class="btn btn-outline-secondary">Batal</a>
</form>
@endsection
