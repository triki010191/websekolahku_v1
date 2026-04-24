<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Major;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class MajorController extends Controller
{
    public function index()
    {
        $majors = Major::orderBy('sort_order')->get();
        return view('admin.majors.index', compact('majors'));
    }

    public function create()
    {
        return view('admin.majors.form', ['major' => new Major()]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['is_active'] = $request->boolean('is_active');
        $data['slug'] = Str::slug($data['slug'] ?? $data['name']);
        if ($request->hasFile('cover')) $data['cover'] = $request->file('cover')->store('majors', 'public');
        Major::create($data);
        return redirect()->route('admin.majors.index')->with('success', 'Jurusan ditambahkan.');
    }

    public function edit(Major $major)
    {
        return view('admin.majors.form', compact('major'));
    }

    public function update(Request $request, Major $major)
    {
        $data = $this->validated($request, $major);
        $data['is_active'] = $request->boolean('is_active');
        $data['slug'] = Str::slug($data['slug'] ?? $data['name']);
        if ($request->hasFile('cover')) $data['cover'] = $request->file('cover')->store('majors', 'public');
        $major->update($data);
        return redirect()->route('admin.majors.index')->with('success', 'Jurusan diperbarui.');
    }

    public function destroy(Major $major)
    {
        $major->delete();
        return back()->with('success', 'Jurusan dihapus.');
    }

    private function validated(Request $r, ?Major $major = null): array
    {
        return $r->validate([
            'code'          => ['required', 'string', 'max:10', Rule::unique('majors', 'code')->ignore($major?->id)],
            'name'          => ['required', 'string', 'max:255'],
            'slug'          => ['nullable', 'string', 'max:255'],
            'tagline'       => ['nullable', 'string', 'max:500'],
            'description'   => ['nullable', 'string'],
            'curriculum'    => ['nullable', 'string'],
            'career_prospects' => ['nullable', 'string'],
            'certifications'=> ['nullable', 'string'],
            'head_teacher'  => ['nullable', 'string', 'max:255'],
            'color'         => ['nullable', 'string', 'max:20'],
            'student_count' => ['nullable', 'integer', 'min:0'],
            'quota'         => ['nullable', 'integer', 'min:0'],
            'sort_order'    => ['nullable', 'integer', 'min:0'],
            'cover'         => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);
    }
}
