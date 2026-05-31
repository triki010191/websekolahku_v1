<?php

namespace App\Http\Controllers;

use App\Models\Major;
use App\Models\PpdbRegistration;
use App\Services\PpdbRegistrationService;
use App\Support\PpdbFormOptions;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PpdbController extends Controller
{
    public function __construct(private PpdbRegistrationService $service) {}

    public function create(Request $request)
    {
        $majors  = Major::where('is_active', true)->orderBy('sort_order')->get();
        $options = PpdbFormOptions::class;
        $draft   = null;

        if ($token = $request->query('draft')) {
            $draft = PpdbRegistration::where('draft_token', $token)->where('form_status', 'draft')->first();
        }

        return view('ppdb.form', compact('majors', 'options', 'draft'));
    }

    public function saveDraft(Request $request)
    {
        $request->validate($this->service->rules(submit: false));

        $reg = $this->service->saveDraft($request);

        return response()->json([
            'ok'           => true,
            'draft_token'  => $reg->draft_token,
            'registration_number' => $reg->registration_number,
            'saved_at'     => now()->toIso8601String(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate($this->service->rules(submit: true));

        if (! $request->boolean('data_declaration') && $request->input('data_declaration') !== '1') {
            throw ValidationException::withMessages([
                'data_declaration' => 'Anda harus menyetujui pernyataan kebenaran data.',
            ]);
        }

        $reg = $this->service->submit($request);

        return redirect()->route('ppdb.success', $reg->registration_number)
            ->with('success', 'Formulir Dapodik berhasil dikirim.');
    }

    public function success(string $number)
    {
        $reg = PpdbRegistration::with('major')->where('registration_number', $number)->firstOrFail();

        return view('ppdb.success', compact('reg'));
    }

    public function pdf(string $number)
    {
        $reg = PpdbRegistration::with('major')->where('registration_number', $number)->firstOrFail();

        $pdf = Pdf::loadView('ppdb.pdf.bukti', compact('reg'))->setPaper('a4');

        return $pdf->download('bukti-daftar-ulang-'.$reg->registration_number.'.pdf');
    }
}
