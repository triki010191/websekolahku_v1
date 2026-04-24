<?php

namespace App\Http\Controllers;

use App\Models\Major;
use App\Models\PpdbRegistration;
use Illuminate\Http\Request;

class PpdbController extends Controller
{
    public function index()
    {
        $majors = Major::where('is_active', true)->orderBy('sort_order')->get();
        return view('ppdb.index', compact('majors'));
    }

    public function create()
    {
        $majors = Major::where('is_active', true)->orderBy('sort_order')->get();
        return view('ppdb.form', compact('majors'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'major_id'        => ['required', 'exists:majors,id'],
            'full_name'       => ['required', 'string', 'max:255'],
            'nisn'            => ['required', 'string', 'size:10', 'unique:ppdb_registrations,nisn'],
            'gender'          => ['required', 'in:L,P'],
            'religion'        => ['nullable', 'string', 'max:30'],
            'birth_place'     => ['nullable', 'string', 'max:80'],
            'birth_date'      => ['nullable', 'date'],
            'phone'           => ['nullable', 'string', 'max:32'],
            'email'           => ['nullable', 'email', 'max:255'],
            'address'         => ['nullable', 'string'],
            'city'            => ['nullable', 'string', 'max:80'],
            'postal_code'     => ['nullable', 'string', 'max:10'],
            'previous_school' => ['required', 'string', 'max:255'],
            'graduation_year' => ['nullable', 'integer', 'min:2000', 'max:' . (date('Y') + 1)],
            'father_name'     => ['nullable', 'string', 'max:255'],
            'father_job'      => ['nullable', 'string', 'max:255'],
            'mother_name'     => ['nullable', 'string', 'max:255'],
            'mother_job'      => ['nullable', 'string', 'max:255'],
            'parent_phone'    => ['nullable', 'string', 'max:32'],
            'parent_income'   => ['nullable', 'string', 'max:100'],
            'pathway'         => ['required', 'in:zonasi,prestasi,afirmasi,mutasi'],
            'doc_ijazah'      => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
            'doc_kk'          => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
            'doc_photo'       => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:1024'],
            'doc_akta'        => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
        ]);

        foreach (['doc_ijazah', 'doc_kk', 'doc_photo', 'doc_akta'] as $f) {
            if ($request->hasFile($f)) {
                $data[$f] = $request->file($f)->store('ppdb', 'public');
            }
        }

        $data['registration_number'] = PpdbRegistration::generateNumber();
        $data['status']              = 'pending';

        $reg = PpdbRegistration::create($data);

        return redirect()->route('ppdb.success', $reg->registration_number)
            ->with('success', 'Pendaftaran berhasil dikirim! Nomor pendaftaran Anda: ' . $reg->registration_number);
    }

    public function success(string $number)
    {
        $reg = PpdbRegistration::where('registration_number', $number)->firstOrFail();
        return view('ppdb.success', compact('reg'));
    }
}
