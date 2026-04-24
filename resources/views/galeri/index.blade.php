@extends('layouts.app')
@section('title', 'Galeri — '.config('app.name'))
@section('content')
<section class="page-hero"><div class="container"><h1 class="display-6 fw-bold">Galeri Kegiatan</h1></div></section>
<section class="py-5"><div class="container">
    <div class="row g-4">
        @forelse($albums as $album)
        <div class="col-md-4 col-lg-3">
            <a href="{{ route('galeri.show', $album) }}" class="text-decoration-none text-body">
                <div class="card border-0 shadow-sm h-100">
                    <div class="ratio ratio-4x3 bg-body-secondary">
                        @if($album->cover)
                        <img src="{{ asset('storage/'.$album->cover) }}" class="object-fit-cover rounded-top" alt="">
                        @endif
                    </div>
                    <div class="card-body">
                        <h6 class="card-title mb-0">{{ $album->title }}</h6>
                        <small class="text-muted">{{ $album->items_count }} media</small>
                    </div>
                </div>
            </a>
        </div>
        @empty
        <p>Belum ada album.</p>
        @endforelse
    </div>
    <div class="mt-4">{{ $albums->links() }}</div>
</div></section>
@endsection
