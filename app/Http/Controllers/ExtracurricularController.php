<?php

namespace App\Http\Controllers;

use App\Models\Extracurricular;

class ExtracurricularController extends Controller
{
    public function index()
    {
        $extras = Extracurricular::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('ekstrakurikuler.index', compact('extras'));
    }

    public function show(Extracurricular $extracurricular)
    {
        abort_unless($extracurricular->is_active, 404);

        return view('ekstrakurikuler.show', ['x' => $extracurricular]);
    }
}
