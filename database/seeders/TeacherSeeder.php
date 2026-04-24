<?php

namespace Database\Seeders;

use App\Models\Teacher;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nip' => '196508101990031004', 'name' => 'Drs. H. Ahmad Fauzi, M.Pd',  'gender' => 'L', 'position' => 'Kepala Sekolah', 'subject' => 'Manajemen Pendidikan', 'employment_status' => 'pns',     'field' => 'struktural'],
            ['nip' => '197509202005011003', 'name' => 'Imran Sumarsa, S.T.',         'gender' => 'L', 'position' => 'Waka Kurikulum',  'subject' => 'Pemrograman Web',      'employment_status' => 'pns',     'field' => 'rpl'],
            ['nip' => '198003102010012008', 'name' => 'Siti Maryam, S.Pd.',          'gender' => 'P', 'position' => 'Waka Kesiswaan',  'subject' => 'Bahasa Indonesia',     'employment_status' => 'pns',     'field' => 'normatif'],
            ['nip' => '198506102012011002', 'name' => 'Budi Pranoto, M.T.',          'gender' => 'L', 'position' => 'Kaprog AKL',      'subject' => 'Akuntansi Keuangan',   'employment_status' => 'pppk',    'field' => 'akl'],
            ['nip' => '198710052013012001', 'name' => 'Maya Sari, S.Ds.',            'gender' => 'P', 'position' => 'Kaprog DKV',      'subject' => 'Desain Grafis',        'employment_status' => 'pppk',    'field' => 'dkv'],
            ['nip' => '198002102008011005', 'name' => 'Rahmat Hidayat, S.T.',        'gender' => 'L', 'position' => 'Kaprog TBSM',     'subject' => 'Teknik Otomotif',      'employment_status' => 'pns',     'field' => 'tbsm'],
            ['nip' => '198412082012011003', 'name' => 'Dwi Santoso, S.T.',           'gender' => 'L', 'position' => 'Kaprog TITL',     'subject' => 'Instalasi Listrik',    'employment_status' => 'pns',     'field' => 'titl'],
            ['nip' => '199211252020121001', 'name' => 'Rendi Pratama, S.Kom.',       'gender' => 'L', 'position' => 'Guru Produktif',  'subject' => 'Basis Data',           'employment_status' => 'honorer', 'field' => 'rpl'],
            ['nip' => '199509142021022002', 'name' => 'Intan Permata, S.Pd.',        'gender' => 'P', 'position' => 'Guru Normatif',   'subject' => 'Matematika',           'employment_status' => 'pppk',    'field' => 'adaptif'],
            ['nip' => null,                 'name' => 'Yusuf Ramadhan',              'gender' => 'L', 'position' => 'Staff TU',        'subject' => 'Administrasi Umum',    'employment_status' => 'honorer', 'field' => 'tu'],
        ];

        foreach ($data as $i => $d) {
            Teacher::updateOrCreate(
                ['name' => $d['name']],
                $d + ['sort_order' => $i, 'is_active' => true]
            );
        }
    }
}
