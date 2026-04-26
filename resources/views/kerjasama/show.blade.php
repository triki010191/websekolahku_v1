@extends('layouts.app')
@section('title', $partner->name.' — Kerjasama')
@section('content')
<section class="page-hero"><div class="container">
    <h1 class="display-6 fw-bold">{{ $partner->name }}</h1>
    <p class="mb-0 opacity-75">{{ $partner->industry ?? 'Mitra DU-DI' }}</p>
</div></section>
<section class="py-5"><div class="container text-center text-md-start" style="max-width:800px">
    <div class="d-flex flex-column flex-md-row gap-4 align-items-start">
        @if($partner->logo)
        <img src="{{ asset('storage/'.$partner->logo) }}" class="img-fluid border rounded-3 p-2 bg-white" style="max-width:180px;max-height:100px;object-fit:contain" alt="">
        @endif
        <div class="flex-grow-1 text-start">
            <div class="prose mb-3">{!! $partner->description ? $partner->description : '<p class="text-secondary">Belum ada deskripsi.</p>' !!}</div>
            @if($partner->website)
            <a href="{{ $partner->website }}" class="btn btn-primary btn-sm" target="_blank" rel="noopener">Kunjungi situs</a>
            @endif
            @if($partner->mou_number)
            <p class="small text-secondary mt-3 mb-0">MOU: {{ $partner->mou_number }}
                @if($partner->mou_start) · {{ $partner->mou_start->translatedFormat('d M Y') }} @endif
                @if($partner->mou_end) s/d {{ $partner->mou_end->translatedFormat('d M Y') }}@endif
            </p>
            @endif
        </div>
    </div>
</div></section>
@endsection
