<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->groupBy('group');

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'files' => ['nullable', 'array'],
            'files.*' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:15360'],
        ], [
            'files.*.image' => 'Berkas harus gambar (JPG, PNG, WebP).',
            'files.*.max' => 'Ukuran gambar maksimum 15 MB per file.',
        ]);

        $input = $request->except(['_token', '_method', 'files']);
        foreach ($input as $key => $value) {
            Setting::set($key, is_array($value) ? json_encode($value) : (string) $value);
        }

        $fileBag = $request->file('files', []);
        if (is_array($fileBag)) {
            foreach ($fileBag as $key => $file) {
                if (! $file || ! $file->isValid()) {
                    continue;
                }
                $path = $file->store('settings', 'public');
                if ($path) {
                    Setting::set($key, $path, 'identity', 'image');
                }
            }
        }

        return back()->with('success', 'Pengaturan disimpan.');
    }
}
