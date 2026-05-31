<?php

namespace App\Http\Controllers;

use App\Models\Announcement;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::active()->with('category')->latest('published_at')->paginate(10);
        return view('pengumuman.index', compact('announcements'));
    }

    public function show(string $slug)
    {
        $announcement = Announcement::active()->where('slug', $slug)->with('category')->firstOrFail();
        return view('pengumuman.show', compact('announcement'));
    }
}
