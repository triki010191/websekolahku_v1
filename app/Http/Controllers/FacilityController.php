<?php

namespace App\Http\Controllers;

use App\Models\Facility;

class FacilityController extends Controller
{
    public function index()
    {
        $facilities = Facility::where('is_active', true)->orderBy('sort_order')->get();
        return view('fasilitas.index', compact('facilities'));
    }

    public function show(Facility $facility)
    {
        abort_unless($facility->is_active, 404);
        return view('fasilitas.show', compact('facility'));
    }
}
