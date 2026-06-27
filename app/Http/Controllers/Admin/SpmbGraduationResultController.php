<?php

namespace App\Http\Controllers\Admin;

use App\Exports\SpmbGraduationResultsExport;
use App\Exports\SpmbGraduationResultsTemplateExport;
use App\Http\Controllers\Controller;
use App\Imports\SpmbGraduationResultsImport;
use App\Models\Setting;
use App\Models\SpmbGraduationResult;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class SpmbGraduationResultController extends Controller
{
    public function index()
    {
        $results = SpmbGraduationResult::query()
            ->orderBy('sort_order')
            ->orderBy('full_name')
            ->paginate(50);

        $isPublished = (bool) setting('spmb_graduation_published', false);
        $total = SpmbGraduationResult::count();

        return view('admin.spmb-graduation-results.index', compact('results', 'isPublished', 'total'));
    }

    public function create()
    {
        return view('admin.spmb-graduation-results.form', [
            'result'  => new SpmbGraduationResult,
            'majors'  => SpmbGraduationResult::ACCEPTED_MAJORS,
        ]);
    }

    public function store(Request $request)
    {
        SpmbGraduationResult::create($this->validated($request));

        return redirect()->route('admin.spmb-graduation-results.index')
            ->with('success', 'Data siswa diterima ditambahkan.');
    }

    public function edit(SpmbGraduationResult $spmb_graduation_result)
    {
        return view('admin.spmb-graduation-results.form', [
            'result' => $spmb_graduation_result,
            'majors' => SpmbGraduationResult::ACCEPTED_MAJORS,
        ]);
    }

    public function update(Request $request, SpmbGraduationResult $spmb_graduation_result)
    {
        $spmb_graduation_result->update($this->validated($request, $spmb_graduation_result));

        return redirect()->route('admin.spmb-graduation-results.index')
            ->with('success', 'Data diperbarui.');
    }

    public function destroy(SpmbGraduationResult $spmb_graduation_result)
    {
        $spmb_graduation_result->delete();

        return back()->with('success', 'Data dihapus.');
    }

    public function togglePublish(Request $request)
    {
        $published = $request->boolean('published');
        Setting::set('spmb_graduation_published', $published ? '1' : '0', 'ppdb', 'boolean');

        $message = $published
            ? 'Daftar kelulusan dipublikasikan di website.'
            : 'Daftar kelulusan disembunyikan dari website.';

        return back()->with('success', $message);
    }

    public function exportExcel(): BinaryFileResponse
    {
        return Excel::download(
            new SpmbGraduationResultsExport,
            'pengumuman-hasil-seleksi-spmb-'.now()->format('Y-m-d').'.xlsx'
        );
    }

    public function exportTemplate(): BinaryFileResponse
    {
        return Excel::download(
            new SpmbGraduationResultsTemplateExport,
            'template-import-hasil-seleksi-spmb.xlsx'
        );
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls,csv', 'max:5120'],
        ]);

        $import = new SpmbGraduationResultsImport;
        Excel::import($import, $request->file('file'));

        return back()->with(
            'success',
            "Import selesai: {$import->created} ditambah, {$import->updated} diperbarui, {$import->skipped} dilewati."
        );
    }

    private function validated(Request $request, ?SpmbGraduationResult $existing = null): array
    {
        $data = $request->validate([
            'sort_order'          => ['required', 'integer', 'min:0'],
            'registration_number' => ['nullable', 'string', 'max:50'],
            'nisn'                => [
                'required',
                'string',
                'size:10',
                'regex:/^\d{10}$/',
                Rule::unique('spmb_graduation_results', 'nisn')->ignore($existing?->id),
            ],
            'full_name'           => ['required', 'string', 'max:255'],
            'gender'              => ['required', 'in:L,P'],
            'origin_school'       => ['nullable', 'string', 'max:255'],
            'accepted_major'      => ['required', Rule::in(SpmbGraduationResult::ACCEPTED_MAJORS)],
        ]);

        $data['academic_year'] = setting('ppdb_year', '2026/2027');

        return $data;
    }
}
