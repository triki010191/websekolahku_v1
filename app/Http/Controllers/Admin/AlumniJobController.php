<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AlumniJob;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AlumniJobController extends Controller
{
    public function index()
    {
        $jobs = AlumniJob::with('poster')->latest()->paginate(20);

        return view('admin.alumni-jobs.index', compact('jobs'));
    }

    public function create()
    {
        return view('admin.alumni-jobs.form', ['job' => new AlumniJob]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request, null);
        $data['user_id'] = $request->user()->id;
        $data['closes_at'] = $data['closes_at'] ?: null;
        AlumniJob::create($data);

        return redirect()->route('admin.alumni-jobs.index')->with('success', 'Lowongan ditambahkan.');
    }

    public function edit(AlumniJob $alumniJob)
    {
        return view('admin.alumni-jobs.form', ['job' => $alumniJob]);
    }

    public function update(Request $request, AlumniJob $alumniJob)
    {
        $data = $this->validated($request, $alumniJob);
        $data['closes_at'] = $data['closes_at'] ?: null;
        $alumniJob->update($data);

        return redirect()->route('admin.alumni-jobs.index')->with('success', 'Lowongan diperbarui.');
    }

    public function destroy(AlumniJob $alumniJob)
    {
        $alumniJob->delete();

        return back()->with('success', 'Dihapus.');
    }

    private function validated(Request $r, ?AlumniJob $j): array
    {
        return $r->validate([
            'title'          => ['required', 'string', 'max:255'],
            'company'        => ['required', 'string', 'max:255'],
            'location'       => ['nullable', 'string', 'max:255'],
            'type'           => ['required', Rule::in(['fulltime', 'parttime', 'internship', 'contract'])],
            'salary_range'   => ['nullable', 'string', 'max:120'],
            'description'    => ['nullable', 'string'],
            'requirements'   => ['nullable', 'string'],
            'contact_email'  => ['nullable', 'email', 'max:255'],
            'contact_link'   => ['nullable', 'string', 'max:500'],
            'closes_at'      => ['nullable', 'date'],
            'status'         => ['required', Rule::in(['draft', 'active', 'closed'])],
        ]);
    }
}
