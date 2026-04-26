@extends('layouts.app')
@section('title', 'Ekstrakurikuler — '.config('app.name'))
@section('content')
<section class="page-hero"><div class="container"><h1 class="display-6 fw-bold">Ekstrakurikuler</h1></div></section>
<section class="py-5"><div class="container">
    <div class="row g-3">
        @foreach($extras as $x)
        <div class="col-md-4">
            <a href="{{ route('ekstrakurikuler.show', $x) }}" class="text-decoration-none text-body">
            <div class="card border-0 shadow-sm h-100 overflow-hidden">
                <div class="ratio ratio-4x3 bg-body-secondary">
                    @if($x->cover)
                    <img src="{{ asset('storage/'.$x->cover) }}" class="object-fit-cover" alt="" loading="lazy">
                    @endif
                </div>
                <div class="p-3">
                <h5 class="mb-1">{{ $x->name }}</h5>
                <span class="badge bg-primary bg-opacity-10 text-primary mb-2">{{ $x->category ?? 'Eskul' }}</span>
                <p class="small text-secondary mb-0 line-clamp-3">{{ $x->description }}</p>
                <span class="small text-primary">Baca &rarr;</span>
                </div>
            </div>
            </a>
        </div>
        @endforeach
    </div>
</div></section>
@endsection
