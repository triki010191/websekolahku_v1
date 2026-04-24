<?php

namespace App\Http\Controllers;

use App\Models\Major;

class MajorController extends Controller
{
    public function index()
    {
        $majors = Major::where('is_active', true)->orderBy('sort_order')->get();
        return view('jurusan.index', compact('majors'));
    }

    public function show(Major $major)
    {
        abort_unless($major->is_active, 404);
        return view('jurusan.show', compact('major'));
    }
}
