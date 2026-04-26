<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FacilityController extends Controller
{
    public function index()
    {
        $facilities = Facility::orderBy('sort_order')->orderBy('name')->paginate(20);

        return view('admin.facilities.index', compact('facilities'));
    }

    public function create()
    {
        return view('admin.facilities.form', ['facility' => new Facility]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = Str::slug($data['slug'] ?: $data['name']);
        $data['is_active'] = $request->boolean('is_active');
        if ($request->hasFile('cover')) {
            $data['cover'] = $request->file('cover')->store('facilities', 'public');
        }
        Facility::create($data);

        return redirect()->route('admin.facilities.index')->with('success', 'Fasilitas ditambahkan.');
    }

    public function edit(Facility $facility)
    {
        return view('admin.facilities.form', compact('facility'));
    }

    public function update(Request $request, Facility $facility)
    {
        $data = $this->validated($request);
        $data['slug'] = Str::slug($data['slug'] ?: $data['name']);
        $data['is_active'] = $request->boolean('is_active');
        if ($request->hasFile('cover')) {
            if ($facility->cover) {
                Storage::disk('public')->delete($facility->cover);
            }
            $data['cover'] = $request->file('cover')->store('facilities', 'public');
        }
        $facility->update($data);

        return redirect()->route('admin.facilities.index')->with('success', 'Fasilitas diperbarui.');
    }

    public function destroy(Facility $facility)
    {
        if ($facility->cover) {
            Storage::disk('public')->delete($facility->cover);
        }
        $facility->delete();

        return back()->with('success', 'Dihapus.');
    }

    private function validated(Request $r): array
    {
        return $r->validate([
            'name'         => ['required', 'string', 'max:255'],
            'slug'         => ['nullable', 'string', 'max:255'],
            'icon'         => ['nullable', 'string', 'max:50'],
            'description'  => ['nullable', 'string', 'max:2000'],
            'content'      => ['nullable', 'string'],
            'sort_order'   => ['nullable', 'integer', 'min:0'],
            'cover'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:15360'],
        ]);
    }
}
