<?php

namespace App\Http\Controllers;

use App\Models\GalleryAlbum;

class GalleryController extends Controller
{
    public function index()
    {
        $albums = GalleryAlbum::where('is_published', true)
            ->withCount('items')
            ->latest()
            ->paginate(12);

        return view('galeri.index', compact('albums'));
    }

    public function show(GalleryAlbum $album)
    {
        abort_unless($album->is_published, 404);
        $album->load(['items' => fn ($q) => $q->orderBy('sort_order')]);
        return view('galeri.show', compact('album'));
    }
}
