<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Formulir Dapodik — {{ $reg->registration_number }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 10px; color: #111; line-height: 1.35; }
        h1 { font-size: 15px; margin: 0 0 4px; text-align: center; }
        h2 { font-size: 11px; margin: 12px 0 4px; border-bottom: 1px solid #999; padding-bottom: 2px; page-break-after: avoid; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 6px; }
        td { padding: 2px 4px; vertical-align: top; border-bottom: 1px solid #eee; }
        td.label { width: 38%; color: #333; font-weight: bold; }
        .header { text-align: center; margin-bottom: 12px; }
        .muted { color: #666; font-size: 9px; }
        .section { page-break-inside: avoid; }
        .grid-table th, .grid-table td { border: 1px solid #ccc; padding: 3px 4px; font-size: 9px; }
        .grid-table th { background: #f3f3f3; }
    </style>
</head>
<body>
@php use App\Support\PpdbFieldLabels as L; @endphp
    <div class="header">
        <h1>FORMULIR DAFTAR ULANG DAPODIK</h1>
        <div><strong>{{ config('app.name') }}</strong></div>
        <div class="muted">Tahun ajaran {{ setting('ppdb_year', '2026/2027') }} — Dicetak {{ now()->format('d/m/Y H:i') }}</div>
    </div>

    <div class="section">
        <h2>Identitas Pendaftaran</h2>
        <table>
            <tr><td class="label">No. Daftar Ulang</td><td>{{ $reg->registration_number }}</td></tr>
            <tr><td class="label">No. Pendaftaran SPMB Banten</td><td>{{ L::dash($reg->spmb_banten_number) }}</td></tr>
            <tr><td class="label">Tanggal Kirim Formulir</td><td>{{ $reg->updated_at?->format('d/m/Y H:i') }}</td></tr>
        </table>
    </div>

    <div class="section">
        <h2>1. Data Pribadi</h2>
        <table>
            <tr><td class="label">Nama Lengkap</td><td>{{ L::dash($reg->full_name) }}</td></tr>
            <tr><td class="label">NISN</td><td>{{ L::dash($reg->nisn) }}</td></tr>
            <tr><td class="label">NIK / No. KITAS</td><td>{{ L::dash($reg->nik) }}</td></tr>
            <tr><td class="label">Jenis Kelamin</td><td>{{ $reg->gender ? $reg->genderLabel() : '-' }}</td></tr>
            <tr><td class="label">Tempat, Tanggal Lahir</td><td>{{ L::dash($reg->birth_place) }}, {{ L::date($reg->birth_date) }}</td></tr>
            <tr><td class="label">No. Registrasi Akta Kelahiran</td><td>{{ L::dash($reg->birth_cert_number) }}</td></tr>
            <tr><td class="label">Agama / Kepercayaan</td><td>{{ L::dash($reg->religion) }}</td></tr>
            <tr><td class="label">Kewarganegaraan</td><td>{{ L::dash($reg->citizenship) }}{{ $reg->country_name ? ' — '.$reg->country_name : '' }}</td></tr>
            <tr><td class="label">Berkebutuhan Khusus</td><td>{{ L::list($reg->special_needs) }}</td></tr>
        </table>
    </div>

    <div class="section">
        <h2>Alamat Tempat Tinggal</h2>
        <table>
            <tr><td class="label">Alamat Jalan</td><td>{{ L::dash($reg->address) }}</td></tr>
            <tr><td class="label">RT / RW</td><td>{{ L::dash($reg->rt) }} / {{ L::dash($reg->rw) }}</td></tr>
            <tr><td class="label">Dusun / Kelurahan / Kecamatan</td><td>{{ L::dash($reg->hamlet) }} / {{ L::dash($reg->village) }} / {{ L::dash($reg->district) }}</td></tr>
            <tr><td class="label">Kab/Kota / Kode Pos</td><td>{{ L::dash($reg->city) }} / {{ L::dash($reg->postal_code) }}</td></tr>
            <tr><td class="label">Koordinat (Lat / Long)</td><td>{{ L::dash($reg->latitude) }} / {{ L::dash($reg->longitude) }}</td></tr>
            <tr><td class="label">Tempat Tinggal</td><td>{{ L::dash($reg->residence_type) }}</td></tr>
            <tr><td class="label">Moda Transportasi</td><td>{{ L::dash($reg->transport_mode) }}</td></tr>
        </table>
    </div>

    <div class="section">
        <h2>Program Bantuan Sosial &amp; Perbankan</h2>
        <table>
            <tr><td class="label">Nomor KKS</td><td>{{ L::dash($reg->kks_number) }}</td></tr>
            <tr><td class="label">Anak Keberapa</td><td>{{ L::dash($reg->child_order) }}</td></tr>
            <tr><td class="label">Penerima KPS/PKH</td><td>{{ L::yesNo($reg->kps_pkh_receiver) }} {{ $reg->kps_pkh_number ? '— '.$reg->kps_pkh_number : '' }}</td></tr>
            <tr><td class="label">Layak PIP</td><td>{{ L::yesNo($reg->pip_eligible) }} — {{ L::dash($reg->pip_reason) }}</td></tr>
            <tr><td class="label">Penerima KIP</td><td>{{ L::yesNo($reg->kip_receiver) }} — {{ L::dash($reg->kip_number) }}</td></tr>
            <tr><td class="label">Nama di KIP</td><td>{{ L::dash($reg->kip_name) }}</td></tr>
            <tr><td class="label">Terima Kartu KIP Fisik</td><td>{{ L::yesNo($reg->kip_card_received) }}</td></tr>
            <tr><td class="label">Bank / No. Rekening / Atas Nama</td><td>{{ L::dash($reg->bank_name) }} / {{ L::dash($reg->bank_account_number) }} / {{ L::dash($reg->bank_account_holder) }}</td></tr>
        </table>
    </div>

    <div class="section">
        <h2>2. Data Ayah Kandung</h2>
        <table>
            <tr><td class="label">Nama</td><td>{{ L::dash($reg->father_name) }}</td></tr>
            <tr><td class="label">NIK / Tahun Lahir</td><td>{{ L::dash($reg->father_nik) }} / {{ L::dash($reg->father_birth_year) }}</td></tr>
            <tr><td class="label">Pendidikan / Pekerjaan</td><td>{{ L::dash($reg->father_education) }} / {{ L::dash($reg->father_job) }}</td></tr>
            <tr><td class="label">Penghasilan Bulanan</td><td>{{ L::dash($reg->father_income) }}</td></tr>
            <tr><td class="label">Berkebutuhan Khusus</td><td>{{ L::list($reg->father_special_needs) }}</td></tr>
        </table>
    </div>

    <div class="section">
        <h2>3. Data Ibu Kandung</h2>
        <table>
            <tr><td class="label">Nama</td><td>{{ L::dash($reg->mother_name) }}</td></tr>
            <tr><td class="label">NIK / Tahun Lahir</td><td>{{ L::dash($reg->mother_nik) }} / {{ L::dash($reg->mother_birth_year) }}</td></tr>
            <tr><td class="label">Pendidikan / Pekerjaan</td><td>{{ L::dash($reg->mother_education) }} / {{ L::dash($reg->mother_job) }}</td></tr>
            <tr><td class="label">Penghasilan Bulanan</td><td>{{ L::dash($reg->mother_income) }}</td></tr>
            <tr><td class="label">Berkebutuhan Khusus</td><td>{{ L::list($reg->mother_special_needs) }}</td></tr>
        </table>
    </div>

    <div class="section">
        <h2>4. Data Wali</h2>
        <table>
            <tr><td class="label">Nama</td><td>{{ L::dash($reg->guardian_name) }}</td></tr>
            <tr><td class="label">NIK / Tahun Lahir</td><td>{{ L::dash($reg->guardian_nik) }} / {{ L::dash($reg->guardian_birth_year) }}</td></tr>
            <tr><td class="label">Pendidikan / Pekerjaan</td><td>{{ L::dash($reg->guardian_education) }} / {{ L::dash($reg->guardian_job) }}</td></tr>
            <tr><td class="label">Penghasilan Bulanan</td><td>{{ L::dash($reg->guardian_income) }}</td></tr>
        </table>
    </div>

    <div class="section">
        <h2>5. Data Kontak</h2>
        <table>
            <tr><td class="label">Telepon Rumah</td><td>{{ L::dash($reg->home_phone) }}</td></tr>
            <tr><td class="label">Nomor Handphone</td><td>{{ L::dash($reg->phone) }}</td></tr>
            <tr><td class="label">Email</td><td>{{ L::dash($reg->email) }}</td></tr>
        </table>
    </div>

    <div class="section">
        <h2>6. Data Periodik</h2>
        <table>
            <tr><td class="label">Tinggi / Berat Badan</td><td>{{ L::dash($reg->height_cm) }} cm / {{ L::dash($reg->weight_kg) }} kg</td></tr>
            <tr><td class="label">Jarak ke Sekolah</td><td>{{ L::dash($reg->distance_category) }} ({{ L::dash($reg->distance_km) }} km)</td></tr>
            <tr><td class="label">Waktu Tempuh</td><td>{{ L::dash($reg->travel_hours) }} jam {{ L::dash($reg->travel_minutes) }} menit</td></tr>
            <tr><td class="label">Jumlah Saudara Kandung</td><td>{{ L::dash($reg->siblings_count) }}</td></tr>
        </table>
    </div>

    @if($reg->achievements && count($reg->achievements))
    <div class="section">
        <h2>7. Data Prestasi</h2>
        <table class="grid-table">
            <thead><tr><th>Jenis</th><th>Tingkat</th><th>Nama</th><th>Tahun</th><th>Penyelenggara</th><th>Peringkat</th></tr></thead>
            <tbody>
            @foreach($reg->achievements as $ach)
                <tr>
                    <td>{{ L::dash($ach['type'] ?? null) }}</td>
                    <td>{{ L::dash($ach['level'] ?? null) }}</td>
                    <td>{{ L::dash($ach['name'] ?? null) }}</td>
                    <td>{{ L::dash($ach['year'] ?? null) }}</td>
                    <td>{{ L::dash($ach['organizer'] ?? null) }}</td>
                    <td>{{ L::dash($ach['rank'] ?? null) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @endif

    @if($reg->scholarships && count($reg->scholarships))
    <div class="section">
        <h2>8. Data Beasiswa</h2>
        <table class="grid-table">
            <thead><tr><th>Jenis</th><th>Keterangan</th><th>Tahun Mulai</th><th>Tahun Selesai</th></tr></thead>
            <tbody>
            @foreach($reg->scholarships as $sch)
                <tr>
                    <td>{{ L::dash($sch['type'] ?? null) }}</td>
                    <td>{{ L::dash($sch['description'] ?? null) }}</td>
                    <td>{{ L::dash($sch['year_start'] ?? null) }}</td>
                    <td>{{ L::dash($sch['year_end'] ?? null) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <div class="section">
        <h2>9. Data Registrasi Peserta Didik</h2>
        <table>
            <tr><td class="label">Kompetensi Keahlian</td><td>{{ L::dash($reg->major?->name) }}</td></tr>
            <tr><td class="label">Jenis Pendaftaran</td><td>{{ L::registrationType($reg->registration_type) }}</td></tr>
            <tr><td class="label">NIS</td><td>{{ L::dash($reg->nis) }}</td></tr>
            <tr><td class="label">Tanggal Masuk Sekolah</td><td>{{ L::date($reg->school_entry_date) }}</td></tr>
            <tr><td class="label">Asal Sekolah</td><td>{{ L::dash($reg->previous_school) }}</td></tr>
            <tr><td class="label">Nomor Peserta Ujian</td><td>{{ L::dash($reg->exam_number) }}</td></tr>
            <tr><td class="label">Nomor Seri Ijazah</td><td>{{ L::dash($reg->diploma_serial) }}</td></tr>
            <tr><td class="label">Nomor Seri SKHUS/SKHUN</td><td>{{ L::dash($reg->skhus_serial) }}</td></tr>
        </table>
    </div>

    <p class="muted" style="margin-top:16px">
        Pernyataan: Peserta didik menyatakan bahwa seluruh data di atas benar dan dapat dipertanggungjawabkan.
        Dokumen ini dicetak otomatis dari sistem {{ config('app.name') }}.
    </p>

    <table style="margin-top:36px; width:100%; page-break-inside:avoid">
        <tr>
            <td style="width:55%"></td>
            <td style="width:45%; text-align:center; vertical-align:top">
                <p style="margin:0 0 8px">Pandeglang, {{ $reg->updated_at?->format('d/m/Y') ?? now()->format('d/m/Y') }}</p>
                <p style="margin:0 0 24px">Peserta Didik,</p>
                <div style="height:56px"></div>
                <p style="margin:0; font-weight:bold; text-decoration:underline">{{ $reg->full_name }}</p>
                <p class="muted" style="margin:6px 0 0">Tanda Tangan Siswa</p>
            </td>
        </tr>
    </table>
</body>
</html>
