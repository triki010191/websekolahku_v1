<section class="maps-section py-5 border-top" aria-label="Lokasi sekolah">
    <div class="container">
        <div class="row g-4 align-items-stretch">
            <div class="col-lg-4">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span class="maps-section__icon d-inline-flex align-items-center justify-content-center rounded-circle">
                        <i class="bi bi-geo-alt-fill"></i>
                    </span>
                    <span class="text-uppercase small fw-semibold text-primary letter-spacing-sm">Lokasi Sekolah</span>
                </div>
                <h3 class="fw-bold mb-3">{{ setting('site_name', 'SMKN 8 Pandeglang') }}</h3>
                <p class="text-secondary mb-4">{{ setting('contact_address') }}</p>
                <ul class="list-unstyled small mb-4">
                    @if(setting('contact_phone'))
                    <li class="mb-2"><i class="bi bi-telephone me-2 text-primary"></i>{{ setting('contact_phone') }}</li>
                    @endif
                    @if(setting('contact_email'))
                    <li class="mb-2"><i class="bi bi-envelope me-2 text-primary"></i>{{ setting('contact_email') }}</li>
                    @endif
                </ul>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ google_maps_url() }}" class="btn btn-primary" target="_blank" rel="noopener noreferrer">
                        <i class="bi bi-map me-1"></i> Buka Google Maps
                    </a>
                    <a href="{{ route('kontak.index') }}" class="btn btn-outline-primary">
                        <i class="bi bi-chat-dots me-1"></i> Hubungi Kami
                    </a>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="maps-section__frame ratio ratio-16x9 rounded-4 overflow-hidden shadow-lg border">
                    <iframe
                        src="{{ google_maps_embed_url() }}"
                        title="Peta lokasi {{ setting('site_name', 'SMKN 8 Pandeglang') }}"
                        loading="lazy"
                        allowfullscreen
                        referrerpolicy="no-referrer-when-downgrade"
                    ></iframe>
                </div>
            </div>
        </div>
    </div>
</section>
