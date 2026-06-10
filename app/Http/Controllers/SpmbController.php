<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Category;
use App\Models\Major;
use App\Models\Page;

class SpmbController extends Controller
{
    public function index()
    {
        $page = Page::where('slug', 'spmb-2026')->where('is_published', true)->first();

        $majors = Major::where('is_active', true)->orderBy('sort_order')->get();

        $ppdbCategory = Category::where('type', 'announcement')
            ->whereIn('slug', ['ppdb-announcement', 'spmb-announcement'])
            ->first();

        $announcements = Announcement::query()
            ->with('category')
            ->active()
            ->when($ppdbCategory, fn ($q) => $q->where('category_id', $ppdbCategory->id))
            ->latest('published_at')
            ->limit(10)
            ->get();

        $isOpen = (bool) setting('ppdb_is_open', false);

        return view('spmb.index', compact('page', 'majors', 'announcements', 'isOpen'));
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
}
