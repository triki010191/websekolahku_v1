@extends('layouts.app')
@section('title', 'Event — '.config('app.name'))
@section('content')
<section class="page-hero"><div class="container"><h1 class="display-6 fw-bold">Event &amp; Agenda</h1></div></section>
<section class="py-5"><div class="container">
    <h4 class="mb-3">Mendatang</h4>
    <div class="row g-3 mb-5">
        @forelse($upcoming as $ev)
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <small class="text-primary">{{ $ev->start_at?->translatedFormat('d M Y H:i') }}</small>
                    <h5 class="mt-1"><a href="{{ route('event.show', $ev->slug) }}">{{ $ev->title }}</a></h5>
                    <p class="small text-secondary mb-0">{{ $ev->location }}</p>
                </div>
            </div>
        </div>
        @empty
        <p>Tidak ada event mendatang.</p>
        @endforelse
    </div>
    <h4 class="mb-3">Selesai</h4>
    <ul class="list-group shadow-sm">
        @foreach($past as $ev)
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>{{ $ev->title }}</span>
            <small class="text-muted">{{ $ev->start_at?->translatedFormat('M Y') }}</small>
        </li>
        @endforeach
    </ul>
</div></section>
@endsection
