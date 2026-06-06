@extends('layouts.app')
@section('title', 'Guru & TU — '.config('app.name'))
@section('content')
<section class="page-hero"><div class="container"><h1 class="display-6 fw-bold">Guru &amp; Tenaga Kependidikan</h1><p class="mb-0 opacity-75">Geser kartu ke kanan/kiri untuk melihat profil lainnya</p></div></section>
<section class="py-5"><div class="container">
    <form method="get" class="row g-2 mb-4">
        <div class="col-md-4"><input type="search" name="search" class="form-control" placeholder="Cari nama..." value="{{ request('search') }}"></div>
        <div class="col-md-3">
            <select name="field" class="form-select" onchange="this.form.submit()">
                <option value="">Semua bidang</option>
                @foreach($fields as $f)
                <option value="{{ $f }}" @selected(request('field')===$f)>{{ $f }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2"><button class="btn btn-primary w-100">Cari</button></div>
    </form>

    @if($teachers->isEmpty())
    <p class="text-secondary mb-0">Data tidak tersedia.</p>
    @else
    <div class="guru-carousel-wrap" data-guru-carousel>
        <button type="button" class="guru-carousel__nav guru-carousel__nav--prev" aria-label="Profil sebelumnya" data-guru-prev disabled>
            <i class="bi bi-chevron-left"></i>
        </button>

        <div class="guru-carousel" data-guru-track tabindex="0" aria-label="Daftar profil guru">
            <div class="guru-carousel__inner">
                @foreach($teachers as $t)
                <article class="guru-carousel__slide">
                    <div class="card border-0 shadow guru-showcase-card h-100">
                        <div class="guru-showcase-card__photo">
                            <img src="{{ $t->photo_url }}" alt="{{ $t->name }}" loading="lazy" class="guru-showcase-card__img">
                            @if($t->field)
                            <span class="badge guru-showcase-card__field">{{ strtoupper($t->field) }}</span>
                            @endif
                        </div>
                        <div class="guru-showcase-card__body">
                            <h2 class="guru-showcase-card__name">{{ $t->name }}</h2>
                            <p class="guru-showcase-card__role">{{ $t->position }}</p>
                            <p class="guru-showcase-card__desc">
                                @if($t->motto)
                                    {{ \Illuminate\Support\Str::limit($t->motto, 80) }}
                                @elseif($t->bio)
                                    {{ \Illuminate\Support\Str::limit(strip_tags($t->bio), 80) }}
                                @elseif($t->subject)
                                    {{ $t->subject }}
                                @else
                                    Guru &amp; tenaga kependidikan SMKN 8 Pandeglang
                                @endif
                            </p>
                            <a href="{{ route('guru.show', $t) }}" class="btn btn-primary w-100 guru-showcase-card__btn">
                                <i class="bi bi-person-lines-fill me-1"></i> Lihat Profil
                            </a>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>
        </div>

        <button type="button" class="guru-carousel__nav guru-carousel__nav--next" aria-label="Profil berikutnya" data-guru-next>
            <i class="bi bi-chevron-right"></i>
        </button>

        <div class="guru-carousel__footer text-center mt-3">
            <span class="badge text-bg-light border text-secondary px-3 py-2" data-guru-counter>1 / {{ $teachers->count() }}</span>
        </div>
    </div>
    @endif
</div></section>
@endsection

@push('styles')
<style>
.guru-carousel-wrap {
    position: relative;
    padding: 0 2.75rem;
}
.guru-carousel {
    overflow-x: auto;
    overflow-y: hidden;
    scroll-snap-type: x mandatory;
    scroll-behavior: smooth;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: none;
    padding: 0.25rem 0 1rem;
}
.guru-carousel::-webkit-scrollbar { display: none; }
.guru-carousel__inner {
    display: flex;
    gap: 1.25rem;
    padding: 0.35rem 0.5rem 0.75rem;
}
.guru-carousel__slide {
    flex: 0 0 min(88vw, 340px);
    scroll-snap-align: center;
}
.guru-showcase-card {
    height: 500px;
    border-radius: 1rem;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    transition: transform 0.18s ease, box-shadow 0.18s ease;
}
.guru-showcase-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 1rem 2rem rgba(29, 78, 216, 0.18) !important;
}
.guru-showcase-card__photo {
    position: relative;
    flex: 0 0 70%;
    min-height: 0;
    background: linear-gradient(145deg, #1e3a8a, #1d4ed8 50%, #38bdf8);
    overflow: hidden;
}
.guru-showcase-card__img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center top;
    display: block;
}
.guru-showcase-card__field {
    position: absolute;
    top: 0.75rem;
    right: 0.75rem;
    background: rgba(255, 255, 255, 0.92);
    color: #1d4ed8;
    font-weight: 700;
    font-size: 0.68rem;
    letter-spacing: 0.03em;
}
.guru-showcase-card__body {
    flex: 0 0 30%;
    min-height: 0;
    padding: 0.75rem 0.85rem 0.85rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
    background: #fff;
}
.guru-showcase-card__name {
    font-size: 0.88rem;
    font-weight: 700;
    line-height: 1.25;
    margin: 0 0 0.15rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.guru-showcase-card__role {
    font-size: 0.72rem;
    font-weight: 600;
    color: #1d4ed8;
    margin: 0 0 0.2rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.guru-showcase-card__desc {
    font-size: 0.68rem;
    color: #64748b;
    margin: 0 0 0.35rem;
    line-height: 1.35;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.guru-showcase-card__btn {
    font-size: 0.875rem;
    font-weight: 600;
    padding: 0.5rem 0.75rem;
    margin-top: auto;
}
.guru-carousel__nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    z-index: 2;
    width: 2.75rem;
    height: 2.75rem;
    border: 0;
    border-radius: 50%;
    background: #fff;
    color: #1d4ed8;
    box-shadow: 0 0.35rem 1rem rgba(15, 23, 42, 0.15);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.35rem;
    transition: background 0.15s ease, color 0.15s ease, opacity 0.15s ease;
}
.guru-carousel__nav:hover:not(:disabled) {
    background: #1d4ed8;
    color: #fff;
}
.guru-carousel__nav:disabled {
    opacity: 0.35;
    cursor: not-allowed;
}
.guru-carousel__nav--prev { left: 0; }
.guru-carousel__nav--next { right: 0; }
@media (max-width: 575.98px) {
    .guru-carousel-wrap { padding: 0 2.25rem; }
    .guru-carousel__nav {
        width: 2.35rem;
        height: 2.35rem;
        font-size: 1.15rem;
    }
    .guru-showcase-card { height: 460px; }
}
</style>
@endpush

@push('scripts')
<script>
(function () {
    document.querySelectorAll('[data-guru-carousel]').forEach(function (wrap) {
        var track = wrap.querySelector('[data-guru-track]');
        var prevBtn = wrap.querySelector('[data-guru-prev]');
        var nextBtn = wrap.querySelector('[data-guru-next]');
        var counter = wrap.querySelector('[data-guru-counter]');
        var slides = wrap.querySelectorAll('.guru-carousel__slide');
        if (!track || !slides.length) return;

        function slideStep() {
            var slide = slides[0];
            if (!slide) return track.clientWidth;
            var gap = parseFloat(getComputedStyle(slide.parentElement).gap) || 20;
            return slide.offsetWidth + gap;
        }

        function activeIndex() {
            var step = slideStep();
            if (step <= 0) return 0;
            return Math.max(0, Math.min(slides.length - 1, Math.round(track.scrollLeft / step)));
        }

        function updateUi() {
            var idx = activeIndex();
            if (counter) counter.textContent = (idx + 1) + ' / ' + slides.length;
            if (prevBtn) prevBtn.disabled = idx <= 0;
            if (nextBtn) nextBtn.disabled = idx >= slides.length - 1;
        }

        function scrollToIndex(index) {
            var step = slideStep();
            track.scrollTo({ left: step * index, behavior: 'smooth' });
        }

        if (prevBtn) {
            prevBtn.addEventListener('click', function () {
                scrollToIndex(Math.max(0, activeIndex() - 1));
            });
        }
        if (nextBtn) {
            nextBtn.addEventListener('click', function () {
                scrollToIndex(Math.min(slides.length - 1, activeIndex() + 1));
            });
        }

        track.addEventListener('scroll', updateUi, { passive: true });
        window.addEventListener('resize', updateUi);

        track.addEventListener('keydown', function (e) {
            if (e.key === 'ArrowLeft') {
                e.preventDefault();
                scrollToIndex(Math.max(0, activeIndex() - 1));
            } else if (e.key === 'ArrowRight') {
                e.preventDefault();
                scrollToIndex(Math.min(slides.length - 1, activeIndex() + 1));
            }
        });

        updateUi();
    });
})();
</script>
@endpush
