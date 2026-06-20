@php
    $items = [
        [
            'label' => 'Pra SPMB',
            'desc'  => 'Tahap pra-pendaftaran wajib Provinsi Banten',
            'icon'  => 'bi-clipboard-check',
            'href'  => spmb_route('spmb.pra-spmb', '/spmb-2026/pra-spmb'),
            'color' => 'primary',
        ],
        [
            'label' => 'Kuota SPMB',
            'desc'  => 'Kuota penerimaan kelas X per jurusan',
            'icon'  => 'bi-people',
            'href'  => spmb_route('spmb.index', '/spmb-2026', '#kuota-spmb'),
            'color' => 'info',
        ],
        [
            'label' => 'Formulir Dapodik Online',
            'desc'  => 'Isi formulir pendaftaran Dapodik secara online',
            'icon'  => 'bi-clipboard-data',
            'href'  => spmb_route('ppdb.create', '/ppdb/daftar'),
            'color' => 'success',
        ],
        [
            'label' => 'Panduan Dapodik',
            'desc'  => 'Petunjuk pengisian & solusi masalah umum',
            'icon'  => 'bi-book',
            'href'  => spmb_route('spmb.panduan-dapodik', '/spmb-2026/panduan-dapodik'),
            'color' => 'success',
        ],
        [
            'label' => 'Jadwal & Persyaratan Pendaftaran',
            'desc'  => 'Syarat dan ketentuan pendaftaran SPMB',
            'icon'  => 'bi-file-earmark-text',
            'href'  => spmb_route('spmb.index', '/spmb-2026', '#persyaratan-spmb'),
            'color' => 'secondary',
        ],
        [
            'label' => 'Tes Bakat Minat',
            'desc'  => 'Jadwal tes seleksi SPMB 23–24 Juni 2026',
            'icon'  => 'bi-calendar2-week',
            'href'  => spmb_route('spmb.tes-bakat-minat', '/spmb-2026/tes-bakat-minat'),
            'color' => 'warning',
        ],
        [
            'label' => 'Pengumuman Kelulusan',
            'desc'  => 'Hasil seleksi dan pengumuman resmi SPMB',
            'icon'  => 'bi-megaphone',
            'href'  => spmb_route('spmb.index', '/spmb-2026', '#pengumuman-spmb'),
            'color' => 'danger',
        ],
        [
            'label' => 'Daftar Ulang',
            'desc'  => 'Informasi Belum Tersedia',
            'icon'  => 'bi-person-check',
            'href'  => spmb_route('spmb.daftar-ulang', '/spmb-2026/daftar-ulang'),
            'color' => 'dark',
        ],
    ];
@endphp
<div class="row g-3">
    @foreach($items as $item)
    <div class="col-6 col-md-4 col-lg-3 col-xl">
        <a href="{{ $item['href'] }}" class="spmb-quick-nav__btn btn btn-outline-{{ $item['color'] }} w-100 h-100 text-start p-3">
            <i class="bi {{ $item['icon'] }} fs-4 d-block mb-2 text-{{ $item['color'] }}"></i>
            <span class="fw-semibold d-block small">{{ $item['label'] }}</span>
            <span class="text-secondary d-none d-md-block" style="font-size:.75rem;line-height:1.35">{{ $item['desc'] }}</span>
        </a>
    </div>
    @endforeach
</div>
