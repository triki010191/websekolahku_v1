@extends('layouts.app')

@section('title', 'Panduan Formulir Dapodik — '.config('app.name'))

@section('content')
@php
    $yearLabel = setting('ppdb_year', date('Y').'/'.(date('Y')+1));
@endphp

<section class="page-hero">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-2">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-50">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('spmb.index') }}" class="text-white-50">SPMB {{ $yearLabel }}</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Panduan Dapodik</li>
            </ol>
        </nav>
        <h1 class="display-6 fw-bold">Panduan Pengisian Formulir Dapodik</h1>
        <p class="mb-0 opacity-75">Petunjuk lengkap mengisi formulir daftar ulang online — SPMB {{ $yearLabel }}</p>
    </div>
</section>

<section class="py-5 bg-body-tertiary border-bottom">
    <div class="container">
        <div class="row g-3 align-items-center">
            <div class="col-lg-8">
                <p class="mb-0 text-secondary">Formulir ini mengumpulkan data peserta didik sesuai format <strong>Dapodik</strong> (Data Pokok Pendidikan) untuk keperluan Pendaftaran di {{ config('app.name') }}. Disarankan dibaca sebelum mengisi.</p>
            </div>
            <div class="col-lg-4 d-flex flex-wrap gap-2 justify-content-lg-end">
                @if($isOpen)
                <a href="{{ route('ppdb.create') }}" class="btn btn-primary">
                    <i class="bi bi-clipboard-data me-1"></i> Isi Formulir Sekarang
                </a>
                @else
                <a href="{{ route('spmb.index') }}" class="btn btn-outline-primary">
                    <i class="bi bi-calendar-event me-1"></i> Cek Jadwal SPMB
                </a>
                @endif
                <a href="{{ route('spmb.index') }}#cek-formulir-spmb" class="btn btn-outline-secondary">
                    <i class="bi bi-search me-1"></i> Cek Formulir
                </a>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-3 d-none d-lg-block">
                <nav class="card border-0 shadow-sm sticky-top panduan-toc" style="top:5.5rem" aria-label="Daftar isi panduan">
                    <div class="card-header bg-white fw-semibold small text-uppercase text-secondary">Daftar Isi</div>
                    <div class="list-group list-group-flush small">
                        <a href="#tentang" class="list-group-item list-group-item-action">Tentang Formulir</a>
                        <a href="#persiapan" class="list-group-item list-group-item-action">Persiapan Dokumen</a>
                        <a href="#cara-akses" class="list-group-item list-group-item-action">Cara Mengakses</a>
                        <a href="#langkah" class="list-group-item list-group-item-action">Langkah Pengisian</a>
                        <a href="#tips" class="list-group-item list-group-item-action">Tips Penting</a>
                        <a href="#setelah-kirim" class="list-group-item list-group-item-action">Setelah Kirim</a>
                        <a href="#status-pendaftar" class="list-group-item list-group-item-action">Status Pendaftar</a>
                        <a href="#masalah" class="list-group-item list-group-item-action">Masalah &amp; Solusi</a>
                        <a href="#checklist" class="list-group-item list-group-item-action">Checklist</a>
                    </div>
                </nav>
            </div>

            <div class="col-lg-9">
                <article class="card border-0 shadow-sm p-4 p-md-5 mb-4 scroll-margin-top" id="tentang">
                    <h2 class="h5 fw-bold mb-3"><i class="bi bi-info-circle text-primary me-2"></i>Tentang Formulir</h2>
                    <p>Formulir Dapodik adalah pengisian data peserta didik sesuai format <strong>Data Pokok Pendidikan (Dapodik)</strong> Kemendikbud. Data ini digunakan untuk keperluan pendaftaran SPMB tahun ajaran {{ $yearLabel }}.</p>
                    <p class="mb-0"><strong>Siapa yang mengisi?</strong> Calon siswa bersama orang tua/wali, menggunakan HP atau komputer yang terhubung internet. Estimasi waktu pengisian: <strong>15–30 menit</strong>.</p>
                </article>

                <article class="card border-0 shadow-sm p-4 p-md-5 mb-4 scroll-margin-top" id="persiapan">
                    <h2 class="h5 fw-bold mb-3"><i class="bi bi-folder2-open text-primary me-2"></i>Persiapan Dokumen</h2>
                    <p class="text-secondary small">Siapkan data berikut sebelum mulai mengisi agar proses lebih cepat:</p>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered mb-0">
                            <thead class="table-light">
                                <tr><th>Data</th><th>Keterangan</th></tr>
                            </thead>
                            <tbody>
                                <tr><td class="fw-semibold">NISN</td><td>10 digit angka (dari kartu NISN / SPMB Banten)</td></tr>
                                <tr><td class="fw-semibold">NIK</td><td>Kartu Keluarga / KTP siswa</td></tr>
                                <tr><td class="fw-semibold">Akta kelahiran</td><td>Nomor registrasi akta (jika ada)</td></tr>
                                <tr><td class="fw-semibold">Data orang tua</td><td>NIK, tahun lahir, pendidikan, pekerjaan, penghasilan</td></tr>
                                <tr><td class="fw-semibold">NIS</td><td>Nomor Induk Siswa dari sekolah asal</td></tr>
                                <tr><td class="fw-semibold">Ijazah / SKHUN</td><td>Nomor seri (jika sudah ada)</td></tr>
                                <tr><td class="fw-semibold">Nomor HP aktif</td><td>Untuk kontak sekolah</td></tr>
                            </tbody>
                        </table>
                    </div>
                </article>

                <article class="card border-0 shadow-sm p-4 p-md-5 mb-4 scroll-margin-top" id="cara-akses">
                    <h2 class="h5 fw-bold mb-3"><i class="bi bi-box-arrow-in-right text-primary me-2"></i>Cara Mengakses Formulir</h2>
                    <ol class="mb-0">
                        <li class="mb-2">Buka halaman <a href="{{ route('spmb.index') }}">Info SPMB {{ $yearLabel }}</a>.</li>
                        <li class="mb-2">Pastikan jadwal pengisian <strong>masih dibuka</strong> (tombol biru <em>Isi Formulir Dapodik</em> tampil).</li>
                        <li class="mb-2">Klik <strong>Isi Formulir Dapodik</strong> atau menu <strong>Formulir Dapodik Online</strong> di bagian Informasi SPMB.</li>
                        <li>Ikuti langkah-langkah (wizard) dari awal sampai kirim.</li>
                    </ol>
                </article>

                <article class="card border-0 shadow-sm p-4 p-md-5 mb-4 scroll-margin-top" id="langkah">
                    <h2 class="h5 fw-bold mb-4"><i class="bi bi-list-ol text-primary me-2"></i>Langkah Pengisian (11 Tahap)</h2>
                    <div class="table-responsive">
                        <table class="table table-sm align-middle mb-4">
                            <thead class="table-light">
                                <tr><th style="width:3rem">No.</th><th>Tahap</th><th>Yang Diisi</th></tr>
                            </thead>
                            <tbody>
                                <tr><td>0</td><td class="fw-semibold">Identitas SPMB</td><td>NISN (10 digit) sebagai nomor SPMB Banten</td></tr>
                                <tr><td>1</td><td class="fw-semibold">Data Pribadi</td><td>Nama, NIK, tempat/tanggal lahir, alamat lengkap, agama, bantuan sosial</td></tr>
                                <tr><td>2</td><td class="fw-semibold">Data Ayah</td><td>Nama, NIK, tahun lahir, pendidikan, pekerjaan, penghasilan</td></tr>
                                <tr><td>3</td><td class="fw-semibold">Data Ibu</td><td>Sama seperti data ayah</td></tr>
                                <tr><td>4</td><td class="fw-semibold">Data Wali</td><td>Opsional (isi jika wali bukan orang tua)</td></tr>
                                <tr><td>5</td><td class="fw-semibold">Kontak</td><td>Nomor HP wajib, telepon rumah &amp; email opsional</td></tr>
                                <tr><td>6</td><td class="fw-semibold">Data Periodik</td><td>Tinggi/berat badan, jarak &amp; waktu ke sekolah</td></tr>
                                <tr><td>7</td><td class="fw-semibold">Prestasi</td><td>Opsional — bisa dilewati jika tidak ada</td></tr>
                                <tr><td>8</td><td class="fw-semibold">Beasiswa</td><td>Opsional</td></tr>
                                <tr><td>9</td><td class="fw-semibold">Registrasi</td><td>Jurusan, jenis pendaftaran, NIS, asal sekolah</td></tr>
                                <tr><td>10</td><td class="fw-semibold">Preview &amp; Kirim</td><td>Cek ulang data, centang pernyataan, lalu <strong>Kirim Formulir</strong></td></tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="border rounded-3 p-3 h-100 bg-body-tertiary small">
                                <i class="bi bi-cloud-arrow-up text-primary fs-5 d-block mb-2"></i>
                                <strong>Simpan Draft</strong><br>Menyimpan sementara ke server sekolah.
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border rounded-3 p-3 h-100 bg-body-tertiary small">
                                <i class="bi bi-arrow-right-circle text-primary fs-5 d-block mb-2"></i>
                                <strong>Lanjut / Kembali</strong><br>Pindah antar tahap pengisian.
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border rounded-3 p-3 h-100 bg-body-tertiary small">
                                <i class="bi bi-send text-success fs-5 d-block mb-2"></i>
                                <strong>Kirim Formulir</strong><br>Kirim final — hanya di tahap terakhir.
                            </div>
                        </div>
                    </div>
                </article>

                <article class="card border-0 shadow-sm p-4 p-md-5 mb-4 scroll-margin-top" id="tips">
                    <h2 class="h5 fw-bold mb-3"><i class="bi bi-lightbulb text-warning me-2"></i>Tips Penting Saat Mengisi</h2>
                    <ul class="mb-0">
                        <li class="mb-2"><strong>NISN harus 10 digit angka</strong> — tanpa spasi, tanpa huruf.</li>
                        <li class="mb-2"><strong>Nomor SPMB Banten = NISN Anda</strong> — jangan pakai nomor orang lain.</li>
                        <li class="mb-2"><strong>Satu NISN hanya bisa dikirim sekali</strong> — tidak bisa isi ulang kecuali admin mengubah status Anda ke <em>Revisi</em>.</li>
                        <li class="mb-2"><strong>Berkebutuhan Khusus wajib dipilih</strong> — minimal centang <em>Tidak ada</em> jika tidak ada kebutuhan khusus.</li>
                        <li class="mb-2">Field bertanda bintang (<strong>*</strong>) wajib diisi sebelum bisa lanjut.</li>
                        <li class="mb-2">Data harus <strong>sama dengan dokumen resmi</strong> (KK, ijazah, kartu NISN).</li>
                        <li>Setelah berhasil kirim, <strong>unduh dan simpan PDF</strong> formulir sebagai bukti.</li>
                    </ul>
                </article>

                <article class="card border-0 shadow-sm p-4 p-md-5 mb-4 scroll-margin-top" id="setelah-kirim">
                    <h2 class="h5 fw-bold mb-3"><i class="bi bi-check-circle text-success me-2"></i>Setelah Berhasil Kirim</h2>
                    <ul>
                        <li>Muncul halaman <strong>Formulir Berhasil Dikirim</strong>.</li>
                        <li>PDF formulir akan <strong>terunduh otomatis</strong>.</li>
                        <li>Catat <strong>No. Daftar Ulang</strong> yang muncul di layar.</li>
                        <li>Simpan PDF di HP atau cetak untuk keperluan daftar ulang di sekolah.</li>
                    </ul>
                    <h3 class="h6 fw-bold mt-4 mb-2">Cek / Unduh Ulang Formulir</h3>
                    <p class="small text-secondary mb-2">Jika sudah pernah kirim dan ingin lihat atau unduh PDF lagi:</p>
                    <ol class="mb-0">
                        <li class="mb-1">Buka halaman <a href="{{ route('spmb.index') }}#cek-formulir-spmb">SPMB → Cek Formulir Pendaftaran</a>.</li>
                        <li class="mb-1">Masukkan <strong>NISN</strong> (10 digit) dan <strong>tanggal lahir</strong> sesuai formulir.</li>
                        <li>Klik <strong>Cek &amp; Unduh Formulir</strong>.</li>
                    </ol>
                </article>

                <article class="card border-0 shadow-sm p-4 p-md-5 mb-4 scroll-margin-top" id="status-pendaftar">
                    <h2 class="h5 fw-bold mb-3"><i class="bi bi-flag text-primary me-2"></i>Status Pendaftar</h2>
                    <p class="small text-secondary">Setelah formulir dikirim, panitia sekolah meninjau data Anda. Status dapat dilihat oleh admin; siswa merasakan efeknya lewat fitur Cek Formulir.</p>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered mb-3">
                            <thead class="table-light">
                                <tr><th>Status</th><th>Arti</th><th>Yang Bisa Dilakukan Siswa</th></tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="fw-semibold">Pending</td>
                                    <td>Formulir sudah masuk, menunggu peninjauan panitia.</td>
                                    <td>Cek &amp; unduh PDF lewat NISN + tanggal lahir.</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Revisi</td>
                                    <td>Ada data yang perlu diperbaiki. Admin/operator mengizinkan perbaikan.</td>
                                    <td>Masuk lewat <strong>Cek Formulir Pendaftaran</strong> → data lama tetap tampil → edit → kirim ulang.</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Diterima</td>
                                    <td>Data disetujui / pendaftar diterima.</td>
                                    <td>Cek &amp; unduh PDF.</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Ditolak</td>
                                    <td>Pendaftaran tidak lolos peninjauan.</td>
                                    <td>Cek &amp; unduh PDF. Hubungi panitia untuk informasi lebih lanjut.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <h3 class="h6 fw-bold mb-2">Alur Perbaikan Data (Status Revisi)</h3>
                    <ol class="mb-0 small">
                        <li class="mb-1">Hubungi operator/admin sekolah jika ada kesalahan data setelah formulir dikirim.</li>
                        <li class="mb-1">Admin mengubah status pendaftar menjadi <strong>Revisi</strong>.</li>
                        <li class="mb-1">Siswa buka <a href="{{ route('spmb.index') }}#cek-formulir-spmb">Cek Formulir Pendaftaran</a>, masukkan NISN dan tanggal lahir.</li>
                        <li class="mb-1">Formulir terbuka dengan data lama yang sudah tersimpan — perbaiki bagian yang salah.</li>
                        <li>Setelah <strong>Kirim Formulir</strong>, status kembali ke <em>Pending</em> untuk ditinjau ulang oleh panitia.</li>
                    </ol>
                </article>

                <article class="card border-0 shadow-sm p-4 p-md-5 mb-4 scroll-margin-top" id="masalah">
                    <h2 class="h5 fw-bold mb-4"><i class="bi bi-wrench text-danger me-2"></i>Masalah Umum &amp; Cara Mengatasinya</h2>
                    <div class="accordion accordion-flush" id="panduanAccordion">
                        @foreach([
                            ['Tombol "Isi Formulir Dapodik" tidak muncul', 'Jadwal pengisian sudah ditutup.', 'Cek jadwal di halaman SPMB. Hubungi panitia jika melewati batas waktu karena kendala teknis.'],
                            ['"NISN harus 10 digit angka"', 'NISN kurang/lebih dari 10 digit, atau ada huruf/spasi.', 'Ketik ulang NISN dari kartu NISN. Hanya angka, tanpa titik atau strip.'],
                            ['"Nomor SPMB Banten ini sudah terdaftar"', 'NISN tersebut sudah pernah mengirim formulir (bukan mode revisi).', 'Gunakan fitur Cek Formulir (NISN + tanggal lahir) untuk unduh PDF. Jika data salah, hubungi panitia agar status diubah ke <strong>Revisi</strong>.'],
                            ['Tidak bisa lanjut ke tahap berikutnya', 'Ada field wajib (*) yang belum diisi, atau NISN ditolak sistem.', 'Isi semua yang bertanda bintang. Periksa Berkebutuhan Khusus (wajib centang minimal satu opsi) dan Nama Negara jika kewarganegaraan WNA. Jika sedang perbaikan data, pastikan admin sudah mengubah status ke Revisi lalu masuk lewat Cek Formulir.'],
                            ['Tidak bisa lanjut saat status Revisi', 'Belum masuk lewat Cek Formulir atau status belum diubah admin.', 'Buka SPMB → Cek Formulir Pendaftaran → masukkan NISN &amp; tanggal lahir. Jangan buka formulir baru dari menu Isi Formulir. Data lama akan muncul otomatis.'],
                            ['"Formulir belum dapat dikirim" / daftar error merah', 'Ada data yang tidak valid di salah satu tahap.', 'Baca pesan error, kembali ke tahap terkait, perbaiki, lalu kirim ulang dari tahap Preview.'],
                            ['Belum centang pernyataan kebenaran data', 'Checkbox di tahap Preview belum dicentang.', 'Centang pernyataan kebenaran data, lalu klik Kirim Formulir.'],
                            ['"Data tidak ditemukan" saat Cek Formulir', 'NISN/tanggal lahir salah, atau formulir belum pernah dikirim (masih draft).', 'Pastikan NISN dan tanggal lahir persis seperti saat mengisi. Pastikan sudah menekan Kirim Formulir (bukan hanya Simpan Draft).'],
                            ['Draft hilang / halaman tertutup', 'Browser ditutup sebelum kirim.', 'Buka kembali formulir dengan NISN yang sama — draft tersimpan di server setiap kali klik Lanjut.'],
                            ['"Koneksi bermasalah" / gagal kirim', 'Internet putus atau lemah.', 'Cek koneksi WiFi/data. Klik Simpan Draft dulu, muat ulang halaman, lalu coba Kirim Formulir lagi.'],
                            ['"Terlalu banyak percobaan kirim"', 'Tombol kirim ditekan berulang kali dalam waktu singkat.', 'Tunggu 1 menit, lalu tekan Kirim Formulir sekali saja.'],
                            ['PDF tidak terunduh', 'Browser memblokir unduhan otomatis.', 'Klik tombol Unduh PDF Formulir di halaman sukses, atau gunakan fitur Cek Formulir lalu unduh dari sana.'],
                            ['Ingin mengubah data setelah dikirim', 'Formulir yang sudah dikirim tidak bisa diedit sendiri.', 'Hubungi operator/admin sekolah. Jika diizinkan, status diubah ke <strong>Revisi</strong>. Masuk lewat Cek Formulir Pendaftaran (NISN + tanggal lahir), perbaiki data yang tersimpan, lalu kirim ulang.'],
                        ] as $i => [$title, $cause, $solution])
                        <div class="accordion-item">
                            <h3 class="accordion-header">
                                <button class="accordion-button {{ $i > 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#panduanItem{{ $i }}" aria-expanded="{{ $i === 0 ? 'true' : 'false' }}">
                                    {{ $title }}
                                </button>
                            </h3>
                            <div id="panduanItem{{ $i }}" class="accordion-collapse collapse {{ $i === 0 ? 'show' : '' }}" data-bs-parent="#panduanAccordion">
                                <div class="accordion-body small">
                                    <p class="mb-2"><strong>Penyebab:</strong> {{ $cause }}</p>
                                    <p class="mb-0"><strong>Solusi:</strong> {{ $solution }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </article>

                <article class="card border-0 shadow-sm p-4 p-md-5 mb-4 scroll-margin-top" id="checklist">
                    <h2 class="h5 fw-bold mb-3"><i class="bi bi-clipboard-check text-primary me-2"></i>Checklist Sebelum Kirim</h2>
                    <div class="row g-2">
                        @foreach([
                            'NISN & NIK sudah benar',
                            'Nama sesuai ijazah/KK',
                            'Alamat lengkap (RT/RW/Desa/Kecamatan/Kode Pos)',
                            'Data ayah & ibu lengkap',
                            'Nomor HP aktif',
                            'Jurusan sesuai hasil SPMB',
                            'NIS & asal sekolah benar',
                            'Sudah centang pernyataan kebenaran data',
                            'PDF sudah diunduh dan disimpan',
                        ] as $item)
                        <div class="col-md-6">
                            <label class="d-flex align-items-start gap-2 border rounded-3 p-3 mb-0 h-100 bg-body-tertiary small">
                                <input type="checkbox" class="form-check-input mt-1 flex-shrink-0" disabled>
                                <span>{{ $item }}</span>
                            </label>
                        </div>
                        @endforeach
                    </div>
                </article>

                <div class="card border-0 shadow-sm p-4 p-md-5 bg-primary-subtle">
                    <h2 class="h5 fw-bold mb-2"><i class="bi bi-headset me-2"></i>Butuh Bantuan?</h2>
                    <p class="small text-secondary mb-3">Hubungi panitia SPMB / TU {{ config('app.name') }}. Siapkan nama lengkap calon siswa, NISN, screenshot error (jika ada), dan No. Daftar Ulang (jika sudah pernah kirim).</p>
                    <ul class="list-unstyled small mb-4">
                        @if(setting('contact_ppdb'))
                        <li class="mb-1"><i class="bi bi-envelope me-1"></i> {{ setting('contact_ppdb') }}</li>
                        @endif
                        @if(setting('contact_phone'))
                        <li class="mb-1"><i class="bi bi-telephone me-1"></i> {{ setting('contact_phone') }}</li>
                        @endif
                        @if(setting('contact_whatsapp'))
                        <li><i class="bi bi-whatsapp me-1"></i> {{ setting('contact_whatsapp') }}</li>
                        @endif
                    </ul>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('spmb.index') }}" class="btn btn-outline-primary">
                            <i class="bi bi-arrow-left me-1"></i> Kembali ke Info SPMB
                        </a>
                        @if($isOpen)
                        <a href="{{ route('ppdb.create') }}" class="btn btn-primary">
                            <i class="bi bi-clipboard-data me-1"></i> Mulai Isi Formulir
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
.scroll-margin-top{scroll-margin-top:5.5rem}
.panduan-toc .list-group-item-action.active{background:var(--bs-primary);color:#fff;border-color:var(--bs-primary)}
</style>
@endpush

@push('scripts')
<script>
(function () {
    const links = document.querySelectorAll('.panduan-toc .list-group-item-action');
    const sections = Array.from(links).map(a => document.querySelector(a.getAttribute('href'))).filter(Boolean);
    if (!sections.length) return;
    const obs = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (!entry.isIntersecting) return;
            const id = '#' + entry.target.id;
            links.forEach(l => l.classList.toggle('active', l.getAttribute('href') === id));
        });
    }, { rootMargin: '-40% 0px -50% 0px', threshold: 0 });
    sections.forEach(s => obs.observe(s));
})();
</script>
@endpush
