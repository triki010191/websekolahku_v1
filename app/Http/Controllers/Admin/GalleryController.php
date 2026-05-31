<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryAlbum;
use App\Models\GalleryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    public function index()
    {
        $albums = GalleryAlbum::withCount('items')->latest()->paginate(15);

        return view('admin.gallery.index', compact('albums'));
    }

    public function create()
    {
        return view('admin.gallery.form', ['album' => new GalleryAlbum]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['is_published'] = $request->boolean('is_published');
        $data['slug'] = Str::slug($data['title']).'-'.now()->format('YmdHis');
        if ($request->hasFile('cover')) {
            $data['cover'] = $request->file('cover')->store('gallery', 'public');
        }
        $album = GalleryAlbum::create($data);

        return redirect()->route('admin.gallery.edit', $album)->with('success', 'Album dibuat. Tambahkan foto sekarang.');
    }

    public function edit(GalleryAlbum $album)
    {
        $album->load('items');

        return view('admin.gallery.form', compact('album'));
    }

    public function update(Request $request, GalleryAlbum $album)
    {
        $data = $this->validated($request);
        $data['is_published'] = $request->boolean('is_published');
        if ($request->hasFile('cover')) {
            $data['cover'] = $request->file('cover')->store('gallery', 'public');
        }
        $album->update($data);

        return back()->with('success', 'Album diperbarui.');
    }

    public function destroy(GalleryAlbum $album)
    {
        $album->delete();

        return redirect()->route('admin.gallery.index')->with('success', 'Album dihapus.');
    }

    public function addItem(Request $request, GalleryAlbum $album)
    {
        $request->validate([
            'images' => ['required', 'array', 'min:1'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:15360'],
        ], [
            'images.*.max' => 'Tiap gambar maks. 15 MB.',
        ]);
        foreach ($request->file('images', []) as $file) {
            GalleryItem::create([
                'album_id' => $album->id,
                'type' => 'photo',
                'url' => $file->store('gallery/items', 'public'),
            ]);
        }

        return back()->with('success', 'Foto ditambahkan.');
    }

    public function destroyItem(GalleryItem $item)
    {
        $item->delete();

        return back()->with('success', 'Foto dihapus.');
    }

    private function validated(Request $r): array
    {
        return $r->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'category' => ['nullable', 'string', 'max:50'],
            'cover' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:15360'],
        ]);
    }
}
