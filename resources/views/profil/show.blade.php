@extends('layouts.app')

@section('title', $page->title.' — '.config('app.name'))

@section('content')
<section class="page-hero">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-2">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-50">Beranda</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Profil</li>
            </ol>
        </nav>
        <h1 class="display-6 fw-bold">{{ $page->title }}</h1>
    </div>
</section>
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 mb-4">
                <div class="list-group shadow-sm">
                    <a href="{{ route('profil.show','sejarah') }}" class="list-group-item list-group-item-action {{ $page->slug==='sejarah'?'active':'' }}">Sejarah</a>
                    <a href="{{ route('profil.show','sambutan') }}" class="list-group-item list-group-item-action {{ $page->slug==='sambutan'?'active':'' }}">Sambutan</a>
                    <a href="{{ route('profil.show','visi-misi') }}" class="list-group-item list-group-item-action {{ $page->slug==='visi-misi'?'active':'' }}">Visi &amp; Misi</a>
                    <a href="{{ route('profil.show','struktur') }}" class="list-group-item list-group-item-action {{ $page->slug==='struktur'?'active':'' }}">Struktur</a>
                    <a href="{{ route('profil.show','prestasi') }}" class="list-group-item list-group-item-action {{ $page->slug==='prestasi'?'active':'' }}">Prestasi</a>
                    <a href="{{ route('profil.show','tata-tertib') }}" class="list-group-item list-group-item-action {{ $page->slug==='tata-tertib'?'active':'' }}">Tata Tertib</a>
                </div>
            </div>
            <div class="col-lg-9">
                <article class="card border-0 shadow-sm p-4 p-md-5">
                    <div class="prose">{!! $page->content !!}</div>
                </article>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>.prose img{max-width:100%;height:auto;border-radius:.5rem}</style>
@endpush
