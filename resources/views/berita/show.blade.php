@extends('layouts.app')
@section('title', $post->title)
@section('description', \Illuminate\Support\Str::limit(strip_tags($post->excerpt ?? $post->content), 160))
@section('content')
<section class="py-5 bg-body-secondary"><div class="container">
    <nav aria-label="breadcrumb"><ol class="breadcrumb mb-3">
        <li class="breadcrumb-item"><a href="{{ route('berita.index') }}">Berita</a></li>
        <li class="breadcrumb-item active">{{ $post->title }}</li>
    </ol></nav>
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <span class="badge bg-primary">{{ $post->category?->name }}</span>
            <h1 class="fw-bold mt-2">{{ $post->title }}</h1>
            <p class="text-secondary small">{{ optional($post->published_at)->translatedFormat('d F Y') }} · {{ $post->author?->name }}</p>
            <img src="{{ $post->cover_url }}" class="img-fluid rounded-3 w-100 mb-4" style="object-fit:cover;max-height:min(70vh,520px);width:100%" alt="">
            <article class="card border-0 shadow-sm p-4">
                <div class="prose">{!! $post->content !!}</div>
                @if($post->tags)
                <div class="mt-3"><small class="text-muted">Tag: {{ $post->tags }}</small></div>
                @endif
            </article>
            <h5 class="mt-5 mb-3">Berita terkait</h5>
            <div class="row g-3">
                @foreach($related as $r)
                <div class="col-md-4">
                    <a href="{{ route('berita.show', $r->slug) }}" class="text-decoration-none text-body small fw-semibold">{{ $r->title }}</a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div></section>
@endsection
