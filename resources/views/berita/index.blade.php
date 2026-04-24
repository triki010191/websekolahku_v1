@extends('layouts.app')
@section('title', 'Berita — '.config('app.name'))
@section('content')
<section class="page-hero"><div class="container"><h1 class="display-6 fw-bold">Berita &amp; Artikel</h1></div></section>
<section class="py-5"><div class="container">
    <form method="get" class="row g-2 mb-4">
        <div class="col-md-4"><input type="search" name="search" class="form-control" placeholder="Cari..." value="{{ request('search') }}"></div>
        <div class="col-md-4">
            <select name="category" class="form-select" onchange="this.form.submit()">
                <option value="">Semua kategori</option>
                @foreach($categories as $c)
                <option value="{{ $c->slug }}" @selected(request('category')==$c->slug)>{{ $c->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2"><button class="btn btn-primary w-100">Filter</button></div>
    </form>
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="row g-4">
                @forelse($posts as $post)
                <div class="col-md-6">
                    <article class="card border-0 shadow-sm h-100">
                        <a href="{{ route('berita.show', $post->slug) }}"><img src="{{ $post->cover_url }}" class="card-img-top" style="aspect-ratio:16/10;object-fit:cover" alt=""></a>
                        <div class="card-body">
                            <span class="badge bg-light text-primary">{{ $post->category?->name }}</span>
                            <h5 class="mt-2"><a href="{{ route('berita.show', $post->slug) }}" class="text-decoration-none text-body">{{ $post->title }}</a></h5>
                            <p class="small text-secondary line-clamp-2">{{ $post->excerpt }}</p>
                            <small class="text-muted">{{ optional($post->published_at)->translatedFormat('d M Y') }}</small>
                        </div>
                    </article>
                </div>
                @empty
                <p>Tidak ada berita.</p>
                @endforelse
            </div>
            <div class="mt-4">{{ $posts->withQueryString()->links() }}</div>
        </div>
        <div class="col-lg-4">
            <h6 class="fw-bold mb-3">Populer</h6>
            @foreach($popular as $p)
            <div class="mb-3">
                <a href="{{ route('berita.show', $p->slug) }}" class="text-decoration-none">{{ $p->title }}</a>
                <div class="small text-muted">{{ $p->views }} views</div>
            </div>
            @endforeach
        </div>
    </div>
</div></section>
@endsection
