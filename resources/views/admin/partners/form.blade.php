@extends('layouts.admin')
@section('title', 'Mitra')
@section('admin')
<h1 class="h4 mb-3">{{ $partner->exists ? 'Edit' : 'Mitra baru' }}</h1>
<form method="post" action="{{ $partner->exists ? route('admin.partners.update', $partner) : route('admin.partners.store') }}" enctype="multipart/form-data" class="card border-0 shadow-sm p-4" style="max-width:800px">
    @csrf @if($partner->exists) @method('put') @endif
    <div class="mb-2"><label class="form-label">Nama *</label>
        <input class="form-control" name="name" value="{{ old('name', $partner->name) }}" required></div>
    <div class="row g-2">
        <div class="col-md-6"><label class="form-label">Slug</label>
        <input class="form-control" name="slug" value="{{ old('slug', $partner->slug) }}"></div>
        <div class="col-md-3"><label class="form-label">Industri</label>
        <input class="form-control" name="industry" value="{{ old('industry', $partner->industry) }}"></div>
        <div class="col-md-3"><label class="form-label">Urutan</label>
        <input type="number" class="form-control" name="sort_order" value="{{ old('sort_order', $partner->sort_order) }}"></div>
    </div>
    <div class="mb-2"><label class="form-label">Website</label>
        <input class="form-control" name="website" value="{{ old('website', $partner->website) }}" placeholder="https://"></div>
    <div class="mb-2"><label class="form-label">Deskripsi (HTML diperbolehkan)</label>
        <textarea class="form-control" name="description" rows="6">{{ old('description', $partner->description) }}</textarea></div>
    <div class="row g-2 mb-2">
        <div class="col-md-4"><label class="form-label">No. MOU</label>
        <input class="form-control" name="mou_number" value="{{ old('mou_number', $partner->mou_number) }}"></div>
        <div class="col-md-4"><label class="form-label">MOU mulai</label>
        <input type="date" class="form-control" name="mou_start" value="{{ old('mou_start', $partner->mou_start?->format('Y-m-d')) }}"></div>
        <div class="col-md-4"><label class="form-label">MOU s/d</label>
        <input type="date" class="form-control" name="mou_end" value="{{ old('mou_end', $partner->mou_end?->format('Y-m-d')) }}"></div>
    </div>
    <div class="mb-2"><label class="form-label">Logo</label>
        <input type="file" class="form-control" name="logo" accept="image/*">
        @if($partner->logo)
        <img src="{{ asset('storage/'.$partner->logo) }}" class="img-thumbnail mt-1" style="max-height:64px" alt="">
        @endif
    </div>
    <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="act" @checked(old('is_active', $partner->is_active ?? true))>
        <label class="form-check-label" for="act">Aktif</label>
    </div>
    <button class="btn btn-primary">Simpan</button>
    <a href="{{ route('admin.partners.index') }}" class="btn btn-outline-secondary">Batal</a>
</form>
@endsection
