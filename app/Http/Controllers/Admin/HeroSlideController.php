<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroSlideController extends Controller
{
    public function index()
    {
        $slides = HeroSlide::orderBy('sort_order')->orderByDesc('id')->paginate(20);

        return view('admin.hero-slides.index', compact('slides'));
    }

    public function create()
    {
        return view('admin.hero-slides.form', ['slide' => new HeroSlide]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request, true);
        unset($data['image']);
        if (! $request->hasFile('image')) {
            return back()->withInput()->with('error', 'Gambar slide wajib diunggah.');
        }
        $data['image'] = $request->file('image')->store('hero-slides', 'public');
        $data['is_active'] = $request->boolean('is_active');
        HeroSlide::create($data);

        return redirect()->route('admin.hero-slides.index')->with('success', 'Slide berhasil ditambahkan.');
    }

    public function edit(HeroSlide $hero_slide)
    {
        return view('admin.hero-slides.form', ['slide' => $hero_slide]);
    }

    public function update(Request $request, HeroSlide $hero_slide)
    {
        $data = $this->validated($request, false);
        unset($data['image']);
        if ($request->hasFile('image')) {
            if ($hero_slide->image) {
                Storage::disk('public')->delete($hero_slide->image);
            }
            $data['image'] = $request->file('image')->store('hero-slides', 'public');
        }
        $data['is_active'] = $request->boolean('is_active');
        $hero_slide->update($data);

        return redirect()->route('admin.hero-slides.index')->with('success', 'Slide diperbarui.');
    }

    public function destroy(HeroSlide $hero_slide)
    {
        if ($hero_slide->image) {
            Storage::disk('public')->delete($hero_slide->image);
        }
        $hero_slide->delete();

        return back()->with('success', 'Slide dihapus.');
    }

    private function validated(Request $r, bool $isCreate): array
    {
        $imageRule = $isCreate
            ? ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:15360']
            : ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:15360'];

        $data = $r->validate([
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:500'],
            'image' => $imageRule,
            'button_text' => ['nullable', 'string', 'max:80'],
            'button_url' => ['nullable', 'string', 'max:500'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
        ]);
        $data['sort_order'] = (int) ($r->input('sort_order', $data['sort_order'] ?? 0));

        return $data;
    }
}
