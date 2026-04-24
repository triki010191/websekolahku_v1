@extends('layouts.app')
@section('title', $event->title)
@section('content')
<section class="py-5"><div class="container" style="max-width:800px">
    <h1 class="h2 fw-bold">{{ $event->title }}</h1>
    <p class="text-secondary">{{ $event->start_at?->translatedFormat('d F Y, H:i') }} · {{ $event->location }}</p>
    @if($event->cover)
    <img src="{{ asset('storage/'.$event->cover) }}" class="img-fluid rounded-3 w-100 mb-4" alt="">
    @endif
    <div class="prose card border-0 shadow-sm p-4">{!! $event->content ?: nl2br(e($event->description)) !!}</div>
</div></section>
@endsection
