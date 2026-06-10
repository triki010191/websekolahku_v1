@php
    $yearLabel = setting('ppdb_year', date('Y').'/'.(date('Y')+1));
    $items = [
        [
            'label' => 'Pra SPMB',
            'desc'  => 'Tahap pra-pendaftaran wajib Provinsi Banten',
            'icon'  => 'bi-clipboard-check',
            'href'  => route('spmb.pra-spmb'),
            'color' => 'primary',
        ],
        [
            'label' => 'Kuota SPMB',
            'desc'  => 'Kuota penerimaan kelas X per jurusan',
            'icon'  => 'bi-people',
            'href'  => route('spmb.index').'#kuota-spmb',
            'color' => 'info',
        ],
        [
            'label' => 'Persyaratan Pendaftaran',
            'desc'  => 'Syarat dan ketentuan pendaftaran SPMB',
            'icon'  => 'bi-file-earmark-text',
            'href'  => route('spmb.index').'#persyaratan-spmb',
            'color' => 'success',
        ],
        [
            'label' => 'Jadwal Tes',
            'desc'  => 'Informasi jadwal seleksi / tes masuk',
            'icon'  => 'bi-calendar2-week',
            'href'  => route('spmb.jadwal-tes'),
            'color' => 'warning',
        ],
        [
            'label' => 'Pengumuman Kelulusan',
            'desc'  => 'Hasil seleksi dan pengumuman resmi SPMB',
            'icon'  => 'bi-megaphone',
            'href'  => route('spmb.index').'#pengumuman-spmb',
            'color' => 'danger',
        ],
    ];
@endphp
<div class="row g-3">
    @foreach($items as $item)
    <div class="col-6 col-md-4 col-lg">
        <a href="{{ $item['href'] }}" class="spmb-quick-nav__btn btn btn-outline-{{ $item['color'] }} w-100 h-100 text-start p-3">
            <i class="bi {{ $item['icon'] }} fs-4 d-block mb-2 text-{{ $item['color'] }}"></i>
            <span class="fw-semibold d-block small">{{ $item['label'] }}</span>
            <span class="text-secondary d-none d-md-block" style="font-size:.75rem;line-height:1.35">{{ $item['desc'] }}</span>
        </a>
    </div>
    @endforeach
</div>
