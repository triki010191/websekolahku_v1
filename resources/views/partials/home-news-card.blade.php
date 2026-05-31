<a href="{{ route('berita.show', $post->slug) }}" class="text-decoration-none text-body d-block">
    <div class="card border-0 shadow-sm hover-lift home-news-card">
        <div class="home-news-card__inner d-flex align-items-stretch">
            <div class="home-news-card__thumb flex-shrink-0">
                <img src="{{ $post->cover_url }}" alt="{{ $post->title }}" loading="lazy">
            </div>
            <div class="home-news-card__body flex-grow-1 min-w-0">
                <span class="badge bg-light text-primary mb-2">{{ $post->category?->name ?? 'Berita' }}</span>
                <h5 class="home-news-card__title line-clamp-2 mb-2">{{ $post->title }}</h5>
                <small class="text-muted">{{ optional($post->published_at)->translatedFormat('d M Y') }}</small>
            </div>
        </div>
    </div>
</a>
