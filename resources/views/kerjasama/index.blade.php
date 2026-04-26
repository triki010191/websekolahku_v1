@extends('layouts.app')
@section('title', 'Kerjasama Industri — '.config('app.name'))
@section('content')
<section class="page-hero"><div class="container"><h1 class="display-6 fw-bold">Kerjasama DU-DI</h1><p class="mb-0 opacity-75">Mitra strategis pendidikan kejuruan</p></div></section>
<section class="py-5"><div class="container">
    <div class="row g-3">
        @foreach($partners as $p)
        <div class="col-6 col-md-4 col-lg-3">
            <a href="{{ route('kerjasama.show', $p) }}" class="text-decoration-none text-body d-block h-100 text-center p-3 border rounded-3 shadow-sm h-100 hover-lift" style="transition:transform .2s">
            @if($p->logo)
            <img src="{{ asset('storage/'.$p->logo) }}" class="img-fluid mb-2" style="max-height:56px" alt="{{ $p->name }}">
            @endif
            <div class="fw-semibold small">{{ $p->name }}</div>
            <div class="text-muted" style="font-size:.75rem">{{ $p->industry }}</div>
            <span class="d-inline-block small text-primary mt-1">Detail &rarr;</span>
            </a>
        </div>
        @endforeach
    </div>
</div></section>
@endsection
