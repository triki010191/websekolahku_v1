<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Bukti Validasi — {{ $reg->registration_number }}</title>
    <style>
        @page { size: A4 portrait; margin: 12mm 14mm; }
        * { box-sizing: border-box; }
        html, body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #111;
            margin: 0;
            padding: 0;
            line-height: 1.35;
        }
        table { border-collapse: collapse; width: 100%; }
        .doc { border: 1.5px solid #111; }
        .hdr td {
            vertical-align: middle;
            padding: 10px 12px;
            border-bottom: 1px solid #111;
        }
        .hdr-logo { width: 80px; text-align: left; padding-right: 4px; }
        .hdr-logo img { width: 64px; height: 64px; object-fit: contain; }
        .hdr-center { text-align: left; padding-left: 4px; }
        .hdr-center .school { font-size: 15px; font-weight: bold; margin: 0 0 3px; }
        .hdr-center .title { font-size: 12px; font-weight: bold; margin: 0 0 3px; letter-spacing: 0.3px; }
        .hdr-center .year { font-size: 9.5px; margin: 0; }
        .doc-bar {
            text-align: center;
            padding: 8px 12px;
            border-bottom: 1px solid #111;
        }
        .doc-bar .main { font-size: 11px; font-weight: bold; margin: 0 0 2px; }
        .doc-bar .sub { font-size: 9px; margin: 0; }
        .section-hdr {
            background: #e6e6e6;
            border-bottom: 1px solid #111;
            padding: 5px 10px;
            font-weight: bold;
            font-size: 10px;
        }
        .info-grid td {
            border-right: 1px solid #111;
            border-bottom: 1px solid #111;
            padding: 6px 10px;
            vertical-align: top;
            width: 33.33%;
        }
        .info-grid td:last-child { border-right: none; }
        .info-grid .lbl { font-weight: bold; font-size: 9px; margin-bottom: 2px; }
        .info-grid .val { font-size: 10px; }
        .data-row td {
            border-bottom: 1px dotted #999;
            padding: 5px 10px;
            vertical-align: top;
            font-size: 10px;
        }
        .data-row td.lbl {
            width: 28%;
            background: #f3f3f3;
            font-weight: bold;
        }
        .data-row.alt td.lbl { background: #ececec; }
        .data-row.alt td.val { background: #fafafa; }
        .extra td {
            border-bottom: 1px solid #111;
            padding: 5px 10px;
            font-size: 10px;
        }
        .extra td.lbl {
            width: 50%;
            background: #e6e6e6;
            font-weight: bold;
            border-right: 1px solid #111;
        }
        .sign-box td {
            border-bottom: 1px solid #111;
            width: 33.33%;
            vertical-align: top;
            padding: 10px 8px 12px;
            font-size: 9.5px;
            line-height: 1.45;
        }
        .sign-box td + td { border-left: 1px solid #111; }
        .sign-space { height: 52px; }
        .sign-line { text-align: center; margin-top: 4px; }
        .sign-name { text-align: center; font-weight: bold; margin-top: 4px; }
        .footer td {
            padding: 8px 10px;
            vertical-align: middle;
            font-size: 8px;
            line-height: 1.4;
        }
        .footer-left { width: 72%; }
        .footer-right {
            width: 28%;
            border-left: 1px solid #111;
            text-align: center;
        }
        .footer-right img { height: 42px; object-fit: contain; }
    </style>
</head>
<body>
@php
    use App\Support\PpdbFieldLabels as L;

    $schoolName = setting('site_name', config('app.name'));
    $yearLabel = setting('ppdb_year', date('Y').'/'.(date('Y')+1));
    $spmbUrl = 'https://spmb.bantenprov.go.id/';
    $schoolUrl = 'https://smkn8pandeglang.sch.id';
    $printCity = 'Pandeglang';
    $printDate = now()->translatedFormat('d F Y');
    $operatorName = $operator?->name ?? 'Administrator';
    $jenjang = setting('ppdb_jenjang', 'Sekolah Menengah Kejuruan Negeri');
    $regDate = ($reg->verified_at ?? $reg->updated_at)?->translatedFormat('d F Y H:i:s') ?? '-';

    $siteLogoPath = setting('site_logo');
    $schoolLogoFile = storage_file_exists($siteLogoPath)
        ? storage_path('app/public/'.ltrim($siteLogoPath, '/'))
        : (is_file(public_path('images/spmb-banten-official.png')) ? public_path('images/spmb-banten-official.png') : null);

    $spmbLogoPath = setting('spmb_banten_logo');
    $spmbLogoFile = storage_file_exists($spmbLogoPath)
        ? storage_path('app/public/'.ltrim($spmbLogoPath, '/'))
        : (is_file(public_path('images/spmb-banten-official.png')) ? public_path('images/spmb-banten-official.png') : null);

    $alamat = strtoupper(collect([
        $reg->address,
        ($reg->rt || $reg->rw) ? 'RT '.L::dash($reg->rt).' / RW '.L::dash($reg->rw) : null,
        $reg->hamlet,
        $reg->village,
        $reg->district,
        $reg->city,
        $reg->postal_code,
    ])->filter(fn ($v) => filled($v) && $v !== '-')->implode(', '));

    $specialNeeds = array_values(array_filter((array) $reg->special_needs));
    $disabilitas = (empty($specialNeeds) || $specialNeeds === ['Tidak']) ? 'Tidak' : 'Ya';

    $dataRows = [
        ['NISN', L::dash($reg->nisn)],
        ['NIK', L::dash($reg->nik)],
        ['Nama Lengkap', strtoupper(L::dash($reg->full_name))],
        ['Jenis Kelamin', $reg->gender ? $reg->genderLabel() : '-'],
        ['Tempat, Tgl Lahir', strtoupper(L::dash($reg->birth_place)).', '.L::date($reg->birth_date)],
        ['Alamat', $alamat !== '' ? $alamat : '-'],
        ['Sekolah Asal', strtoupper(L::dash($reg->previous_school))],
        ['Pilih Jurusan', L::dash($reg->major?->name)],
    ];
@endphp

<table class="doc">
    <tr class="hdr">
        <td class="hdr-logo">
            @if($schoolLogoFile)
            <img src="{{ $schoolLogoFile }}" alt="Logo">
            @endif
        </td>
        <td class="hdr-center">
            <p class="school">{{ $schoolName }}</p>
            <p class="title">TANDA BUKTI PENDAFTARAN</p>
            <p class="year">Seleksi Penerimaan Murid Baru (SPMB) Tahun {{ $yearLabel }}</p>
        </td>
    </tr>
</table>

<div class="doc doc-bar">
    <p class="main">TANDA BUKTI VALIDASI DATA PENDAFTAR</p>
    <p class="sub">SISTEM PENERIMAAN MURID BARU — Tahun ajaran {{ $yearLabel }}</p>
</div>

<div class="doc section-hdr" style="border-top: none;">Info Pendaftaran</div>
<table class="doc" style="border-top: none;">
    <tr class="info-grid">
        <td>
            <div class="lbl">Nomor Pendaftaran</div>
            <div class="val">{{ L::dash($reg->registration_number) }}</div>
        </td>
        <td>
            <div class="lbl">Jenjang</div>
            <div class="val">{{ $jenjang }}</div>
        </td>
        <td>
            <div class="lbl">Tanggal</div>
            <div class="val">{{ $regDate }}</div>
        </td>
    </tr>
</table>

<table class="doc" style="border-top: none;">
    @foreach($dataRows as $i => $row)
    <tr class="data-row {{ $i % 2 ? 'alt' : '' }}">
        <td class="lbl">{{ $row[0] }}</td>
        <td class="val">{{ $row[1] }}</td>
    </tr>
    @endforeach
</table>

<div class="doc section-hdr" style="border-top: none;">Data Tambahan</div>
<table class="doc extra" style="border-top: none;">
    <tr>
        <td class="lbl">Status anak Penyandang Disabilitas</td>
        <td>{{ $disabilitas }}</td>
    </tr>
</table>

<table class="doc sign-box" style="border-top: none;">
    <tr>
        <td>
            a/n {{ strtoupper(L::dash($reg->full_name)) }}<br>
            Menyetujui data diatas,<br>
            Ortu/Wali Murid terdaftar **)
            <div class="sign-space"></div>
            <div class="sign-line">(......................................)</div>
        </td>
        <td>
            Menyetujui data diatas,<br>
            Murid terdaftar
            <div class="sign-space"></div>
            <div class="sign-name">{{ L::dash($reg->full_name) }}</div>
        </td>
        <td>
            {{ $printCity }}, {{ $printDate }}<br>
            Operator SPMB
            <div class="sign-space"></div>
            <div class="sign-name">({{ $operatorName }})</div>
        </td>
    </tr>
</table>

<table class="doc footer" style="border-top: none;">
    <tr>
        <td class="footer-left">
            Pantau hasil seleksi Sistem Penerimaan Murid Baru Anda melalui Website {{ $spmbUrl }} atau {{ $schoolUrl }}
        </td>
        <td class="footer-right">
            @if($spmbLogoFile)
            <img src="{{ $spmbLogoFile }}" alt="SPMB Online">
            @else
            <strong>SPMB online</strong>
            @endif
        </td>
    </tr>
</table>
</body>
</html>
