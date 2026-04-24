@extends('layouts.app')
@section('title', 'Kalender — '.config('app.name'))
@section('content')
<section class="page-hero"><div class="container"><h1 class="display-6 fw-bold">Kalender Akademik</h1></div></section>
<section class="py-5"><div class="container">
    <div class="list-group shadow-sm">
        @foreach($events as $ev)
        <div class="list-group-item d-flex flex-column flex-md-row justify-content-between gap-2">
            <div>
                <strong>{{ $ev->title }}</strong>
                <div class="small text-secondary">{{ $ev->location }}</div>
            </div>
            <div class="text-md-end text-primary small">
                {{ $ev->start_at?->translatedFormat('d M Y') }}
                @if($ev->end_at) – {{ $ev->end_at?->translatedFormat('d M Y') }} @endif
            </div>
        </div>
        @endforeach
    </div>
</div></section>
@endsection
