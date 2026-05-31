<?php

namespace App\Support;

class PpdbFormOptions
{
    public static function religions(): array
    {
        return [
            'Islam', 'Kristen Protestan', 'Katolik', 'Hindu', 'Buddha', 'Konghucu', 'Kepercayaan kepada Tuhan YME',
        ];
    }

    public static function citizenships(): array
    {
        return ['WNI' => 'Indonesia (WNI)', 'WNA' => 'Asing (WNA)'];
    }

    public static function specialNeeds(): array
    {
        return [
            'Tidak', 'Netra', 'Rungu', 'Grahita Ringan', 'Grahita Sedang', 'Daksa Ringan', 'Daksa Sedang',
            'Laras', 'Wicara', 'Tuna Ganda', 'Hiperaktif', 'Cerdas Istimewa', 'Bakat Istimewa',
            'Kesulitan Belajar', 'Narkoba', 'Indigo', 'Down Syndrome', 'Autis',
        ];
    }

    public static function residenceTypes(): array
    {
        return [
            'Bersama Orang Tua', 'Wali', 'Kos', 'Asrama', 'Panti Asuhan', 'Lainnya',
        ];
    }

    public static function transportModes(): array
    {
        return [
            'Jalan Kaki', 'Kendaraan Pribadi', 'Kendaraan Umum', 'Jemputan Sekolah',
            'Kereta Api', 'Ojek', 'Delman/Beca', 'Perahu/Rakit', 'Lainnya',
        ];
    }

    public static function yesNo(): array
    {
        return ['1' => 'Ya', '0' => 'Tidak'];
    }

    public static function pipReasons(): array
    {
        return [
            'Pemegang PKH/KPS/KIP', 'Penerima BSM 2014', 'Yatim Piatu', 'Panti Asuhan',
            'Dampak Bencana Alam', 'Pernah Drop Out', 'Siswa Miskin/Rentan Miskin',
            'Daerah Konflik', 'Keluarga Terpidana', 'Kelainan Fisik', 'Alasan Lainnya',
        ];
    }

    public static function educations(): array
    {
        return [
            'Tidak Sekolah', 'Putus SD', 'SD', 'SMP', 'SMA', 'D1', 'D2', 'D3', 'D4/S1', 'S2', 'S3',
        ];
    }

    public static function occupations(): array
    {
        return [
            'Tidak Bekerja', 'Nelayan', 'Petani', 'Peternak', 'PNS/TNI/POLRI', 'Karyawan Swasta',
            'Pedagang', 'Wiraswasta', 'Wirausaha', 'Buruh', 'Pensiunan', 'Lainnya',
        ];
    }

    public static function incomes(): array
    {
        return [
            '< Rp500.000', 'Rp500.000 – Rp999.999', 'Rp1.000.000 – Rp1.999.999',
            'Rp2.000.000 – Rp4.999.999', 'Rp5.000.000 – Rp20.000.000', '> Rp20.000.000',
        ];
    }

    public static function distanceCategories(): array
    {
        return ['Kurang dari 1 km', 'Lebih dari 1 km'];
    }

    public static function achievementTypes(): array
    {
        return ['Sains', 'Seni', 'Olahraga', 'Lainnya'];
    }

    public static function achievementLevels(): array
    {
        return ['Sekolah', 'Kecamatan', 'Kabupaten/Kota', 'Provinsi', 'Nasional', 'Internasional'];
    }

    public static function scholarshipTypes(): array
    {
        return ['Anak Berprestasi', 'Anak Miskin', 'Pendidikan', 'Unggulan', 'Lainnya'];
    }

    public static function registrationTypes(): array
    {
        return [
            'siswa_baru' => 'Siswa Baru',
            'pindahan'   => 'Pindahan',
            'kembali'    => 'Kembali Bersekolah',
        ];
    }

    public static function stepLabels(): array
    {
        return [
            1 => 'Data Pribadi',
            2 => 'Data Ayah',
            3 => 'Data Ibu',
            4 => 'Data Wali',
            5 => 'Kontak',
            6 => 'Data Periodik',
            7 => 'Prestasi',
            8 => 'Beasiswa',
            9 => 'Registrasi',
            10 => 'Preview',
        ];
    }
}
