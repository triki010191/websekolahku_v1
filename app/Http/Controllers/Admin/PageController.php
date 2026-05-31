<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::orderBy('title')->paginate(20);

        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.form', ['page' => new Page()]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = Str::slug($data['slug']);

        Page::create($data);

        return redirect()->route('admin.pages.index')->with('success', 'Halaman dibuat.');
    }

    public function edit(Page $page)
    {
        return view('admin.pages.form', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $data = $this->validated($request, $page);
        $data['slug'] = Str::slug($data['slug']);

        $page->update($data);

        return redirect()->route('admin.pages.index')->with('success', 'Halaman diperbarui.');
    }

    public function destroy(Page $page)
    {
        $page->delete();

        return back()->with('success', 'Halaman dihapus.');
    }

    private function validated(Request $request, ?Page $page = null): array
    {
        $data = $request->validate([
            'title'            => ['required', 'string', 'max:255'],
            'slug'             => ['required', 'string', 'max:120', Rule::unique('pages', 'slug')->ignore($page?->id)],
            'content'          => ['required', 'string'],
            'meta_title'       => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'is_published'     => ['nullable', 'boolean'],
        ]);

        $data['is_published'] = $request->boolean('is_published');

        return $data;
    }
}
