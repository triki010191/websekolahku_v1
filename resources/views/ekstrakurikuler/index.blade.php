@extends('layouts.app')
@section('title', 'Ekstrakurikuler — '.config('app.name'))
@section('content')
<section class="page-hero"><div class="container"><h1 class="display-6 fw-bold">Ekstrakurikuler</h1></div></section>
<section class="py-5"><div class="container">
    <div class="row g-3">
        @foreach($extras as $x)
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 p-3">
                <h5 class="mb-1">{{ $x->name }}</h5>
                <span class="badge bg-primary bg-opacity-10 text-primary mb-2">{{ $x->category }}</span>
                <p class="small text-secondary mb-0">{{ $x->description }}</p>
            </div>
        </div>
        @endforeach
    </div>
</div></section>
@endsection
