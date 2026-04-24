@extends('layouts.app')
@section('title', 'Pengumuman — '.config('app.name'))
@section('content')
<section class="page-hero"><div class="container"><h1 class="display-6 fw-bold">Pengumuman Resmi</h1></div></section>
<section class="py-5"><div class="container">
    <div class="list-group shadow-sm rounded-3 overflow-hidden">
        @forelse($announcements as $a)
        <a href="{{ route('pengumuman.show', $a->slug) }}" class="list-group-item list-group-item-action py-4">
            <div class="d-flex gap-3">
                <div class="text-center">
                    <div class="fs-3 fw-bold text-primary">{{ $a->published_at?->format('d') }}</div>
                    <small class="text-uppercase">{{ $a->published_at?->translatedFormat('M Y') }}</small>
                </div>
                <div>
                    @if(in_array($a->priority, ['important','urgent'], true))<span class="badge bg-danger">Penting</span>@endif
                    <h5 class="mb-1">{{ $a->title }}</h5>
                    <p class="text-secondary small mb-0">{{ \Illuminate\Support\Str::limit(strip_tags($a->content), 160) }}</p>
                </div>
            </div>
        </a>
        @empty
        <div class="list-group-item">Tidak ada pengumuman.</div>
        @endforelse
    </div>
    <div class="mt-4">{{ $announcements->links() }}</div>
</div></section>
@endsection
