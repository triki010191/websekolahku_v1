@extends('layouts.app')
@section('title', $album->title.' — Galeri')
@section('content')
<section class="page-hero"><div class="container">
    <h1 class="display-6 fw-bold">{{ $album->title }}</h1>
    <p class="mb-0 opacity-75">{{ $album->description }}</p>
</div></section>
<section class="py-5"><div class="container">
    <div class="row g-2">
        @foreach($album->items as $item)
        <div class="col-6 col-md-4 col-lg-3">
            @if($item->type==='video')
            <div class="ratio ratio-1x1 bg-dark rounded d-flex align-items-center justify-content-center text-white">Video</div>
            @else
            <a href="{{ asset('storage/'.$item->url) }}" target="_blank" class="d-block">
                <img src="{{ asset('storage/'.$item->url) }}" class="img-fluid rounded w-100 shadow-sm" alt="">
            </a>
            @endif
        </div>
        @endforeach
    </div>
</div></section>
@endsection
