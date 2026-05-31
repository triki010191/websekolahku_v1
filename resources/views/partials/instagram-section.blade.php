@php
    $instagramUrl = instagram_profile_url();
    $instagramPosts = instagram_post_urls(9);
    $instagramUsername = instagram_username();
    $instagramHandle = '@'.$instagramUsername;
    $siteLogo = setting('site_logo');
    $siteLogoUrl = storage_file_exists($siteLogo) ? public_storage_url($siteLogo) : null;
    $useGrid = count($instagramPosts) > 0;
@endphp
<section class="instagram-section py-5 border-top" aria-label="Instagram resmi sekolah">
    <div class="container">
        <div class="instagram-section__widget mx-auto">
            <div class="instagram-section__header d-flex align-items-center gap-3 px-3 py-3 border-bottom">
                @if($siteLogoUrl)
                <img src="{{ $siteLogoUrl }}" alt="" class="instagram-section__avatar rounded-circle border" width="56" height="56">
                @else
                <span class="instagram-section__avatar instagram-section__avatar--fallback rounded-circle d-inline-flex align-items-center justify-content-center">
                    <i class="bi bi-instagram"></i>
                </span>
                @endif
                <div class="min-w-0 flex-grow-1">
                    <a href="{{ $instagramUrl }}" class="instagram-section__username text-decoration-none fw-semibold" target="_blank" rel="noopener noreferrer">
                        {{ $instagramHandle }}
                    </a>
                    <div class="small text-secondary">SMKN 8 Pandeglang</div>
                </div>
                <a href="{{ $instagramUrl }}" class="btn btn-sm btn-instagram flex-shrink-0" target="_blank" rel="noopener noreferrer">
                    Follow
                </a>
            </div>

            @if($useGrid)
            <div class="instagram-grid" role="list">
                @foreach($instagramPosts as $postUrl)
                @php $thumbnail = instagram_post_thumbnail_url($postUrl); @endphp
                <a href="{{ $postUrl }}" class="instagram-grid__cell" role="listitem" target="_blank" rel="noopener noreferrer" title="Lihat posting Instagram">
                    @if($thumbnail)
                    <img src="{{ $thumbnail }}" alt="Posting Instagram SMKN 8 Pandeglang" loading="lazy" width="320" height="320" referrerpolicy="no-referrer">
                    @else
                    <span class="instagram-grid__placeholder d-flex align-items-center justify-content-center h-100">
                        <i class="bi bi-instagram fs-3 text-secondary"></i>
                    </span>
                    @endif
                    @if(str_contains($postUrl, '/reel/') || str_contains($postUrl, '/reels/'))
                    <span class="instagram-grid__badge"><i class="bi bi-play-fill"></i></span>
                    @endif
                </a>
                @endforeach
            </div>
            @else
            <div class="instagram-section__embed">
                <iframe
                    src="{{ instagram_profile_embed_url() }}"
                    title="Feed Instagram {{ $instagramHandle }}"
                    loading="lazy"
                    scrolling="yes"
                    allowtransparency="true"
                    allow="encrypted-media"
                ></iframe>
            </div>
            @endif
        </div>

        <p class="text-center small text-secondary mt-3 mb-0">
            Update kegiatan sekolah di
            <a href="{{ $instagramUrl }}" target="_blank" rel="noopener noreferrer">{{ $instagramHandle }}</a>
        </p>
    </div>
</section>
