<?php

namespace App\Http\Controllers;

use App\Models\Extracurricular;

class ExtracurricularController extends Controller
{
    public function index()
    {
        $extras = Extracurricular::where('is_active', true)->orderBy('name')->get();
        return view('ekstrakurikuler.index', compact('extras'));
    }
}
