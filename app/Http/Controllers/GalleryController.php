<?php

namespace App\Http\Controllers;

use App\Models\GalleryAlbum;
use Illuminate\Support\Facades\DB;

class GalleryController extends Controller
{
    public function index()
    {
        $albums = GalleryAlbum::where('is_published', true)
            ->withCount('items')
            ->latest()
            ->paginate(12);

        $firstItemUrlByAlbum = collect();
        $ids = $albums->pluck('id');
        if ($ids->isNotEmpty()) {
            $firstItemUrlByAlbum = DB::table('gallery_items as gi')
                ->select('gi.album_id', 'gi.url')
                ->whereIn('gi.album_id', $ids)
                ->whereRaw(
                    'gi.id = (SELECT gi2.id FROM gallery_items gi2
                    WHERE gi2.album_id = gi.album_id
                    ORDER BY gi2.sort_order ASC, gi2.id ASC
                    LIMIT 1)'
                )
                ->pluck('url', 'album_id');
        }

        return view('galeri.index', [
            'albums' => $albums,
            'firstItemUrlByAlbum' => $firstItemUrlByAlbum,
        ]);
    }

    public function show(GalleryAlbum $album)
    {
        abort_unless($album->is_published, 404);
        $album->load(['items' => fn ($q) => $q->orderBy('sort_order')]);

        return view('galeri.show', compact('album'));
    }
}
