@php
    $bUrl = setting('spmb_banten_url', 'https://spmb.bantenprov.go.id/');
    // Situs resmi: spmb (bukan ppdb) — ganti bila data/kolom lama masih menunjuk ke ppdb
    if (is_string($bUrl) && $bUrl !== '' && str_contains(strtolower($bUrl), 'ppdb.bantenprov')) {
        $bUrl = 'https://spmb.bantenprov.go.id/';
    }
    $bLogo = setting('spmb_banten_logo');
    $v = $variant ?? 'sm';
    $imgSrc = $bLogo ? asset('storage/'.$bLogo) : asset('images/spmb-banten-official.png');
    if ($v === 'cta') {
        $btnClass = 'btn btn-light btn-lg text-dark d-inline-flex align-items-center gap-2';
        $imgH = 40;
        $imgMax = 220;
    } elseif ($v === 'lg') {
        $btnClass = 'btn btn-info btn-lg text-white d-inline-flex align-items-center gap-2';
        $imgH = 40;
        $imgMax = 200;
    } else {
        $btnClass = 'btn btn-info btn-sm text-white d-inline-flex align-items-center gap-2';
        $imgH = 32;
        $imgMax = 140;
    }
@endphp
@if($bUrl)
<a href="{{ $bUrl }}" target="_blank" rel="noopener" class="{{ $btnClass }} text-nowrap">
    <img src="{{ $imgSrc }}" alt="SPMB Online — Provinsi Banten" class="flex-shrink-0" width="{{ (int) round($imgH * 3) }}" height="{{ $imgH }}" style="height:{{ $imgH }}px;width:auto;max-width:min({{ $imgMax }}px,55vw);object-fit:contain" loading="lazy" decoding="async">
    @if($v === 'sm')
    <span class="d-none d-sm-inline">SPMB Online Prov. Banten</span>
    <span class="d-sm-none">Prov. Banten</span>
    @else
    <span>SPMB Online Prov. Banten</span>
    @endif
</a>
@endif
