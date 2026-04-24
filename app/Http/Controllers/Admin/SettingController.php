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
        $input = $request->except(['_token', '_method', 'files']);
        foreach ($input as $key => $value) {
            if ($key === 'files') {
                continue;
            }
            Setting::set($key, is_array($value) ? json_encode($value) : (string) $value);
        }

        if ($request->file('files')) {
            foreach ($request->file('files', []) as $key => $file) {
                if ($file && $file->isValid()) {
                    $path = $file->store('settings', 'public');
                    Setting::set($key, $path, 'identity', 'image');
                }
            }
        }

        return back()->with('success', 'Pengaturan disimpan.');
    }
}
