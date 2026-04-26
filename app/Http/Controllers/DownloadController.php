<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Download;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DownloadController extends Controller
{
    public function index(Request $request)
    {
        $downloads = Download::where('is_public', true)
            ->when($request->category, fn ($q, $slug) => $q->whereHas('category', fn ($q) => $q->where('slug', $slug)))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $categories = Category::where('type', 'download')->get();
        return view('download.index', compact('downloads', 'categories'));
    }

    /**
     * Sajikan file dari storage/app/public (tetap jalan walaupun symlink public/storage belum dipasang).
     */
    public function file(Download $download): StreamedResponse
    {
        if (! $download->is_public) {
            abort(404);
        }

        $path = $download->file_path;
        if (! $path || ! Storage::disk('public')->exists($path)) {
            abort(404, 'Berkas tidak ditemukan di server. Unggah ulang dari panel admin.');
        }

        $download->increment('download_count');

        $ext = $download->file_type ?: (string) pathinfo($path, PATHINFO_EXTENSION);
        $ext = ltrim($ext, '.');
        $filename = Str::limit(Str::slug($download->title), 80, '') ?: 'unduhan';
        if ($ext !== '') {
            $filename .= '.'.$ext;
        }

        return Storage::disk('public')->download($path, $filename);
    }
}
