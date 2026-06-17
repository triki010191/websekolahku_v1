<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kartu TES — {{ $reg->exam_number ?? $reg->registration_number }}</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 18mm 16mm;
        }
        * { box-sizing: border-box; }
        html, body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #000;
            margin: 0;
            padding: 0;
            width: 100%;
            line-height: 1.4;
        }
        .card {
            border: 2px solid #000;
            border-radius: 6px;
            overflow: hidden;
            width: 100%;
            background: #fff;
        }
        .header {
            background: #fff;
            padding: 14px 16px 12px;
            border-bottom: 1px solid #000;
        }
        .header-layout {
            width: 100%;
            border-collapse: collapse;
        }
        .header-layout td {
            vertical-align: middle;
        }
        .header-logo {
            width: 76px;
            padding-right: 14px;
        }
        .header-logo img {
            width: 68px;
            height: 68px;
            object-fit: contain;
        }
        .header-text {
            text-align: left;
        }
        .header .school {
            font-size: 16px;
            font-weight: bold;
            margin: 0 0 3px;
            color: #000;
        }
        .header h1 {
            font-size: 14px;
            margin: 0 0 3px;
            letter-spacing: 0.5px;
            color: #000;
            font-weight: bold;
        }
        .header .year {
            font-size: 10px;
            margin: 0;
            color: #000;
        }
        .title-bar {
            background: #fff;
            border-bottom: 1px solid #000;
            text-align: center;
            padding: 8px 16px;
            font-size: 12px;
            font-weight: bold;
            letter-spacing: 0.5px;
            color: #000;
        }
        .body {
            padding: 14px 16px 16px;
        }
        .exam-no {
            margin: 0 0 14px;
            text-align: center;
            border: 1px dashed #000;
            background: #fff;
            padding: 10px 12px;
            border-radius: 4px;
        }
        .exam-no .label {
            font-size: 10px;
            color: #000;
            margin-bottom: 3px;
        }
        .exam-no .number {
            font-size: 20px;
            font-weight: bold;
            color: #000;
            letter-spacing: 1px;
        }
        .identity-layout {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0;
        }
        .identity-layout td {
            vertical-align: top;
            padding: 0;
        }
        .photo-box {
            width: 90px;
            height: 115px;
            border: 1px solid #000;
            text-align: center;
            font-size: 9px;
            color: #000;
            padding-top: 46px;
            background: #fff;
        }
        .info {
            padding-left: 14px;
        }
        .info table {
            width: 100%;
            border-collapse: collapse;
        }
        .info td {
            padding: 6px 0;
            vertical-align: top;
            border-bottom: 1px dotted #000;
            color: #000;
            font-size: 11px;
        }
        .info td.label {
            width: 38%;
            font-weight: bold;
        }
        .schedule {
            margin-top: 12px;
            border-top: 1px solid #000;
            padding-top: 10px;
        }
        .schedule table {
            width: 100%;
            border-collapse: collapse;
        }
        .schedule td {
            padding: 5px 0;
            vertical-align: top;
            color: #000;
            font-size: 11px;
        }
        .schedule td.label {
            width: 30%;
            font-weight: bold;
        }
        .note {
            margin-top: 14px;
            padding: 10px 12px;
            background: #fff;
            border: 1px solid #000;
            border-radius: 4px;
            font-size: 10px;
            line-height: 1.45;
            color: #000;
        }
    </style>
</head>
<body>
@php
    use App\Support\PpdbFieldLabels as L;
    $schoolName = setting('site_name', config('app.name'));
    $yearLabel = setting('ppdb_year', date('Y').'/'.(date('Y')+1));
    $testDate = setting('ppdb_test_date', 'Akan diumumkan');
    $testLocation = setting('ppdb_test_location', setting('contact_address', '-'));
    $testTime = setting('ppdb_test_time', '07.00 WIB');
    $siteLogoPath = setting('site_logo');
    $schoolLogoFile = storage_file_exists($siteLogoPath)
        ? storage_path('app/public/'.ltrim($siteLogoPath, '/'))
        : null;
@endphp

<div class="card">
    <div class="header">
        <table class="header-layout">
            <tr>
                @if($schoolLogoFile)
                <td class="header-logo">
                    <img src="{{ $schoolLogoFile }}" alt="Logo {{ $schoolName }}">
                </td>
                @endif
                <td class="header-text">
                    <p class="school">{{ $schoolName }}</p>
                    <h1>KARTU PESERTA TES</h1>
                    <p class="year">Seleksi Penerimaan Murid Baru (SPMB) Tahun Ajaran {{ $yearLabel }}</p>
                </td>
            </tr>
        </table>
    </div>

    <div class="title-bar">BUKTI VALIDASI DATA PENDAFTAR</div>

    <div class="body">
        <div class="exam-no">
            <div class="label">NOMOR PESERTA TES</div>
            <div class="number">{{ L::dash($reg->exam_number) }}</div>
        </div>

        <table class="identity-layout">
            <tr>
                <td style="width: 96px">
                    <div class="photo-box">Foto<br>3×4</div>
                </td>
                <td class="info">
                    <table>
                        <tr><td class="label">Nama Lengkap</td><td>{{ L::dash($reg->full_name) }}</td></tr>
                        <tr><td class="label">NISN</td><td>{{ L::dash($reg->nisn) }}</td></tr>
                        <tr><td class="label">NIK</td><td>{{ L::dash($reg->nik) }}</td></tr>
                        <tr><td class="label">Jenis Kelamin</td><td>{{ $reg->gender ? $reg->genderLabel() : '-' }}</td></tr>
                        <tr><td class="label">Tempat, Tgl Lahir</td><td>{{ L::dash($reg->birth_place) }}, {{ L::date($reg->birth_date) }}</td></tr>
                    </table>
                </td>
            </tr>
        </table>

        <div class="schedule">
            <table>
                <tr><td class="label">No. Daftar Ulang</td><td>{{ $reg->registration_number }}</td></tr>
                <tr><td class="label">No. SPMB Banten</td><td>{{ L::dash($reg->spmb_banten_number) }}</td></tr>
                <tr><td class="label">Asal Sekolah</td><td>{{ L::dash($reg->previous_school) }}</td></tr>
                <tr><td class="label">Pilihan Jurusan</td><td>{{ L::dash($reg->major?->name) }} ({{ L::dash($reg->major?->code) }})</td></tr>
                <tr><td class="label">Tanggal Tes</td><td>{{ $testDate }}</td></tr>
                <tr><td class="label">Waktu</td><td>{{ $testTime }}</td></tr>
                <tr><td class="label">Lokasi</td><td>{{ $testLocation }}</td></tr>
            </table>
        </div>

        <div class="note">
            <strong>Catatan:</strong> Kartu ini dicetak setelah data formulir Dapodik dinyatakan valid oleh panitia.
            Peserta wajib membawa kartu ini saat tes seleksi. Pastikan identitas sesuai dengan dokumen asli.
        </div>
    </div>
</div>
</body>
</html>
