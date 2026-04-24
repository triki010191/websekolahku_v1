<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Major;
use App\Models\PpdbRegistration;
use Illuminate\Http\Request;

class PpdbController extends Controller
{
    public function index(Request $request)
    {
        $registrations = PpdbRegistration::with('major')
            ->when($request->status,   fn ($q, $s) => $q->where('status', $s))
            ->when($request->major_id, fn ($q, $m) => $q->where('major_id', $m))
            ->when($request->search,   fn ($q, $s) => $q->where(fn ($q) => $q->where('full_name', 'like', "%$s%")->orWhere('nisn', 'like', "%$s%")->orWhere('registration_number', 'like', "%$s%")))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $majors = Major::where('is_active', true)->orderBy('sort_order')->get();
        $counts = [
            'total'    => PpdbRegistration::count(),
            'pending'  => PpdbRegistration::where('status', 'pending')->count(),
            'verified' => PpdbRegistration::where('status', 'verified')->count(),
            'accepted' => PpdbRegistration::where('status', 'accepted')->count(),
            'rejected' => PpdbRegistration::where('status', 'rejected')->count(),
        ];

        return view('admin.ppdb.index', compact('registrations', 'majors', 'counts'));
    }

    public function show(PpdbRegistration $ppdb)
    {
        return view('admin.ppdb.show', ['reg' => $ppdb->load('major', 'verifier')]);
    }

    public function updateStatus(Request $request, PpdbRegistration $ppdb)
    {
        $data = $request->validate([
            'status' => ['required', 'in:pending,verified,accepted,rejected'],
            'note'   => ['nullable', 'string'],
        ]);
        $data['verified_by'] = $request->user()->id;
        $data['verified_at'] = now();
        $ppdb->update($data);
        return back()->with('success', 'Status pendaftar diperbarui.');
    }

    public function destroy(PpdbRegistration $ppdb)
    {
        $ppdb->delete();
        return back()->with('success', 'Data pendaftar dihapus.');
    }
}
