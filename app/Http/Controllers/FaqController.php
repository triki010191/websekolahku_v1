<?php

namespace App\Http\Controllers;

use App\Models\Faq;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::where('is_published', true)->orderBy('sort_order')->get();
        return view('faq.index', compact('faqs'));
    }
}
