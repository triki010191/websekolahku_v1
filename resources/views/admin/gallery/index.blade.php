@extends('layouts.admin')
@section('title', 'Galeri')
@section('admin')
<div class="d-flex justify-content-between mb-3">
    <h1 class="h4">Album Galeri</h1>
    <a href="{{ route('admin.gallery.create') }}" class="btn btn-primary btn-sm">+ Album</a>
</div>
<div class="row g-3">
    @foreach($albums as $a)
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            @if($a->cover)
            <img src="{{ asset('storage/'.$a->cover) }}" class="card-img-top" style="height:120px;object-fit:cover" alt="">
            @endif
            <div class="card-body">
                <h6 class="card-title mb-0">{{ $a->title }}</h6>
                <small class="text-muted">{{ $a->items_count }} file</small>
                <div class="mt-2">
                    <a href="{{ route('admin.gallery.edit', $a) }}" class="btn btn-sm btn-primary">Kelola</a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
{{ $albums->links() }}
@endsection
