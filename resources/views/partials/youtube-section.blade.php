@php
    $youtubeUrl = youtube_channel_url();
    $youtubeEmbed = youtube_embed_url();
    $youtubeVideoUrl = youtube_featured_watch_url();
@endphp
@if($youtubeEmbed)
<section class="youtube-section py-5 border-top" aria-label="Kanal YouTube sekolah">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-4">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span class="youtube-section__icon d-inline-flex align-items-center justify-content-center rounded-circle">
                        <i class="bi bi-youtube"></i>
                    </span>
                    <span class="text-uppercase small fw-semibold text-danger letter-spacing-sm">YouTube Resmi</span>
                </div>
                <h3 class="fw-bold mb-3">SMKN 8 Pandeglang</h3>
                <p class="text-secondary mb-4">
                    Saksikan dokumentasi kegiatan, prestasi siswa, dan informasi resmi sekolah melalui kanal YouTube kami.
                </p>
                <div class="d-flex flex-wrap gap-2">
                    @if($youtubeVideoUrl)
                    <a href="{{ $youtubeVideoUrl }}" class="btn btn-danger" target="_blank" rel="noopener noreferrer">
                        <i class="bi bi-play-fill me-1"></i> Tonton Video
                    </a>
                    @endif
                    <a href="{{ $youtubeUrl }}" class="btn btn-{{ $youtubeVideoUrl ? 'outline-danger' : 'danger' }}" target="_blank" rel="noopener noreferrer">
                        <i class="bi bi-youtube me-1"></i> Kunjungi Channel
                    </a>
                    <a href="{{ $youtubeUrl }}?sub_confirmation=1" class="btn btn-outline-danger" target="_blank" rel="noopener noreferrer">
                        <i class="bi bi-bell me-1"></i> Subscribe
                    </a>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="youtube-section__player ratio ratio-16x9 rounded-4 overflow-hidden shadow-lg bg-dark">
                    <iframe
                        src="{{ $youtubeEmbed }}"
                        title="Video SMKN 8 Pandeglang"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen
                        loading="lazy"
                        referrerpolicy="strict-origin-when-cross-origin"
                    ></iframe>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
