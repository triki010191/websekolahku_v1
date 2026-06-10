<?php

namespace App\Http\Controllers;

use App\Models\Major;
use App\Models\PpdbRegistration;
use App\Services\PpdbRegistrationService;
use App\Support\PpdbFormOptions;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class PpdbController extends Controller
{
    public function __construct(private PpdbRegistrationService $service) {}

    public function create(Request $request): Response|RedirectResponse
    {
        $draft = $this->resolveEditableRegistration($request);

        if (! $draft && ($closed = $this->ensurePpdbOpen())) {
            return $closed;
        }

        $majors  = Major::where('is_active', true)->orderBy('sort_order')->get();
        $options = PpdbFormOptions::class;

        return response()->view('ppdb.form', compact('majors', 'options', 'draft'));
    }

    public function csrfToken()
    {
        return response()->json(['token' => csrf_token()]);
    }

    public function checkSpmb(Request $request)
    {
        $request->validate([
            'spmb_banten_number' => ['required', 'string', 'size:10', 'regex:/^\d{10}$/'],
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

    public function saveDraft(Request $request): JsonResponse|RedirectResponse
    {
        $draftId = $this->resolveRegistrationId($request->input('draft_token'));

        if (! $this->isCorrectionRequest($request) && ($closed = $this->ensurePpdbOpen())) {
            return $closed;
        }

        $request->validate(
            $this->service->rules(submit: false, exceptId: $draftId),
            $this->service->messages(),
            $this->service->attributes()
        );

        $reg = $this->service->saveDraft($request);

        return response()->json([
            'ok'                  => true,
            'draft_token'         => $reg->draft_token,
            'registration_number' => $reg->registration_number,
            'saved_at'            => now()->toIso8601String(),
            'csrf_token'          => csrf_token(),
        ]);
    }

    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $draftId = $this->resolveRegistrationId($request->input('draft_token'));

        if (! $this->isCorrectionRequest($request) && ($closed = $this->ensurePpdbOpen())) {
            return $closed;
        }

        $request->validate(
            $this->service->rules(submit: true, exceptId: $draftId),
            $this->service->messages(),
            $this->service->attributes()
        );

        if (! $request->boolean('data_declaration') && $request->input('data_declaration') !== '1') {
            throw ValidationException::withMessages([
                'data_declaration' => 'Anda harus menyetujui pernyataan kebenaran data.',
            ]);
        }

        $reg = $this->service->submit($request);
        $this->grantPpdbAccess($reg);

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

    public function lookup(Request $request): RedirectResponse
    {
        $request->validate([
            'nisn'       => ['required', 'string', 'size:10'],
            'birth_date' => ['required', 'date'],
        ], [
            'nisn.required'       => 'NISN wajib diisi.',
            'nisn.size'           => 'NISN harus 10 digit.',
            'birth_date.required' => 'Tanggal lahir wajib diisi.',
            'birth_date.date'     => 'Format tanggal lahir tidak valid.',
        ]);

        $reg = PpdbRegistration::query()
            ->where('nisn', trim($request->input('nisn')))
            ->whereDate('birth_date', $request->input('birth_date'))
            ->where('form_status', 'submitted')
            ->first();

        if (! $reg) {
            return back()
                ->withInput($request->only('nisn', 'birth_date'))
                ->withErrors([
                    'lookup' => 'Data tidak ditemukan. Pastikan NISN dan tanggal lahir benar, serta formulir Dapodik sudah dikirim.',
                ]);
        }

        $this->grantPpdbAccess($reg);

        if ($reg->allowsCorrection()) {
            return redirect()
                ->route('ppdb.create')
                ->with('info', 'Admin telah mengizinkan perbaikan data. Silakan periksa dan kirim ulang formulir Anda.');
        }

        return redirect()
            ->route('ppdb.success', $reg->registration_number)
            ->with('lookup', true);
    }

    public function success(string $number): Response|RedirectResponse
    {
        $reg = PpdbRegistration::with('major')
            ->where('registration_number', $number)
            ->where('form_status', 'submitted')
            ->firstOrFail();

        if (! $this->canAccessPpdb($reg)) {
            return redirect()->route('spmb.index')
                ->with('error', 'Akses ditolak. Gunakan fitur Cek Formulir Daftar Ulang di halaman SPMB dengan NISN dan tanggal lahir Anda.');
        }

        return response()->view('ppdb.success', compact('reg'));
    }

    public function pdf(string $number)
    {
        $reg = PpdbRegistration::with('major')
            ->where('registration_number', $number)
            ->where('form_status', 'submitted')
            ->firstOrFail();

        if (! $this->canAccessPpdb($reg)) {
            return redirect()->route('spmb.index')
                ->with('error', 'Akses ditolak. Gunakan fitur Cek Formulir Daftar Ulang di halaman SPMB dengan NISN dan tanggal lahir Anda.');
        }

        $pdf = Pdf::loadView('ppdb.pdf.bukti', compact('reg'))->setPaper('a4');

        return $pdf->download('formulir-dapodik-'.$reg->registration_number.'.pdf');
    }

    private function grantPpdbAccess(PpdbRegistration $reg): void
    {
        session(['ppdb_access' => $reg->registration_number]);
    }

    private function canAccessPpdb(PpdbRegistration $reg): bool
    {
        return session('ppdb_access') === $reg->registration_number;
    }

    private function ensurePpdbOpen(): JsonResponse|RedirectResponse|null
    {
        if ((bool) setting('ppdb_is_open', false)) {
            return null;
        }

        $message = 'Pendaftaran formulir Dapodik sedang ditutup. Silakan cek jadwal di halaman SPMB.';

        if (request()->expectsJson()) {
            return response()->json(['message' => $message], 403);
        }

        return redirect()->route('spmb.index')->with('error', $message);
    }

    private function resolveEditableRegistration(Request $request): ?PpdbRegistration
    {
        if ($token = $request->query('draft')) {
            $reg = PpdbRegistration::where('draft_token', $token)->first();
            if ($reg && ($reg->form_status === 'draft' || $reg->allowsCorrection())) {
                return $reg;
            }
        }

        if ($number = session('ppdb_access')) {
            return PpdbRegistration::query()
                ->where('registration_number', $number)
                ->where('form_status', 'submitted')
                ->where('status', 'verified')
                ->first();
        }

        return null;
    }

    private function resolveRegistrationId(?string $token): ?int
    {
        if (! $token) {
            return null;
        }

        return PpdbRegistration::where('draft_token', $token)->value('id');
    }

    private function isCorrectionRequest(Request $request): bool
    {
        $token = $request->input('draft_token');
        if (! $token) {
            return false;
        }

        $reg = PpdbRegistration::where('draft_token', $token)->first();

        return $reg?->allowsCorrection() ?? false;
    }
}
