@extends('layouts.admin')
@section('title', 'Pengaturan')
@section('admin')
@php
    $fieldLabels = [
        'site_name' => 'Nama sekolah (panjang)',
        'site_short' => 'Nama singkat (navbar)',
        'site_tagline' => 'Tagline beranda',
        'site_npsn' => 'NPSN',
        'site_accreditation' => 'Akreditasi',
        'site_logo' => 'Logo sekolah (navbar)',
        'hero_principal_image' => 'Foto kepala sekolah (blok hero beranda)',
        'hero_principal_caption' => 'Keterangan di bawah foto (contoh: nama + gelar)',
        'sambutan_section_image' => 'Foto sambutan Kepala Sekolah (blok teks sambutan di tengah beranda, kiri)',
        'spmb_banten_url' => 'URL tombol "SPMB Online Prov. Banten" (resmi: https://spmb.bantenprov.go.id/)',
        'spmb_banten_logo' => 'Ganti logo tombol "SPMB Prov. Banten" (kosong = file bawaan `public/images/spmb-banten-official.png`)',
        'ppdb_year' => 'Tahun ajaran SPMB (contoh: 2026/2027)',
        'ppdb_is_open' => 'Status pendaftaran (1 = dibuka, 0 = ditutup)',
        'ppdb_start' => 'Tanggal pembukaan pendaftaran (YYYY-MM-DD)',
        'ppdb_end' => 'Tanggal penutupan pendaftaran (YYYY-MM-DD)',
        'ppdb_announce' => 'Tanggal pengumuman hasil seleksi (YYYY-MM-DD)',
        'google_maps_url' => 'Link Google Maps lokasi sekolah (tombol Buka Google Maps)',
        'google_maps_embed_url' => 'URL embed iframe Google Maps (kosongkan = otomatis dari koordinat)',
        'youtube_channel_url' => 'URL kanal YouTube resmi (contoh: https://www.youtube.com/@SMKN8PANDEGLANG)',
        'youtube_channel_id' => 'YouTube Channel ID (UC...) — untuk embed preview video di beranda',
        'youtube_featured_video' => 'URL atau ID video YouTube yang ditampilkan (contoh: https://www.youtube.com/watch?v=maqRd3EeizQ)',
        'instagram_profile_url' => 'URL profil Instagram resmi (contoh: https://www.instagram.com/smkn8pandeglang_official)',
        'instagram_post_urls' => 'URL posting Instagram (satu per baris, maks. 9) untuk grid 3 kolom. Kosongkan = embed feed profil otomatis seperti Instagram.',
    ];
@endphp
<h1 class="h4 mb-4">Pengaturan Website</h1>
<form method="post" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="vstack gap-4">
    @csrf
    @method('put')
    @foreach($settings as $group => $rows)
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white fw-bold text-uppercase small text-secondary">{{ $group }}</div>
        <div class="card-body">
            @foreach($rows as $s)
            <div class="mb-3">
                <label class="form-label small text-muted mb-0">{{ $fieldLabels[$s->key] ?? $s->key }}</label>
                @if($s->type==='image')
                <input type="file" class="form-control" name="files[{{ $s->key }}]" accept="image/*">
                @if($s->value)
                    <div class="mt-2">
                        <img src="{{ asset('storage/'.$s->value) }}" alt="" class="img-thumbnail" style="max-height:100px;max-width:180px;object-fit:contain">
                    </div>
                @endif
                <div class="small text-secondary">Kosongkan bila tidak ingin mengganti. JPG/PNG/WebP, maks. 15MB.</div>
                @elseif($s->key === 'instagram_post_urls')
                <textarea class="form-control font-monospace" name="{{ $s->key }}" rows="6" placeholder="https://www.instagram.com/p/...&#10;https://www.instagram.com/reel/...">{{ old($s->key, $s->value) }}</textarea>
                <div class="small text-secondary">Salin link posting dari Instagram (menu ⋯ → Salin tautan). Maks. 6 baris.</div>
                @else
                <input type="text" class="form-control" name="{{ $s->key }}" value="{{ old($s->key, $s->value) }}">
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @endforeach
    <button class="btn btn-primary">Simpan semua</button>
</form>
@endsection
