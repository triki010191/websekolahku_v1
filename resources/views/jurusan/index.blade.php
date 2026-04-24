@extends('layouts.app')
@section('title', 'Jurusan — '.config('app.name'))
@section('content')
<section class="page-hero"><div class="container"><h1 class="display-6 fw-bold">Kompetensi Keahlian</h1><p class="mb-0 opacity-75">Program keahlian SMKN 8 Pandeglang</p></div></section>
<section class="py-5"><div class="container">
    <div class="row g-4">
        @foreach($majors as $m)
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <span class="badge bg-primary">{{ $m->code }}</span>
                    <h5 class="mt-2 fw-bold">{{ $m->name }}</h5>
                    <p class="text-secondary small">{{ \Illuminate\Support\Str::limit(strip_tags($m->description), 120) }}</p>
                    <a href="{{ route('jurusan.show', $m) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div></section>
@endsection
