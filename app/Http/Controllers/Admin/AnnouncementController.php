<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::with('category')->latest()->paginate(15);
        return view('admin.announcements.index', compact('announcements'));
    }

    public function create()
    {
        $categories = Category::where('type', 'announcement')->get();
        return view('admin.announcements.form', ['announcement' => new Announcement(), 'categories' => $categories]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['user_id'] = $request->user()->id;
        $data['slug']    = Str::slug($data['title']) . '-' . now()->format('YmdHis');
        Announcement::create($data);
        return redirect()->route('admin.announcements.index')->with('success', 'Pengumuman dibuat.');
    }

    public function edit(Announcement $announcement)
    {
        $categories = Category::where('type', 'announcement')->get();
        return view('admin.announcements.form', compact('announcement', 'categories'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $announcement->update($this->validated($request));
        return redirect()->route('admin.announcements.index')->with('success', 'Pengumuman diperbarui.');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();
        return back()->with('success', 'Pengumuman dihapus.');
    }

    private function validated(Request $r): array
    {
        return $r->validate([
            'title'        => ['required', 'string', 'max:255'],
            'category_id'  => ['nullable', 'exists:categories,id'],
            'content'      => ['required', 'string'],
            'priority'     => ['required', 'in:normal,important,urgent'],
            'published_at' => ['required', 'date'],
            'expires_at'   => ['nullable', 'date', 'after_or_equal:published_at'],
            'status'       => ['required', 'in:draft,active,archived'],
        ]);
    }
}
