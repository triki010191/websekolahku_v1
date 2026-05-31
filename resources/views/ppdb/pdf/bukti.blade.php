<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Bukti Daftar Ulang — {{ $reg->registration_number }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #111; }
        h1 { font-size: 16px; margin: 0 0 4px; }
        h2 { font-size: 13px; margin: 16px 0 6px; border-bottom: 1px solid #ccc; padding-bottom: 4px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 8px; }
        td { padding: 3px 6px; vertical-align: top; }
        td.label { width: 35%; color: #444; }
        .header { text-align: center; margin-bottom: 16px; }
        .muted { color: #666; font-size: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>BUKTI FORMULIR DAFTAR ULANG DAPODIK</h1>
        <div>{{ config('app.name') }}</div>
        <div class="muted">Tahun ajaran {{ setting('ppdb_year', '2026/2027') }}</div>
    </div>

    <table>
        <tr><td class="label">No. Daftar Ulang</td><td><strong>{{ $reg->registration_number }}</strong></td></tr>
        <tr><td class="label">No. Pendaftaran SPMB Banten</td><td><strong>{{ $reg->spmb_banten_number }}</strong></td></tr>
        <tr><td class="label">Tanggal Submit</td><td>{{ $reg->updated_at?->format('d/m/Y H:i') }}</td></tr>
    </table>

    <h2>Data Pribadi</h2>
    <table>
        <tr><td class="label">Nama Lengkap</td><td>{{ $reg->full_name }}</td></tr>
        <tr><td class="label">NISN / NIK</td><td>{{ $reg->nisn }} / {{ $reg->nik }}</td></tr>
        <tr><td class="label">Jenis Kelamin</td><td>{{ $reg->genderLabel() }}</td></tr>
        <tr><td class="label">Tempat, Tgl Lahir</td><td>{{ $reg->birth_place }}, {{ $reg->birth_date?->format('d/m/Y') }}</td></tr>
        <tr><td class="label">Agama</td><td>{{ $reg->religion }}</td></tr>
        <tr><td class="label">Alamat</td><td>{{ $reg->address }} RT {{ $reg->rt }}/RW {{ $reg->rw }}, {{ $reg->village }}, {{ $reg->district }}</td></tr>
    </table>

    <h2>Orang Tua / Wali</h2>
    <table>
        <tr><td class="label">Ayah</td><td>{{ $reg->father_name }} (NIK: {{ $reg->father_nik }})</td></tr>
        <tr><td class="label">Ibu</td><td>{{ $reg->mother_name }} (NIK: {{ $reg->mother_nik }})</td></tr>
        <tr><td class="label">Wali</td><td>{{ $reg->guardian_name }} (NIK: {{ $reg->guardian_nik }})</td></tr>
        <tr><td class="label">Kontak</td><td>{{ $reg->phone }} / {{ $reg->email }}</td></tr>
    </table>

    <h2>Registrasi</h2>
    <table>
        <tr><td class="label">Jurusan</td><td>{{ $reg->major?->name }}</td></tr>
        <tr><td class="label">Jenis Pendaftaran</td><td>{{ $reg->registration_type }}</td></tr>
        <tr><td class="label">Asal Sekolah</td><td>{{ $reg->previous_school }}</td></tr>
        <tr><td class="label">NIS</td><td>{{ $reg->nis }}</td></tr>
    </table>

    <p class="muted" style="margin-top:24px">Dokumen ini dicetak otomatis dari sistem. Simpan sebagai bukti pengisian formulir daftar ulang Dapodik.</p>
</body>
</html>
