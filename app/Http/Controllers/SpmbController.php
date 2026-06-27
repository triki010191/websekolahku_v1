<?php

namespace App\Http\Controllers;

use App\Models\Major;
use App\Models\Page;
use App\Models\SpmbGraduationResult;
use Illuminate\Http\Request;

class SpmbController extends Controller
{
    public function index()
    {
        $page = Page::where('slug', 'spmb-2026')->where('is_published', true)->first();

        $majors = Major::where('is_active', true)->orderBy('sort_order')->get();

        $isOpen = (bool) setting('ppdb_is_open', false);

        return view('spmb.index', compact('page', 'majors', 'isOpen'));
    }

    public function praSpmb()
    {
        return view('spmb.pra-spmb');
    }

    public function jadwalTes()
    {
        return view('spmb.jadwal-tes');
    }

    public function tesBakatMinat()
    {
        return view('spmb.tes-bakat-minat');
    }

    public function daftarUlang()
    {
        return view('spmb.daftar-ulang');
    }

    public function panduanDapodik()
    {
        $isOpen = (bool) setting('ppdb_is_open', false);

        return view('spmb.panduan-dapodik', compact('isOpen'));
    }

    public function pengumumanKelulusan(Request $request)
    {
        $isPublished = (bool) setting('spmb_graduation_published', false);
        $search = trim((string) $request->query('q', ''));
        $major = trim((string) $request->query('jurusan', ''));
        $gender = strtoupper(trim((string) $request->query('jk', '')));

        if (! in_array($major, SpmbGraduationResult::ACCEPTED_MAJORS, true)) {
            $major = '';
        }

        if (! in_array($gender, ['L', 'P'], true)) {
            $gender = '';
        }

        $results = SpmbGraduationResult::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('registration_number', 'like', "%{$search}%")
                        ->orWhere('nisn', 'like', "%{$search}%")
                        ->orWhere('full_name', 'like', "%{$search}%")
                        ->orWhere('origin_school', 'like', "%{$search}%")
                        ->orWhere('accepted_major', 'like', "%{$search}%");
                });
            })
            ->when($major !== '', fn ($query) => $query->where('accepted_major', $major))
            ->when($gender !== '', fn ($query) => $query->where('gender', $gender))
            ->orderBy('sort_order')
            ->orderBy('full_name')
            ->get();

        $filters = [
            'q' => $search,
            'jurusan' => $major,
            'jk' => $gender,
        ];

        $acceptedMajors = SpmbGraduationResult::ACCEPTED_MAJORS;

        return view('spmb.pengumuman-kelulusan', compact('results', 'isPublished', 'filters', 'acceptedMajors'));
    }
}
