<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PartnerController extends Controller
{
    public function index()
    {
        $partners = Partner::orderBy('sort_order')->orderBy('name')->paginate(20);

        return view('admin.partners.index', compact('partners'));
    }

    public function create()
    {
        return view('admin.partners.form', ['partner' => new Partner]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request, null);
        $data['slug'] = Str::slug($data['slug'] ?: $data['name']);
        $data['is_active'] = $request->boolean('is_active');
        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('partners', 'public');
        }
        Partner::create($data);

        return redirect()->route('admin.partners.index')->with('success', 'Mitra ditambahkan.');
    }

    public function edit(Partner $partner)
    {
        return view('admin.partners.form', compact('partner'));
    }

    public function update(Request $request, Partner $partner)
    {
        $data = $this->validated($request, $partner);
        $data['slug'] = Str::slug($data['slug'] ?: $data['name']);
        $data['is_active'] = $request->boolean('is_active');
        if ($request->hasFile('logo')) {
            if ($partner->logo) {
                Storage::disk('public')->delete($partner->logo);
            }
            $data['logo'] = $request->file('logo')->store('partners', 'public');
        }
        $partner->update($data);

        return redirect()->route('admin.partners.index')->with('success', 'Mitra diperbarui.');
    }

    public function destroy(Partner $partner)
    {
        if ($partner->logo) {
            Storage::disk('public')->delete($partner->logo);
        }
        $partner->delete();

        return back()->with('success', 'Dihapus.');
    }

    private function validated(Request $r, ?Partner $m): array
    {
        return $r->validate([
            'name'         => ['required', 'string', 'max:255'],
            'slug'         => ['nullable', 'string', 'max:255', Rule::unique('partners', 'slug')->ignore($m?->id)],
            'industry'     => ['nullable', 'string', 'max:100'],
            'website'      => ['nullable', 'string', 'max:500'],
            'description'  => ['nullable', 'string'],
            'mou_number'   => ['nullable', 'string', 'max:100'],
            'mou_start'    => ['nullable', 'date'],
            'mou_end'      => ['nullable', 'date'],
            'sort_order'   => ['nullable', 'integer', 'min:0'],
            'logo'         => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);
    }
}
