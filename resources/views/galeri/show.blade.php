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
            @php $imgUrl = public_storage_url($item->url); @endphp
            @if($imgUrl)
            <a href="{{ $imgUrl }}" target="_blank" rel="noopener" class="d-block">
                <img src="{{ $imgUrl }}" class="img-fluid rounded w-100 shadow-sm" alt="" loading="lazy" style="object-fit:cover;aspect-ratio:1">
            </a>
            @else
            <div class="ratio ratio-1x1 bg-body-secondary rounded d-flex align-items-center justify-content-center text-muted small">Tidak ada file</div>
            @endif
            @endif
        </div>
        @endforeach
    </div>
</div></section>
@endsection
