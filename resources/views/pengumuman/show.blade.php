@extends('layouts.app')
@section('title', $announcement->title)
@section('content')
<section class="py-5"><div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <nav aria-label="breadcrumb" class="mb-3"><ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('pengumuman.index') }}">Pengumuman</a></li>
                <li class="breadcrumb-item active">{{ $announcement->title }}</li>
            </ol></nav>
            <article class="card border-0 shadow-sm p-4 p-md-5">
                <h1 class="h3 fw-bold">{{ $announcement->title }}</h1>
                <p class="text-secondary small">{{ $announcement->published_at?->translatedFormat('d F Y') }}</p>
                <div class="prose mt-3">{!! $announcement->content !!}</div>
                @if($announcement->attachment)
                <a href="{{ asset('storage/'.$announcement->attachment) }}" class="btn btn-outline-primary mt-3" target="_blank">Lampiran</a>
                @endif
            </article>
        </div>
    </div>
</div></section>
@endsection
