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

    public function csrfToken()
    {
        return response()->json(['token' => csrf_token()]);
    }

    public function checkSpmb(Request $request)
    {
        $request->validate([
            'spmb_banten_number' => ['required', 'string', 'max:64'],
            'draft_token'        => ['nullable', 'string', 'max:64'],
        ]);

        $exceptId = null;
        if ($token = $request->input('draft_token')) {
            $exceptId = PpdbRegistration::where('draft_token', $token)->value('id');
        }

        $number = trim((string) $request->input('spmb_banten_number'));
        $used   = PpdbRegistration::spmbAlreadySubmitted($number, $exceptId);

        return response()->json([
            'available' => ! $used,
            'message'   => $used
                ? 'Nomor SPMB Banten ini sudah terdaftar. Formulir daftar ulang tidak dapat diisi ulang.'
                : null,
        ]);
    }

    public function saveDraft(Request $request)
    {
        $draftId = null;
        if ($token = $request->input('draft_token')) {
            $draftId = PpdbRegistration::where('draft_token', $token)->value('id');
        }

        $request->validate($this->service->rules(submit: false, exceptId: $draftId), $this->service->messages());

        $reg = $this->service->saveDraft($request);

        return response()->json([
            'ok'                  => true,
            'draft_token'         => $reg->draft_token,
            'registration_number' => $reg->registration_number,
            'saved_at'            => now()->toIso8601String(),
            'csrf_token'          => csrf_token(),
        ]);
    }

    public function store(Request $request)
    {
        $draftId = null;
        if ($token = $request->input('draft_token')) {
            $draftId = PpdbRegistration::where('draft_token', $token)->value('id');
        }

        $request->validate($this->service->rules(submit: true, exceptId: $draftId), $this->service->messages());

        if (! $request->boolean('data_declaration') && $request->input('data_declaration') !== '1') {
            throw ValidationException::withMessages([
                'data_declaration' => 'Anda harus menyetujui pernyataan kebenaran data.',
            ]);
        }

        $reg = $this->service->submit($request);

        if ($request->expectsJson()) {
            return response()->json([
                'ok'                  => true,
                'registration_number' => $reg->registration_number,
                'redirect'            => route('ppdb.success', $reg->registration_number),
                'pdf_url'             => route('ppdb.pdf', $reg->registration_number),
            ]);
        }

        return redirect()->route('ppdb.success', $reg->registration_number)
            ->with('success', 'Formulir Dapodik berhasil dikirim.');
    }

    public function lookup(Request $request)
    {
        $request->validate([
            'registration_number' => ['required', 'string', 'max:32'],
            'spmb_banten_number'  => ['required', 'string', 'max:64'],
        ], [
            'registration_number.required' => 'No. Daftar Ulang wajib diisi.',
            'spmb_banten_number.required'  => 'No. Pendaftaran SPMB Banten wajib diisi.',
        ]);

        $reg = PpdbRegistration::query()
            ->where('registration_number', trim($request->input('registration_number')))
            ->where('spmb_banten_number', trim($request->input('spmb_banten_number')))
            ->where('form_status', 'submitted')
            ->first();

        if (! $reg) {
            return back()
                ->withInput($request->only('registration_number', 'spmb_banten_number'))
                ->withErrors([
                    'lookup' => 'Data tidak ditemukan. Pastikan kedua nomor benar dan formulir Dapodik sudah dikirim.',
                ]);
        }

        return redirect()
            ->route('ppdb.success', $reg->registration_number)
            ->with('lookup', true);
    }

    public function success(string $number)
    {
        $reg = PpdbRegistration::with('major')
            ->where('registration_number', $number)
            ->where('form_status', 'submitted')
            ->firstOrFail();

        return view('ppdb.success', compact('reg'));
    }

    public function pdf(string $number)
    {
        $reg = PpdbRegistration::with('major')
            ->where('registration_number', $number)
            ->where('form_status', 'submitted')
            ->firstOrFail();

        $pdf = Pdf::loadView('ppdb.pdf.bukti', compact('reg'))->setPaper('a4');

        return $pdf->download('formulir-dapodik-'.$reg->registration_number.'.pdf');
    }
}
