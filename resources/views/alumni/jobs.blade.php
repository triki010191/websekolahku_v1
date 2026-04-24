@extends('layouts.app')
@section('title', 'Lowongan Alumni — '.config('app.name'))
@section('content')
<section class="page-hero"><div class="container"><h1 class="display-6 fw-bold">Lowongan Kerja</h1></div></section>
<section class="py-5"><div class="container">
    @forelse($jobs as $j)
    <div class="card border-0 shadow-sm mb-3 p-3">
        <h5 class="mb-1">{{ $j->title }}</h5>
        <div class="text-secondary small mb-2">{{ $j->company }} · {{ $j->location }} · {{ $j->type }}</div>
        <p class="mb-0 small">{{ \Illuminate\Support\Str::limit($j->description, 200) }}</p>
    </div>
    @empty
    <p>Belum ada lowongan.</p>
    @endforelse
    <div class="mt-3">{{ $jobs->links() }}</div>
</div></section>
@endsection
