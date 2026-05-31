<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('kontak.index');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255'],
            'phone'    => ['nullable', 'string', 'max:32'],
            'category' => ['required', 'in:umum,ppdb,alumni,kerjasama,lainnya'],
            'subject'  => ['required', 'string', 'max:255'],
            'message'  => ['required', 'string', 'min:10', 'max:5000'],
        ]);

        ContactMessage::create($data + ['status' => 'new']);

        return back()->with('success', 'Pesan Anda berhasil dikirim! Tim kami akan menghubungi Anda dalam 1×24 jam kerja.');
    }
}
