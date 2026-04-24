<footer class="bg-dark text-white-50 mt-5 pt-5 pb-4">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span class="d-inline-flex align-items-center justify-content-center text-white fw-bold rounded-2"
                          style="width:38px;height:38px;background:linear-gradient(135deg,#1d4ed8,#3b82f6);">S8</span>
                    <div>
                        <div class="fw-bold text-white">{{ setting('site_name', 'SMKN 8 Pandeglang') }}</div>
                        <small>NPSN: {{ setting('site_npsn', '20604321') }} | Akreditasi {{ setting('site_accreditation', 'A') }}</small>
                    </div>
                </div>
                <p class="mb-3">{{ setting('site_tagline', 'Pusat Keunggulan & Prestasi Akademik') }}. {{ setting('seo_description') }}</p>
                <div class="d-flex gap-2">
                    @if(setting('social_instagram'))<a class="btn btn-sm btn-outline-light rounded-circle" href="https://instagram.com/{{ setting('social_instagram') }}" target="_blank" title="Instagram"><i class="bi bi-instagram"></i></a>@endif
                    @if(setting('social_facebook')) <a class="btn btn-sm btn-outline-light rounded-circle" href="https://facebook.com/{{ setting('social_facebook') }}"  target="_blank" title="Facebook"><i class="bi bi-facebook"></i></a>@endif
                    @if(setting('social_youtube'))  <a class="btn btn-sm btn-outline-light rounded-circle" href="https://youtube.com/{{ setting('social_youtube') }}"    target="_blank" title="YouTube"><i class="bi bi-youtube"></i></a>@endif
                    @if(setting('social_tiktok'))   <a class="btn btn-sm btn-outline-light rounded-circle" href="https://tiktok.com/{{ setting('social_tiktok') }}"      target="_blank" title="TikTok"><i class="bi bi-tiktok"></i></a>@endif
                </div>
            </div>
            <div class="col-6 col-lg-2">
                <h6 class="text-white mb-3">Navigasi</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a class="link-light link-underline link-underline-opacity-0" href="{{ route('home') }}">Beranda</a></li>
                    <li class="mb-2"><a class="link-light link-underline link-underline-opacity-0" href="{{ route('profil.show','sejarah') }}">Profil</a></li>
                    <li class="mb-2"><a class="link-light link-underline link-underline-opacity-0" href="{{ route('jurusan.index') }}">Jurusan</a></li>
                    <li class="mb-2"><a class="link-light link-underline link-underline-opacity-0" href="{{ route('berita.index') }}">Berita</a></li>
                    <li class="mb-2"><a class="link-light link-underline link-underline-opacity-0" href="{{ route('ppdb.index') }}">SPMB</a></li>
                </ul>
            </div>
            <div class="col-6 col-lg-2">
                <h6 class="text-white mb-3">Akademik</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a class="link-light link-underline link-underline-opacity-0" href="{{ route('guru.index') }}">Guru &amp; TU</a></li>
                    <li class="mb-2"><a class="link-light link-underline link-underline-opacity-0" href="{{ route('event.index') }}">Event</a></li>
                    <li class="mb-2"><a class="link-light link-underline link-underline-opacity-0" href="{{ route('kalender.index') }}">Kalender</a></li>
                    <li class="mb-2"><a class="link-light link-underline link-underline-opacity-0" href="{{ route('download.index') }}">Download</a></li>
                </ul>
            </div>
            <div class="col-lg-4">
                <h6 class="text-white mb-3">Kontak Sekolah</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2"><i class="bi bi-geo-alt me-2"></i>{{ setting('contact_address') }}</li>
                    <li class="mb-2"><i class="bi bi-telephone me-2"></i>{{ setting('contact_phone') }}</li>
                    <li class="mb-2"><i class="bi bi-whatsapp me-2"></i>{{ setting('contact_whatsapp') }}</li>
                    <li class="mb-2"><i class="bi bi-envelope me-2"></i>{{ setting('contact_email') }}</li>
                </ul>
            </div>
        </div>
        <hr class="border-secondary my-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center small">
            <div>&copy; {{ date('Y') }} {{ setting('site_name', 'SMKN 8 Pandeglang') }}. Seluruh hak cipta dilindungi.</div>
            <div>Built with <i class="bi bi-heart-fill text-danger"></i> Laravel &amp; Bootstrap 5</div>
        </div>
    </div>
</footer>
