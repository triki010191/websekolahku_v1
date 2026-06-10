@php
    use Illuminate\Support\Facades\Route;

    $spmbUrl = function (string $name, string $fallback, string $fragment = '') {
        $base = Route::has($name) ? route($name) : url($fallback);

        return $fragment ? $base.$fragment : $base;
    };

    $items = [
        [
            'label' => 'Pra SPMB',
            'desc'  => 'Tahap pra-pendaftaran wajib Provinsi Banten',
            'icon'  => 'bi-clipboard-check',
            'href'  => $spmbUrl('spmb.pra-spmb', '/spmb-2026/pra-spmb'),
            'color' => 'primary',
        ],
        [
            'label' => 'Kuota SPMB',
            'desc'  => 'Kuota penerimaan kelas X per jurusan',
            'icon'  => 'bi-people',
            'href'  => $spmbUrl('spmb.index', '/spmb-2026', '#kuota-spmb'),
            'color' => 'info',
        ],
        [
            'label' => 'Formulir Dapodik Online',
            'desc'  => 'Isi formulir pendaftaran Dapodik secara online',
            'icon'  => 'bi-clipboard-data',
            'href'  => $spmbUrl('ppdb.create', '/ppdb/daftar'),
            'color' => 'success',
        ],
        [
            'label' => 'Panduan Dapodik',
            'desc'  => 'Petunjuk pengisian & solusi masalah umum',
            'icon'  => 'bi-book',
            'href'  => $spmbUrl('spmb.panduan-dapodik', '/spmb-2026/panduan-dapodik'),
            'color' => 'success',
        ],
        [
            'label' => 'Jadwal & Persyaratan Pendaftaran',
            'desc'  => 'Syarat dan ketentuan pendaftaran SPMB',
            'icon'  => 'bi-file-earmark-text',
            'href'  => $spmbUrl('spmb.index', '/spmb-2026', '#persyaratan-spmb'),
            'color' => 'secondary',
        ],
        [
            'label' => 'Tes Bakat Minat',
            'desc'  => 'Informasi Belum Tersedia',
            'icon'  => 'bi-calendar2-week',
            'href'  => $spmbUrl('spmb.tes-bakat-minat', '/spmb-2026/tes-bakat-minat'),
            'color' => 'warning',
        ],
        [
            'label' => 'Pengumuman Kelulusan',
            'desc'  => 'Hasil seleksi dan pengumuman resmi SPMB',
            'icon'  => 'bi-megaphone',
            'href'  => $spmbUrl('spmb.index', '/spmb-2026', '#pengumuman-spmb'),
            'color' => 'danger',
        ],
        [
            'label' => 'Daftar Ulang',
            'desc'  => 'Informasi Belum Tersedia',
            'icon'  => 'bi-person-check',
            'href'  => $spmbUrl('spmb.daftar-ulang', '/spmb-2026/daftar-ulang'),
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
