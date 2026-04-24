@extends('layouts.app')
@section('title', 'Fasilitas — '.config('app.name'))
@section('content')
<section class="page-hero"><div class="container"><h1 class="display-6 fw-bold">Fasilitas Sekolah</h1></div></section>
<section class="py-5"><div class="container">
    <div class="row g-4">
        @foreach($facilities as $f)
        <div class="col-md-6 col-lg-4">
            <a href="{{ route('fasilitas.show', $f) }}" class="text-decoration-none text-body">
                <div class="card border-0 shadow-sm h-100">
                    @if($f->cover)
                    <img src="{{ asset('storage/'.$f->cover) }}" class="card-img-top" style="aspect-ratio:16/9;object-fit:cover" alt="">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $f->name }}</h5>
                        <p class="small text-secondary line-clamp-2">{{ $f->description }}</p>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div></section>
@endsection
