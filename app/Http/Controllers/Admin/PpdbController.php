<?php

namespace App\Http\Controllers\Admin;

use App\Exports\PpdbRegistrationsExport;
use App\Http\Controllers\Controller;
use App\Models\Major;
use App\Models\PpdbRegistration;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PpdbController extends Controller
{
    public function index(Request $request)
    {
        $formStatus = $request->query('form_status', 'submitted');

        $registrations = PpdbRegistration::with('major')
            ->where('form_status', $formStatus)
            ->when($request->status,   fn ($q, $s) => $q->where('status', $s))
            ->when($request->major_id, fn ($q, $m) => $q->where('major_id', $m))
            ->when($request->search,   fn ($q, $s) => $q->where(fn ($q) => $q->where('full_name', 'like', "%$s%")->orWhere('nisn', 'like', "%$s%")->orWhere('registration_number', 'like', "%$s%")->orWhere('spmb_banten_number', 'like', "%$s%")))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $majors = Major::where('is_active', true)->orderBy('sort_order')->get();
        $counts = [
            'total'    => PpdbRegistration::where('form_status', 'submitted')->count(),
            'pending'  => PpdbRegistration::where('form_status', 'submitted')->where('status', 'pending')->count(),
            'revisi'   => PpdbRegistration::where('form_status', 'submitted')->where('status', 'revisi')->count(),
            'accepted' => PpdbRegistration::where('form_status', 'submitted')->where('status', 'accepted')->count(),
            'rejected' => PpdbRegistration::where('form_status', 'submitted')->where('status', 'rejected')->count(),
            'drafts'   => PpdbRegistration::where('form_status', 'draft')->count(),
        ];

        return view('admin.ppdb.index', compact('registrations', 'majors', 'counts', 'formStatus'));
    }

    public function show(PpdbRegistration $ppdb)
    {
        return view('admin.ppdb.show', ['reg' => $ppdb->load('major', 'verifier')]);
    }

    public function updateStatus(Request $request, PpdbRegistration $ppdb)
    {
        $data = $request->validate([
            'status' => ['required', 'in:'.implode(',', PpdbRegistration::STATUSES)],
            'note'   => ['nullable', 'string'],
        ]);
        $data['verified_by'] = $request->user()->id;
        $data['verified_at'] = now();
        $ppdb->update($data);
        return back()->with('success', 'Status pendaftar diperbarui.');
    }

    public function destroy(Request $request, PpdbRegistration $ppdb)
    {
        $ppdb->delete();

        $query = array_filter($request->only(['form_status', 'status', 'major_id', 'search', 'page']));

        return redirect()
            ->route('admin.ppdb.index', $query)
            ->with('success', 'Data pendaftar berhasil dihapus.');
    }

    public function exportExcel(Request $request)
    {
        $status = $request->query('status');
        $name   = 'data-dapodik-spmb-'.now()->format('Ymd-His').'.xlsx';

        return Excel::download(new PpdbRegistrationsExport($status), $name);
    }

    public function exportPdf(Request $request, PpdbRegistration $ppdb)
    {
        $reg = $ppdb->load('major');
        $pdf = Pdf::loadView('ppdb.pdf.bukti', ['reg' => $reg])->setPaper('a4');

        return $pdf->download('dapodik-'.$reg->registration_number.'.pdf');
    }
}
