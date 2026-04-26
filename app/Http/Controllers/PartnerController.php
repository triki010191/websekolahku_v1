<?php

namespace App\Http\Controllers;

use App\Models\Partner;

class PartnerController extends Controller
{
    public function index()
    {
        $partners = Partner::where('is_active', true)->orderBy('sort_order')->get();

        return view('kerjasama.index', compact('partners'));
    }

    public function show(Partner $partner)
    {
        abort_unless($partner->is_active, 404);

        return view('kerjasama.show', compact('partner'));
    }
}
