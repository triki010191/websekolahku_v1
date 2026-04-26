<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Extracurricular;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ExtracurricularController extends Controller
{
    public function index()
    {
        $rows = Extracurricular::orderBy('sort_order')->orderBy('name')->paginate(20);

        return view('admin.extracurriculars.index', ['extracurriculars' => $rows]);
    }

    public function create()
    {
        return view('admin.extracurriculars.form', ['x' => new Extracurricular]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request, null);
        $data['slug'] = Str::slug($data['slug'] ?: $data['name']);
        $data['is_active'] = $request->boolean('is_active');
        if ($request->hasFile('cover')) {
            $data['cover'] = $request->file('cover')->store('extracurriculars', 'public');
        }
        Extracurricular::create($data);

        return redirect()->route('admin.extracurriculars.index')->with('success', 'Data ditambahkan.');
    }

    public function edit(Extracurricular $extracurricular)
    {
        return view('admin.extracurriculars.form', ['x' => $extracurricular]);
    }

    public function update(Request $request, Extracurricular $extracurricular)
    {
        $data = $this->validated($request, $extracurricular);
        $data['slug'] = Str::slug($data['slug'] ?: $data['name']);
        $data['is_active'] = $request->boolean('is_active');
        if ($request->hasFile('cover')) {
            if ($extracurricular->cover) {
                Storage::disk('public')->delete($extracurricular->cover);
            }
            $data['cover'] = $request->file('cover')->store('extracurriculars', 'public');
        }
        $extracurricular->update($data);

        return redirect()->route('admin.extracurriculars.index')->with('success', 'Data diperbarui.');
    }

    public function destroy(Extracurricular $extracurricular)
    {
        if ($extracurricular->cover) {
            Storage::disk('public')->delete($extracurricular->cover);
        }
        $extracurricular->delete();

        return back()->with('success', 'Dihapus.');
    }

    private function validated(Request $r, ?Extracurricular $m): array
    {
        return $r->validate([
            'name'         => ['required', 'string', 'max:255'],
            'slug'         => ['nullable', 'string', 'max:255', Rule::unique('extracurriculars', 'slug')->ignore($m?->id)],
            'icon'         => ['nullable', 'string', 'max:20'],
            'category'     => ['nullable', 'string', 'max:50'],
            'description'  => ['nullable', 'string', 'max:2000'],
            'content'      => ['nullable', 'string'],
            'coach'        => ['nullable', 'string', 'max:255'],
            'schedule'     => ['nullable', 'string', 'max:500'],
            'member_count' => ['nullable', 'integer', 'min:0'],
            'sort_order'   => ['nullable', 'integer', 'min:0'],
            'cover'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:15360'],
        ]);
    }
}
