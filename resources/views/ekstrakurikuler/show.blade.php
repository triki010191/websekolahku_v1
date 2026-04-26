@extends('layouts.app')
@section('title', $x->name.' — Ekstrakurikuler')
@section('content')
<section class="page-hero"><div class="container"><h1 class="display-6 fw-bold">{{ $x->name }}</h1>
    <p class="mb-0 opacity-75"><span class="badge bg-primary bg-opacity-25 text-primary border border-primary border-opacity-25">{{ $x->category ?? 'Eskul' }}</span>
        @if($x->schedule) · <span class="text-white-50">{{ $x->schedule }}</span> @endif
    </p>
</div></section>
<section class="py-5"><div class="container" style="max-width:800px">
    @if($x->cover)
    <img src="{{ asset('storage/'.$x->cover) }}" class="img-fluid rounded-3 mb-4 w-100" style="object-fit:cover;max-height:400px" alt="">
    @endif
    <div class="prose">{!! $x->content ?: nl2br(e($x->description)) !!}</div>
    @if($x->coach || $x->member_count)
    <p class="text-secondary small mt-4 mb-0">
        @if($x->coach)
            Pembina: {{ $x->coach }}
        @endif
        @if($x->member_count)
            @if($x->coach) · @endif
            {{ number_format($x->member_count) }} anggota
        @endif
    </p>
    @endif
</div></section>
@endsection
