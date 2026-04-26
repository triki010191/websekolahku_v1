<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Download;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    public function index()
    {
        $downloads = Download::with('category')->latest()->paginate(20);

        return view('admin.downloads.index', compact('downloads'));
    }

    public function create()
    {
        $categories = Category::where('type', 'download')->orderBy('name')->get();

        return view('admin.downloads.form', [
            'download' => new Download,
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request, true);
        if (! $request->hasFile('file')) {
            return back()->withInput()->with('error', 'Berkas wajib diunggah.');
        }
        $file = $request->file('file');
        $data['file_path'] = $file->store('downloads', 'public');
        $data['file_size'] = $file->getSize();
        $data['file_type'] = $file->getClientOriginalExtension() ?: 'file';
        Download::create($data);

        return redirect()->route('admin.downloads.index')->with('success', 'File download ditambahkan.');
    }

    public function edit(Download $download)
    {
        $categories = Category::where('type', 'download')->orderBy('name')->get();

        return view('admin.downloads.form', [
            'download' => $download,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, Download $download)
    {
        $data = $this->validateData($request, false);
        if ($request->hasFile('file')) {
            if ($download->file_path) {
                Storage::disk('public')->delete($download->file_path);
            }
            $file = $request->file('file');
            $data['file_path'] = $file->store('downloads', 'public');
            $data['file_size'] = $file->getSize();
            $data['file_type'] = $file->getClientOriginalExtension() ?: 'file';
        }
        $download->update($data);

        return redirect()->route('admin.downloads.index')->with('success', 'Data diperbarui.');
    }

    public function destroy(Download $download)
    {
        if ($download->file_path) {
            Storage::disk('public')->delete($download->file_path);
        }
        $download->delete();

        return back()->with('success', 'Dihapus.');
    }

    private function validateData(Request $r, bool $isCreate): array
    {
        $fileRule = $isCreate
            ? ['required', 'file', 'max:20480', 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,jpg,jpeg,png,webp']
            : ['nullable', 'file', 'max:20480', 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,jpg,jpeg,png,webp'];

        $data = $r->validate([
            'title'        => ['required', 'string', 'max:255'],
            'category_id'  => ['nullable', 'exists:categories,id'],
            'description'  => ['nullable', 'string', 'max:2000'],
            'file'         => $fileRule,
        ]);
        $data['is_public'] = $r->boolean('is_public');

        unset($data['file']);

        return $data;
    }
}
